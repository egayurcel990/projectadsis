@extends('layouts.app')

@section('title', 'Leave Request Status')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Status Perizinan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('leave.history') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="nim" placeholder="Enter your NIM" value="{{ $nim }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>

                    @if($nim && $leaveRequests->isEmpty())
                        <div class="alert alert-info">
                            No leave requests found for NIM: {{ $nim }}
                        </div>
                    @elseif($leaveRequests->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal Permohonan</th>
                                    <th>Waktu perizinan</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaveRequests as $request)
                                    <tr>
                                        <td>{{ $request->created_at->format('Y-m-d') }}</td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
