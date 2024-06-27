@extends('layouts.bursar')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <!-- Transactions Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <img src="{{ asset('images/transactions.webp') }}" class="card-img-top" alt="Transactions">
                <div class="card-body">
                    <h3 class="card-title mb-4">Transactions</h3>
                    <a href="{{ route('bursar.transactions.create') }}" class="btn btn-primary mb-2">Record Transaction</a>
                    <a href="{{ route('bursar.transactions.index') }}" class="btn btn-secondary">View Transactions</a>
                </div>
            </div>
        </div>

        <!-- Income Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <img src="{{ asset('images/income.webp') }}" class="card-img-top" alt="Income">
                <div class="card-body">
                    <h3 class="card-title mb-4">Income</h3>
                    <a href="{{ route('bursar.income.create') }}" class="btn btn-primary mb-2">Record Income</a>
                    <a href="{{ route('bursar.financials.index') }}" class="btn btn-secondary">View Financials</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Expenditure Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <img src="{{ asset('images/expenditure.webp') }}" class="card-img-top" alt="Expenditure">
                <div class="card-body">
                    <h3 class="card-title mb-4">Expenditure</h3>
                    <a href="{{ route('bursar.expenditure.create') }}" class="btn btn-primary mb-2">Record Expenditure</a>
                    <a href="{{ route('bursar.financials.index') }}" class="btn btn-secondary">View Financials</a>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <img src="{{ asset('images/reports.webp') }}" class="card-img-top" alt="Reports">
                <div class="card-body">
                    <h3 class="card-title mb-4">Reports</h3>
                    <a href="{{ route('bursar.reports.income') }}" class="btn btn-info mb-2">Income Reports</a>
                    <a href="{{ route('bursar.reports.expenditure') }}" class="btn btn-info">Expenditure Reports</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <img src="{{ asset('images/profile.webp') }}" class="card-img-top" alt="Profile">
                <div class="card-body">
                    <h3 class="card-title mb-4">Profile</h3>
                    <a href="{{ route('bursar.profile.edit') }}" class="btn btn-warning">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 1.5rem; /* Reduced font size */
        font-weight: 700;
    }
    .card-body {
        padding: 20px;
    }
    .btn {
        margin-right: 10px;
    }
</style>
@endsection
