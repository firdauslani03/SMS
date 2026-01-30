<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CourseRegistrationController extends Controller
{
    // ... (index function remains the same) ...
    public function index(Request $request)
    {
        $student = Auth::user();

        $registeredCourses = $student->courses;
        $registeredCourseCodes = $registeredCourses->pluck('courseCode')->toArray();

        $query = Course::withCount('students')->whereHas('programme', function($q) use ($student) {
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
        
        // Fetch the course to check its semester
        $course = Course::where('courseCode', $request->course_code)->firstOrFail();

        // RESTRICTION: Prevent adding courses from future semesters
        if ($course->courseSem > $student->semester) {
            return redirect()->back()->with('error', 'You cannot register for courses from future semesters.');
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

    // ... (destroy, confirm, roadmap, submissions remain the same) ...
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
        
        foreach ($student->courses as $course) {
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

        return view('course-registration.submissions', compact('student', 'registeredCourses', 'totalCredits', 'submissionStatus', 'submissionDate'));
    }
}