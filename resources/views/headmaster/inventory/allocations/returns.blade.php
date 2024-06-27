@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Returned Items</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Staff</th>
                <th>Quantity</th>
                <th>Returned At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($returns as $return)
                <tr>
                    <td>{{ $return->item->name }}</td>
                    <td>{{ $return->staff->name }}</td>
                    <td>{{ $return->quantity }}</td>
                    <td>{{ $return->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
