<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Event;
use App\Models\Asset;
use App\Models\Inventory;
use App\Models\SchoolYear;
use App\Models\Term;
use App\Models\Grade;
use App\Models\GradeClass;
use App\Models\Income;
use App\Models\Expenditure;
use App\Models\Transaction;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\School;
use App\Models\Guardian;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Staff;
use App\Services\SmsService;
use App\Models\GradeClassStaff;
use App\Models\StudentTermFee;
use App\Models\Subscription;
use App\Models\PaymentProof;
use App\Models\Item;
use App\Models\AssetReturn;
use App\Models\AssetAssignment;
use App\Models\ItemCategory;
use App\Models\ItemLocation;
use App\Models\ItemSupplier;
use App\Models\ItemAllocation;
use App\Models\AssetMaintenance;
use App\Models\Category;
use App\Models\ItemReturn;
use App\Models\Location;
use App\Models\Bursar;


class HeadmasterController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;

        // Metrics
        $totalStudents = Student::where('school_id', $schoolId)->count();
        $totalStaff = Staff::whereHas('user', function($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->count();
        $currentDateTime = now();

        // Reports
        $staffReports = GradeClassStaff::with(['staff', 'gradeClass'])
            ->whereHas('staff.user', function($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })->get();

        // Incomes and Expenditures for the current week
        $incomes = Income::where('school_id', $schoolId)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();

        $expenditures = Expenditure::where('school_id', $schoolId)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();
        $students = Student::where('school_id', $schoolId)->get();

        return view('headmaster.dashboard', compact('totalStudents', 'totalStaff', 'currentDateTime', 'staffReports', 'incomes', 'expenditures','students'));
    }

    public function searchStudents(Request $request)
{
    $query = $request->get('query');
    $students = Student::where('name', 'LIKE', "%{$query}%")
        ->where('school_id', auth()->user()->school_id)
        ->get();
    return response()->json($students);
}

public function searchStaff(Request $request)
{
    $query = $request->get('query');
    $staff = Staff::whereHas('user', function($query) {
        $query->where('school_id', auth()->user()->school_id);
    })->where('name', 'LIKE', "%{$query}%")
    ->get();
    return response()->json($staff);
}

    public function indexStudents()
    {
        $schoolId = auth()->user()->school_id;
        $students = Student::where('school_id', $schoolId)->get();
        return view('headmaster.students.index', compact('students'));
    }

    public function createStudent()
    {
        $guardians = Guardian::where('school_id', auth()->user()->school_id)->get();
        return view('headmaster.students.create', compact('guardians'));
    }
    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:50', // Make contact optional
            'email' => 'required|email|max:255|unique:students,email',
            'street_no' => 'required|string|max:10',
            'street_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'guardian_id' => 'required|integer|exists:guardians,id',
        ]);

        $address = new Address();
        $address->street_no = $request->get('street_no');
        $address->street_name = $request->get('street_name');
        $address->city = $request->get('city');
        $address->postal_code = $request->get('postal_code');
        $address->save();

        $student = new Student();
        $student->name = $request->get('name');
        $student->contact = $request->get('contact'); // Optional contact
        $student->email = $request->get('email'); // Add email field
        $student->address_id = $address->id;
        $student->guardian_id = $request->get('guardian_id');
        $student->school_id = auth()->user()->school_id;
        $student->save();

        // Generate a password for the student
        $password = rand(10000000, 99999999);

        // Create the User instance
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($password);
        $user->role = 'Student';
        $user->school_id = auth()->user()->school_id;
        $user->save();

        // Create financial records for each existing term
        $terms = Term::where('school_year_id', function ($query) {
            $query->select('id')
                ->from('school_years')
                ->where('school_id', auth()->user()->school_id);
        })->get();

        foreach ($terms as $term) {
            StudentTermFee::create([
                'student_id' => $student->id,
                'term_id' => $term->id,
                'amount_paid' => 0,
            ]);
        }

        // Save the password to a text file in the downloads directory
        $fileName = 'downloads/' . $user->email . '.txt';
        Storage::disk('public')->put($fileName, 'Password: ' . $password);

        return redirect()->route('headmaster.students.index')->with('success', 'Student and user created successfully. Password saved to ' . $fileName);
    }

    public function searchGuardians(Request $request)
    {
        $search = $request->input('query');
        $guardians = Guardian::where('name', 'LIKE', "%{$search}%")
                              ->where('school_id', auth()->user()->school_id)
                              ->get();

        return response()->json($guardians);
    }





    public function editStudent($id)
    {
        $student = Student::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $guardians = Guardian::where('school_id', auth()->user()->school_id)->get();
        $address = Address::findOrFail($student->address_id); // Fetch a single Address instance
        return view('headmaster.students.edit', compact('student', 'guardians', 'address'));
    }

    public function studentsForGuardian($guardian_id)
    {
        $schoolId = auth()->user()->school_id;
        $guardian = Guardian::where('school_id', $schoolId)->findOrFail($guardian_id);
        $students = Student::where('guardian_id', $guardian_id)->where('school_id', $schoolId)->get();
        return view('headmaster.students.guardian_students', compact('guardian', 'students'));
    }
    public function viewStudent($id)
    {
        $schoolId = auth()->user()->school_id;
        $student = Student::where('school_id', $schoolId)->with(['address', 'guardian', 'gradeClasses', 'termFees.term'])->findOrFail($id);
        return view('headmaster.students.view_student', compact('student'));
    }



    public function updateStudent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:50',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'street_no' => 'required|string|max:10',
            'street_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'guardian_id' => 'required|integer|exists:guardians,id',
        ]);

        DB::transaction(function () use ($request, $id) {
            $student = Student::where('school_id', auth()->user()->school_id)->findOrFail($id);
            $address = Address::findOrFail($student->address_id);

            $address->street_no = $request->get('street_no');
            $address->street_name = $request->get('street_name');
            $address->city = $request->get('city');
            $address->postal_code = $request->get('postal_code');
            $address->save();

            $student->name = $request->get('name');
            $student->contact = $request->get('contact');
            $student->guardian_id = $request->get('guardian_id');
            $student->email = $request->get('email');
            $student->save();

            $user = User::where('email', $student->email)->first();
            if ($user) {
                $user->name = $request->get('name');
                $user->email = $request->get('email');
                $user->save();
            }
        });

        return redirect()->route('headmaster.students.index')->with('success', 'Student updated successfully');
    }

    public function destroyStudent($id)
    {
        DB::transaction(function () use ($id) {
            $student = Student::where('school_id', auth()->user()->school_id)->findOrFail($id);
            $user = User::where('email', $student->email)->first();

            if ($user) {
                $user->delete();
            }
            $student->delete();
        });

        return redirect()->route('headmaster.students.index')->with('success', 'Student and associated user deleted successfully.');
    }


    public function createEvent(Request $request)
    {
        $event = new Event();
        $event->name = $request->get('name');
        $event->date = $request->get('date');
        $event->description = $request->get('description');
        $event->school_id = auth()->user()->school_id;
        $event->save();

        return response()->json(['status' => 'Event created successfully']);
    }

    public function manageAssets(Request $request)
    {
        $asset = new Asset();
        $asset->name = $request->get('name');
        $asset->category = $request->get('category');
        $asset->state = $request->get('state');
        $asset->school_id = auth()->user()->school_id;
        $asset->save();

        return response()->json(['status' => 'Asset managed successfully']);
    }

    public function manageInventory(Request $request)
    {
        $inventory = new Inventory();
        $inventory->item_name = $request->get('item_name');
        $inventory->category = $request->get('category');
        $inventory->stock_level = $request->get('stock_level');
        $inventory->school_id = auth()->user()->school_id;
        $inventory->save();

        return response()->json(['status' => 'Inventory managed successfully']);
    }

    public function fetchGuardians()
    {
        $guardians = User::where('school_id', auth()->user()->school_id)->where('role', 'Guardian')->get();
        return response()->json($guardians);
    }
    public function manageSchoolYears()
    {
        $schoolYears = SchoolYear::all();

        // Return view with school years data
        return view('school_years.index', compact('schoolYears'));
    }

    public function manageTerms()
    {
        $terms = Term::all();

        // Return view with terms data
        return view('terms.index', compact('terms'));
    }

    public function manageGrades()
    {
        $grades = Grade::all();

        // Return view with grades data
        return view('grades.index', compact('grades'));
    }

    public function manageClasses()
    {
        $classes = GradeClass::all();

        // Return view with classes data
        return view('classes.index', compact('classes'));
    }
    public function indexSchoolYears()
    {
        // Get the authenticated user's school_id
        $schoolId = Auth::user()->school_id;

        // Fetch school years for the authenticated user's school
        $schoolYears = SchoolYear::where('school_id', $schoolId)->get();

        // Pass the school years to the view
        return view('headmaster.school_years.index', ['schoolYears' => $schoolYears]);
    }
    public function indexTerms()
    {
        // Get the authenticated user's school
        $userSchoolId = Auth::user()->school_id;

        // Fetch school years for the user's school
        $schoolYears = SchoolYear::where('school_id', $userSchoolId)->pluck('id');

        // Fetch terms for the school years of the user's school
        $terms = Term::whereIn('school_year_id', $schoolYears)->get();

        // Return view with terms data
        return view('headmaster.terms.index', compact('terms'));
    }


    public function indexGrades()
    {
        $user = Auth::user();
        $grades = Grade::where('school_id', $user->school_id)->get();

        return view('headmaster.grades.index', ['grades' => $grades]);
    }
    public function destroyGrade($id)
    {
        $grade = Grade::findOrFail($id);

        // Check if the grade belongs to the authenticated user's school
        if ($grade->school_id !== Auth::user()->school_id) {
            return redirect()->back()->with('error', 'You do not have permission to delete this grade.');
        }

        $grade->delete();

        return redirect()->route('headmaster.grades.index')->with('success', 'Grade deleted successfully.');
    }
    public function indexClasses()
    {
        // Add your logic here to fetch and return the classes
        $classes = GradeClass::all();

        return view('headmaster.classes.index', ['classes' => $classes]);
    }
    public function createSchoolYear()
    {
        return view('headmaster.school_years.create');
    }



    public function storeSchoolYear(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date|after_or_equal:'.date('Y').'-01-01|before_or_equal:'.date('Y').'-12-31',
            'end_date' => 'required|date|after_or_equal:start_date|before_or_equal:'.date('Y').'-12-31|after_or_equal:'.date('Y').'-08-31',
        ]);

        // Get the authenticated user's school_id
        $schoolId = Auth::user()->school_id;

        // Check if there's already a school year for the current actual year for this school
        $currentYearSchoolYear = SchoolYear::where('school_id', $schoolId)
            ->whereYear('start_date', date('Y'))
            ->first();

        if ($currentYearSchoolYear) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'A school year for the current year already exists for your school.');
        }

        // Set the school_id and year to the validated data
        $validatedData['school_id'] = $schoolId;
        $validatedData['year'] = date('Y');

        // Create a new school year using the validated data
        SchoolYear::create($validatedData);

        // Fetch all school years for the authenticated user's school
        $schoolYears = SchoolYear::where('school_id', $schoolId)->get();

        // Redirect the user to a relevant page
        return view('headmaster.school_years.index', ['schoolYears' => $schoolYears]);
    }
    public function editSchoolYear($id)
    {
        // Fetch the school year by ID
        $schoolYear = SchoolYear::findOrFail($id);

        // Check if the school year belongs to the authenticated user's school
        if ($schoolYear->school_id !== Auth::user()->school_id) {
            session()->flash('error', 'You do not have permission to edit this school year.');
        }

        // Pass the school year to the edit view
        return view('headmaster.school_years.edit', ['schoolYear' => $schoolYear]);
    }

    public function updateSchoolYear(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date|after_or_equal:'.date('Y').'-01-01|before_or_equal:'.date('Y').'-12-31',
            'end_date' => 'required|date|after_or_equal:start_date|before_or_equal:'.date('Y').'-12-31|after_or_equal:'.date('Y').'-08-31',
        ]);

        // Fetch the school year by ID
        $schoolYear = SchoolYear::findOrFail($id);

        // Check if the school year belongs to the authenticated user's school
        if ($schoolYear->school_id !== Auth::user()->school_id) {
            session()->flash('error', 'You do not have permission to edit this school year.');
            return redirect()->back();
        }

        // Update the school year with the validated data
        $schoolYear->update($validatedData);

        // Redirect the user to the school years index page with success message
        session()->flash('success', 'School year updated successfully.');
        return redirect()->route('headmaster.school-years.index');
    }


    public function checkTerms($id)
    {
        $hasTerms = Term::where('school_year_id', $id)->exists();

        return response()->json(['hasTerms' => $hasTerms]);
    }

    public function destroySchoolYear($id)
    {
        // Check if there are terms associated with the school year
        $hasTerms = Term::where('school_year_id', $id)->exists();

        if ($hasTerms) {
            // If there are terms, set an error message in the session
            session()->flash('error', 'There are terms associated with this school year. You cannot delete it unless you delete the terms first.');
            return redirect()->back();
        }

        // If there are no terms, delete the school year
        SchoolYear::destroy($id);

        // Set a success message in the session
        session()->flash('success', 'School year deleted successfully');
        return redirect()->back();
    }




    public function createTerm()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch the school years belonging to the user's school
        $schoolYears = SchoolYear::where('school_id', $user->school_id)->get();

        // Check if there are no school years and prompt the user to create one
        if ($schoolYears->isEmpty()) {
            return view('headmaster.school_years.create')->with('error', 'Please create a school year first.');
        }

        // Fetch the last created term
        $lastCreatedTerm = Term::orderBy('created_at', 'desc')->first();
        $lastUpdatedTermEndDate = $lastCreatedTerm ? $lastCreatedTerm->end_date : now();

        return view('headmaster.terms.create', [
            'schoolYears' => $schoolYears,
            'lastUpdatedTermEndDate' => $lastUpdatedTermEndDate,
        ]);
    }





    public function storeTerm(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'school_year_id' => 'required|exists:school_years,id',
            'fee' => 'required|numeric|min:0',
            'currency' => 'required|string|in:USD,ZIG',
        ]);

        // If validation fails, redirect back with errors and old input
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validation failed.');
        }

        // Get the validated form data
        $validatedData = $validator->validated();

        // Ensure the school year belongs to the user's school
        $schoolYear = SchoolYear::where('id', $validatedData['school_year_id'])
                                ->where('school_id', $user->school_id)
                                ->first();

        if (!$schoolYear) {
            return redirect()->back()->with('error', 'Invalid school year selected.')->withInput();
        }

        $terms = $schoolYear->terms()->orderBy('start_date')->get();

        // Ensure there are only 3 terms per year
        if (count($terms) >= 3) {
            return redirect()->back()->with('error', 'There can only be 3 terms in a school year.')->withInput();
        }

        // Validate term dates
        if (count($terms) == 0) {
            // First term must start on the school year start date
            if ($validatedData['start_date'] != $schoolYear->start_date) {
                return redirect()->back()->with('error', 'The first term must start on the school year start date.')->withInput();
            }
        } else {
            $lastTerm = $terms->last();

            // Subsequent terms must start after the previous term ends and last at least 2 months
            if ($validatedData['start_date'] <= $lastTerm->end_date) {
                return redirect()->back()->with('error', 'Each term must start after the previous term ends.')->withInput();
            }

            $minEndDate = (new \DateTime($validatedData['start_date']))->modify('+2 months');
            if (new \DateTime($validatedData['end_date']) < $minEndDate) {
                return redirect()->back()->with('error', 'Each term must be at least 2 months long.')->withInput();
            }
        }

        // Create a new term record
        $term = new Term();
        $term->name = $validatedData['name'];
        $term->start_date = $validatedData['start_date'];
        $term->end_date = $validatedData['end_date'];
        $term->school_year_id = $validatedData['school_year_id'];
        $term->fee = $validatedData['fee'];
        $term->currency= $validatedData['currency'];
        // Set other properties of the term as needed
        $term->save();

        // Create financial records for each existing student
        $students = Student::where('school_id', auth()->user()->school_id)->get();

        foreach ($students as $student) {
            StudentTermFee::create([
                'student_id' => $student->id,
                'term_id' => $term->id,
                'amount_paid' => 0,
            ]);
        }


        // Redirect back to the page
        return redirect()->back()->with('success', 'Term created successfully');
    }


    public function editTerm($id)
    {
        $term = Term::find($id);
        if (!$term) {
            return redirect()->back()->with('error', 'Term not found.');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Fetch the school years belonging to the user's school
        $schoolYears = SchoolYear::where('school_id', $user->school_id)->get();

        return view('headmaster.terms.edit', compact('term', 'schoolYears'));
    }
    public function updateTerm(Request $request, $id)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'school_year_id' => 'required|exists:school_years,id',
            'fee' => 'required|numeric|min:0',
            'currency' => 'required|string|in:USD,ZIG',
        ]);

        // If validation fails, redirect back with errors and old input
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the validated form data
        $validatedData = $validator->validated();

        // Find the term
        $term = Term::find($id);
        if (!$term) {
            return redirect()->back()->with('error', 'Term not found.')->withInput();
        }

        // Ensure the school year belongs to the user's school
        $schoolYear = SchoolYear::where('id', $validatedData['school_year_id'])
                                 ->where('school_id', $user->school_id)
                                 ->first();

        if (!$schoolYear) {
            return redirect()->back()->with('error', 'Invalid school year selected.')->withInput();
        }

        // Check for overlapping terms
        $overlappingTerm = $schoolYear->terms()
                                      ->where('id', '!=', $term->id)
                                      ->where(function ($query) use ($validatedData) {
                                          $query->whereBetween('start_date', [$validatedData['start_date'], $validatedData['end_date']])
                                              ->orWhereBetween('end_date', [$validatedData['start_date'], $validatedData['end_date']]);
                                      })
                                      ->first();

        if ($overlappingTerm) {
            return redirect()->back()->with('error', 'Term dates overlap with another term.')->withInput();
        }

        // Update the term record
        $term->name = $validatedData['name'];
        $term->start_date = $validatedData['start_date'];
        $term->end_date = $validatedData['end_date'];
        $term->school_year_id = $validatedData['school_year_id'];
        $term->fee = $validatedData['fee'];
        $term->currency = $validatedData['currency'];
        $term->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Term updated successfully.');
    }


    public function destroyTerm($id)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Find the term by id and ensure it belongs to the user's school
        $term = Term::where('id', $id)->whereHas('schoolYear', function($query) use ($user) {
            $query->where('school_id', $user->school_id);
        })->first();

        // Check if the term exists and belongs to the user's school
        if (!$term) {
            return redirect()->back()->with('error', 'Term not found or you do not have permission to delete this term.');
        }

        // Delete the term
        $term->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Term deleted successfully.');
    }
    public function financialStatus()
    {
        $students = Student::with('termFees.term')->where('school_id', auth()->user()->school_id)->get();

        return view('headmaster.financial_status.index', compact('students'));
    }
    public function createGrade()
        {
            $user = Auth::user();
            $school = $user->school; // Assuming the user model has a relationship with the school model
            $schoolType = $school->type; // Assuming the school model has a type attribute

            $primaryGrades = ['ECDA', 'ECDB', 'GRADE1', 'GRADE2', 'GRADE3', 'GRADE4', 'GRADE5', 'GRADE6', 'GRADE7'];
            $secondaryGrades = ['FORM1', 'FORM2', 'FORM3', 'FORM4', 'FORM5', 'FORM6'];

            $grades = $schoolType === 'Primary' ? $primaryGrades : $secondaryGrades;

            return view('headmaster.grades.create', compact('grades'));
        }

        public function storeGrade(Request $request)
    {
        $school = Auth::user()->school;
        $schoolType = $school->type;

        $validGrades = [];
        if ($schoolType === 'Primary') {
            $validGrades = ['ECDA', 'ECDB', 'GRADE1', 'GRADE2', 'GRADE3', 'GRADE4', 'GRADE5', 'GRADE6', 'GRADE7'];
        } elseif ($schoolType === 'High') {
            $validGrades = ['FORM1', 'FORM2', 'FORM3', 'FORM4', 'FORM5', 'FORM6'];
        }

        $request->validate([
            'name' => ['required', Rule::in($validGrades)],
        ]);

        // Check if the grade already exists for the school
        if (Grade::where('school_id', $school->id)->where('name', $request->name)->exists()) {
            return redirect()->back()->with('error', 'Grade has already been created for your particular school.');
        }

        // Create an instance of a grade
        $grade = new Grade();
        $grade->name = $request->name;
        $grade->school_id = $school->id;
        $grade->save();

        return redirect()->route('headmaster.grades.index')->with('success', 'Grade added successfully');
    }

    public function assignStudentToClass($id)
    {
        $student = Student::findOrFail($id);
        $user = Auth::user();

        // Fetch grade classes for the authenticated user's school
        $gradeClasses = GradeClass::whereHas('grade', function ($query) use ($user) {
            $query->where('school_id', $user->school_id);
        })->get();

        return view('headmaster.students.assign', compact('student', 'gradeClasses'));
    }

    public function assignStudentToClassStore(Request $request, $id)
    {
        $request->validate([
            'grade_class_id' => 'required|exists:grade_classes,id',
        ]);

        $student = Student::findOrFail($id);

        // Check if the student is already assigned to a class
        if ($student->gradeClasses()->exists()) {
            return redirect()->back()->with('error', 'Student is already assigned to a class.');
        }

        $student->gradeClasses()->sync([$request->grade_class_id]);

        return redirect()->route('headmaster.students.index')->with('success', 'Student assigned to class successfully.');
    }
    public function assignMultipleStudents()
    {
        $user = Auth::user();

        // Fetch students for the authenticated user's school
        $students = Student::where('school_id', $user->school_id)->get();

        // Fetch grade classes for the authenticated user's school
        $gradeClasses = GradeClass::whereHas('grade', function ($query) use ($user) {
            $query->where('school_id', $user->school_id);
        })->get();

        return view('headmaster.students.assign_multiple', compact('students', 'gradeClasses'));
    }

    public function assignMultipleStudentsStore(Request $request)
    {
        $request->validate([
            'grade_class_id' => 'required|exists:grade_classes,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $gradeClass = GradeClass::findOrFail($request->grade_class_id);

        // Check if any of the students are already assigned to a class
        $alreadyAssignedStudents = Student::whereIn('id', $request->student_ids)
            ->whereHas('gradeClasses')
            ->get();

        if ($alreadyAssignedStudents->isNotEmpty()) {
            $assignedStudentNames = $alreadyAssignedStudents->pluck('name')->implode(', ');
            return redirect()->back()->with('error', "The following students are already assigned to a class: $assignedStudentNames.");
        }

        $gradeClass->students()->sync($request->student_ids);

        return redirect()->route('headmaster.students.index')->with('success', 'Students assigned to class successfully.');
    }


    public function indexGradeClasses()
    {
        $user = Auth::user();

        $gradeClasses = GradeClass::with(['grade', 'staff'])
            ->whereHas('grade', function ($query) use ($user) {
                $query->whereHas('school', function ($query) use ($user) {
                    $query->where('school_id', $user->school_id);
                });
            })
            ->whereHas('grade.school.schoolYears', function ($query) use ($user) {
                $query->whereHas('terms', function ($query) use ($user) {
                    $query->where('school_year_id', function ($subquery) use ($user) {
                        $subquery->select('id')
                                ->from('school_years')
                                ->where('school_id', $user->school_id);
                    });
                });
            })
            ->get();

        return view('headmaster.grade_classes.index', compact('gradeClasses'));
    }



    public function createGradeClass()
    {
        $user = Auth::user();
        $grades = Grade::where('school_id', $user->school_id)->get();
        $schoolYears = SchoolYear::where('school_id', $user->school_id)->get();
        $terms = Term::whereHas('schoolYear', function ($query) use ($user) {
            $query->where('school_id', $user->school_id);
        })->get();

        return view('headmaster.grade_classes.create', compact('grades', 'schoolYears', 'terms'));
    }

    public function storeGradeClass(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_id' => 'required|exists:grades,id',
        ]);

        GradeClass::create([
            'name' => $request->name,
            'grade_id' => $request->grade_id,
        ]);

        return redirect()->route('headmaster.grade_classes.index')->with('success', 'Class added successfully.');
    }

    public function editGradeClass($id)
    {
        $gradeClass = GradeClass::findOrFail($id);
        $user = Auth::user();
        $grades = Grade::where('school_id', $user->school_id)->get();
        $schoolYears = SchoolYear::where('school_id', $user->school_id)->get();
        $terms = Term::whereHas('schoolYear', function ($query) use ($user) {
            $query->where('school_id', $user->school_id);
        })->get();

        return view('headmaster.grade_classes.edit', compact('gradeClass', 'grades', 'schoolYears', 'terms'));
    }

    public function updateGradeClass(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_id' => 'required|exists:grades,id',
            'school_year_id' => 'required|exists:school_years,id',
            'term_id' => 'required|exists:terms,id',
        ]);

        $gradeClass = GradeClass::findOrFail($id);
        $gradeClass->update($request->all());

        return redirect()->route('headmaster.grade_classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroyGradeClass($id)
    {
        $gradeClass = GradeClass::findOrFail($id);
        $gradeClass->delete();

        return redirect()->route('headmaster.grade_classes.index')->with('success', 'Class deleted successfully.');
    }

    public function showGradeClass($id)
    {
        $gradeClass = GradeClass::findOrFail($id);
        return view('headmaster.grade_classes.show', compact('gradeClass'));
    }
    public function indexGuardians()
    {
        $schoolId = Auth::user()->school_id;
        $guardians = Guardian::where('school_id', $schoolId)->get();
        return view('headmaster.guardians.index', compact('guardians'));
    }


    public function createGuardian()
    {
        $schoolId = auth()->user()->school_id;
        $school = School::find($schoolId);

        // Check if the school has reached the maximum number of guardians
        $currentGuardianCount = User::where('school_id', $schoolId)->where('role', 'Guardian')->count();
        if ($school->subscription && $currentGuardianCount >= $school->subscription->max_guardians) {
            return redirect()->route('headmaster.guardians.index')->with('error', 'You have reached the maximum number of guardians for your current subscription package. Please update your package to register more guardians.');
        }

        return view('headmaster.guardians.create');
    }

    public function storeGuardian(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $school = School::find($schoolId);

        // Check if the school has reached the maximum number of guardians
        $currentGuardianCount = User::where('school_id', $schoolId)->where('role', 'Guardian')->count();
        if ($school->subscription && $currentGuardianCount >= $school->subscription->max_guardians) {
            return redirect()->route('headmaster.guardians.index')->with('error', 'You have reached the maximum number of guardians for your current subscription package. Please update your package to register more guardians.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'required|regex:/^07\d{8}$/',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'national_id' => 'required|string|max:20',
            'job' => 'required|string|max:255',
        ]);

        try {
            // Create Guardian with school_id
            $guardian = Guardian::create(array_merge($validatedData, ['school_id' => $schoolId]));

            // Generate an 8-digit random password
            $password = rand(10000000, 99999999);

            // Create User
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($password),
                'role' => 'Guardian', // Ensure you have this role in your User model
                'school_id' => $schoolId,
            ]);

            // Save the password to a text file using the guardian's email
            $fileName = 'downloads/' . $validatedData['email'] . '.txt';
            $content = 'Password: ' . $password . ' Username: ' . $validatedData['email'];
            Storage::disk('public')->put($fileName, $content);

            return redirect()->route('headmaster.guardians.index')->with('success', 'Guardian created successfully and user account generated. Password file saved to downloads.');
        } catch (\Exception $e) {
            return redirect()->route('headmaster.guardians.create')->with('error', 'Error creating guardian and user: ' . $e->getMessage());
        }
    }
    // app/Http/Controllers/GuardianController.php



    public function downloadPasswordGurdian($id)
    {
        $guardian = Guardian::findOrFail($id);

        // Assuming the password is stored in a file named after the guardian's email
        $fileName = 'downloads/' . $guardian->email . '.txt';

        if (!Storage::disk('public')->exists($fileName)) {
            return redirect()->route('headmaster.guardians.index')->with('error', 'Password file not found.');
        }

        return Storage::disk('public')->download($fileName);
    }

    public function editGuardian($id)
    {
        $guardian = Guardian::findOrFail($id);
        return view('headmaster.guardians.edit', compact('guardian'));
    }

    public function updateGuardian(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|regex:/^07\d{8}$/',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'national_id' => 'required|string|max:20',
            'job' => 'required|string|max:255',
        ]);

        try {
            $guardian = Guardian::findOrFail($id);
            $guardian->update($validatedData);
            return redirect()->route('headmaster.guardians.index')->with('success', 'Guardian updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('headmaster.guardians.index')->with('error', 'Error updating guardian.');
        }
    }

    public function destroyGuardian($id)
    {
        try {
            $guardian = Guardian::findOrFail($id);
            $guardian->delete();
            return redirect()->route('headmaster.guardians.index')->with('success', 'Guardian deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('headmaster.guardians.index')->with('error', 'Error deleting guardian.');
        }
    }
    // staff logic
    public function indexStaff()
    {
        $staff = Staff::all();
        return view('headmaster.staff.index', compact('staff'));
    }
    private $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }
    public function createStaff()
    {
        $schoolId = auth()->user()->school_id;
        $school = School::find($schoolId);

        // Check if the school has reached the maximum number of staff
        $currentStaffCount = User::where('school_id', $schoolId)->where('role', 'Staff')->count();
        if ($school->subscription && $currentStaffCount >= $school->subscription->max_staff) {
            return redirect()->route('headmaster.staff.index')->with('error', 'You have reached the maximum number of staff for your current subscription package. Please update your package to register more staff.');
        }

        return view('headmaster.staff.create');
    }

    public function storeStaff(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $school = School::find($schoolId);

        // Check if the school has reached the maximum number of staff
        $currentStaffCount = User::where('school_id', $schoolId)->where('role', 'Staff')->count();
        if ($school->subscription && $currentStaffCount >= $school->subscription->max_staff) {
            return redirect()->route('headmaster.staff.index')->with('error', 'You have reached the maximum number of staff for your current subscription package. Please update your package to register more staff.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'national_id' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^07\d{8}$/',
            'date_of_birth' => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'highest_education_level' => 'required|string|max:255',
        ]);

        $staff = Staff::create($validatedData);

        // Generate random password
        $password = rand(10000000, 99999999);

        // Create user instance
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'Staff',
            'school_id' => $schoolId,
        ]);

        // Save password to a file in the public downloads directory using the staff's email
        $fileName = 'downloads/' . $request->email . '.txt';
        $content = 'Password: ' . $password . ' Username: ' . $request->email;
        Storage::disk('public')->put($fileName, $content);

        return redirect()->route('headmaster.staff.index')->with('success', 'Staff created successfully. Password file saved to downloads.');
    }

    // app/Http/Controllers/StaffController.php




    public function downloadPasswordStaff($id)
    {
        $staff = Staff::findOrFail($id);

        // Assuming the password is stored in a file named after the staff's email
        $fileName = 'downloads/' . $staff->email . '.txt';

        if (!Storage::disk('public')->exists($fileName)) {
            return redirect()->route('headmaster.staff.index')->with('error', 'Password file not found.');
        }

        return Storage::disk('public')->download($fileName);
    }



    private function sendSms($phoneNumber, $password)
    {
        // Remove the first character and format phone number to E.164
        $formattedPhoneNumber = '+263' . substr($phoneNumber, 1);

        $message = "Your account has been created. Your password is: $password";
        $this->smsService->send($formattedPhoneNumber, $message);
    }

    public function editStaff($id)
    {
        $staff = Staff::findOrFail($id);
        return view('headmaster.staff.edit', compact('staff'));
    }

    public function updateStaff(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:staff,email,' . $id,
            'national_id' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^07\d{8}$/',
            'date_of_birth' => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'highest_education_level' => 'required|string|max:255',
        ]);

        $staff = Staff::findOrFail($id);
        $staff->update($validatedData);
        return redirect()->route('headmaster.staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroyStaff($id)
    {
        $staff = Staff::findOrFail($id);

        // Find the user with the same email as the staff
        $user = User::where('email', $staff->email)->first();

        // Delete the user if found
        if ($user) {
            $user->delete();
        }

        // Delete the staff
        $staff->delete();

        return redirect()->route('headmaster.staff.index')->with('success', 'Staff and associated user deleted successfully.');
    }

    public function assignStaff($id)
    {
        $gradeClass = GradeClass::findOrFail($id);

        // Get the school ID of the authenticated user
        $schoolId = auth()->user()->school_id;

        // Get the staff who belong to the same school as the authenticated user
        $staffs = Staff::whereHas('user', function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->get();

        return view('headmaster.grade_classes.assign_staff', compact('gradeClass', 'staffs'));
    }

    public function assignStaffStore(Request $request, $id)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
        ]);

        $gradeClass = GradeClass::findOrFail($id);
        $staffId = $request->input('staff_id');

        // Check if the staff belongs to the same school as the authenticated user
        $schoolId = auth()->user()->school_id;
        $staff = Staff::findOrFail($staffId);

        if ($staff->user->school_id !== $schoolId) {
            return redirect()->route('headmaster.grade_classes.assign_staff', $gradeClass->id)
                ->with('error', 'This staff does not belong to your school.');
        }

        // Check if the staff is already assigned to another grade class
        if (GradeClassStaff::where('staff_id', $staffId)->exists()) {
            return redirect()->route('headmaster.grade_classes.assign_staff', $gradeClass->id)
                ->with('error', 'This staff is already assigned to another grade class.');
        }

        // Check if the grade class already has 2 teachers
        if (GradeClassStaff::where('grade_class_id', $gradeClass->id)->count() >= 2) {
            return redirect()->route('headmaster.grade_classes.assign_staff', $gradeClass->id)
                ->with('error', 'This grade class already has 2 teachers.');
        }

        GradeClassStaff::create([
            'grade_class_id' => $gradeClass->id,
            'staff_id' => $staffId,
        ]);

        return redirect()->route('headmaster.grade_classes.index')
            ->with('success', 'Staff assigned successfully.');
    }
    // packages
    public function currentPackage()
    {
        $school = auth()->user()->school;
        $currentSubscription = $school->subscription;
        $paymentProofs = PaymentProof::where('school_id', $school->id)->orderBy('created_at', 'desc')->get();

        return view('headmaster.packages.current', compact('currentSubscription', 'paymentProofs'));
    }
    public function viewPackages()
    {
        $subscriptions = Subscription::all();
        return view('headmaster.packages.view', compact('subscriptions'));
    }

    public function makePayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('proof_of_payment')->store('payment_proofs');

        PaymentProof::create([
            'school_id' => auth()->user()->school_id,
            'subscription_id' => $id,
            'amount' => $request->amount,
            'proof_of_payment' => $path,
            'status' => 'Pending',
        ]);

        return redirect()->route('headmaster.packages.view')->with('success', 'Payment proof uploaded successfully. Awaiting admin approval.');
    }

