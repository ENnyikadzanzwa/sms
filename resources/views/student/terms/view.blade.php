@extends('layouts.student')

@section('main-content')
<div class="container">
    <h1>Terms and Fees</h1>
    @foreach($terms as $term)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $term->name }}</h5>
                <p class="card-text">Fee: {{ $term->fee }} {{ $term->currency }}</p>
                @php
                    $studentTermFee = $term->studentTermFees->first();
                @endphp
                @if($studentTermFee->status == 'Not Paid')
                    <button class="btn btn-primary" data-toggle="modal" data-target="#paymentModal" data-term-id="{{ $term->id }}" data-term-name="{{ $term->name }}" data-term-fee="{{ $term->fee }}">Upload Payment</button>
                @elseif($studentTermFee->status == 'Pending')
                    <p class="card-text text-warning">Payment is being processed...</p>
                @else
                    <p class="card-text text-success">Payment Completed</p>
                @endif
            </div>
        </div>
    @endforeach

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('student.terms.pay') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Upload Payment Proof</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="term_id" id="term_id">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount" readonly>
                        </div>
                        <div class="form-group">
                            <label for="proof_of_payment">Proof of Payment</label>
                            <input type="file" class="form-control" name="proof_of_payment" id="proof_of_payment" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                    </div>
                </form>
            </div>
        </div>
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
    $('#paymentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var termId = button.data('term-id');
        var termName = button.data('term-name');
        var termFee = button.data('term-fee');

        var modal = $(this);
        modal.find('.modal-title').text('Upload Payment Proof for ' + termName);
        modal.find('#amount').val(termFee);
        modal.find('#term_id').val(termId);
        modal.find('#paymentForm').attr('action', '{{ route('student.terms.pay') }}');
    });
</script>
@endsection
