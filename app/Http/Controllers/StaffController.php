<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradeClass;
use App\Models\Student;
use App\Models\Logbook;
use App\Models\GradeClassStaff;
use Auth;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $gradeClass = GradeClass::whereHas('staff', function ($query) use ($user) {
            $query->where('email', $user->email);
        })->first();

        return view('staff.dashboard', compact('gradeClass'));
    }

    public function indexStudents()
    {
        $user = Auth::user();
        $gradeClass = GradeClass::whereHas('staff', function ($query) use ($user) {
            $query->where('email', $user->email);
        })->first();

        if ($gradeClass) {
            $students = $gradeClass->students;
            return view('staff.students.index', compact('students'));
        } else {
            return redirect()->route('staff.dashboard')->with('error', 'You are not assigned to any grade class.');
        }
    }

    public function logBook()
    {
        $user = Auth::user();
        $logbooks = Logbook::where('user_id', $user->id)->get();

        return view('staff.logbook', compact('logbooks'));
    }


    public function logIn()
    {
        $user = Auth::user();
        Logbook::create([
            'user_id' => $user->id,
            'log_in' => now(),
        ]);

        return redirect()->route('staff.logbook')->with('success', 'Logged in successfully.');
    }

    public function logOut()
    {
        $user = Auth::user();
        $logbook = Logbook::where('user_id', $user->id)->latest()->first();

        if ($logbook && $logbook->log_out === null) {
            $logbook->update([
                'log_out' => now(),
            ]);

            return redirect()->route('staff.logbook')->with('success', 'Logged out successfully.');
        }

        return redirect()->route('staff.logbook')->with('error', 'You are not logged in.');
    }

    public function attendance()
    {
        // Get the authenticated user's email
        $userEmail = auth()->user()->email;

        // Find the staff member with the same email
        $staff = Staff::where('email', $userEmail)->first();

        // If the staff member is not found, redirect with an error message
        if (!$staff) {
            return redirect()->route('staff.dashboard')->with('error', 'Staff member not found.');
        }

        // Find the grade class the staff member is assigned to
        $gradeClassStaff = GradeClassStaff::where('staff_id', $staff->id)->first();

        // If the staff member is not assigned to any grade class, redirect with an error message
        if (!$gradeClassStaff) {
            return redirect()->route('staff.dashboard')->with('error', 'You are not assigned to any grade class.');
        }

        // Get the grade class ID
        $gradeClassId = $gradeClassStaff->grade_class_id;

        // Retrieve students assigned to the grade class
        $students = Student::whereHas('gradeClasses', function ($query) use ($gradeClassId) {
            $query->where('grade_class_id', $gradeClassId);
        })->get();

        // Return the attendance view with the list of students
        return view('staff.attendance', compact('students'));
    }


    public function storeAttendance(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $request->date],
                ['status' => $status]
            );
        }

        return redirect()->route('staff.attendance')->with('success', 'Attendance recorded successfully.');
    }
}
