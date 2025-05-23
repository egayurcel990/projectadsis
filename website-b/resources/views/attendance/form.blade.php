@extends('layouts.app')

@section('title', 'Submit Attendance')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Daily Attendance Form</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-present" value="present" {{ old('status') == 'present' ? 'checked' : '' }} checked>
                                <label class="form-check-label" for="status-present">
                                    Present
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-late" value="late" {{ old('status') == 'late' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-late">
                                    Late
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-absent" value="absent" {{ old('status') == 'absent' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-absent">
                                    Absent
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Attendance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection