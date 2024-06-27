@extends('layouts.app')

@section('title', 'Guardian Dashboard')

@section('sidebar')
    @include('partials.sidebars.guardian')
@endsection

@section('content')
    <h1>Guardian Dashboard</h1>
    <p>Welcome, Guardian! Here you can view your child's progress, fees, and notifications.</p>
@endsection
