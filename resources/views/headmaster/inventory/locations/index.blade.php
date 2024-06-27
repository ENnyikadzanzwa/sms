@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Locations</h1>
    <a href="{{ route('headmaster.inventory-locations.create') }}" class="btn btn-primary">Add New Location</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locations as $location)
                <tr>
                    <td>{{ $location->name }}</td>
                    <td>
                        <a href="{{ route('headmaster.inventory-locations.edit', $location->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('headmaster.inventory-locations.destroy', $location->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
