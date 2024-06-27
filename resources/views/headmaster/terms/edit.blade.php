@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Edit Term</h1>

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif

        @if($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: '<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                });
            </script>
        @endif

        <form action="{{ route('headmaster.terms.update', $term->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Term Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $term->name) }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $term->start_date) }}" required>
                @error('start_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $term->end_date) }}" required>
                @error('end_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fee">Fee</label>
                <div class="input-group">
                    <input type="number" name="fee" class="form-control" value="{{ old('fee', $term->fee) }}" required>
                    <div class="input-group-append">
                        <select class="form-control" id="currency" name="currency" required>
                            <option value="USD" {{ old('currency', $term->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="ZIG" {{ old('currency', $term->currency) == 'ZIG' ? 'selected' : '' }}>ZIG</option>
                        </select>
                    </div>
                </div>
                @error('fee')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('currency')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="school_year_id">School Year</label>
                <select name="school_year_id" class="form-control" required>
                    @foreach($schoolYears as $schoolYear)
                        <option value="{{ $schoolYear->id }}" {{ old('school_year_id', $term->school_year_id) == $schoolYear->id ? 'selected' : '' }}>
                            {{ $schoolYear->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_year_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Term</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
