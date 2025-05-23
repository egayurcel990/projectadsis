@extends('layouts.app')

@section('title', 'Leave Requests')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Leave Requests</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>NIM</th>
                        <th>Period</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leaveRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->employee->name }}</td>
                            <td>{{ $request->employee->nim }}</td>
                            <td>{{ $request->start_date }} to {{ $request->end_date }}</td>
                            <td>{{ $request->reason }}</td>
                            <td>
                                @if($request->status == 'pending')
                                    <span class="badge bg-secondary">Pending</span>
                                @elseif($request->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if($request->status == 'pending')
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('leave-requests.update-status', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form action="{{ route('leave-requests.update-status', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No leave requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection