<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    @stack('styles')
    <style>
        .navbar {
            background-color: white;
            color: #6a0dad;
            padding: 0.5rem 1rem; /* Reduced padding */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1030;
            position: fixed;
            width: 100%;
            top: 0;
        }
        .navbar .navbar-toggler {
            color: #6a0dad;
            border: none;
        }
        .navbar .form-inline {
            display: flex;
            align-items: center;
            flex-grow: 1;
            justify-content: center;
        }
        .navbar .form-inline input {
            border-radius: 20px;
            padding: 0.3rem 1rem; /* Reduced padding */
            width: 300px;
        }
        .navbar .form-inline button {
            border-radius: 20px;
            margin-left: 10px;
            background-color: #6a0dad;
            color: white;
            border: none;
        }
        .navbar .form-inline button:hover {
            background-color: #5a0ba5;
        }
        .navbar .navbar-nav {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }
        .navbar .nav-item .nav-link {
            color: #6a0dad;
            margin-left: 10px;
            display: flex;
            align-items: center;
            text-decoration: none; /* Remove underlining */
        }
        .navbar .nav-item .nav-link i {
            margin-right: 5px;
            font-size: 1.5rem; /* Increase icon size */
        }
        .navbar .nav-item .nav-link:hover {
            color: #5a0ba5;
        }
        .navbar .nav-item {
            list-style: none; /* Remove dots from profile and logout */
        }
        #menu-toggle {
            border: none;
            background: none;
            color: #6a0dad;
            font-size: 1.5rem;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            font-size: 1.5em;
            color: #6a0dad;
            width: 100%;
            position: fixed;
            top: 56px; /* Adjusted to be below the navbar */
            z-index: 1020;
        }
        .container-fluid {
            background-color: #f8f9fa;
            padding-top: 120px; /* Adjusted to avoid overlap with the fixed navbar and header */
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-light border-right" id="sidebar-wrapper">
                @yield('sidebar')
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light fixed-top">
                    <button class="navbar-toggler" id="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="form-inline mx-auto my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn my-2 my-sm-0" type="submit">Search</button>
                        <ul class="navbar-nav ml-3">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="header">
                    Welcome to Smart School Management System
                </div>

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        document.getElementById("menu-toggle").onclick = function() {
            document.getElementById("wrapper").classList.toggle("toggled");
        };
    </script>
    @stack('scripts')
</body>
</html>
