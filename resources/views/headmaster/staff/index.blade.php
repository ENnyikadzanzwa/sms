<!-- resources/views/headmaster/staff/index.blade.php -->
@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Staff</h1>

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

        <a href="{{ route('headmaster.staff.create') }}" class="btn btn-primary">Add New Staff</a>

        <ul class="list-group mt-3">
            @foreach($staff as $member)
                <li class="list-group-item">
                    {{ $member->name }} {{ $member->surname }} - {{ $member->email }}
                    <a href="{{ route('headmaster.staff.edit', $member->id) }}" class="btn btn-sm btn-warning float-right ml-2">Edit</a>
                    <form action="{{ route('headmaster.staff.destroy', $member->id) }}" method="POST" class="float-right ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    <a href="{{ route('headmaster.staff.download-password', $member->id) }}" class="btn btn-sm btn-info float-right">Download Password</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
