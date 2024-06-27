<!-- resources/views/guardian/events.blade.php -->

@extends('guardian.dashboard')

@section('main-content')
<div class="container mt-4">
    <h1>Posted Events</h1>

    <table class="table">
        @foreach ($events as $event)
            <tr>
                <th>Title:</th>
                <td>{{ $event->title }}</td>
            </tr>
            <tr>
                <th>Description:</th>
                <td>{{ $event->description }}</td>
            </tr>
            <tr>
                <th>Date:</th>
                <td>{{ $event->date }}</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
