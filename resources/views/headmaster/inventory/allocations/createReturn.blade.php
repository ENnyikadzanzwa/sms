@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <h1>Return Item</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('headmaster.inventory-allocations.storeReturn') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="item_id">Item:</label>
            <select name="item_id" id="item_id" class="form-control" required>
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="staff_id">Staff:</label>
            <select name="staff_id" id="staff_id" class="form-control" required>
                @foreach ($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Return Item</button>
    </form>
</div>
@endsection
