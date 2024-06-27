@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h2>Assign Student to Grade Class</h2>

    <form action="{{ route('headmaster.assignStudentToClassStore', $student->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="grade_class">Grade Class</label>
            <select name="grade_class_id" id="grade_class" class="form-control">
                @foreach($gradeClasses as $gradeClass)
                    <option value="{{ $gradeClass->id }}">{{ $gradeClass->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assign</button>
    </form>
</div>
@endsection
