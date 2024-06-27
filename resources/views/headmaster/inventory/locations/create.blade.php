@extends('layouts.headmaster')
@section('main-content')
<div class="container mt-4">
    <h1 class="mb-4">Add New Inventory Location</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('headmaster.inventory-locations.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="name">Location Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Add Location</button>
    </form>
</div>
@endsection
