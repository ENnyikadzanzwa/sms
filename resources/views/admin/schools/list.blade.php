@extends('layouts.admin')

@section('main-content')
<div class="container">
    @include('components.admin-metrics')
    <h1>Schools</h1>

    <!-- Search and Filter Panel -->
    <div class="mb-3">
        <form action="{{ route('admin.schools.list') }}" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
            </div>
            <div class="form-group mr-2">
                <select name="sort" class="form-control">
                    <option value="">Sort by</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                    <option value="updated_at" {{ request('sort') == 'updated_at' ? 'selected' : '' }}>Date Updated</option>
                </select>
            </div>
            <div class="form-group mr-2">
                <select name="direction" class="form-control">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <!-- Schools Table -->
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
