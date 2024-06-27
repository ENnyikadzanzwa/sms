<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;

class SchoolRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register_school');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'street_no' => 'required|string|max:255',
            'street_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'type' => 'required|string|in:primary,high',
        ]);

        $school = School::create([
            'name' => $request->name,
            'province' => $request->province,
            'district' => $request->district,
            'contact' => $request->contact,
            'street_no' => $request->street_no,
            'street_name' => $request->street_name,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'type' => $request->type,
        ]);

        return redirect()->route('register.headmaster')->with('school_id', $school->id);
    }
}
