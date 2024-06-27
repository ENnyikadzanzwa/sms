@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <h1>Items</h1>
    <a href="{{ route('headmaster.inventory-items.create') }}" class="btn btn-primary mb-3">Add New Item</a>
    <a href="{{ route('headmaster.inventory-allocations.returns') }}" class="btn btn-info mb-3">View Returns</a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($restockItems->isNotEmpty())
    <div class="modal fade" id="restockAlertModal" tabindex="-1" aria-labelledby="restockAlertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restockAlertModalLabel">Restock Alerts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach($restockItems as $item)
                            <li>{{ $item->name }} (Current Stock: {{ $item->stock_level }}, Restock Level: {{ $item->restock_level }}) is running low!</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Location</th>
                <th>Stock Level</th>
                <th>Restock Level</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->location->name }}</td>
                    <td>{{ $item->stock_level }}</td>
                    <td>{{ $item->restock_level }}</td>
                    <td>{{ $item->supplier->name }}</td>
                    <td>
                        <a href="{{ route('headmaster.inventory-items.edit', $item->id) }}" class="btn btn-warning mb-2">Edit</a>
                        <form action="{{ route('headmaster.inventory-items.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mb-2">Delete</button>
                        </form>
                        <a href="{{ route('headmaster.inventory-items.restock-view', $item->id) }}" class="btn btn-success mb-2">Restock</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($restockItems->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var restockAlertModal = new bootstrap.Modal(document.getElementById('restockAlertModal'));
        restockAlertModal.show();
    });
</script>
@endif
@endsection

@push('scripts')
<!-- Include Bootstrap JS (make sure it matches your Bootstrap CSS version) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNhuG0URZgkeA5kcuBOcyC9Zm3NNG5FzkOxlJrYyiVzbZZ3Co8qLCkly6Eog7Cz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9SNHf3wG5fWoaUHPNHn2bB9AV+gQF0gB5YF0g5KqR6E7De4w3f6LB5h" crossorigin="anonymous"></script>
@endpush
