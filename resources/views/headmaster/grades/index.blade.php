@extends('layouts.headmaster')
@section('main-content')
    <div class="container">
        <h1>Grades</h1>

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

        <a href="{{ route('headmaster.grades.create') }}" class="btn btn-primary">Add New Grade</a>
        <ul class="list-group mt-3">
            @foreach($grades as $grade)
                <li class="list-group-item">
                    {{ $grade->name }}

                    <form action="{{ route('headmaster.grades.destroy', $grade->id) }}" method="POST" class="float-right mr-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
