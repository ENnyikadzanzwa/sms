@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('sidebar')
    @include('partials.sidebars.student')
@endsection

@section('content')
    <h1>Student Dashboard</h1>
    <p>Welcome, Student! Here you can view your courses, assignments, and grades.</p>
@endsection
