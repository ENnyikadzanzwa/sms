@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Add New Term</h1>
        <form action="{{ route('headmaster.terms.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Term Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                @error('start_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="fee">Fee</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="fee" name="fee" value="{{ old('fee') }}" required>
                    <div class="input-group-append">
                        <select class="form-control" id="currency" name="currency" required>
                            <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="ZIG" {{ old('currency') == 'ZIG' ? 'selected' : '' }}>ZIG</option>
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
                <select class="form-control" id="school_year_id" name="school_year_id" required onchange="setDefaultStartDate()">
                    @foreach($schoolYears as $schoolYear)
                        <option value="{{ $schoolYear->id }}" data-start-date="{{ $schoolYear->start_date }}" {{ old('school_year_id') == $schoolYear->id ? 'selected' : '' }}>
                            {{ $schoolYear->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_year_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setDefaultStartDate();

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            @endif
        });

        function setDefaultStartDate() {
            var lastUpdatedTermEndDate = '{{ $lastUpdatedTermEndDate }}';
            console.log('Last Updated Term End Date:', '{{ $lastUpdatedTermEndDate }}');
            document.getElementById('start_date').value = lastUpdatedTermEndDate;
        }
    </script>
@endsection
