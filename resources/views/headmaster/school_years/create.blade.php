@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4" style="font-size: 1.5rem;">Add New School Year</h2>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('headmaster.school-years.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">School Year Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="form-group mb-3">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .container {
        max-width: 800px;
    }
    .card {
        border-radius: 10px;
    }
    .card-body {
        padding: 20px;
    }
</style>
@endsection
