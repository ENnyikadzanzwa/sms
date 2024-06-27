@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Payment Proofs</h1>
    <table class="table">
        <thead>
            <tr>
                <th>School</th>
                <th>Subscription</th>
                <th>Amount</th>
                <th>Proof of Payment</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paymentProofs as $paymentProof)
                <tr>
                    <td>{{ $paymentProof->school->name }}</td>
                    <td>{{ $paymentProof->subscription->name }}</td>
                    <td>${{ $paymentProof->amount }}</td>
                    <td>
                        @if(Storage::exists($paymentProof->proof_of_payment))
                            <a href="{{ route('admin.downloadProof', $paymentProof->id) }}">Download Proof</a>
                        @else
                            <span class="text-danger">File not available</span>
                        @endif
                    </td>
                    <td>{{ $paymentProof->status }}</td>
                    <td>
                        <form action="{{ route('admin.payments.update-status', $paymentProof->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-control" required>
                                <option value="Pending" {{ $paymentProof->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processed" {{ $paymentProof->status == 'Processed' ? 'selected' : '' }}>Processed</option>
                                <option value="Failed" {{ $paymentProof->status == 'Failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
