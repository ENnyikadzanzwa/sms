@extends('layouts.bursar')

@section('main-content')
<div class="container">
    <div class="card mt-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Record Transaction</h3>
            <form action="{{ route('bursar.transactions.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" id="amount" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="credit">Credit</option>
                        <option value="debit">Debit</option>
                        <option value="fees">Fees</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="student_id">Student</label>
                    <select name="student_id" id="student_id" class="form-control select2" required>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 1.5rem; /* Reduced font size */
        font-weight: 700;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
    });
    @endif
</script>
@endsection
