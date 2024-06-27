@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Edit Inventory Item</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('headmaster.inventory-items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Item Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item->name) }}" required>
        </div>
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $item->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="location_id">Location:</label>
            <select name="location_id" id="location_id" class="form-control" required>
                <option value="">Select Location</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}" {{ $location->id == $item->location_id ? 'selected' : '' }}>{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="supplier_id">Supplier:</label>
            <select name="supplier_id" id="supplier_id" class="form-control" required>
                <option value="">Select Supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $supplier->id == $item->supplier_id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="stock_level">Stock Level:</label>
            <input type="number" class="form-control" id="stock_level" name="stock_level" value="{{ old('stock_level', $item->stock_level) }}" required>
        </div>
        <div class="form-group">
            <label for="restock_level">Restock Level:</label>
            <input type="number" class="form-control" id="restock_level" name="restock_level" value="{{ old('restock_level', $item->restock_level) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
