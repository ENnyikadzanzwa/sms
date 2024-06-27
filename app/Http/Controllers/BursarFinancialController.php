<?php
// app/Http/Controllers/BursarFinancialController.php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class BursarFinancialController extends Controller
{
    public function index()
    {
        $incomes = Income::where('school_id', auth()->user()->school_id)->get();
        $expenditures = Expenditure::where('school_id', auth()->user()->school_id)->get();
        return view('bursar.financials.index', compact('incomes', 'expenditures'));
    }
}