// Inventory Management
   // Inventory Locations
   public function indexInventoryLocations()
   {
       $locations = ItemLocation::where('school_id', Auth::user()->school_id)->get();
       return view('headmaster.inventory.locations.index', compact('locations'));
   }

   public function createInventoryLocation()
   {
       return view('headmaster.inventory.locations.create');
   }

   public function storeInventoryLocation(Request $request)
   {
       $request->validate([
           'name' => 'required|string|max:255',
       ]);

       ItemLocation::create([
           'school_id' => Auth::user()->school_id,
           'name' => $request->name,
       ]);

       return redirect()->route('headmaster.inventory-locations.index')->with('success', 'Location created successfully.');
   }

   public function editInventoryLocation($id)
   {
       $location = ItemLocation::where('school_id', Auth::user()->school_id)->findOrFail($id);
       return view('headmaster.inventory.locations.edit', compact('location'));
   }

   public function updateInventoryLocation(Request $request, $id)
   {
       $request->validate([
           'name' => 'required|string|max:255',
       ]);

       $location = ItemLocation::where('school_id', Auth::user()->school_id)->findOrFail($id);
       $location->update([
           'name' => $request->name,
       ]);

       return redirect()->route('headmaster.inventory-locations.index')->with('success', 'Location updated successfully.');
   }

   public function destroyInventoryLocation($id)
   {
       $location = ItemLocation::where('school_id', Auth::user()->school_id)->findOrFail($id);
       $location->delete();
       return redirect()->route('headmaster.inventory-locations.index')->with('success', 'Location deleted successfully.');
   }

   // Inventory Categories
   public function indexInventoryCategories()
   {
       $categories = ItemCategory::where('school_id', Auth::user()->school_id)->get();
       return view('headmaster.inventory.categories.index', compact('categories'));
   }

   public function createInventoryCategory()
   {
       return view('headmaster.inventory.categories.create');
   }

   public function storeInventoryCategory(Request $request)
   {
       $request->validate([
           'name' => 'required|string|max:255',
       ]);

       ItemCategory::create([
           'school_id' => Auth::user()->school_id,
           'name' => $request->name,
       ]);

       return redirect()->route('headmaster.inventory-categories.index')->with('success', 'Category created successfully.');
   }

   public function editInventoryCategory($id)
   {
       $category = ItemCategory::where('school_id', Auth::user()->school_id)->findOrFail($id);
       return view('headmaster.inventory.categories.edit', compact('category'));
   }

   public function updateInventoryCategory(Request $request, $id)
   {
       $request->validate([
           'name' => 'required|string|max:255',
       ]);

       $category = ItemCategory::where('school_id', Auth::user()->school_id)->findOrFail($id);
       $category->update([
           'name' => $request->name,
       ]);

       return redirect()->route('headmaster.inventory-categories.index')->with('success', 'Category updated successfully.');
   }

   public function destroyInventoryCategory($id)
   {
       $category = ItemCategory::where('school_id', Auth::user()->school_id)->findOrFail($id);
       $category->delete();
       return redirect()->route('headmaster.inventory-categories.index')->with('success', 'Category deleted successfully.');
   }

   // Inventory Items
