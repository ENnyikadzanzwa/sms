<?php
// app/Http/Controllers/BursarReportController.php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expenditure;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BursarReportController extends Controller
{
    public function income(Request $request)
    {
        $query = Income::where('school_id', auth()->user()->school_id);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $incomes = $query->get();

        $incomeData = $incomes->groupBy('source')->map(function($group) {
            return $group->sum('amount');
        });

        return view('bursar.reports.income', compact('incomes', 'incomeData'));
    }
    public function financialSummary()
    {
        $incomes = Income::where('school_id', auth()->user()->school_id)->get();
        $expenditures = Expenditure::where('school_id', auth()->user()->school_id)->get();
        $transactions = Transaction::where('school_id', auth()->user()->school_id)->get();

        return view('bursar.reports.summary', compact('incomes', 'expenditures', 'transactions'));
    }
    public function expenditure()
    {
        $expenditures = Expenditure::where('school_id', auth()->user()->school_id)->get();
        return view('bursar.reports.expenditure', compact('expenditures'));
    }
}
