@extends('layouts.admin')

@section('main-content')
<div class="container">
    @include('components.admin-metrics')
    <h1>School Activities</h1>
    <h2>{{ $school->name }}</h2>
    <p><strong>Subscription:</strong> {{ $school->subscription ? $school->subscription->name : 'None' }}</p>
    <p><strong>Max Students:</strong> {{ $school->subscription ? $school->subscription->max_students : 'N/A' }}</p>
    <p><strong>Max Staff:</strong> {{ $school->subscription ? $school->subscription->max_staff : 'N/A' }}</p>
    <p><strong>Max Guardians:</strong> {{ $school->subscription ? $school->subscription->max_guardians : 'N/A' }}</p>
    <p><strong>Subscription Fee:</strong> {{ $school->subscription ? $school->subscription->fee : 'N/A' }}</p>

    <h3>Statistics</h3>
    <p><strong>Number of Students:</strong> {{ $studentsCount }}</p>
    <p><strong>Number of Staff:</strong> {{ $staffCount }}</p>
    <p><strong>Number of Guardians:</strong> {{ $guardiansCount }}</p>

    <h3>Update Subscription</h3>
    <form action="{{ route('admin.schools.assign-subscription', $school->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="subscription_id">Subscription</label>
            <select name="subscription_id" class="form-control">
                @foreach($subscriptions as $subscription)
                    <option value="{{ $subscription->id }}" {{ $school->subscription_id == $subscription->id ? 'selected' : '' }}>
                        {{ $subscription->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Subscription</button>
    </form>

    <h3 class="mt-4">Update Payment Status</h3>
    <form action="{{ route('admin.schools.update-payment-status', $school->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="payment_status">Payment Status</label>
            <input type="text" name="payment_status" class="form-control" value="{{ $school->payment_status }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Payment Status</button>
    </form>
</div>
@endsection
