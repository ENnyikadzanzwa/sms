@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Available Packages</h1>
    <div class="row">
        @foreach($subscriptions as $subscription)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $subscription->name }}</h5>
                        <p class="card-text">Max Students: {{ $subscription->max_students }}</p>
                        <p class="card-text">Max Staff: {{ $subscription->max_staff }}</p>
                        <p class="card-text">Max Guardians: {{ $subscription->max_guardians }}</p>
                        <p class="card-text">Fee: ${{ $subscription->fee }}</p>
                        <button class="btn btn-primary" onclick="showPaymentForm({{ $subscription->id }})" id="make-payment-btn-{{ $subscription->id }}">Make Payment</button>
                        <form action="{{ route('headmaster.packages.pay', $subscription->id) }}" method="POST" enctype="multipart/form-data" id="payment-form-{{ $subscription->id }}" style="display: none;">
                            @csrf
                            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
                            <input type="hidden" name="amount" value="{{ $subscription->fee }}">
                            <div class="form-group">
                                <label for="proof_of_payment_{{ $subscription->id }}">Proof of Payment</label>
                                <input type="file" class="form-control" name="proof_of_payment" id="proof_of_payment_{{ $subscription->id }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
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
</div>

<script>
    function showPaymentForm(subscriptionId) {
        document.getElementById('make-payment-btn-' + subscriptionId).style.display = 'none';
        document.getElementById('payment-form-' + subscriptionId).style.display = 'block';
    }
</script>
@endsection
