@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <h1>Restock Item: {{ $item->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('headmaster.inventory-items.restock', $item->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="restock_quantity">Quantity to Restock:</label>
            <input type="number" class="form-control" id="restock_quantity" name="restock_quantity" required min="1">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Restock</button>
    </form>
</div>
@endsection
