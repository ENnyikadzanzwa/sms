@extends('layouts.headmaster')
@section('main-content')
    <div class="container">
        <h1>Class Details</h1>
        <p><strong>Name:</strong> {{ $gradeClass->name }}</p>
        <p><strong>Grade:</strong> {{ $gradeClass->grade->name }}</p>
        <p><strong>School Year:</strong> {{ $gradeClass->schoolYear->name }}</p>
        <p><strong>Term:</strong> {{ $gradeClass->term->name }}</p>
    </div>
@endsection
