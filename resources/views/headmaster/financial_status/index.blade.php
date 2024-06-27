@extends('layouts.headmaster')

@section('main-content')
<div class="container">
    <h1>Financial Status</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Term</th>
                <th>Fee</th>
                <th>Amount Paid</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                @foreach($student->termFees as $termFee)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $termFee->term->name }}</td>
                        <td>{{ $termFee->term->fee }}</td>
                        <td>{{ $termFee->amount_paid }}</td>
                        <td>{{ $termFee->amount_paid >= $termFee->term->fee ? 'Paid' : 'Unpaid' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
