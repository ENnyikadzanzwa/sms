@extends('layouts.app')

@section('title', 'Bursar Dashboard')

@section('sidebar')
    @include('partials.sidebars.bursar')
@endsection

@section('content')
    <h1>Bursar Dashboard</h1>
    <p>Welcome, Bursar! Here you can manage fees, expenditures, and view financial reports.</p>
@endsection
