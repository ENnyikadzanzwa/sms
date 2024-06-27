@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Inventory Allocations</h1>
    <a href="{{ route('headmaster.inventory-allocations.create') }}" class="btn btn-primary mb-3">Allocate Item</a>
    {{-- <a href="{{ route('headmaster.inventory-allocations.createReturn') }}" class="btn btn-secondary mb-3">Return Item</a> --}}
    <a href="{{ route('headmaster.inventory-allocations.returns') }}" class="btn btn-info mb-3">View Returns</a>

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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allocations as $allocation)
                <tr>
                    <td>{{ $allocation->item->name }}</td>
                    <td>{{ $allocation->staff->name }}</td>
                    <td>{{ $allocation->quantity }}</td>
                    <td>
                        <form action="{{ route('headmaster.inventory-allocations.destroy', $allocation->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <form action="{{ route('headmaster.inventory-allocations.storeReturn') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $allocation->item_id }}">
                            <input type="hidden" name="staff_id" value="{{ $allocation->staff_id }}">
                            <input type="number" name="quantity" min="1" max="{{ $allocation->quantity }}" required>
                            <button type="submit" class="btn btn-warning">Return</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
