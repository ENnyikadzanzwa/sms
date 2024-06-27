@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Categories</h1>
    <a href="{{ route('headmaster.inventory-categories.create') }}" class="btn btn-primary">Add New Category</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('headmaster.inventory-categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('headmaster.inventory-categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
