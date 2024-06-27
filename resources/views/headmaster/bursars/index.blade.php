<!-- resources/views/headmaster/bursars/index.blade.php -->
@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Bursars</h1>
    <a href="{{ route('headmaster.bursars.create') }}" class="btn btn-primary mb-3">Add New Bursar</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bursars as $bursar)
                <tr>
                    <td>{{ $bursar->name }}</td>
                    <td>{{ $bursar->email }}</td>
                    <td>
                        <a href="{{ route('headmaster.bursars.edit', $bursar->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('headmaster.bursars.destroy', $bursar->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a href="{{ route('headmaster.bursars.download-password', $bursar->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-download"></i> Download Password
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
