<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RekapController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin,guru'])->group(function () {
    Route::get('/schedules', [App\Http\Controllers\ScheduleController::class, 'index'])->name('schedules.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('students', App\Http\Controllers\StudentController::class)->except(['show']);
    Route::post('/classes/promote-students', [App\Http\Controllers\ClassController::class, 'promoteStudents'])->name('classes.promote-students');
    Route::post('/classes/{class}/promote-selected-students', [App\Http\Controllers\ClassController::class, 'promoteSelectedStudents'])->name('classes.promote-selected-students');
    Route::resource('classes', App\Http\Controllers\ClassController::class);
    Route::resource('teachers', App\Http\Controllers\TeacherController::class)->except(['show']);
    Route::post('/academic-years/{academicYear}/activate', [App\Http\Controllers\AcademicYearController::class, 'activate'])->name('academic-years.activate');
    Route::resource('academic-years', App\Http\Controllers\AcademicYearController::class);
    Route::resource('schedules', App\Http\Controllers\ScheduleController::class)->except(['show', 'index']);
});

// absensi
Route::middleware(['auth', 'role:admin,guru'])->group(function () {
    Route::get('/attendances', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/create', [App\Http\Controllers\AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendances.store');
});

// rekap
Route::middleware(['auth', 'role:admin,guru'])->prefix('rekap')->name('rekap.')->group(function () {
    Route::get('/', [RekapController::class, 'index'])->name('index');
    Route::get('/kelas/{class}', [RekapController::class, 'show'])->name('kelas');
    Route::get('/kelas/{class}/export', [RekapController::class, 'export'])->name('kelas.export');
});