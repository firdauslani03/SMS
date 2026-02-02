<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

// IT STAFF (ADMIN) ROUTES
Route::middleware(['auth:it_staff', 'no_cache'])->group(function () {
    Route::get('/admin/dashboard', function () {

        $totalCourses = Course::count();
        $pendingRegistrations = DB::table('registration')->where('status', 'Pending')->count();
        $approvedRegistrations = DB::table('registration')->where('status', 'Approved')->count();

        $recentRegistrations = DB::table('registration')
            ->join('student', 'registration.matricNum', '=', 'student.matricNum')
            ->join('course', 'registration.courseCode', '=', 'course.courseCode')
            ->select(
                'registration.*', 
                'student.fName', 
                'student.lName', 
                'course.courseName', 
                'course.courseCode'
            )
            ->orderBy('registration.registrationDate', 'desc')
            ->orderBy('registration.registrationTime', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalCourses', 
            'pendingRegistrations', 
            'approvedRegistrations', 
            'recentRegistrations'
        ));
    })->name('admin.dashboard');

    Route::resource('admin/courses', CourseController::class)->names('admin.courses');

    Route::get('admin/registrations', [RegistrationController::class, 'index'])->name('admin.registrations.index');
    Route::post('admin/registrations/update', [RegistrationController::class, 'updateStatus'])->name('admin.registrations.update');

});

require __DIR__.'/auth.php';