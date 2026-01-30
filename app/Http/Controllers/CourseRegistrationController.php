<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user();

        // 1. Start with the Base Query: Courses in the student's faculty
        $query = Course::whereHas('programme', function($q) use ($student) {
            $q->where('facCode', $student->facCode);
        });

        // 2. Apply Search Filter (Course Name or Code)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('courseName', 'like', "%{$search}%")
                  ->orWhere('courseCode', 'like', "%{$search}%");
            });
        }

        // 3. Apply Programme Filter
        if ($request->filled('programme') && $request->input('programme') !== 'all') {
            $query->where('progCode', $request->input('programme'));
        }

        // 4. Apply Semester Filter
        if ($request->filled('semester') && $request->input('semester') !== 'all') {
            $query->where('courseSem', $request->input('semester'));
        }

        // 5. Execute Query
        $courses = $query->paginate(4)->appends($request->query());

        // 6. Fetch Data for Filter Dropdowns
        // Get all programmes in the student's faculty for the dropdown
        $programmes = Programme::where('facCode', $student->facCode)->get();

        // Get available semesters dynamically based on courses in this faculty
        $semesters = Course::whereHas('programme', function($q) use ($student) {
                $q->where('facCode', $student->facCode);
            })
            ->distinct()
            ->orderBy('courseSem')
            ->pluck('courseSem');

        return view('course-registration.index', compact('courses', 'programmes', 'semesters'));
    }

    public function roadmap()
    {
        $student = Auth::user();
        
        // Fetch the student's specific program curriculum
        $curriculum = $student->programCourses->groupBy('courseSem');

        // Calculate basic stats for the creative view
        $totalSemesters = $curriculum->count();
        $currentSemester = $student->semester;
        
        // Calculate progress percentage (capped at 100%)
        $progress = min(100, round((($currentSemester - 1) / max($totalSemesters, 1)) * 100));

        return view('course-registration.roadmap', compact('student', 'curriculum', 'progress', 'totalSemesters'));
    }

    public function submissions()
    {
        $student = Auth::user();
        
        // Fetch registered courses with pivot data (status, dates)
        // We use the 'courses' relationship from Student model which links to 'registration' table
        $registeredCourses = $student->courses()
                                     ->withPivot('status', 'registrationDate', 'registrationTime')
                                     ->get();

        // Calculate stats
        $totalCredits = $registeredCourses->sum('courseCreds');
        
        // Since only 1 submission is allowed, we take the status/date from the first record
        $submissionStatus = $registeredCourses->first()->pivot->status ?? 'Pending';
        $submissionDate = $registeredCourses->first()->pivot->registrationDate ?? null;

        return view('course-registration.submissions', compact('student', 'registeredCourses', 'totalCredits', 'submissionStatus', 'submissionDate'));
    }
}