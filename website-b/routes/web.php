<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('attendance.form');
});

// Attendance routes
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.form');
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');

// Leave request routes
Route::get('/leave', [LeaveRequestController::class, 'index'])->name('leave.form');
Route::post('/leave', [LeaveRequestController::class, 'store'])->name('leave.store');
Route::get('/leave/history', [LeaveRequestController::class, 'history'])->name('leave.history');