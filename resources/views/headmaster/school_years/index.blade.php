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
    .content-wrapper {
        padding: 20px;
    }
    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        padding: 20px;
    }
    .card h2 {
        margin-bottom: 20px;
    }
    .add-button {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 20px;
    }
    .add-button:hover {
        background-color: #218838;
    }
    .table-wrapper {
        overflow-x: auto;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .table th {
        background-color: #f8f9fa;
    }
    .table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    .action-buttons a, .action-buttons button {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
    }
    .action-buttons a:hover, .action-buttons button:hover {
        background-color: #0056b3;
    }
    .terms-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
        height: 350px; /* Reduced height to fit Gantt chart nicely */
    }
    .terms-card h3 {
        margin-bottom: 20px;
    }
    .gantt-chart {
        width: 100%;
        height: 300px; /* Adjusted height for Gantt chart */
    }
</style>
@endpush
@section('sidebar')
    @include('partials.sidebars.headmaster')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="card">
        <h2>School Years</h2>
        <a href="{{ route('headmaster.school-years.create') }}" class="add-button">Add New School Year</a>

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

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>School Year Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schoolYears as $year)
                        <tr>
                            <td>{{ $year->name }}</td>
                            <td>{{ $year->start_date }}</td>
                            <td>{{ $year->end_date }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('headmaster.school-years.edit', $year->id) }}">Edit</a>
                                <form id="delete-form-{{ $year->id }}" action="{{ route('headmaster.school-years.destroy', $year->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $year->id }})">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="terms-card">
        <h3>Terms for Selected School Year</h3>
        <div id="gantt_chart" class="gantt-chart"></div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle('show');
    }
</script>

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

    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('string', 'Resource');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');

        data.addRows([
            ['Term1', 'Term 1', 'term', new Date(2024, 0, 1), new Date(2024, 3, 1), null, 100, null],
            ['Term2', 'Term 2', 'term', new Date(2024, 4, 1), new Date(2024, 7, 1), null, 100, null],
            ['Term3', 'Term 3', 'term', new Date(2024, 8, 1), new Date(2024, 11, 1), null, 100, null]
        ]);

        var options = {
            height: 300, // Adjusted height for Gantt chart
            gantt: {
                trackHeight: 30,
                barHeight: 20, // Adjust bar height for better fit
                palette: [
                    {
                        "color": "#1b9e77",
                        "dark": "#1b9e77",
                        "light": "#1b9e77"
                    },
                    {
                        "color": "#d95f02",
                        "dark": "#d95f02",
                        "light": "#d95f02"
                    },
                    {
                        "color": "#7570b3",
                        "dark": "#7570b3",
                        "light": "#7570b3"
                    }
                ]
            }
        };

        var chart = new google.visualization.Gantt(document.getElementById('gantt_chart'));

        chart.draw(data, options);
    }
</script>
@endpush
