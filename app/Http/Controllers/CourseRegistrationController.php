<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Programme;
use App\Notifications\PortalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CourseRegistrationController extends Controller
{
    // ... [index, store, destroy, confirm methods remain unchanged] ...

    public function index(Request $request)
    {
        $student = Auth::user();

        // CHECK: Active Submission
        $hasActiveSubmission = $student->courses()
            ->wherePivotIn('status', ['Approved', 'Waiting for Approval'])
            ->exists();

        // Filter out 'Cancelled' courses from the visible "Cart"
        $registeredCourses = $student->courses()
            ->wherePivot('status', '!=', 'Cancelled')
            ->get();
            
        $registeredCourseCodes = $registeredCourses->pluck('courseCode')->toArray();

        // Availability Query
        $query = Course::withCount(['students' => function ($q) {
            $q->where('registration.status', 'Approved');
        }])->whereHas('programme', function($q) use ($student) {
            $q->where('facCode', $student->facCode);
        });

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('courseName', 'like', "%{$search}%")
                  ->orWhere('courseCode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('programme') && $request->input('programme') !== 'all') {
            $query->where('progCode', $request->input('programme'));
        }

        if ($request->filled('semester') && $request->input('semester') !== 'all') {
            $query->where('courseSem', $request->input('semester'));
        }

        $courses = $query->paginate(4)->appends($request->query());

        $programmes = Programme::where('facCode', $student->facCode)->get();
        $semesters = Course::whereHas('programme', function($q) use ($student) {
                $q->where('facCode', $student->facCode);
            })
            ->distinct()
            ->orderBy('courseSem')
            ->pluck('courseSem');

        return view('course-registration.index', compact(
            'courses', 
            'programmes', 
            'semesters', 
            'registeredCourses', 
            'registeredCourseCodes',
            'hasActiveSubmission'
        ));
    }

    public function store(Request $request)
    {
        $student = Auth::user();

        if ($student->courses()->wherePivotIn('status', ['Approved', 'Waiting for Approval'])->exists()) {
            return redirect()->back()->with('error', 'Registration is closed. Please use "Modify" on the submissions page to make changes.');
        }

        $request->validate([
            'course_code' => 'required|exists:course,courseCode',
        ]);
        
        $course = Course::where('courseCode', $request->course_code)->firstOrFail();

        if ($course->progCode !== $student->progCode) {
            return redirect()->back()->with('error', 'You cannot register for courses outside your programme (' . $student->progCode . ').');
        }

        if ($course->courseSem > ($student->semester + 1)) {
            return redirect()->back()->with('error', 'You cannot register for courses that are more than one semester ahead.');
        }
        
        $existingRegistration = $student->courses()
            ->where('registration.courseCode', $request->course_code)
            ->withPivot('status')
            ->first();

        if ($existingRegistration) {
            $status = $existingRegistration->pivot->status;

            if (in_array($status, ['Pending', 'Approved', 'Waiting for Approval'])) {
                return redirect()->back()->with('error', 'Course already added.');
            }

            if ($status === 'Cancelled') {
                $student->courses()->updateExistingPivot($request->course_code, [
                    'status' => 'Pending',
                    'registrationDate' => Carbon::now()->toDateString(),
                    'registrationTime' => Carbon::now()->toTimeString(),
                ]);
                return redirect()->back()->with('success', 'Course re-added to list.');
            }
        }

        $student->courses()->attach($request->course_code, [
            'status' => 'Pending',
            'registrationDate' => Carbon::now()->toDateString(),
            'registrationTime' => Carbon::now()->toTimeString(),
        ]);

        return redirect()->back()->with('success', 'Course added to list.');
    }

    public function destroy(Request $request)
    {
        $student = Auth::user();

        if ($student->courses()->wherePivotIn('status', ['Approved', 'Waiting for Approval'])->exists()) {
            return redirect()->back()->with('error', 'Registration is closed. You cannot remove courses after submission.');
        }

        $request->validate([
            'course_code' => 'required|exists:course,courseCode',
        ]);

        $student->courses()->detach($request->course_code);

        return redirect()->back()->with('success', 'Course removed successfully.');
    }

    public function confirm()
    {
        $student = Auth::user();

        if ($student->courses()->wherePivotIn('status', ['Approved', 'Waiting for Approval'])->exists()) {
            return redirect()->back()->with('error', 'Registration already submitted.');
        }
        
        $pendingCourses = $student->courses()->wherePivot('status', 'Pending')->get();

        if ($pendingCourses->isEmpty()) {
            return redirect()->back()->with('error', 'No new courses to confirm.');
        }

        $nextSemester = $student->semester + 1;
        $requiredCourses = Course::where('progCode', $student->progCode)
                                 ->where('courseSem', $nextSemester)
                                 ->get();

        if ($requiredCourses->isNotEmpty()) {
            $allStudentCourseCodes = $student->courses->where('pivot.status', '!=', 'Cancelled')->pluck('courseCode')->toArray();
            $requiredCourseCodes = $requiredCourses->pluck('courseCode')->toArray();
            
            $missingCourses = array_diff($requiredCourseCodes, $allStudentCourseCodes);

            if (!empty($missingCourses)) {
                return redirect()->back()->with('error', "You must register for all courses required for Semester {$nextSemester}. Missing: " . implode(', ', $missingCourses));
            }
        }

        $approvedCourses = [];
        $waitingCourses = [];

        foreach ($pendingCourses as $course) {
            $currentConfirmed = $course->students()
                ->wherePivotIn('status', ['Approved'])
                ->count();
            
            if ($currentConfirmed < $course->courseCapacity) {
                $status = 'Approved';
                $approvedCourses[] = $course->courseCode;
            } else {
                $status = 'Waiting for Approval';
                $waitingCourses[] = $course->courseCode;
            }

             $student->courses()->updateExistingPivot($course->courseCode, [
                'status' => $status,
                'registrationDate' => Carbon::now()->toDateString(),
                'registrationTime' => Carbon::now()->toTimeString(),
             ]);
        }

        $message = "Registration processed.";
        
        if (!empty($approvedCourses)) {
            $message .= " Approved: " . count($approvedCourses) . " course(s).";
        }
        
        if (!empty($waitingCourses)) {
            $message .= " Waiting for approval (Full): " . count($waitingCourses) . " course(s).";
        }

        $student->notify(new PortalNotification(
            'Registration submitted successfully! Check your status.',
            route('course.submissions')
        ));

        return redirect()->route('course.submissions')->with('success', $message);
    }

    public function modify(Request $request)
    {
        $student = Auth::user();

        $hasSubmission = $student->courses()
            ->wherePivotIn('status', ['Approved', 'Waiting for Approval'])
            ->exists();

        if (!$hasSubmission) {
            return redirect()->back()->with('error', 'No active submission found to modify.');
        }

        DB::table('registration')
            ->where('matricNum', $student->matricNum)
            ->whereIn('status', ['Approved', 'Waiting for Approval'])
            ->update([
                'status' => 'Pending',
                'registrationDate' => Carbon::now()->toDateString(),
                'registrationTime' => Carbon::now()->toTimeString(),
            ]);

        return redirect()->route('course.registration')->with('success', 'Registration reopened. You can now Add or Drop courses. Remember to Submit again!');
    }

    /**
     * CANCEL: Withdraws from all courses (With Password Verification).
     */
    public function cancel(Request $request)
    {
        $student = Auth::user();

        // 1. Validate Password Input
        $request->validate([
            'password' => 'required',
        ]);

        // 2. Check Password Match
        // Using $student->pass because your User model defines this as the password field
        if (!Hash::check($request->password, $student->pass)) {
            return redirect()->back()->with('error', 'Incorrect password. Cancellation failed.');
        }

        // 3. Check for active courses to cancel
        $hasActive = $student->courses()
                             ->wherePivotIn('status', ['Approved', 'Waiting for Approval'])
                             ->exists();

        if (!$hasActive) {
            return redirect()->back()->with('error', 'No active submission found to cancel.');
        }

        // 4. Perform Cancellation
        DB::table('registration')
            ->where('matricNum', $student->matricNum)
            ->whereIn('status', ['Approved', 'Waiting for Approval'])
            ->update([
                'status' => 'Cancelled',
                'registrationDate' => Carbon::now()->toDateString(),
                'registrationTime' => Carbon::now()->toTimeString(),
            ]);

        Auth::user()->notify(new PortalNotification(
            'Your course registration has been cancelled.',
            route('course.registration')
        ));

        return redirect()->back()->with('success', 'Submission cancelled. You have withdrawn from this semester.');
    }

    public function submissions()
    {
        $student = Auth::user();
        
        $registeredCourses = $student->courses()
                                     ->withPivot('status', 'registrationDate', 'registrationTime')
                                     ->get();
        
        $activeCourses = $registeredCourses->filter(function($course) {
            return in_array($course->pivot->status, ['Approved', 'Waiting for Approval', 'Submitted']);
        });

        $totalCredits = $activeCourses->sum('courseCreds');

        if ($activeCourses->isNotEmpty()) {
            $submissionStatus = 'Submitted'; 
        } elseif ($registeredCourses->where('pivot.status', 'Cancelled')->count() > 0) {
            $submissionStatus = 'Cancelled';
        } else {
            $submissionStatus = 'Pending';
        }

        $submissionDate = $registeredCourses->first()->pivot->registrationDate ?? null;
        
        $allCourses = Course::where('progCode', $student->progCode)
                    ->where('courseSem', $student->semester + 1)
                    ->get();

        return view('course-registration.submissions', compact('student', 'registeredCourses', 'totalCredits', 'submissionStatus', 'submissionDate', 'allCourses'));
    }

    public function roadmap()
    {
        $student = Auth::user();
        $curriculum = $student->programCourses->groupBy('courseSem');
        $totalSemesters = $curriculum->count();
        $currentSemester = $student->semester;
        $progress = min(100, round((($currentSemester - 1) / max($totalSemesters, 1)) * 100));

        return view('course-registration.roadmap', compact('student', 'curriculum', 'progress', 'totalSemesters'));
    }
}