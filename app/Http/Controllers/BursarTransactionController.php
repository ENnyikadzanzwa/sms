<?php
// app/Http/Controllers/BursarTransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class BursarTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('school_id', auth()->user()->school_id)->get();
        return view('bursar.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $students = User::where('school_id', auth()->user()->school_id)->where('role', 'Student')->get();
        return view('bursar.transactions.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'student_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        Transaction::create([
            'amount' => $request->amount,
            'type' => $request->type,
            'student_id' => $request->student_id,
            'description' => $request->description,
            'school_id' => auth()->user()->school_id,
        ]);

        return redirect()->route('bursar.transactions.index')->with('success', 'Transaction recorded successfully.');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $students = User::where('school_id', auth()->user()->school_id)->where('role', 'Student')->get();
        return view('bursar.transactions.edit', compact('transaction', 'students'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'student_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return redirect()->route('bursar.transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('bursar.transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
