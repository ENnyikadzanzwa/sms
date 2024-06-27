<!-- resources/views/guardian/records/contacts.blade.php -->

@extends('guardian.dashboard')

@section('main-content')
<div class="container mt-4">
    <h1>Contacts</h1>

    @if ($guardian)
    <table class="table">
        <tr>
            <th>Phone:</th>
            <td>{{ $guardian->phone }}</td>
        </tr>
        <!-- Add more fields as necessary -->
    </table>
    @else
    <p>No contacts found.</p>
    @endif
</div>
@endsection
