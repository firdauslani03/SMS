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

        // CHECK: Active Submission
        // We only consider it "Locked" if status is Approved or Waiting.
        // If 'Pending' (Modify mode) or 'Cancelled', the student CAN register.
        $hasActiveSubmission = $student->courses()
            ->wherePivotIn('status', ['Approved', 'Waiting for Approval'])
            ->exists();

        // Filter out 'Cancelled' courses from the visible "Cart" so they don't clutter the view
        // unless you want a history. Usually, the cart shows active intentions.
        $registeredCourses = $student->courses()
            ->wherePivot('status', '!=', 'Cancelled')
            ->get();
            
        $registeredCourseCodes = $registeredCourses->pluck('courseCode')->toArray();

        // Availability Query
        $query = Course::withCount(['students' => function ($q) {
            $q->whereIn('registration.status', ['Approved']);
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

        // BLOCK: Prevent adding if submitted (Locked state)
        if ($student->courses()->wherePivotIn('status', ['Approved', 'Waiting for Approval'])->exists()) {
            return redirect()->back()->with('error', 'Registration is closed. Please use "Modify" on the submissions page to make changes.');
        }

        $request->validate([
            'course_code' => 'required|exists:course,courseCode',
        ]);
        
        $course = Course::where('courseCode', $request->course_code)->firstOrFail();

        // 1. Validation Logic
        if ($course->progCode !== $student->progCode) {
            return redirect()->back()->with('error', 'You cannot register for courses outside your programme (' . $student->progCode . ').');
        }

        if ($course->courseSem > ($student->semester + 1)) {
            return redirect()->back()->with('error', 'You cannot register for courses that are more than one semester ahead.');
        }
        
        // 2. Check for Existing Record (including Cancelled)
        $existingRegistration = $student->courses()
            ->where('registration.courseCode', $request->course_code)
            ->withPivot('status')
            ->first();

        if ($existingRegistration) {
            $status = $existingRegistration->pivot->status;

            // If it's already active/pending, stop duplicate
            if (in_array($status, ['Pending', 'Approved', 'Waiting for Approval'])) {
                return redirect()->back()->with('error', 'Course already added.');
            }

            // If it was Cancelled, REACTIVATE it
            if ($status === 'Cancelled') {
                $student->courses()->updateExistingPivot($request->course_code, [
                    'status' => 'Pending', // Reset to Pending
                    'registrationDate' => Carbon::now()->toDateString(),
                    'registrationTime' => Carbon::now()->toTimeString(),
                ]);
                return redirect()->back()->with('success', 'Course re-added to list.');
            }
        }

        // 3. New Registration
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
        if ($student->courses()->wherePivotIn('status', ['Approved', 'Waiting for Approval'])->exists()) {
            return redirect()->back()->with('error', 'Registration is closed. You cannot remove courses after submission.');
        }

        $request->validate([
            'course_code' => 'required|exists:course,courseCode',
        ]);

        // We detach completely so it disappears from the list
        $student->courses()->detach($request->course_code);

        return redirect()->back()->with('success', 'Course removed successfully.');
    }

    public function confirm()
    {
        $student = Auth::user();

        // BLOCK: Prevent re-confirming if submitted
        if ($student->courses()->wherePivotIn('status', ['Approved', 'Waiting for Approval'])->exists()) {
            return redirect()->back()->with('error', 'Registration already submitted.');
        }
        
        $pendingCourses = $student->courses()->wherePivot('status', 'Pending')->get();

        if ($pendingCourses->isEmpty()) {
            return redirect()->back()->with('error', 'No new courses to confirm.');
        }

        // 1. CURRICULUM VALIDATION (Optional: You can relax this during Modify phase if needed)
        $nextSemester = $student->semester + 1;
        $requiredCourses = Course::where('progCode', $student->progCode)
                                 ->where('courseSem', $nextSemester)
                                 ->get();

        if ($requiredCourses->isNotEmpty()) {
            // Logic to ensure they have taken required courses...
            // (Keeping your existing logic here)
            $allStudentCourseCodes = $student->courses->where('pivot.status', '!=', 'Cancelled')->pluck('courseCode')->toArray();
            $requiredCourseCodes = $requiredCourses->pluck('courseCode')->toArray();
            
            $missingCourses = array_diff($requiredCourseCodes, $allStudentCourseCodes);

            if (!empty($missingCourses)) {
                return redirect()->back()->with('error', "You must register for all courses required for Semester {$nextSemester}. Missing: " . implode(', ', $missingCourses));
            }
        }

        // 2. PROCESS REGISTRATION
        $approvedCourses = [];
        $waitingCourses = [];

        foreach ($pendingCourses as $course) {
            // Count currently 'Approved' students
            $currentConfirmed = $course->students()
                ->wherePivotIn('status', ['Approved'])
                ->count();
            
            // Check Capacity
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

        // 3. GENERATE FEEDBACK
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

    /**
     * MODIFY: Reverts submission to Pending to allow editing.
     */
    public function modify(Request $request)
    {
        $student = Auth::user();

        // 1. Check if we actually have a submission to modify
        $hasSubmission = $student->courses()
            ->wherePivotIn('status', ['Approved', 'Waiting for Approval'])
            ->exists();

        if (!$hasSubmission) {
            return redirect()->back()->with('error', 'No active submission found to modify.');
        }

        // 2. Revert Status: Approved/Waiting -> Pending
        // This "Unlocks" the destroy() and store() methods for the student
        DB::table('registration')
            ->where('matricNum', $student->matricNum)
            ->whereIn('status', ['Approved', 'Waiting for Approval'])
            ->update([
                'status' => 'Pending',
                'updated_at' => Carbon::now() // Ensure you have timestamps or remove this line
            ]);

        // 3. Notify and Redirect
        // We redirect them to the Registration Page (Index) so they can immediately add/remove courses
        return redirect()->route('course.registration')->with('success', 'Registration reopened. You can now Add or Drop courses. Remember to Submit again!');
    }

    /**
     * CANCEL: Withdraws from all courses.
     */
    public function cancel(Request $request)
    {
        $student = Auth::user();

        // Check for active courses to cancel (Include 'Approved')
        $hasActive = $student->courses()
                             ->wherePivotIn('status', ['Approved', 'Waiting for Approval'])
                             ->exists();

        if (!$hasActive) {
            return redirect()->back()->with('error', 'No active submission found to cancel.');
        }

        // Bulk update to 'Cancelled'
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
        
        // Get all courses including Cancelled ones for history
        $registeredCourses = $student->courses()
                                     ->withPivot('status', 'registrationDate', 'registrationTime')
                                     ->get();
        
        // Calculate credits only for Active courses
        $activeCourses = $registeredCourses->filter(function($course) {
            return in_array($course->pivot->status, ['Approved', 'Waiting for Approval', 'Submitted']);
        });

        $totalCredits = $activeCourses->sum('courseCreds');

        // Determine main status
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
        // ... (Keep existing roadmap code) ...
        $student = Auth::user();
        $curriculum = $student->programCourses->groupBy('courseSem');
        $totalSemesters = $curriculum->count();
        $currentSemester = $student->semester;
        $progress = min(100, round((($currentSemester - 1) / max($totalSemesters, 1)) * 100));

        return view('course-registration.roadmap', compact('student', 'curriculum', 'progress', 'totalSemesters'));
    }
}