@extends('layouts.staff')

@section('main-content')
<div class="container">
    <h1>Logbook</h1>

    <form action="{{ route('staff.log.in') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Log In</button>
    </form>

    <form action="{{ route('staff.log.out') }}" method="POST" style="margin-top: 10px;">
        @csrf
        <button type="submit" class="btn btn-danger">Log Out</button>
    </form>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Log In</th>
                <th>Log Out</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logbooks as $logbook)
                <tr>
                    <td>{{ $logbook->log_in }}</td>
                    <td>{{ $logbook->log_out }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
