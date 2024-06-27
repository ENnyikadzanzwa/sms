@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4" style="font-size: 1.5rem;">Edit Student</h2>
            <form action="{{ route('headmaster.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="contact">Contact</label>
                            <input type="text" name="contact" class="form-control" value="{{ $student->contact }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="street_no">Street No</label>
                            <input type="text" name="street_no" class="form-control" value="{{ $address->street_no }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="street_name">Street Name</label>
                            <input type="text" name="street_name" class="form-control" value="{{ $address->street_name }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $address->city }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" value="{{ $address->postal_code }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="guardian_id">Guardian</label>
                            <select name="guardian_id" class="form-control" required>
                                @foreach($guardians as $guardian)
                                    <option value="{{ $guardian->id }}" {{ $student->guardian_id == $guardian->id ? 'selected' : '' }}>{{ $guardian->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
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

@endsection

@section('styles')
<style>
    .container {
        max-width: 1200px;
    }
    .card {
        border-radius: 10px;
    }
    .card-body {
        padding: 20px;
    }
</style>
@endsection
