<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        return view('leave.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|exists:employees,nim',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $employee = Employee::where('nim', $validated['nim'])->first();

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Leave request submitted successfully');
    }

    public function history(Request $request)
    {
        $nim = $request->nim ?? null;
        $leaveRequests = collect();
        
        if ($nim) {
            $employee = Employee::where('nim', $nim)->first();
            if ($employee) {
                $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
        
        return view('leave.history', compact('leaveRequests', 'nim'));
    }
}