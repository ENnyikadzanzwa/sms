@extends('guardian.dashboard')

@section('main-content')
<div class="container mt-4">
    <h1>Edit Profile</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guardian.records.updateProfile') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $guardian->name) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $guardian->email) }}" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $guardian->phone_number) }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $guardian->address) }}" required>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $guardian->date_of_birth) }}" required>
        </div>
        <div class="form-group">
            <label for="national_id">National ID:</label>
            <input type="text" class="form-control" id="national_id" name="national_id" value="{{ old('national_id', $guardian->national_id) }}" required>
        </div>
        <div class="form-group">
            <label for="job">Job:</label>
            <input type="text" class="form-control" id="job" name="job" value="{{ old('job', $guardian->job) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
