<!-- resources/views/guardian/childData.blade.php -->

@extends('guardian.dashboard')

@section('main-content')
<div class="container mt-4">
    <h1>Child's Data</h1>

    @if ($children && $children->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Class</th>
                <th>Contact</th>
                <th>School</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($children as $child)
                <tr>
                    <td>{{ $child->name }}</td>
                    <td>{{ $child->class }}</td>
                    <td>{{ $child->contact }}</td>
                    <td>{{ $child->school->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No child data found.</p>
    @endif
</div>
@endsection
