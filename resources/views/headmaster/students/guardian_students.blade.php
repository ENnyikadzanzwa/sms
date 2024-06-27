<!-- resources/views/headmaster/students/guardian_students.blade.php -->
@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Students for {{ $guardian->name }}</h1>
    <a href="{{ route('headmaster.students.create') }}" class="btn btn-primary mb-3">Add Student</a>
    <div class="card">
        <div class="card-header">Student List</div>
        <div class="card-body">
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}',
                    });
                </script>
            @endif
            @if($students->isEmpty())
                <p>No students available for this guardian.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->contact }}</td>
                                <td>{{ $student->address->full_address }}</td>
                                <td>
                                    <a href="{{ route('headmaster.students.view', $student->id) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('headmaster.students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('headmaster.students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    <a href="{{ route('headmaster.assignStudentToClass', $student->id) }}" class="btn btn-warning">Assign to Class</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
