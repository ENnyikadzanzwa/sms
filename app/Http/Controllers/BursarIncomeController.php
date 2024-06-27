<?php
// app/Http/Controllers/BursarIncomeController.php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class BursarIncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::where('school_id', auth()->user()->school_id)->get();
        return view('bursar.income.index', compact('incomes'));
    }

    public function create()
    {
        return view('bursar.income.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'source' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Income::create([
            'amount' => $request->amount,
            'source' => $request->source,
            'description' => $request->description,
            'school_id' => auth()->user()->school_id,
        ]);

        return redirect()->route('bursar.income.index')->with('success', 'Income recorded successfully.');
    }

    public function edit($id)
    {
        $income = Income::findOrFail($id);
        return view('bursar.income.edit', compact('income'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'source' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $income = Income::findOrFail($id);
        $income->update($request->all());

        return redirect()->route('bursar.income.index')->with('success', 'Income updated successfully.');
    }

    public function destroy($id)
    {
        $income = Income::findOrFail($id);
        $income->delete();

        return redirect()->route('bursar.income.index')->with('success', 'Income deleted successfully.');
    }
}
