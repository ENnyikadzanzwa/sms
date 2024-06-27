@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Edit Subscription</h1>
    <form action="{{ route('admin.subscriptions.update', $subscription->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Subscription Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $subscription->name }}" required>
        </div>
        <div class="form-group">
            <label for="max_students">Max Students</label>
            <input type="number" class="form-control" id="max_students" name="max_students" value="{{ $subscription->max_students }}" required>
        </div>
        <div class="form-group">
            <label for="max_staff">Max Staff</label>
            <input type="number" class="form-control" id="max_staff" name="max_staff" value="{{ $subscription->max_staff }}" required>
        </div>
        <div class="form-group">
            <label for="max_guardians">Max Guardians</label>
            <input type="number" class="form-control" id="max_guardians" name="max_guardians" value="{{ $subscription->max_guardians }}" required>
        </div>
        <div class="form-group">
            <label for="fee">Subscription Fee</label>
            <input type="number" step="0.01" class="form-control" id="fee" name="fee" value="{{ $subscription->fee }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
