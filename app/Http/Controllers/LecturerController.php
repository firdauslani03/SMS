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
}