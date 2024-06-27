<!-- resources/views/headmaster/students/view_student.blade.php -->
@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Student Details</h1>
    <div class="card">
        <div class="card-header">{{ $student->name }}</div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $student->id }}</p>
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Contact:</strong> {{ $student->contact }}</p>
            <p><strong>Address:</strong> {{ $student->address->full_address }}</p>
            <p><strong>Guardian:</strong> {{ $student->guardian->name }}</p>
            <a href="{{ route('headmaster.students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('headmaster.students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <a href="{{ route('headmaster.assignStudentToClass', $student->id) }}" class="btn btn-warning">Assign to Class</a>
        </div>
    </div>
</div>
@endsection
