@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('sidebar')
    @include('partials.sidebars.teacher')
@endsection

@section('content')
    <h1>Teacher Dashboard</h1>
    <p>Welcome, Teacher! Here you can manage your classes, assignments, and student progress.</p>
@endsection
