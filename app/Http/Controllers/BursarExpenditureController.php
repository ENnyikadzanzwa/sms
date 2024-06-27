<?php
// app/Http/Controllers/BursarExpenditureController.php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use Illuminate\Http\Request;

class BursarExpenditureController extends Controller
{
    public function index()
    {
        $expenditures = Expenditure::where('school_id', auth()->user()->school_id)->get();
        return view('bursar.expenditure.index', compact('expenditures'));
    }

    public function create()
    {
        return view('bursar.expenditure.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'purpose' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Expenditure::create([
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'description' => $request->description,
            'school_id' => auth()->user()->school_id,
        ]);

        return redirect()->route('bursar.expenditure.index')->with('success', 'Expenditure recorded successfully.');
    }

    public function edit($id)
    {
        $expenditure = Expenditure::findOrFail($id);
        return view('bursar.expenditure.edit', compact('expenditure'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'purpose' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $expenditure = Expenditure::findOrFail($id);
        $expenditure->update($request->all());

        return redirect()->route('bursar.expenditure.index')->with('success', 'Expenditure updated successfully.');
    }

    public function destroy($id)
    {
        $expenditure = Expenditure::findOrFail($id);
        $expenditure->delete();

        return redirect()->route('bursar.expenditure.index')->with('success', 'Expenditure deleted successfully.');
    }
}
