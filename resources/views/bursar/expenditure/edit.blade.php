@extends('layouts.bursar')

@section('main-content')
<div class="container">
    <div class="card mt-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Edit Expenditure</h3>
            <form action="{{ route('bursar.expenditure.update', $expenditure->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" id="amount" class="form-control" value="{{ $expenditure->amount }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="purpose">Purpose</label>
                    <input type="text" name="purpose" id="purpose" class="form-control" value="{{ $expenditure->purpose }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ $expenditure->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
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
