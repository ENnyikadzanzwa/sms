@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Terms</h1>
        <a href="{{ route('headmaster.terms.create') }}" class="btn btn-primary">Add New Term</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Term Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Fee</th>
                    <th>Currency</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($terms as $term)
                    <tr>
                        <td>{{ $term->name }}</td>
                        <td>{{ $term->start_date }}</td>
                        <td>{{ $term->end_date }}</td>
                        <td>{{ $term->fee }}</td>
                        <td>{{ $term->currency }}</td>
                        <td>
                            <a href="{{ route('headmaster.terms.edit', $term->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('headmaster.terms.destroy', $term->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
