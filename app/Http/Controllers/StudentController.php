<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\GradeClass;
use App\Models\GradeClassStaff;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Term;
use App\Models\StudentTermFee;
use App\Models\PaymentProof;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Hash;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index()
    {
        $student = Student::where('email', Auth::user()->email)->firstOrFail();
        $gradeClass = $student->gradeClasses->first();
        $grade = $gradeClass ? $gradeClass->grade : null;
        $staff = $gradeClass ? GradeClassStaff::where('grade_class_id', $gradeClass->id)->with('staff')->first() : null;

        return view('student.dashboard', compact('student', 'gradeClass', 'grade', 'staff'));
    }

    public function editProfile()
    {
        $student = Auth::user();
        return view('student.edit_profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8|confirmed',
        ]);

        $student = Auth::user();
        $student->email = $request->email;

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return redirect()->route('student.dashboard')->with('success', 'Profile updated successfully.');
    }

    public function attendance()
    {
        $student = Student::where('email', Auth::user()->email)->firstOrFail();
        $attendanceRecords = Attendance::where('student_id', $student->id)->get();

        return view('student.attendance', compact('attendanceRecords'));
    }
    public function viewTerms()
    {
        $user = Auth::user();
        $student = Student::where('email', $user->email)->first();

        if (!$student) {
            abort(404, "Student not found.");
        }

        $schoolId = $student->school_id;
        $terms = Term::whereHas('schoolYear', function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->with(['schoolYear', 'studentTermFees' => function ($query) use ($student) {
            $query->where('student_id', $student->id);
        }])->get();

        return view('student.terms.view', compact('terms', 'student'));
    }


    public function makePayment(Request $request)
    {
        $request->validate([
            'term_id' => 'required|exists:terms,id',
            'amount' => 'required|numeric|min:0',
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('proof_of_payment')->store('payment_proofs');

        StudentTermFee::create([
            'student_id' => auth()->user()->student->id,
            'term_id' => $request->term_id,
            'amount_paid' => $request->amount,
            'proof_of_payment' => $path,
            'status' => 'Pending',
        ]);

        return redirect()->route('student.terms.view')->with('success', 'Payment proof uploaded successfully. Awaiting admin approval.');
    }

}
