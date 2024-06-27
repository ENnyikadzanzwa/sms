@extends('layouts.bursar')

@section('main-content')
<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Incomes</h3>
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('bursar.income.create') }}" class="btn btn-primary">Record Income</a>
                <input type="text" id="incomeSearch" class="form-control" placeholder="Search incomes..." onkeyup="searchTable('incomeSearch', 'incomeTable')" style="max-width: 300px;">
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="incomeTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Source</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomes as $income)
                            <tr>
                                <td>{{ $income->id }}</td>
                                <td>{{ $income->amount }}</td>
                                <td>{{ $income->source }}</td>
                                <td>{{ $income->description }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('bursar.income.edit', $income->id) }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                    <form action="{{ route('bursar.income.destroy', $income->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
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
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 1.5rem; /* Reduced font size */
        font-weight: 700;
    }
    .table-responsive {
        margin-top: 1rem;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endsection

@section('scripts')
<script>
    function searchTable(inputId, tableId) {
        var input = document.getElementById(inputId);
        var filter = input.value.toUpperCase();
        var table = document.getElementById(tableId);
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) { // start from 1 to skip the header row
            var tds = tr[i].getElementsByTagName("td");
            var showRow = false;

            for (var j = 0; j < tds.length; j++) {
                if (tds[j]) {
                    var txtValue = tds[j].textContent || tds[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        showRow = true;
                        break;
                    }
                }
            }

            if (showRow) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
    });
    @endif
</script>
@endsection
