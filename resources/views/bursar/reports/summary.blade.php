@extends('layouts.bursar')

@section('main-content')
<div class="container">
    <h1>Financial Summary Reports</h1>

    <h2>Income</h2>
    <canvas id="incomeChart"></canvas>

    <h2>Expenditure</h2>
    <canvas id="expenditureChart"></canvas>

    <h2>Transactions</h2>
    <canvas id="transactionChart"></canvas>

    <button id="downloadIncomeCsv" class="btn btn-primary mt-3">Download Income CSV</button>
    <button id="downloadExpenditureCsv" class="btn btn-primary mt-3">Download Expenditure CSV</button>
    <button id="downloadTransactionCsv" class="btn btn-primary mt-3">Download Transaction CSV</button>

    <button id="downloadIncomePng" class="btn btn-primary mt-3">Download Income PNG</button>
    <button id="downloadExpenditurePng" class="btn btn-primary mt-3">Download Expenditure PNG</button>
    <button id="downloadTransactionPng" class="btn btn-primary mt-3">Download Transaction PNG</button>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var incomeData = @json($incomes);
    var expenditureData = @json($expenditures);
    var transactionData = @json($transactions);

    var incomeCtx = document.getElementById('incomeChart').getContext('2d');
    var incomeChart = new Chart(incomeCtx, {
        type: 'bar',
        data: {
            labels: incomeData.map(income => income.created_at.split(' ')[0]),
            datasets: [{
                label: 'Income',
                data: incomeData.map(income => income.amount),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var expenditureCtx = document.getElementById('expenditureChart').getContext('2d');
    var expenditureChart = new Chart(expenditureCtx, {
        type: 'bar',
        data: {
            labels: expenditureData.map(exp => exp.created_at.split(' ')[0]),
            datasets: [{
                label: 'Expenditure',
                data: expenditureData.map(exp => exp.amount),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var transactionCtx = document.getElementById('transactionChart').getContext('2d');
    var transactionChart = new Chart(transactionCtx, {
        type: 'line',
        data: {
            labels: transactionData.map(trans => trans.created_at.split(' ')[0]),
            datasets: [{
                label: 'Transactions',
                data: transactionData.map(trans => trans.amount),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('downloadIncomeCsv').addEventListener('click', function() {
        let csvContent = "data:text/csv;charset=utf-8,"
            + incomeData.map(e => e.created_at.split(' ')[0] + "," + e.amount).join("\n");

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "income-report.csv");
        document.body.appendChild(link);
        link.click();
    });

    document.getElementById('downloadExpenditureCsv').addEventListener('click', function() {
        let csvContent = "data:text/csv;charset=utf-8,"
            + expenditureData.map(e => e.created_at.split(' ')[0] + "," + e.amount).join("\n");

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "expenditure-report.csv");
        document.body.appendChild(link);
        link.click();
    });

    document.getElementById('downloadTransactionCsv').addEventListener('click', function() {
        let csvContent = "data:text/csv;charset=utf-8,"
            + transactionData.map(e => e.created_at.split(' ')[0] + "," + e.amount).join("\n");

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "transaction-report.csv");
        document.body.appendChild(link);
        link.click();
    });

    document.getElementById('downloadIncomePng').addEventListener('click', function() {
        var link = document.createElement('a');
        link.href = incomeChart.toBase64Image();
        link.download = 'income-report.png';
        link.click();
    });

    document.getElementById('downloadExpenditurePng').addEventListener('click', function() {
        var link = document.createElement('a');
        link.href = expenditureChart.toBase64Image();
        link.download = 'expenditure-report.png';
        link.click();
    });

    document.getElementById('downloadTransactionPng').addEventListener('click', function() {
        var link = document.createElement('a');
        link.href = transactionChart.toBase64Image();
        link.download = 'transaction-report.png';
        link.click();
    });
</script>
@endsection
