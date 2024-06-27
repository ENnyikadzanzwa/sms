<!-- resources/views/staff/dashboard.blade.php -->
@extends('layouts.staff')

@section('main-content')
<div class="container">
    <h1>Staff Dashboard</h1>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Assigned Grade Class</h5>
            <p class="card-text">Grade: {{ $gradeClass->grade->name }}</p>
            <p class="card-text">Class: {{ $gradeClass->name }}</p>
        </div>
    </div>
</div>
@endsection
