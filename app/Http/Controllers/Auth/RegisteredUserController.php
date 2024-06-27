<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->createUser($request->all());

        Auth::login($user);

        // Role-based redirection
        $role = $user->role;
        switch ($role) {
            case 'Administrator':
                return redirect()->intended('admin/dashboard');
            case 'Headmaster':
                return redirect()->intended('headmaster/dashboard');
            case 'Bursar':
                return redirect()->intended('bursar/dashboard');
            case 'Staff':
                return redirect()->intended('staff/dashboard');
            case 'Guardian':
                return redirect()->intended('guardian/dashboard');
            case 'Student':
                return redirect()->intended('student/dashboard');
            default:
                return redirect()->intended('dashboard');
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
        ]);
    }

    protected function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }
}
