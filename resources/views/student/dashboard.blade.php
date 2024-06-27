@extends('layouts.student')

@section('main-content')
<div class="container">
    <h1>Student Dashboard</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Grade: {{ $grade ? $grade->name : 'N/A' }}</h5>
            <h5 class="card-title">Class: {{ $gradeClass ? $gradeClass->name : 'N/A' }}</h5>
            <h5 class="card-title">Staff: {{ $staff ? $staff->staff->name : 'N/A' }}</h5>
        </div>
    </div>
</div>
@endsection
