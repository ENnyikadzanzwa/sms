@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Add New Grade</h1>

        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            </script>
        @endif

        <form action="{{ route('headmaster.grades.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Grade Name</label>
                <select class="form-control" id="name" name="name" required>
                    @foreach($grades as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Grade</button>
        </form>
    </div>
@endsection
