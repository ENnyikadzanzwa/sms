<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;

class BursarController extends Controller
{
    public function index()
    {
        return view('bursar.dashboard');
    }

    public function recordIncome(Request $request)
    {
        $income = new Income();
        $income->description = $request->get('description');
        $income->amount = $request->get('amount');
        $income->school_id = auth()->user()->school_id;
        $income->save();

        return response()->json(['status' => 'Income recorded successfully']);
    }

    public function recordExpense(Request $request)
    {
        $expense = new Expense();
        $expense->description = $request->get('description');
        $expense->amount = $request->get('amount');
        $expense->school_id = auth()->user()->school_id;
        $expense->save();

        return response()->json(['status' => 'Expense recorded successfully']);
    }
}
