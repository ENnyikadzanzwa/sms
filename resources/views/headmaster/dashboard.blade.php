@extends('layouts.app')

@section('title', 'Headmaster Dashboard')

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .content-wrapper {
        display: flex;
        flex-direction: column;
        height: 100vh; /* Ensure it fits without scrolling */
        overflow-y: hidden;
    }
    .main-content {
        display: flex;
        flex-wrap: nowrap;
        flex: 1;
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
        position: relative;
    }
    .metrics-row {
        display: flex;
        justify-content: space-between;
        flex-wrap: nowrap;
        margin-bottom: 20px;
    }
    .metric-box {
        flex: 1;
        max-width: 25%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        margin: 10px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .metric-box img {
        width: 50px;
        height: 50px;
    }
    .attendance-row {
        display: flex;
        justify-content: space-between;
        flex-wrap: nowrap;
        margin-bottom: 20px;
    }
    .attendance-box {
        flex: 1;
        max-width: 33%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        margin: 10px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .attendance-box canvas {
        max-width: 150px;
    }
    .chart {
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        padding: 10px 15px; /* Adjust padding to reduce width */
        border-radius: 20px;
        text-decoration: none;
        text-align: center;
    }
    .link-button:hover {
        background-color: #5a0ba5;
    }
    .link-buttons-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
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
    #calendar {
        width: 100%;
        margin-top: 20px;
    }
    .fc-toolbar {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px; /* Add space below the toolbar */
        height: 60px; /* Reduce the height of the toolbar */
    }
    .fc-toolbar h2 {
        font-size: 1.2em;
        color: #6a0dad;
    }
    .fc-button-group {
        display: flex;
        gap: 5px; /* Reduce the gap between buttons */
    }
    .fc-button {
        font-size: 0.75em; /* Reduce font size */
        padding: 3px 6px; /* Reduce padding */
        border: none;
        color: white;
        background: #2196f3; /* Change color to blue */
        border-radius: 5px;
        cursor: pointer;
    }
    .fc-button-group .fc-button.fc-dayGridMonth-button {
        background-color: #2196f3; /* Blue for Month button */
    }
    .fc-button-group .fc-button.fc-timeGridWeek-button {
        background-color: #2196f3; /* Blue for Week button */
    }
    .fc-button-group .fc-button.fc-timeGridDay-button {
        background-color: #2196f3; /* Blue for Day button */
    }
    .fc-button-primary {
        background-color: #2196f3; /* Default color for other buttons */
    }
    .fc-button:hover {
        opacity: 0.8;
    }
    .fc-day {
        cursor: pointer;
    }
    .fc-day:hover {
        background-color: #f5f5f5;
    }

    @media (max-width: 768px) {
        .main-content {
            flex-direction: column;
        }
        .left-column, .right-column {
            flex: 1;
            max-width: 100%;
        }
        .metrics-row, .attendance-row {
            flex-direction: column;
        }
        .metric-box, .attendance-box {
            max-width: 100%;
            margin: 10px 0;
        }
        #page-content-wrapper {
            margin-left: 0;
            width: 100%;
        }
        .toggled #page-content-wrapper {
            margin-left: 0;
            width: 100%;
        }
        .sidebar {
            width: 250px;
            position: absolute;
            z-index: 1050;
        }
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet">
@endpush

@section('sidebar')
    @include('partials.sidebars.headmaster')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="main-content">
        <div class="left-column">
            <!-- Metric Boxes -->
            <div class="metrics-row">
                <div class="metric-box">
                    <div>
                        <h5>Total Students</h5>
                        <p>{{ $totalStudents }}</p>
                    </div>
                    <img src="{{ asset('images/student-avatar.png') }}" alt="Students">
                </div>
                <div class="metric-box">
                    <div>
                        <h5>Total Staff</h5>
                        <p>{{ $totalStaff }}</p>
                    </div>
                    <img src="{{ asset('images/staff-avatar.png') }}" alt="Staff">
                </div>
                <div class="metric-box">
                    <div>
                        <h5>Working Staff</h5>
                        <p>20</p>
                    </div>
                    <img src="{{ asset('images/working-staff-avatar.png') }}" alt="Working Staff">
                </div>
                <div class="metric-box">
                    <div>
                        <h5>This Month Events</h5>
                        <p>8</p>
                    </div>
                    <img src="{{ asset('images/calendar-avatar.png') }}" alt="Events">
                </div>
            </div>

            <!-- Attendance Charts -->
            <div class="attendance-row">
                <div class="attendance-box">
                    <div>
                        <h5>Student Attendance</h5>
                        <p>Present: 230</p>
                        <p>Absent: 20</p>
                    </div>
                    <canvas id="studentAttendanceChart"></canvas>
                </div>
                <div class="attendance-box">
                    <div>
                        <h5>Teacher Attendance</h5>
                        <p>Present: 300</p>
                        <p>Absent: 20</p>
                    </div>
                    <canvas id="teacherAttendanceChart"></canvas>
                </div>
                <div class="attendance-box">
                    <div>
                        <h5>Staff Attendance</h5>
                        <p>Present: 456</p>
                        <p>Absent: 87</p>
                    </div>
                    <canvas id="staffAttendanceChart"></canvas>
                </div>
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
            <div class="link-buttons-container">
                <a href="#" class="link-button">Schedule Class</a>
                <a href="#" class="link-button">New Admission</a>
            </div>

            <!-- My Progress Card -->
            <div class="card" style="height: 300px;">
                <h5>My Progress</h5>
                <div id="calendar"></div>
            </div>

            <!-- Upcoming Events Card -->
            <div class="card">
                <h5>Upcoming Events</h5>
                <div>
                    <p>Event 1: Sports</p>
                    <p>Event 2: Reds</p>
                </div>
            </div>

            <!-- Class Wise Performance Card -->
            <div class="card">
                <h5>Class Wise Performance</h5>
                <canvas id="classPerformanceChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
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

    // Initialize FullCalendar
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'T',
                month: 'M',
                week: 'W',
                day: 'D'
            },
            customButtons: {
                prev: {
                    text: '<',
                    click: function() {
                        calendar.prev();
                    }
                },
                next: {
                    text: '>',
                    click: function() {
                        calendar.next();
                    }
                }
            },
            dateClick: function(info) {
                alert('Date clicked: ' + info.dateStr);
            }
        });
        calendar.render();
    });

    // Toggle sidebar submenu
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle('show');
    }
</script>
@endpush
