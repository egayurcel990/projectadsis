@extends('layouts.app')

@section('title', 'Attendance History')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Riwayat Kehadiran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.history') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="nim" placeholder="Enter your NIM" value="{{ $nim }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>

                    @if($nim && $attendances->isEmpty())
                        <div class="alert alert-info">
                            No attendance records found for NIM: {{ $nim }}
                        </div>
                    @elseif($attendances->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
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
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
