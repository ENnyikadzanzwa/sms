<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Subscription;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Guardian;
use App\Models\PaymentProof;
class AdminController extends Controller

{
    public function index()
    {
        $metrics = $this->getMetrics();
        $schools = School::with('subscription')->get();
        $subscriptions = Subscription::all();
        return view('admin.dashboard', compact('schools', 'subscriptions', 'metrics'));
    }

    public function createSubscription()
    {
        $metrics = $this->getMetrics();
        return view('admin.subscriptions.create', compact('metrics'));
    }

    public function storeSubscription(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_students' => 'required|integer|min:0',
            'max_staff' => 'required|integer|min:0',
            'max_guardians' => 'required|integer|min:0',
            'fee' => 'required|numeric|min:0',
        ]);

        Subscription::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Subscription created successfully.');
    }

    public function editSubscription($id)
    {
        $metrics = $this->getMetrics();
        $subscription = Subscription::findOrFail($id);
        return view('admin.subscriptions.edit', compact('subscription', 'metrics'));
    }

    public function updateSubscription(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_students' => 'required|integer|min:0',
            'max_staff' => 'required|integer|min:0',
            'max_guardians' => 'required|integer|min:0',
            'fee' => 'required|numeric|min:0',
        ]);

        $subscription = Subscription::findOrFail($id);
        $subscription->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Subscription updated successfully.');
    }

    public function destroySubscription($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Subscription deleted successfully.');
    }

    public function assignSubscription(Request $request, $id)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        $school = School::findOrFail($id);
        $school->subscription_id = $request->get('subscription_id');
        $school->save();

        return redirect()->route('admin.schools.activities', $id)->with('success', 'Subscription assigned successfully.');
    }

    public function viewSubscriptions()
    {
        $metrics = $this->getMetrics();
        $subscriptions = Subscription::all();
        return view('admin.subscriptions.index', compact('subscriptions', 'metrics'));
    }

    public function listSchools(Request $request)
    {
        $metrics = $this->getMetrics();
        $query = School::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort') && !empty($request->sort)) {
            $sortField = $request->sort;
            $sortDirection = $request->has('direction') ? $request->direction : 'asc';
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('name', 'asc');
        }

        $schools = $query->with('subscription')->get();
        return view('admin.schools.list', compact('schools', 'metrics'));
    }

    public function viewSchoolActivities($id)
    {
        $metrics = $this->getMetrics();
        $school = School::with(['subscription'])->findOrFail($id);
        $studentsCount = Student::where('school_id', $id)->count();
        $staffCount = Staff::whereHas('user', function($query) use ($id) {
            $query->where('school_id', $id);
        })->count();
        $guardiansCount = Guardian::where('school_id', $id)->count();

        $subscriptions = Subscription::all();

        return view('admin.schools.activities', compact('school', 'studentsCount', 'staffCount', 'guardiansCount', 'subscriptions', 'metrics'));
    }

    public function viewPayments()
    {
        $metrics = $this->getMetrics();
        $paymentProofs = PaymentProof::with('school', 'subscription')->get();
        return view('admin.payments.index', compact('paymentProofs', 'metrics'));
    }
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $paymentProof = PaymentProof::findOrFail($id);
        $paymentProof->status = $request->get('status');
        $paymentProof->save();

        return redirect()->route('admin.payments.index')->with('success', 'Payment status updated successfully.');
    }

    private function getMetrics()
    {
        $totalSchools = School::count();
        $activeSchools = School::whereHas('subscription')->count();
        $inactiveSchools = $totalSchools - $activeSchools;

        return compact('totalSchools', 'activeSchools', 'inactiveSchools');
    }
    public function downloadProof($id)
    {
        $paymentProof = PaymentProof::findOrFail($id);
        $path = $paymentProof->proof_of_payment;

        if (Storage::exists($path)) {
            return Storage::download($path);
        } else {
            return redirect()->back()->with('error', 'File not available');
        }
    }


}
