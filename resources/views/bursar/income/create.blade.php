@extends('layouts.bursar')

@section('main-content')
<div class="container">
    <div class="card mt-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Record Income</h3>
            <form action="{{ route('bursar.income.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" id="amount" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="source">Source</label>
                    <input type="text" name="source" id="source" class="form-control" required>
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
@endsection

@section('scripts')
<script>
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
