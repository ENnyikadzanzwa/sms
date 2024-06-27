<!-- resources/views/guardian/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div id="sidebar-wrapper" class="d-flex flex-column flex-grow-1">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('guardian.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Guardian Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#recordsSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="fas fa-file-alt"></i> Records
                        </a>
                        <ul class="collapse list-unstyled" id="recordsSubmenu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guardian.records.personalInformation') }}"><i class="fas fa-user"></i> Personal Information</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guardian.childData') }}"><i class="fas fa-child"></i> Access Child's Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guardian.events') }}"><i class="fas fa-calendar-alt"></i> Posted Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guardian.communication') }}"><i class="fas fa-comments"></i> Communication with Staff</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
            <div class="content">
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

                @yield('main-content')
            </div>
        </main>
    </div>
</div>

@endsection
