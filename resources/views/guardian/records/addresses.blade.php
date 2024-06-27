<!-- resources/views/guardian/records/addresses.blade.php -->

@extends('guardian.dashboard')

@section('main-content')
<div class="container mt-4">
    <h1>Addresses</h1>

    @if ($guardian)
    <table class="table">
        <tr>
            <th>Address:</th>
            <td>{{ $guardian->address }}</td>
        </tr>
        <!-- Add more fields as necessary -->
    </table>
    @else
    <p>No addresses found.</p>
    @endif
</div>
@endsection
