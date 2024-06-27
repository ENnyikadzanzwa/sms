@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <h1>Return Inventory Item</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('headmaster.inventory-items.return', $item->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Item Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" disabled>
        </div>
        <div class="form-group">
            <label for="staff_id">Select Staff:</label>
            <select class="form-control" id="staff_id" name="staff_id" required>
                @foreach ($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity to Return:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Return Item</button>
    </form>
</div>
@endsection
