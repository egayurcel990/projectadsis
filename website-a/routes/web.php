<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('employees.index');
});

// Employee routes
Route::resource('employees', EmployeeController::class);

// Attendance routes
Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
Route::post('/attendances/filter', [AttendanceController::class, 'filterByDate'])->name('attendances.filter');

// Leave request routes
Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
Route::patch('/leave-requests/{leaveRequest}/status', [LeaveRequestController::class, 'updateStatus'])->name('leave-requests.update-status');