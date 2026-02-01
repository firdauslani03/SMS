<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    public function courses()
    {
        $lecturer = Auth::guard('lecturer')->user();
        $courses = $lecturer->courses; 

        return view('lecturer.courses', compact('courses'));
    }

    public function students(Request $request)
    {
        $lecturer = Auth::guard('lecturer')->user();
        
        $allCourses = $lecturer->courses;

        $query = $lecturer->courses()->with('students');

        if ($request->filled('course_code')) {
            $query->where('courseCode', $request->course_code);
        }

        $courses = $query->get();

        $enrollments = collect();
        
        foreach ($courses as $course) {
            foreach ($course->students as $student) {
                $enrollments->push((object)[
                    'name' => $student->fName . ' ' . $student->lName,
                    'matric' => $student->matricNum,
                    'email' => $student->email,
                    'course_code' => $course->courseCode,
                    'course_name' => $course->courseName,
                ]);
            }
        }

        return view('lecturer.students', compact('enrollments', 'allCourses'));
    }
}