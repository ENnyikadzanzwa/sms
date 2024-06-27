@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Allocate Item</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('headmaster.inventory-allocations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="item_id">Item</label>
            <select name="item_id" class="form-control">
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="staff_id">Staff</label>
            <select name="staff_id" class="form-control">
                @foreach($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}">
        </div>
        <button type="submit" class="btn btn-primary">Allocate</button>
    </form>
</div>
@endsection
