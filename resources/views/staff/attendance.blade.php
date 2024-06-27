@extends('layouts.staff')

@section('main-content')
<div class="container">
    <h1>Attendance</h1>
    <form action="{{ route('staff.attendance.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', now()->toDateString()) }}" required>
            @error('date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="attendance">Attendance</label>
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>
                                <select name="attendance[{{ $student->id }}]" class="form-control" required>
                                    <option value="present" {{ old("attendance.{$student->id}") == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="absent" {{ old("attendance.{$student->id}") == 'absent' ? 'selected' : '' }}>Absent</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @error('attendance')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save Attendance</button>
    </form>
</div>
@endsection
