@extends('guardian.dashboard')

@section('main-content')
<div class="container mt-4">
    <h1>Personal Information</h1>

    @if ($guardian)
    <table class="table">
        <tr>
            <th>Name:</th>
            <td>{{ $guardian->name }}</td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>{{ $guardian->email }}</td>
        </tr>
        <tr>
            <th>Phone Number:</th>
            <td>{{ $guardian->phone_number }}</td>
        </tr>
        <tr>
            <th>Address:</th>
            <td>{{ $guardian->address }}</td>
        </tr>
        <tr>
            <th>Date of Birth:</th>
            <td>{{ $guardian->date_of_birth }}</td>
        </tr>
        <tr>
            <th>National ID:</th>
            <td>{{ $guardian->national_id }}</td>
        </tr>
        <tr>
            <th>Job:</th>
            <td>{{ $guardian->job }}</td>
        </tr>
    </table>
    <a href="{{ route('guardian.records.editProfile') }}" class="btn btn-primary mt-3">Edit Profile</a>
    @else
    <p>No personal information found.</p>
    @endif
</div>
@endsection
