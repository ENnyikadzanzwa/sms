@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('sidebar')
    @include('partials.sidebars.receptionist')
@endsection

@section('content')
    <h1>Receptionist Dashboard</h1>
    <p>Welcome, Receptionist! Here you can manage visitors, schedules, and enquiries.</p>
@endsection
