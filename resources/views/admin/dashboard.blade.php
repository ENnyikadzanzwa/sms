@extends('layouts.admin')

@section('main-content')
<div class="container">
    @include('components.admin-metrics')
    <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">Create Subscription</a>

    <h2>Schools</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subscription</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schools as $school)
                <tr>
                    <td>{{ $school->name }}</td>
                    <td>{{ $school->subscription ? $school->subscription->name : 'None' }}</td>
                    <td>
                        <a href="{{ route('admin.schools.activities', $school->id) }}" class="btn btn-info btn-sm">View Activities</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
