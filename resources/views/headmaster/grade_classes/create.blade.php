@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Add New Class</h1>
        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif
        <form action="{{ route('headmaster.grade_classes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Class Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="grade_id">Grade</label>
                <select name="grade_id" id="grade_id" class="form-control" required>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="school_year_id">School Year</label>
                <select name="school_year_id" id="school_year_id" class="form-control" required>
                    @foreach($schoolYears as $schoolYear)
                        <option value="{{ $schoolYear->id }}">{{ $schoolYear->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="term_id">Term</label>
                <select name="term_id" id="term_id" class="form-control" required>
                    @foreach($terms as $term)
                        <option value="{{ $term->id }}">{{ $term->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Class</button>
        </form>
    </div>
@endsection
