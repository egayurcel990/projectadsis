@extends('layouts.app')

@section('title', 'Attendances')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Attendance List</h1>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('attendances.filter') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-auto">
                    <label for="date" class="visually-hidden">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $date ?? date('Y-m-d') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>NIM</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->id }}</td>
                            <td>{{ $attendance->employee->name }}</td>
                            <td>{{ $attendance->employee->nim }}</td>
                            <td>{{ $attendance->date }}</td>
                            <td>
                                @if($attendance->status == 'present')
                                    <span class="badge bg-success">Present</span>
                                @elseif($attendance->status == 'absent')
                                    <span class="badge bg-danger">Absent</span>
                                @else
                                    <span class="badge bg-warning">Late</span>
                                @endif
                            </td>
                            <td>{{ $attendance->notes }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection