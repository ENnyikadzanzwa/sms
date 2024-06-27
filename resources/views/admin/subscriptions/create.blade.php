@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Create Subscription</h1>
    <form action="{{ route('admin.subscriptions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Subscription Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="max_students">Max Students</label>
            <input type="number" class="form-control" id="max_students" name="max_students" required>
        </div>
        <div class="form-group">
            <label for="max_staff">Max Staff</label>
            <input type="number" class="form-control" id="max_staff" name="max_staff" required>
        </div>
        <div class="form-group">
            <label for="max_guardians">Max Guardians</label>
            <input type="number" class="form-control" id="max_guardians" name="max_guardians" required>
        </div>
        <div class="form-group">
            <label for="fee">Subscription Fee</label>
            <input type="number" step="0.01" class="form-control" id="fee" name="fee" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
