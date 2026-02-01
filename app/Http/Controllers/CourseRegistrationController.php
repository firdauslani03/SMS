<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Programme;
use App\Notifications\PortalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user();

        // CHECK: Does the student have an active submission?
        // If they have any course with 'approved' or 'waiting for approval', they are locked.
        $hasActiveSubmission = $student->courses()
            ->wherePivotIn('status', ['approved', 'waiting for approval'])
            ->exists();

        $registeredCourses = $student->courses;
        $registeredCourseCodes = $registeredCourses->pluck('courseCode')->toArray();

        // Count only 'approved' students for availability
        $query = Course::withCount(['students' => function ($q) {
            $q->where('registration.status', 'approved');
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

        // BLOCK: Prevent adding if submitted
        if ($student->courses()->wherePivotIn('status', ['approved', 'waiting for approval'])->exists()) {
            return redirect()->back()->with('error', 'Registration is closed. You have already submitted.');
        }

        $request->validate([
            'course_code' => 'required|exists:course,courseCode',
        ]);
        
        $course = Course::where('courseCode', $request->course_code)->firstOrFail();

        // Check: Programme Restriction
        if ($course->progCode !== $student->progCode) {
            return redirect()->back()->with('error', 'You cannot register for courses outside your programme (' . $student->progCode . ').');
        }

        // Check: Semester Limit
        if ($course->courseSem > ($student->semester + 1)) {
            return redirect()->back()->with('error', 'You cannot register for courses that are more than one semester ahead.');
        }
        
        // Check: Already Added
        if ($student->courses()->where('registration.courseCode', $request->course_code)->exists()) {
            return redirect()->back()->with('error', 'Course already added.');
        }

        // Initial add to cart is 'Pending'
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

        // BLOCK: Prevent removing if submitted
        if ($student->courses()->wherePivotIn('status', ['approved', 'waiting for approval'])->exists()) {
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

        // BLOCK: Prevent re-confirming if submitted
        if ($student->courses()->wherePivotIn('status', ['approved', 'waiting for approval'])->exists()) {
            return redirect()->back()->with('error', 'Registration already submitted.');
        }
        
        $pendingCourses = $student->courses()->wherePivot('status', 'Pending')->get();

        if ($pendingCourses->isEmpty()) {
            return redirect()->back()->with('error', 'No new courses to confirm.');
        }

        // 1. CURRICULUM VALIDATION
        $nextSemester = $student->semester + 1;
        $requiredCourses = Course::where('progCode', $student->progCode)
                                 ->where('courseSem', $nextSemester)
                                 ->get();

        if ($requiredCourses->isNotEmpty()) {
            $allStudentCourseCodes = $student->courses->pluck('courseCode')->toArray();
            $requiredCourseCodes = $requiredCourses->pluck('courseCode')->toArray();
            
            $missingCourses = array_diff($requiredCourseCodes, $allStudentCourseCodes);

            if (!empty($missingCourses)) {
                return redirect()->back()->with('error', "You must register for all courses required for Semester {$nextSemester}. Missing: " . implode(', ', $missingCourses));
            }

            $totalSelectedCredits = $student->courses()
                ->whereIn('course.courseCode', $requiredCourseCodes)
                ->sum('courseCreds');

            $requiredCredits = $requiredCourses->sum('courseCreds');

            if ($totalSelectedCredits < $requiredCredits) {
                return redirect()->back()->with('error', "Insufficient credits for Semester {$nextSemester}. Selected: {$totalSelectedCredits}, Required: {$requiredCredits}.");
            }
        }

        // 2. PROCESS REGISTRATION
        $approvedCourses = [];
        $waitingCourses = [];

        foreach ($pendingCourses as $course) {
            // Count currently 'approved' students
            $currentConfirmed = $course->students()
                ->wherePivot('status', 'approved')
                ->count();
            
            if ($currentConfirmed < $course->courseCapacity) {
                // Auto-approve
                $status = 'approved';
                $approvedCourses[] = $course->courseCode;
            } else {
                // Full -> Waiting for Approval
                $status = 'waiting for approval';
                $waitingCourses[] = $course->courseCode;
            }

             $student->courses()->updateExistingPivot($course->courseCode, [
                'status' => $status,
                'registrationDate' => Carbon::now()->toDateString(),
                'registrationTime' => Carbon::now()->toTimeString(),
             ]);
        }

        // 3. GENERATE FEEDBACK
        $message = "Registration processed.";
        
        if (!empty($approvedCourses)) {
            $message .= " Approved: " . implode(', ', $approvedCourses) . ".";
        }
        
        if (!empty($waitingCourses)) {
            $message .= " Waiting for approval (Full): " . implode(', ', $waitingCourses) . ".";
        }

        $student->notify(new PortalNotification(
        'Registration submitted successfully! Check your status.',
        route('course.submissions')
        ));

        return redirect()->route('course.submissions')->with('success', $message);
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

    public function submissions()
    {
        $student = Auth::user();
        $registeredCourses = $student->courses()
                                     ->withPivot('status', 'registrationDate', 'registrationTime')
                                     ->get();
        $totalCredits = $registeredCourses->sum('courseCreds');
        $submissionStatus = $registeredCourses->first()->pivot->status ?? 'Pending';
        $submissionDate = $registeredCourses->first()->pivot->registrationDate ?? null;
        $allCourses = Course::where('progCode', $student->progCode)
                    ->where('courseSem', $student->semester + 1)
                    ->get();

        return view('course-registration.submissions', compact('student', 'registeredCourses', 'totalCredits', 'submissionStatus', 'submissionDate', 'allCourses'));
    }

    public function cancel(Request $request)
    {
        $student = Auth::user();

        // Check for active courses to cancel
        $hasActive = $student->courses()
                             ->wherePivotIn('status', ['approved', 'waiting for approval'])
                             ->exists();

        if (!$hasActive) {
            return redirect()->back()->with('error', 'No active submission found to cancel.');
        }

        // Bulk update to 'cancelled'
        DB::table('registration')
            ->where('matricNum', $student->matricNum)
            ->whereIn('status', ['approved', 'waiting for approval'])
            ->update([
                'status' => 'cancelled',
                'registrationDate' => Carbon::now()->toDateString(),
                'registrationTime' => Carbon::now()->toTimeString(),
            ]);

        Auth::user()->notify(new PortalNotification(
        'Your course registration has been cancelled.',
        route('course.registration')
        ));

        return redirect()->back()->with('success', 'Submission cancelled successfully.');
    }
}