@extends('layouts.student')

@section('main-content')
<div class="container">
    <h1>Attendance</h1>
    <canvas id="attendanceChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceData = {
            labels: @json($attendanceRecords->pluck('date')),
            datasets: [{
                label: 'Attendance',
                data: @json($attendanceRecords->map(function($record) { return $record->status == 'present' ? 1 : 0; })),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };
        const attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: attendanceData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value ? 'Present' : 'Absent';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
