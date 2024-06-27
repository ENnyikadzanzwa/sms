@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-4" style="font-size: 1.5rem;">Student Details</h2>
    <div class="row">
        <!-- Personal Details -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">{{ $student->name }}</div>
                <div class="card-body">
                    <h4 class="mb-3" style="font-size: 1.25rem;">Personal Details</h4>
                    <p><strong>ID:</strong> {{ $student->id }}</p>
                    <p><strong>Name:</strong> {{ $student->name }}</p>
                    <p><strong>Contact:</strong> {{ $student->contact }}</p>
                    <p><strong>Email:</strong> {{ $student->email }}</p>
                    <p><strong>Address:</strong> {{ $student->address->street_no }}, {{ $student->address->street_name }}, {{ $student->address->city }}, {{ $student->address->postal_code }}</p>
                    <p><strong>Guardian:</strong> {{ $student->guardian->name }}</p>

                    @if($student->gradeClasses->isNotEmpty())
                        <p><strong>Assigned Classes:</strong>
                            <ul>
                                @foreach($student->gradeClasses as $gradeClass)
                                    <li>{{ $gradeClass->name }} ({{ $gradeClass->grade->name }})</li>
                                @endforeach
                            </ul>
                        </p>
                    @else
                        <p><strong>Assigned Classes:</strong> Not assigned to any class</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Financial Status -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">Financial Status</div>
                <div class="card-body">
                    <h4 class="mb-3" style="font-size: 1.25rem;">Financial Status</h4>
                    @if($student->termFees->isNotEmpty())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Term</th>
                                    <th>Fee</th>
                                    <th>Amount Paid</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->termFees as $termFee)
                                    <tr>
                                        <td>{{ $termFee->term->name }}</td>
                                        <td>{{ $termFee->term->fee }} {{ $termFee->term->currency }}</td>
                                        <td>{{ $termFee->amount_paid }}</td>
                                        <td>{{ $termFee->amount_paid >= $termFee->term->fee ? 'Paid' : 'Unpaid' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No financial records found.</p>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-4">
                        <a href="{{ route('headmaster.students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('headmaster.students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <a href="{{ route('headmaster.assignStudentToClass', $student->id) }}" class="btn btn-warning">Assign to Class</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .container {
        max-width: 1200px;
    }
    .card {
        border-radius: 10px;
    }
    .card-body {
        padding: 20px;
    }
</style>
@endsection
