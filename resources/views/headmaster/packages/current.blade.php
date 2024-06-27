@extends('layouts.headmaster')
@section('main-content')
<div class="container">
    <h1>Current Package</h1>

    @if($currentSubscription)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $currentSubscription->name }}</h5>
                <p class="card-text">Max Students: {{ $currentSubscription->max_students }}</p>
                <p class="card-text">Max Staff: {{ $currentSubscription->max_staff }}</p>
                <p class="card-text">Max Guardians: {{ $currentSubscription->max_guardians }}</p>
                <p class="card-text">Fee: ${{ $currentSubscription->fee }}</p>
            </div>
        </div>
    @else
        <p>No current subscription found for your school.</p>
    @endif

    <h2>Payment Status</h2>
    @if($paymentProofs->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentProofs as $proof)
                    <tr>
                        <td>${{ $proof->amount }}</td>
                        <td>{{ $proof->status }}</td>
                        <td>{{ $proof->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No payment proofs found for your school.</p>
    @endif
</div>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    </script>
@endif
@endsection
