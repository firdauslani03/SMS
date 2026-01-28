<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseRegistrationController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // Fetch all courses that belong to any program within the student's faculty
        // Logic: Get all courses where the related 'programme' has the same 'facCode' as the student
        $courses = Course::whereHas('programme', function($query) use ($student) {
            $query->where('facCode', $student->facCode);
        })->get();

        return view('course-registration.index', compact('courses'));
    }
}