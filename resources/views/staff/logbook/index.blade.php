@extends('layouts.staff')

@section('main-content')
<div class="container">
    <h1>Logbook</h1>
    <form action="{{ route('staff.logbook.add') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="action">Action</label>
            <input type="text" class="form-control" id="action" name="action" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Logbook Entry</button>
    </form>

    <h2>Logbook Entries</h2>
    <ul class="list-group">
        @foreach($logbook as $entry)
        <li class="list-group-item">{{ $entry->action }} - {{ $entry->created_at }}</li>
        @endforeach
    </ul>
</div>
@endsection
