@extends('layouts.headmaster')
@section('main-content')
<div class="container">
    <h2>Assign Multiple Students to Grade Class</h2>

    <form action="{{ route('headmaster.assignMultipleStudentsStore') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="grade_class">Grade Class</label>
            <select name="grade_class_id" id="grade_class" class="form-control">
                @foreach($gradeClasses as $gradeClass)
                    <option value="{{ $gradeClass->id }}">{{ $gradeClass->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="students">Select Students</label>
            <select name="student_ids[]" id="students" class="form-control" multiple>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assign</button>
    </form>
</div>
@endsection
