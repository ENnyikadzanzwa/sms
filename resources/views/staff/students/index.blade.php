@extends('layouts.staff')

@section('main-content')
<div class="container">
    <h1>My Students</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <!-- Add any actions you need, e.g., view, edit, delete -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
