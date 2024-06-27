@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Available Subscriptions</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Max Students</th>
                <th>Max Staff</th>
                <th>Max Guardians</th>
                <th>Fee</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->name }}</td>
                    <td>{{ $subscription->max_students }}</td>
                    <td>{{ $subscription->max_staff }}</td>
                    <td>{{ $subscription->max_guardians }}</td>
                    <td>{{ $subscription->fee }}</td>
                    <td>
                        <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
