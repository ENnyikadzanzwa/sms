@extends('layouts.app')

@section('title', 'Headmaster Dashboard')

@section('sidebar')
    @include('partials.sidebars.headmaster')
@endsection

@section('content')
    <h1>Headmaster Dashboard</h1>
    <p>Welcome, Headmaster! Here you can manage teachers, students, and view reports.</p>
@endsection
