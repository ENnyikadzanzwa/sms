
@extends('layouts.headmaster')

@section('main-content')
<div class="container-fluid">
    <h1 class="text-center my-4">Expenditure Reports</h1>

    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Expenditure Details</h5>
                <input type="text" id="searchBar" class="form-control" placeholder="Search by description..." onkeyup="searchTable()">
            </div>
            <table class="table table-striped" id="expenditureTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenditures as $expenditure)
                        <tr>
                            <td>{{ $expenditure->created_at->format('Y-m-d') }}</td>
                            <td>{{ $expenditure->description }}</td>
                            <td>{{ $expenditure->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-6">
            <div class="card h-100 chart-container">
                <div class="card-body position-relative">
                    <h5 class="card-title">Expenditure Bar Chart <i class="fas fa-download download-icon" onclick="downloadChart('expenditureBarChart')"></i></h5>
                    <canvas id="expenditureBarChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 chart-container">
                <div class="card-body position-relative">
                    <h5 class="card-title">Expenditure Doughnut Chart <i class="fas fa-download download-icon" onclick="downloadChart('expenditureDoughnutChart')"></i></h5>
                    <canvas id="expenditureDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-6">
            <div class="card h-100 chart-container">
                <div class="card-body position-relative">
                    <h5 class="card-title">Expenditure Line Chart <i class="fas fa-download download-icon" onclick="downloadChart('expenditureLineChart')"></i></h5>
                    <canvas id="expenditureLineChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 chart-container">
                <div class="card-body position-relative">
                    <h5 class="card-title">Expenditure Pie Chart <i class="fas fa-download download-icon" onclick="downloadChart('expenditurePieChart')"></i></h5>
                    <canvas id="expenditurePieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-body {
        padding: 20px;
    }
    .chart-container {
        width: 100%;
        max-width: 600px; /* Set fixed width for all charts */
        margin: 0 auto;
    }
    .chart-container canvas {
        height: 500px !important; /* Set fixed height for all charts */
        width: 100% !important;
    }
    .download-icon {
        cursor: pointer;
        font-size: 1rem;
        float: right;
    }
    #searchBar {
        max-width: 300px;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var expenditureData = @json($expenditures);

    var labels = expenditureData.map(exp => exp.created_at.split(' ')[0]);
    var data = expenditureData.map(exp => exp.amount);
    var descriptions = expenditureData.map(exp => exp.description);

    // Bar Chart
    var ctxBar = document.getElementById('expenditureBarChart').getContext('2d');
    var expenditureBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Expenditure by Date',
                data: data,
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

    // Doughnut Chart
    var ctxDoughnut = document.getElementById('expenditureDoughnutChart').getContext('2d');
    var expenditureDoughnutChart = new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: descriptions,
            datasets: [{
                label: 'Expenditure by Description',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });

    // Line Chart
    var ctxLine = document.getElementById('expenditureLineChart').getContext('2d');
    var expenditureLineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Expenditure by Date',
                data: data,
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

    // Pie Chart
    var ctxPie = document.getElementById('expenditurePieChart').getContext('2d');
    var expenditurePieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: descriptions,
            datasets: [{
                label: 'Expenditure by Description',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });

    // Download chart
    function downloadChart(chartId) {
        var link = document.createElement('a');
        link.href = document.getElementById(chartId).toDataURL('image/png');
        link.download = chartId + '.png';
        link.click();
    }

    // Search table
    function searchTable() {
        var input = document.getElementById("searchBar");
        var filter = input.value.toUpperCase();
        var table = document.getElementById("expenditureTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 0; i < tr.length; i++) {
            var td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                var txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection
