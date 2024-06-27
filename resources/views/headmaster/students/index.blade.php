@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4" style="font-size: 1.5rem;">Student Records</h2>
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('headmaster.students.create') }}" class="btn btn-primary">Add Student</a>
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="filterButton">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="studentTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $record)
                            <tr>
                                <td>{{ $record->id }}</td>
                                <td>{{ $record->name }}</td>
                                <td>{{ $record->email }}</td>
                                <td>{{ $record->contact }}</td>
                                <td>{{ $record->address->street_no }} {{ $record->address->street_name }}</td>
                                <td>
                                    <a href="{{ route('headmaster.students.view', $record->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('headmaster.students.edit', $record->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('headmaster.students.destroy', $record->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <a href="{{ route('headmaster.assignStudentToClass', $record->id) }}" class="btn btn-warning btn-sm">Assign to Class</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .container {
        max-width: 1200px;
    }
    .card {
        border-radius: 10px;
        margin-top: 20px;
    }
    .card-body {
        padding: 20px;
    }
    .input-group {
        width: 300px;
    }
    .btn-sm {
        margin-right: 5px;
    }
</style>
@endsection

@section('scripts')
<script>
    document.getElementById('filterButton').addEventListener('click', function() {
        // Implement filter logic here
    });

    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.getElementById("studentTable").getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName("td");
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].innerText.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? "" : "none";
        }
    });
</script>
@endsection
