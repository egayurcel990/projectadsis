<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->get();
        return view('attendances.index', compact('attendances'));
    }

    public function filterByDate(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');
        $attendances = Attendance::with('employee')
            ->whereDate('date', $date)
            ->get();
        
        return view('attendances.index', compact('attendances', 'date'));
    }
}