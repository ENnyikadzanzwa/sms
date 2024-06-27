<!-- resources/views/headmaster/guardians/index.blade.php -->
@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Guardians</h1>

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

        <a href="{{ route('headmaster.guardians.create') }}" class="btn btn-primary mb-3">Add Guardian</a>

        @if($guardians->isEmpty())
            <p>No guardians available.</p>
        @else
            <ul class="list-group mt-3">
                @foreach($guardians as $guardian)
                    <li class="list-group-item">
                        {{ $guardian->name }} - {{ $guardian->email }}
                        <a href="{{ route('headmaster.guardians.edit', $guardian->id) }}" class="btn btn-sm btn-warning float-right ml-2">Edit</a>
                        <a href="{{ route('headmaster.guardians.students', $guardian->id) }}" class="btn btn-sm btn-info float-right ml-2">Access Child Data</a>
                        <form action="{{ route('headmaster.guardians.destroy', $guardian->id) }}" method="POST" class="float-right ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        <a href="{{ route('headmaster.guardians.download-password', $guardian->id) }}" class="btn btn-sm btn-info float-right">Download Password</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
