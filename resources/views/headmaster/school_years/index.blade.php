@extends('layouts.app')

@section('title', 'Headmaster Dashboard')
@push('styles')
<style>
    .sidebar {
        height: 100vh;
        background-color: #4372d8;
        padding-top: 20px;
        position: fixed;
        width: 250px;
        transition: all 0.3s;
        overflow-y: auto; /* Enable scrolling */
    }
    .sidebar .sidebar-heading {
        padding: 20px;
        font-size: 1.5em;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sidebar .sidebar-heading i {
        margin-right: 10px;
    }
    .sidebar .list-group {
        list-style: none;
        padding: 0;
    }
    .sidebar .list-group-item {
        background-color: #4372d8;
        color: white;
        border: none;
        padding: 15px 20px;
        transition: background-color 0.3s, padding-left 0.3s, border-radius 0.3s;
    }
    .sidebar .list-group-item a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .sidebar .list-group-item a .fas {
        margin-right: 10px;
    }
    .sidebar .list-group-item:hover {
        background-color: #5a0ba5;
        padding-left: 25px;
        border-radius: 15px;
    }
    .sidebar .submenu a:hover {
        background-color: #b085f5;
    }
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar::-webkit-scrollbar-track {
        background: #6a0dad;
    }
    .sidebar::-webkit-scrollbar-thumb {
        background: #5a0ba5;
        border-radius: 10px;
    }
    .submenu {
        display: none;
    }
    .submenu.show {
        display: block;
    }
    #page-content-wrapper {
        margin-left: 250px;
        width: calc(100% - 250px);
        transition: all 0.3s;
    }
    .toggled .sidebar {
        margin-left: -250px;
    }
    .toggled #page-content-wrapper {
        margin-left: 0;
        width: 100%;
    }
    .navbar {
        background-color: #ffffff;
        color: black;
    }
    .list-unstyled {
        padding-left: 15px;
    }
</style>
@endpush
@section('sidebar')
    @include('partials.sidebars.headmaster')
@endsection

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4" style="font-size: 1.5rem;">School Years</h2>
            <a href="{{ route('headmaster.school-years.create') }}" class="btn btn-primary mb-3">Add New School Year</a>

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

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th scope="col">School Year Name</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schoolYears as $year)
                        <tr>
                            <td>{{ $year->name }}</td>
                            <td>{{ $year->start_date }}</td>
                            <td>{{ $year->end_date }}</td>
                            <td>
                                <a href="{{ route('headmaster.school-years.edit', $year->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form id="delete-form-{{ $year->id }}" action="{{ route('headmaster.school-years.destroy', $year->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $year->id }})">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this school year!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
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
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endsection
@push('scripts')
<script>
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle('show');
    }
</script>
@endpush
