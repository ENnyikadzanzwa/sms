<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\Event;

class GuardianController extends Controller
{
    public function index()
    {
        return view('guardian.dashboard');
    }

    public function fetchStudents()
    {
        $students = Student::where('guardian_id', auth()->user()->id)->get();
        return response()->json($students);
    }

        public function dashboard()
        {
            return view('guardian.dashboard');
        }

        public function personalInformation()
        {
            $guardian = Auth::user();
            return view('guardian.records.personalInformation', compact('guardian'));
        }

        public function contacts()
        {
            $guardian = Auth::user();
            return view('guardian.records.contacts', compact('guardian'));
        }

        public function addresses()
        {
            $guardian = Auth::user();
            return view('guardian.records.addresses', compact('guardian'));
        }

        public function childData()
        {
            $guardian = Auth::user();
            $children = $guardian->students; // Fetch students associated with the guardian
            return view('guardian.childData', compact('children'));
        }

        public function events()
        {
            $events = Event::where('school_id', Auth::user()->school_id)->get(); // Assuming events are related to a school
            return view('guardian.events', compact('events'));
        }

        public function communication()
        {
            return view('guardian.communication');
        }

        public function editProfile()
        {
            $guardian = Auth::user();
            return view('guardian.records.editProfile', compact('guardian'));
        }

        public function updateProfile(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone_number' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'national_id' => 'required|string|max:20',
                'job' => 'required|string|max:255',
            ]);

            $guardian = Auth::user();
            $guardian->update($request->all());

            return redirect()->route('guardian.records.personalInformation')->with('success', 'Profile updated successfully.');
        }
}

