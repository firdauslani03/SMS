<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseRegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $student = Auth::user();
    $curriculum = $student->programCourses->groupBy('courseSem');

    return view('dashboard', compact('student', 'curriculum'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/course-registration', [CourseRegistrationController::class, 'index'])->name('course.registration');
    Route::post('/course-registration/add', [CourseRegistrationController::class, 'store'])->name('course.add');
    Route::delete('/course-registration/remove', [CourseRegistrationController::class, 'destroy'])->name('course.remove');
    Route::post('/course-registration/confirm', [CourseRegistrationController::class, 'confirm'])->name('course.confirm');
    
    Route::get('/course-registration/roadmap', [CourseRegistrationController::class, 'roadmap'])->name('course.roadmap');
    Route::get('/course-registration/submissions', [CourseRegistrationController::class, 'submissions'])->name('course.submissions');
});

require __DIR__.'/auth.php';