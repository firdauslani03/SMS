<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user();

        $registeredCourses = $student->courses;
        $registeredCourseCodes = $registeredCourses->pluck('courseCode')->toArray();

        // Count only 'Submitted' students for availability
        $query = Course::withCount(['students' => function ($q) {
            $q->where('registration.status', 'Submitted');
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

        return view('course-registration.index', compact('courses', 'programmes', 'semesters', 'registeredCourses', 'registeredCourseCodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|exists:course,courseCode',
        ]);

        $student = Auth::user();
        
        $course = Course::where('courseCode', $request->course_code)->firstOrFail();

        // --- NEW RESTRICTION: Programme Check ---
        // Students can only register for courses belonging to their own programme code
        if ($course->progCode !== $student->progCode) {
            return redirect()->back()->with('error', 'You cannot register for courses outside your programme (' . $student->progCode . ').');
        }

        // RESTRICTION: Semester limit (Max 1 semester ahead)
        if ($course->courseSem > ($student->semester + 1)) {
            return redirect()->back()->with('error', 'You cannot register for courses that are more than one semester ahead.');
        }
        
        // Check if already registered
        if ($student->courses()->where('registration.courseCode', $request->course_code)->exists()) {
            return redirect()->back()->with('error', 'Course already added.');
        }

        $student->courses()->attach($request->course_code, [
            'status' => 'Pending',
            'registrationDate' => Carbon::now()->toDateString(),
            'registrationTime' => Carbon::now()->toTimeString(),
        ]);

        return redirect()->back()->with('success', 'Course added successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'course_code' => 'required|exists:course,courseCode',
        ]);

        Auth::user()->courses()->detach($request->course_code);

        return redirect()->back()->with('success', 'Course removed successfully.');
    }

    public function confirm()
    {
        $student = Auth::user();
        
        $pendingCourses = $student->courses()->wherePivot('status', 'Pending')->get();

        if ($pendingCourses->isEmpty()) {
            return redirect()->back()->with('error', 'No new courses to confirm.');
        }

        // 1. CAPACITY CHECK
        foreach ($pendingCourses as $course) {
            $currentConfirmed = $course->students()
                ->wherePivot('status', 'Submitted')
                ->count();
            
            if ($currentConfirmed >= $course->courseCapacity) {
                return redirect()->back()->with('error', "Registration Failed: {$course->courseCode} ({$course->courseName}) is now full.");
            }
        }

        // 2. NEXT SEMESTER VALIDATION
        $nextSemester = $student->semester + 1;
        $requiredCourses = Course::where('progCode', $student->progCode)
                                 ->where('courseSem', $nextSemester)
                                 ->get();

        if ($requiredCourses->isNotEmpty()) {
            
            $allStudentCourseCodes = $student->courses->pluck('courseCode')->toArray();
            $requiredCourseCodes = $requiredCourses->pluck('courseCode')->toArray();
            
            // A. Check for missing required courses
            $missingCourses = array_diff($requiredCourseCodes, $allStudentCourseCodes);

            if (!empty($missingCourses)) {
                return redirect()->back()->with('error', "You must register for all courses required for Semester {$nextSemester}. Missing: " . implode(', ', $missingCourses));
            }

            // B. Check for sufficient credits
            $totalSelectedCredits = $student->courses()
                ->whereIn('course.courseCode', $requiredCourseCodes)
                ->sum('courseCreds');

            $requiredCredits = $requiredCourses->sum('courseCreds');

            if ($totalSelectedCredits < $requiredCredits) {
                return redirect()->back()->with('error', "Insufficient credits for Semester {$nextSemester}. Selected: {$totalSelectedCredits}, Required: {$requiredCredits}.");
            }
        }

        // 3. FINALIZE
        foreach ($pendingCourses as $course) {
             $student->courses()->updateExistingPivot($course->courseCode, [
                'status' => 'Submitted',
                'registrationDate' => Carbon::now()->toDateString(),
                'registrationTime' => Carbon::now()->toTimeString(),
             ]);
        }

        return redirect()->route('course.submissions')->with('success', 'Registration submitted successfully!');
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

        // Check if there are any submitted courses to cancel
        $hasSubmitted = $student->courses()->wherePivot('status', 'Submitted')->exists();

        if (!$hasSubmitted) {
            return redirect()->back()->with('error', 'No active submission found to cancel.');
        }

        // Bulk update ALL 'Submitted' courses for this student
        DB::table('registration')
            ->where('matricNum', $student->matricNum)
            ->where('status', 'Submitted')
            ->update([
                'status' => 'Cancellation Pending',
                'registrationDate' => Carbon::now()->toDateString(),
                'registrationTime' => Carbon::now()->toTimeString(),
            ]);

        return redirect()->back()->with('success', 'Cancellation request for the entire submission has been sent for approval.');
    }

    // 2. MODIFY WHOLE SUBMISSION (Request to Edit/Unlock)
    public function modify(Request $request)
    {
        $student = Auth::user();

        $hasSubmitted = $student->courses()->wherePivot('status', 'Submitted')->exists();

        if (!$hasSubmitted) {
            return redirect()->back()->with('error', 'No submitted registration found to modify.');
        }

        // Bulk update ALL 'Submitted' courses to 'Modification Pending'
        // This signals the Admin that the student wants to change their courses.
        DB::table('registration')
            ->where('matricNum', $student->matricNum)
            ->where('status', 'Submitted')
            ->update([
                'status' => 'Modification Pending',
                'registrationDate' => Carbon::now()->toDateString(),
                'registrationTime' => Carbon::now()->toTimeString(),
            ]);

        return redirect()->back()->with('success', 'Modification request sent. Please wait for approval to edit your courses.');
    }
}