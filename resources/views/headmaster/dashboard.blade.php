@extends('layouts.app')

@section('title', 'Headmaster Dashboard')

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .content-wrapper {
        display: flex;
        flex-wrap: nowrap;
        height: 100vh; /* Ensure it fits without scrolling */
        overflow-y: hidden;
    }
    .left-column {
        flex: 3;
        padding: 20px;
        overflow-y: auto; /* Allow scrolling within the column */
    }
    .right-column {
        flex: 1;
        padding: 20px;
        overflow-y: auto; /* Allow scrolling within the column */
    }
    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        padding: 20px;
    }
    .metrics-row {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .metric-box {
        flex: 1;
        min-width: 200px;
        margin: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
    }
    .metric-box img {
        width: 50px;
        height: 50px;
    }
    .chart {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .chart canvas {
        max-width: 200px;
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
    .link-button {
        display: inline-block;
        background-color: #6a0dad;
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        margin-bottom: 20px;
        text-align: center;
        display: block;
    }
    .link-button:hover {
        background-color: #5a0ba5;
    }
    .sidebar {
        height: 100vh;
        background-color: #6a0dad;
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
        background-color: #6a0dad;
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
<div class="content-wrapper">
    <div class="left-column">
        <!-- Metric Boxes -->
        <div class="metrics-row">
            <div class="metric-box card">
                <div>
                    <h5>Total Students</h5>
                    <p>{{ $totalStudents }}</p>
                </div>
                <img src="{{ asset('images/student-avatar.png') }}" alt="Students">
            </div>
            <div class="metric-box card">
                <div>
                    <h5>Total Staff</h5>
                    <p>{{ $totalStaff }}</p>
                </div>
                <img src="{{ asset('images/staff-avatar.png') }}" alt="Staff">
            </div>
            <div class="metric-box card">
                <div>
                    <h5>Working Staff</h5>
                    <p>700</p>
                </div>
                <img src="{{ asset('images/working-staff-avatar.png') }}" alt="Working Staff">
            </div>
            <div class="metric-box card">
                <div>
                    <h5>This Month Events</h5>
                    <p>9</p>
                </div>
                <img src="{{ asset('images/calendar-avatar.png') }}" alt="Events">
            </div>
        </div>

        <!-- Attendance Charts -->
        <div class="card chart">
            <div>
                <h5>Student Attendance</h5>
                <p>Present:500</p>
                <p>Absent: 70</p>
            </div>
            <canvas id="studentAttendanceChart"></canvas>
        </div>
        <div class="card chart">
            <div>
                <h5>Teacher Attendance</h5>
                <p>Present: 58</p>
                <p>Absent: 5</p>
            </div>
            <canvas id="teacherAttendanceChart"></canvas>
        </div>
        <div class="card chart">
            <div>
                <h5>Staff Attendance</h5>
                <p>Present: 98</p>
                <p>Absent: 5</p>
            </div>
            <canvas id="staffAttendanceChart"></canvas>
        </div>

        <!-- Student Directory Table -->
        <div class="card">
            <h5>Student Directory</h5>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Guardian Name</th>
                            <th>Phone</th>
                            <th>Grade</th>
                            <th>Class</th>
                            <th>Fees Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->guardian_name }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->grade }}</td>
                            <td>{{ $student->class }}</td>
                            <td>{{ $student->fees_status }}</td>
                            <td>
                                <!-- Actions buttons like edit, delete -->
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Fees Collection Bar Chart -->
        <div class="card">
            <h5>Fees Collection</h5>
            <canvas id="feesCollectionChart"></canvas>
        </div>
    </div>

    <div class="right-column">
        <!-- Schedule Class and New Admission Links -->
        <a href="#" class="link-button">Schedule Class</a>
        <a href="#" class="link-button">New Admission</a>

        <!-- My Progress Card -->
        <div class="card">
            <h5>My Progress</h5>
            <div id="calendar"></div>
            <a href="#" class="link-button">Add Event</a>
        </div>

        <!-- Upcoming Events Card -->
        <div class="card">
            <h5>Upcoming Events</h5>
            <div>
                <p>Event 1: sports</p>
                <p>Event 2: sports</p>
            </div>
        </div>

        <!-- Class Wise Performance Card -->
        <div class="card">
            <h5>Class Wise Performance</h5>
            <canvas id="classPerformanceChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle('show');
    }

    // Initialize charts
    const studentAttendanceCtx = document.getElementById('studentAttendanceChart').getContext('2d');
    const teacherAttendanceCtx = document.getElementById('teacherAttendanceChart').getContext('2d');
    const staffAttendanceCtx = document.getElementById('staffAttendanceChart').getContext('2d');
    const feesCollectionCtx = document.getElementById('feesCollectionChart').getContext('2d');
    const classPerformanceCtx = document.getElementById('classPerformanceChart').getContext('2d');

    // Example data for charts, replace with your actual data
    const attendanceData = {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [70, 30],
            backgroundColor: ['#4caf50', '#f44336'],
        }]
    };

    const barData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
            label: 'Fees Collected',
            data: [120, 190, 300, 500, 200],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    new Chart(studentAttendanceCtx, {
        type: 'doughnut',
        data: attendanceData,
    });

    new Chart(teacherAttendanceCtx, {
        type: 'doughnut',
        data: attendanceData,
    });

    new Chart(staffAttendanceCtx, {
        type: 'doughnut',
        data: attendanceData,
    });

    new Chart(feesCollectionCtx, {
        type: 'bar',
        data: barData,
    });

    new Chart(classPerformanceCtx, {
        type: 'doughnut',
        data: attendanceData,
    });

    // Initialize calendar (example, replace with your actual calendar initialization)
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            { title: 'Event 1', date: '2023-06-01' },
            { title: 'Event 2', date: '2023-06-15' }
        ]
    });
    calendar.render();
</script>
@endpush
