@extends('layouts.headmaster')

@section('main-content')
<div class="container-fluid">
    <h1 class="text-center my-4">Financial Records</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Incomes</h2>
            <div class="d-flex justify-content-end mb-3">
                <input type="text" id="incomeSearch" class="form-control" placeholder="Search incomes..." onkeyup="searchTable('incomeSearch', 'incomeTable')">
                <div class="dropdown ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="incomeFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter"></i>
                    </button>
                    <div class="dropdown-menu p-3">
                        <label for="incomeStartDate">Start Date:</label>
                        <input type="date" id="incomeStartDate" class="form-control mb-2">
                        <label for="incomeEndDate">End Date:</label>
                        <input type="date" id="incomeEndDate" class="form-control mb-2">
                        <button class="btn btn-primary w-100" onclick="filterByDate('incomeStartDate', 'incomeEndDate', 'incomeTable')">Filter</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="incomeTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Source</th>
                            <th>Description</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomes as $income)
                            <tr>
                                <td>{{ $income->id }}</td>
                                <td>{{ $income->amount }}</td>
                                <td>{{ $income->source }}</td>
                                <td>{{ $income->description }}</td>
                                <td>{{ $income->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Expenditures</h2>
            <div class="d-flex justify-content-end mb-3">
                <input type="text" id="expenditureSearch" class="form-control" placeholder="Search expenditures..." onkeyup="searchTable('expenditureSearch', 'expenditureTable')">
                <div class="dropdown ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="expenditureFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter"></i>
                    </button>
                    <div class="dropdown-menu p-3">
                        <label for="expenditureStartDate">Start Date:</label>
                        <input type="date" id="expenditureStartDate" class="form-control mb-2">
                        <label for="expenditureEndDate">End Date:</label>
                        <input type="date" id="expenditureEndDate" class="form-control mb-2">
                        <button class="btn btn-primary w-100" onclick="filterByDate('expenditureStartDate', 'expenditureEndDate', 'expenditureTable')">Filter</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="expenditureTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Purpose</th>
                            <th>Description</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenditures as $expenditure)
                            <tr>
                                <td>{{ $expenditure->id }}</td>
                                <td>{{ $expenditure->amount }}</td>
                                <td>{{ $expenditure->purpose }}</td>
                                <td>{{ $expenditure->description }}</td>
                                <td>{{ $expenditure->created_at->format('Y-m-d') }}</td>
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
    h1, h2 {
        font-family: 'Roboto', sans-serif;
        font-weight: 700;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .table-responsive {
        margin-top: 1rem;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .dropdown-menu {
        width: 250px;
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

    function filterByDate(startDateId, endDateId, tableId) {
        var startDate = document.getElementById(startDateId).value;
        var endDate = document.getElementById(endDateId).value;
        var table = document.getElementById(tableId);
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) { // start from 1 to skip the header row
            var tdDate = tr[i].getElementsByTagName("td")[4]; // assuming date is the fifth column
            if (tdDate) {
                var txtDate = tdDate.textContent || tdDate.innerText;
                if (startDate && endDate) {
                    if (new Date(txtDate) >= new Date(startDate) && new Date(txtDate) <= new Date(endDate)) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                } else {
                    tr[i].style.display = "";
                }
            }
        }
    }
</script>
@endsection
