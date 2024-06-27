<!-- resources/views/headmaster/guardians/edit.blade.php -->
@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Edit Guardian</h1>

        <form action="{{ route('headmaster.guardians.update', $guardian->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $guardian->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $guardian->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ $guardian->phone_number }}" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $guardian->address }}" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" value="{{ $guardian->date_of_birth }}" required>
            </div>
            <div class="form-group">
                <label for="national_id">National ID</label>
                <input type="text" name="national_id" class="form-control" value="{{ $guardian->national_id }}" required>
            </div>
            <div class="form-group">
                <label for="job">Job</label>
                <input type="text" name="job" class="form-control" value="{{ $guardian->job }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
