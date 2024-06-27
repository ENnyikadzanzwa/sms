@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Edit Bursar</h1>
    <form action="{{ route('headmaster.bursars.update', $bursar->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $bursar->name }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ $bursar->phone_number }}" required>
            @error('phone_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Bursar</button>
    </form>
</div>
@endsection
