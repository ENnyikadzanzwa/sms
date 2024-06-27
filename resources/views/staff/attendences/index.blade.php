<!-- resources/views/staff/attendance/index.blade.php -->

@extends('layouts.staff')

@section('content')
<div class="container">
    <h1>Attendance for {{ $gradeClass->name }}</h1>

    <form action="{{ route('staff.attendance.record') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>
                            <input type="radio" name="attendance[{{ $student->id }}]" value="present">
                        </td>
                        <td>
                            <input type="radio" name="attendance[{{ $student->id }}]" value="absent" checked>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Record Attendance</button>
    </form>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif
</div>
@endsection