//    public function indexInventoryItems()
//    {
//        $items = Item::with(['category', 'location'])
//            ->where('school_id', Auth::user()->school_id)
//            ->get();
//        return view('headmaster.inventory.items.index', compact('items'));
//    }
        public function indexInventoryItems()
        {
            $schoolId = Auth::user()->school_id;
            $items = Item::with(['category', 'location'])
                        ->where('school_id', $schoolId)
                        ->get();

            $restockItems = $items->filter(function($item) {
                return $item->needsRestock();
            });

            return view('headmaster.inventory.items.index', compact('items', 'restockItems'));
        }

   public function createInventoryItem()
   {
       $categories = ItemCategory::where('school_id', Auth::user()->school_id)->get();
       $locations = ItemLocation::where('school_id', Auth::user()->school_id)->get();
       $suppliers = ItemSupplier::where('school_id', Auth::user()->school_id)->get();
       return view('headmaster.inventory.items.create', compact('categories', 'locations', 'suppliers'));
   }

   public function storeInventoryItem(Request $request)
   {
       $request->validate([
           'name' => 'required|string|max:255',
           'category_id' => 'required|exists:item_categories,id',
           'location_id' => 'required|exists:item_locations,id',
           'stock_level' => 'required|integer|min:0',
           'restock_level' => 'required|integer|min:0',
           'supplier_id' => 'required|exists:item_suppliers,id',
       ]);

       Item::create([
           'school_id' => Auth::user()->school_id,
           'name' => $request->name,
           'category_id' => $request->category_id,
           'location_id' => $request->location_id,
           'stock_level' => $request->stock_level,
           'restock_level' => $request->restock_level,
           'supplier_id' => $request->supplier_id,
       ]);

        return redirect()->route('headmaster.inventory-items.index')->with('success', 'Item created successfully.');
    }

    public function editInventoryItem($id)
    {
        $item = Item::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $categories = ItemCategory::where('school_id', Auth::user()->school_id)->get();
        $locations = ItemLocation::where('school_id', Auth::user()->school_id)->get();
        $suppliers = ItemSupplier::where('school_id', Auth::user()->school_id)->get();
        return view('headmaster.inventory.items.edit', compact('item', 'categories', 'locations', 'suppliers'));
    }

    public function updateInventoryItem(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:item_categories,id',
            'location_id' => 'required|exists:item_locations,id',
            'stock_level' => 'required|integer|min:0',
            'restock_level' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:item_suppliers,id',
        ]);

        $item = Item::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'location_id' => $request->location_id,
            'stock_level' => $request->stock_level,
            'restock_level' => $request->restock_level,
            'supplier_id' => $request->supplier_id,
        ]);

        return redirect()->route('headmaster.inventory-items.index')->with('success', 'Item updated successfully.');
    }

    public function destroyInventoryItem($id)
    {
        $item = Item::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $item->delete();
        return redirect()->route('headmaster.inventory-items.index')->with('success', 'Item deleted successfully.');
    }

    // Inventory Suppliers
    public function indexItemSuppliers()
    {
        $schoolId = Auth::user()->school_id;
        $suppliers = ItemSupplier::where('school_id', $schoolId)->get();
        return view('headmaster.inventory.suppliers.index', compact('suppliers'));
    }

    public function createItemSupplier()
    {
        return view('headmaster.inventory.suppliers.create');
    }

    public function storeItemSupplier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        ItemSupplier::create([
            'school_id' => Auth::user()->school_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        return redirect()->route('headmaster.item-suppliers.index')->with('success', 'Supplier added successfully.');
    }

    public function editItemSupplier($id)
    {
        $supplier = ItemSupplier::where('school_id', Auth::user()->school_id)->findOrFail($id);
        return view('headmaster.inventory.suppliers.edit', compact('supplier'));
    }

    public function updateItemSupplier(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $supplier = ItemSupplier::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $supplier->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        return redirect()->route('headmaster.item-suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroyItemSupplier($id)
    {
        $supplier = ItemSupplier::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $supplier->delete();

        return redirect()->route('headmaster.item-suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    public function indexInventorySuppliers()
    {
        $schoolId = Auth::user()->school_id;
        $suppliers = ItemSupplier::where('school_id', $schoolId)->get();
        return view('headmaster.inventory.suppliers.index', compact('suppliers'));
    }


    // Inventory Allocations
    public function indexInventoryAllocations()
    {
        $schoolId = Auth::user()->school_id;
        $allocations = ItemAllocation::whereHas('item', function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->with(['item', 'staff'])->get();

        return view('headmaster.inventory.allocations.index', compact('allocations'));
    }

    public function createInventoryAllocation()
    {
        $schoolId = Auth::user()->school_id;
        $items = Item::where('school_id', $schoolId)->get();
        $staffs = Staff::whereHas('user', function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->get();

        return view('headmaster.inventory.allocations.create', compact('items', 'staffs'));
    }

    public function storeInventoryAllocation(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'staff_id' => 'required|exists:staff,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::find($request->item_id);

        if ($item->stock_level < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock available.');
        }

        // Adjust item stock level
        $item->stock_level -= $request->quantity;
        $item->save();

        ItemAllocation::create([
            'item_id' => $request->item_id,
            'staff_id' => $request->staff_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('headmaster.inventory-allocations.index')->with('success', 'Item allocated successfully.');
    }

    public function destroyInventoryAllocation($id)
    {
        $allocation = ItemAllocation::findOrFail($id);

        // Restore item stock level
        $item = $allocation->item;
        $item->stock_level += $allocation->quantity;
        $item->save();

        $allocation->delete();

        return redirect()->route('headmaster.inventory-allocations.index')->with('success', 'Allocation deleted successfully.');
    }

    public function restockView($id)
    {
        $item = Item::findOrFail($id);
        return view('headmaster.inventory.items.restock', compact('item'));
    }

    public function restock(Request $request, $id)
    {
        $request->validate([
            'restock_quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($id);
        $item->stock_level += $request->restock_quantity;
        $item->save();

        return redirect()->route('headmaster.inventory-items.index')->with('success', 'Item restocked successfully.');
    }

    // app/Http/Controllers/HeadmasterController.php

    public function createReturn()
    {
        $schoolId = Auth::user()->school_id;
        $items = Item::where('school_id', $schoolId)->get();
        $staffs = Staff::where('school_id', $schoolId)->get();
        return view('headmaster.inventory.allocations.createReturn', compact('items', 'staffs'));
    }

    public function storeReturn(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'staff_id' => 'required|exists:staff,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($request->item_id);
        $allocation = ItemAllocation::where('item_id', $request->item_id)
                                    ->where('staff_id', $request->staff_id)
                                    ->firstOrFail();

        if ($allocation->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'The return quantity exceeds the allocated quantity.');
        }

        ItemReturn::create([
            'item_id' => $item->id,
            'staff_id' => $request->staff_id,
            'quantity' => $request->quantity,
        ]);

        $item->increment('stock_level', $request->quantity);
        $allocation->decrement('quantity', $request->quantity);

        if ($allocation->quantity == 0) {
            $allocation->delete();
        }

        return redirect()->route('headmaster.inventory-allocations.index')->with('success', 'Item returned successfully.');
    }

    public function viewReturns()
    {
        $schoolId = Auth::user()->school_id;
        $returns = ItemReturn::whereHas('item', function($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->with('item', 'staff')->get();

        return view('headmaster.inventory.allocations.returns', compact('returns'));
    }

    public function indexBursars()
    {
        $bursars = Bursar::where('school_id', auth()->user()->school_id)->get();
        return view('headmaster.bursars.index', compact('bursars'));
    }

    public function createBursar()
    {
        return view('headmaster.bursars.create');
    }

    public function storeBursar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:bursars,email',
            'phone_number' => 'required|string|max:15',
        ]);

        $bursar = Bursar::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'school_id' => auth()->user()->school_id,
        ]);

        $password = rand(10000000, 99999999);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'Bursar',
            'school_id' => auth()->user()->school_id,
        ]);

        // Save the password to a text file in the downloads directory
        $fileName = 'downloads/' . $request->email . '.txt';
        Storage::disk('public')->put($fileName, 'Password: ' . $password . ' username: ' . $request->email);


        return redirect()->route('headmaster.bursars.index')->with('success', 'Bursar created successfully. Password saved to ' . $fileName);
    }

    public function editBursar($id)
    {
        $bursar = Bursar::where('school_id', auth()->user()->school_id)->findOrFail($id);
        return view('headmaster.bursars.edit', compact('bursar'));
    }

    public function updateBursar(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
        ]);

        $bursar = Bursar::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $bursar->update($request->only('name', 'phone_number'));

        return redirect()->route('headmaster.bursars.index')->with('success', 'Bursar updated successfully.');
    }

    public function destroyBursar($id)
    {
        $bursar = Bursar::where('school_id', auth()->user()->school_id)->findOrFail($id);
        User::where('email', $bursar->email)->delete();
        $bursar->delete();

        return redirect()->route('headmaster.bursars.index')->with('success', 'Bursar deleted successfully.');
    }
    public function downloadBursarPassword($id)
{
    $bursar = Bursar::findOrFail($id);

    // Assuming the password is stored in a file named after the bursar's email
    $fileName = 'downloads/' . $bursar->email . '.txt';

    if (!Storage::disk('public')->exists($fileName)) {
        return redirect()->route('headmaster.bursars.index')->with('error', 'Password file not found.');
    }

    return Storage::disk('public')->download($fileName);
}
public function income(Request $request)
{
    $query = Income::where('school_id', auth()->user()->school_id);

    if ($request->start_date && $request->end_date) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    $incomes = $query->get();

    $incomeData = $incomes->groupBy('source')->map(function($group) {
        return $group->sum('amount');
    });

    return view('headmaster.finance.income', compact('incomes', 'incomeData'));
}
public function financialSummary()
{
    $incomes = Income::where('school_id', auth()->user()->school_id)->get();
    $expenditures = Expenditure::where('school_id', auth()->user()->school_id)->get();
    $transactions = Transaction::where('school_id', auth()->user()->school_id)->get();

    return view('headmaster.finance.summary', compact('incomes', 'expenditures', 'transactions'));
}
public function expenditure()
{
    $expenditures = Expenditure::where('school_id', auth()->user()->school_id)->get();
    return view('headmaster.finance.expenditure', compact('expenditures'));
}
public function indexFinance()
    {
        $incomes = Income::where('school_id', auth()->user()->school_id)->get();
        $expenditures = Expenditure::where('school_id', auth()->user()->school_id)->get();
        return view('headmaster.finance.index', compact('incomes', 'expenditures'));
    }


}
