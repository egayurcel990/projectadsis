<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('attendance.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|exists:employees,nim',
            'status' => 'required|in:present,late,absent',
            'notes' => 'nullable|string',
        ]);

        $employee = Employee::where('nim', $validated['nim'])->first();

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => date('Y-m-d'),
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->back()->with('success', 'Attendance recorded successfully');
    }

    public function history(Request $request)
    {
        $nim = $request->nim ?? null;
        $attendances = collect();
        
        if ($nim) {
            $employee = Employee::where('nim', $nim)->first();
            if ($employee) {
                $attendances = Attendance::where('employee_id', $employee->id)
                    ->orderBy('date', 'desc')
                    ->get();
            }
        }
        
        return view('attendance.history', compact('attendances', 'nim'));
    }
}