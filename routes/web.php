<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\LecturerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $student = Auth::user();
    $curriculum = $student->programCourses->groupBy('courseSem');
    return view('dashboard', compact('student', 'curriculum'));
})->middleware(['auth', 'verified', 'no_cache'])->name('dashboard');

// STUDENT ROUTES
Route::middleware(['auth', 'no_cache'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/course-registration', [CourseRegistrationController::class, 'index'])->name('course.registration');
    Route::post('/course-registration/add', [CourseRegistrationController::class, 'store'])->name('course.add');
    Route::delete('/course-registration/remove', [CourseRegistrationController::class, 'destroy'])->name('course.remove');
    Route::post('/course-registration/confirm', [CourseRegistrationController::class, 'confirm'])->name('course.confirm');

    Route::post('/course/cancel', [CourseRegistrationController::class, 'cancel'])->name('course.cancel');
    Route::post('/course/modify', [CourseRegistrationController::class, 'modify'])->name('course.modify');
    
    Route::get('/course-registration/roadmap', [CourseRegistrationController::class, 'roadmap'])->name('course.roadmap');
    Route::get('/course-registration/submissions', [CourseRegistrationController::class, 'submissions'])->name('course.submissions');

    Route::post('/notifications/{id}/mark-read', [ProfileController::class, 'markNotification'])->name('notifications.mark');
});

// LECTURER ROUTES
Route::middleware(['auth:lecturer', 'no_cache'])->group(function () {
    Route::get('/lecturer/dashboard', function () {
        return view('lecturer.dashboard');
    })->name('lecturer.dashboard');

    Route::get('/lecturer/courses', [LecturerController::class, 'courses'])->name('lecturer.courses');
    Route::get('/lecturer/students', [LecturerController::class, 'students'])->name('lecturer.students');

    Route::get('/lecturer/profile', [ProfileController::class, 'editLecturer'])->name('lecturer.profile.edit');
    Route::patch('/lecturer/profile', [ProfileController::class, 'updateLecturer'])->name('lecturer.profile.update');
});

require __DIR__.'/auth.php';