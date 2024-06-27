<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HeadmasterRegistrationController extends Controller
{
    public function create(Request $request)
    {
        $school_id = $request->session()->get('school_id');
        if (!$school_id) {
            return redirect()->route('register.school');
        }

        return view('auth.register_headmaster', compact('school_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'school_id' => 'required|exists:schools,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'Headmaster',
            'school_id' => $request->school_id,
        ]);

        return redirect()->route('login')->with('status', 'Headmaster registered successfully. Please log in.');
    }
}
