<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HeadmasterController;
use App\Http\Controllers\BursarController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\SchoolRegistrationController;
use App\Http\Controllers\Auth\HeadmasterRegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AssetManagementController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BursarTransactionController;
use App\Http\Controllers\BursarIncomeController;
use App\Http\Controllers\BursarExpenditureController;
use App\Http\Controllers\BursarFinancialController;
use App\Http\Controllers\BursarReportController;
use App\Http\Controllers\BursarProfileController;

// Welcome page route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes provided by Breeze
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:6,1'])->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// School registration routes
Route::get('/register/school', [SchoolRegistrationController::class, 'create'])->name('register.school');
Route::post('/register/school', [SchoolRegistrationController::class, 'store']);

// Headmaster registration routes
Route::get('/register/headmaster', [HeadmasterRegistrationController::class, 'create'])->name('register.headmaster');
Route::post('/register/headmaster', [HeadmasterRegistrationController::class, 'store']);

// Admin routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->role !== 'Administrator') {
            return redirect('/');
        }
        return app(AdminController::class)->index();
    })->name('admin.dashboard');

    Route::get('/admin/subscriptions/create', [AdminController::class, 'createSubscription'])->name('admin.subscriptions.create');
    Route::post('/admin/subscriptions', [AdminController::class, 'storeSubscription'])->name('admin.subscriptions.store');
    Route::get('/admin/subscriptions/{id}/edit', [AdminController::class, 'editSubscription'])->name('admin.subscriptions.edit');
    Route::put('/admin/subscriptions/{id}', [AdminController::class, 'updateSubscription'])->name('admin.subscriptions.update');
    Route::delete('/admin/subscriptions/{id}', [AdminController::class, 'destroySubscription'])->name('admin.subscriptions.destroy');
    Route::post('/admin/schools/{id}/assign-subscription', [AdminController::class, 'assignSubscription'])->name('admin.schools.assign-subscription');
    Route::get('/admin/subscriptions', [AdminController::class, 'viewSubscriptions'])->name('admin.subscriptions.view');

    // New routes for viewing and updating school activities
    Route::get('/admin/schools', [AdminController::class, 'listSchools'])->name('admin.schools.list');
    Route::get('/admin/schools/{id}/activities', [AdminController::class, 'viewSchoolActivities'])->name('admin.schools.activities');
    Route::post('/admin/schools/{id}/update-payment-status', [AdminController::class, 'updatePaymentStatus'])->name('admin.schools.update-payment-status');
    //payments
    Route::get('/payments', [AdminController::class, 'viewPayments'])->name('admin.payments.index');
    Route::post('/payments/{id}/update-status', [AdminController::class, 'updatePaymentStatus'])->name('admin.payments.update-status');


    Route::get('/admin/download-proof/{id}', [AdminController::class, 'downloadProof'])->name('admin.downloadProof');
});


// Headmaster routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/headmaster/dashboard', [HeadmasterController::class, 'index'])->name('headmaster.dashboard');

    Route::prefix('headmaster')->group(function () {
        Route::get('/students/create', [HeadmasterController::class, 'createStudent'])->name('headmaster.create');

        Route::get('/students', [HeadmasterController::class, 'indexStudents'])->name('headmaster.students.index');
        Route::get('/students/create', [HeadmasterController::class, 'createStudent'])->name('headmaster.students.create');
        Route::post('/students', [HeadmasterController::class, 'storeStudent'])->name('headmaster.students.store');
        Route::get('/students/{id}/edit', [HeadmasterController::class, 'editStudent'])->name('headmaster.students.edit');
        Route::put('/students/{id}', [HeadmasterController::class, 'updateStudent'])->name('headmaster.students.update');
        Route::delete('/students/{id}', [HeadmasterController::class, 'destroyStudent'])->name('headmaster.students.destroy');
        Route::get('/students/{id}', [HeadmasterController::class, 'viewStudent'])->name('headmaster.students.view');
        Route::get('/guardians/search', [HeadmasterController::class, 'searchGuardians'])->name('headmaster.guardians.search');
        Route::get('/students/{id}/assign', [HeadmasterController::class, 'assignStudentToClass'])->name('headmaster.assignStudentToClass');
        Route::post('/students/{id}/assign', [HeadmasterController::class, 'assignStudentToClassStore'])->name('headmaster.assignStudentToClassStore');
        Route::get('/guardians/{guardian_id}/students', [HeadmasterController::class, 'studentsForGuardian'])->name('headmaster.guardians.students');

        Route::get('/students/assign/multiple', [HeadmasterController::class, 'assignMultipleStudents'])->name('headmaster.assignMultipleStudents');
        Route::post('/students/assign/multiple', [HeadmasterController::class, 'assignMultipleStudentsStore'])->name('headmaster.assignMultipleStudentsStore');

        Route::get('/fetch-guardians', [HeadmasterController::class, 'fetchGuardians'])->name('headmaster.fetchGuardians');
        Route::post('/create-guardian', [HeadmasterController::class, 'createGuardian'])->name('headmaster.createGuardian');
        Route::post('/create-bursar', [HeadmasterController::class, 'createBursar'])->name('headmaster.createBursar');
        Route::post('/create-event', [HeadmasterController::class, 'createEvent'])->name('headmaster.createEvent');
        Route::post('/manage-assets', [HeadmasterController::class, 'manageAssets'])->name('headmaster.manageAssets');
        Route::post('/manage-inventory', [HeadmasterController::class, 'manageInventory'])->name('headmaster.manageInventory');
        Route::get('/generate-reports', [HeadmasterController::class, 'generateReports'])->name('headmaster.generateReports');

        Route::get('/school-years', [HeadmasterController::class, 'indexSchoolYears'])->name('headmaster.school-years.index');
        Route::get('/school-years/create', [HeadmasterController::class, 'createSchoolYear'])->name('headmaster.school-years.create');
        Route::post('/school-years', [HeadmasterController::class, 'storeSchoolYear'])->name('headmaster.school-years.store');
        Route::get('/school-years/{id}/edit', [HeadmasterController::class, 'editSchoolYear'])->name('headmaster.school-years.edit');
        Route::put('/school-years/{id}', [HeadmasterController::class, 'updateSchoolYear'])->name('headmaster.school-years.update');
        Route::delete('/school-years/{id}', [HeadmasterController::class, 'destroySchoolYear'])->name('headmaster.school-years.destroy');
        Route::get('/check-school-year/{id}', [HeadmasterController::class, 'checkTerms'])->name('check-school-year');

        Route::get('/terms', [HeadmasterController::class, 'indexTerms'])->name('headmaster.terms.index');
        Route::get('/terms/create', [HeadmasterController::class, 'createTerm'])->name('headmaster.terms.create');
        Route::post('/terms', [HeadmasterController::class, 'storeTerm'])->name('headmaster.terms.store');
        Route::get('/terms/{id}/edit', [HeadmasterController::class, 'editTerm'])->name('headmaster.terms.edit');
        Route::put('/terms/{id}', [HeadmasterController::class, 'updateTerm'])->name('headmaster.terms.update');
        Route::delete('/terms/{id}', [HeadmasterController::class, 'destroyTerm'])->name('headmaster.terms.destroy');

        Route::get('/grades', [HeadmasterController::class, 'indexGrades'])->name('headmaster.grades.index');
        Route::get('/grades/create', [HeadmasterController::class, 'createGrade'])->name('headmaster.grades.create');
        Route::post('/grades', [HeadmasterController::class, 'storeGrade'])->name('headmaster.grades.store');
        Route::get('/grades/{id}/edit', [HeadmasterController::class, 'editGrade'])->name('headmaster.grades.edit');
        Route::put('/grades/{id}', [HeadmasterController::class, 'updateGrade'])->name('headmaster.grades.update');
        Route::delete('/grades/{id}', [HeadmasterController::class, 'destroyGrade'])->name('headmaster.grades.destroy');

        Route::get('/grade-classes', [HeadmasterController::class, 'indexGradeClasses'])->name('headmaster.grade_classes.index');
        Route::get('/grade-classes/create', [HeadmasterController::class, 'createGradeClass'])->name('headmaster.grade_classes.create');
        Route::post('/grade-classes', [HeadmasterController::class, 'storeGradeClass'])->name('headmaster.grade_classes.store');
        Route::get('/grade-classes/{id}/edit', [HeadmasterController::class, 'editGradeClass'])->name('headmaster.grade_classes.edit');
        Route::put('/grade-classes/{id}', [HeadmasterController::class, 'updateGradeClass'])->name('headmaster.grade_classes.update');
        Route::delete('/grade-classes/{id}', [HeadmasterController::class, 'destroyGradeClass'])->name('headmaster.grade_classes.destroy');
        Route::get('/grade-classes/{id}', [HeadmasterController::class, 'showGradeClass'])->name('headmaster.grade_classes.show');

        // Add routes for assigning staff
        Route::get('/grade-classes/{id}/assign-staff', [HeadmasterController::class, 'assignStaff'])->name('headmaster.grade_classes.assign_staff');
        Route::post('/grade-classes/{id}/assign-staff', [HeadmasterController::class, 'assignStaffStore'])->name('headmaster.grade_classes.assign_staff_store');

        // Routes for guardians
        Route::get('/guardians', [HeadmasterController::class, 'indexGuardians'])->name('headmaster.guardians.index');
        Route::get('/guardians/create', [HeadmasterController::class, 'createGuardian'])->name('headmaster.guardians.create');
        Route::post('/guardians', [HeadmasterController::class, 'storeGuardian'])->name('headmaster.guardians.store');
        Route::get('/guardians/{id}/edit', [HeadmasterController::class, 'editGuardian'])->name('headmaster.guardians.edit');
        Route::put('/guardians/{id}', [HeadmasterController::class, 'updateGuardian'])->name('headmaster.guardians.update');
        Route::delete('/guardians/{id}', [HeadmasterController::class, 'destroyGuardian'])->name('headmaster.guardians.destroy');
        Route::get('headmaster/guardians/download-password/{id}', [HeadmasterController::class, 'downloadPasswordGurdian'])->name('headmaster.guardians.download-password');


        // Staff routes
        Route::get('/staff', [HeadmasterController::class, 'indexStaff'])->name('headmaster.staff.index');
        Route::get('/staff/create', [HeadmasterController::class, 'createStaff'])->name('headmaster.staff.create');
        Route::post('/staff', [HeadmasterController::class, 'storeStaff'])->name('headmaster.staff.store');
        Route::get('/staff/{id}/edit', [HeadmasterController::class, 'editStaff'])->name('headmaster.staff.edit');
        Route::put('/staff/{id}', [HeadmasterController::class, 'updateStaff'])->name('headmaster.staff.update');
        Route::delete('/staff/{id}', [HeadmasterController::class, 'destroyStaff'])->name('headmaster.staff.destroy');
        // routes/web.php
        Route::get('headmaster/staff/download-password/{id}', [HeadmasterController::class, 'downloadPasswordStaff'])->name('headmaster.staff.download-password');


        // Package routes
        Route::get('/packages', [HeadmasterController::class, 'viewPackages'])->name('headmaster.packages.view');
        Route::post('/packages/{subscription}/pay', [HeadmasterController::class, 'makePayment'])->name('headmaster.packages.pay');
        Route::get('/packages/current', [HeadmasterController::class, 'currentPackage'])->name('headmaster.packages.current');




                // Inventory Management

        // Inventory Locations
        Route::get('inventory-locations', [HeadmasterController::class, 'indexInventoryLocations'])->name('headmaster.inventory-locations.index');
        Route::get('inventory-locations/create', [HeadmasterController::class, 'createInventoryLocation'])->name('headmaster.inventory-locations.create');
        Route::post('inventory-locations', [HeadmasterController::class, 'storeInventoryLocation'])->name('headmaster.inventory-locations.store');
        Route::get('inventory-locations/{id}/edit', [HeadmasterController::class, 'editInventoryLocation'])->name('headmaster.inventory-locations.edit');
        Route::put('inventory-locations/{id}', [HeadmasterController::class, 'updateInventoryLocation'])->name('headmaster.inventory-locations.update');
        Route::delete('inventory-locations/{id}', [HeadmasterController::class, 'destroyInventoryLocation'])->name('headmaster.inventory-locations.destroy');

        // Inventory Categories
        Route::get('inventory-categories', [HeadmasterController::class, 'indexInventoryCategories'])->name('headmaster.inventory-categories.index');
        Route::get('inventory-categories/create', [HeadmasterController::class, 'createInventoryCategory'])->name('headmaster.inventory-categories.create');
        Route::post('inventory-categories', [HeadmasterController::class, 'storeInventoryCategory'])->name('headmaster.inventory-categories.store');
        Route::get('inventory-categories/{id}/edit', [HeadmasterController::class, 'editInventoryCategory'])->name('headmaster.inventory-categories.edit');
        Route::put('inventory-categories/{id}', [HeadmasterController::class, 'updateInventoryCategory'])->name('headmaster.inventory-categories.update');
        Route::delete('inventory-categories/{id}', [HeadmasterController::class, 'destroyInventoryCategory'])->name('headmaster.inventory-categories.destroy');

        // Inventory Items
        Route::get('inventory-items', [HeadmasterController::class, 'indexInventoryItems'])->name('headmaster.inventory-items.index');
        Route::get('inventory-items/create', [HeadmasterController::class, 'createInventoryItem'])->name('headmaster.inventory-items.create');
        Route::post('inventory-items', [HeadmasterController::class, 'storeInventoryItem'])->name('headmaster.inventory-items.store');
        Route::get('inventory-items/{id}/edit', [HeadmasterController::class, 'editInventoryItem'])->name('headmaster.inventory-items.edit');
        Route::put('inventory-items/{id}', [HeadmasterController::class, 'updateInventoryItem'])->name('headmaster.inventory-items.update');
        Route::delete('inventory-items/{id}', [HeadmasterController::class, 'destroyInventoryItem'])->name('headmaster.inventory-items.destroy');
        Route::post('/inventory-items/{id}/restock', [HeadmasterController::class, 'restockInventoryItem'])->name('headmaster.inventory-items.restock');
        Route::get('inventory-items/{id}/restock', [HeadmasterController::class, 'restockView'])->name('headmaster.inventory-items.restock-view');
        Route::post('inventory-items/{id}/restock', [HeadmasterController::class, 'restock'])->name('headmaster.inventory-items.restock');

        // Inventory Suppliers
        Route::get('inventory-suppliers', [HeadmasterController::class, 'indexInventorySuppliers'])->name('headmaster.inventory-suppliers.index');
        Route::get('inventory-suppliers/create', [HeadmasterController::class, 'createInventorySupplier'])->name('headmaster.inventory-suppliers.create');
        Route::post('inventory-suppliers', [HeadmasterController::class, 'storeInventorySupplier'])->name('headmaster.inventory-suppliers.store');

        Route::get('inventory-suppliers/{id}/edit', [HeadmasterController::class, 'editInventorySupplier'])->name('headmaster.inventory-suppliers.edit');
        Route::put('inventory-suppliers/{id}', [HeadmasterController::class, 'updateInventorySupplier'])->name('headmaster.inventory-suppliers.update');
        Route::delete('inventory-suppliers/{id}', [HeadmasterController::class, 'destroyInventorySupplier'])->name('headmaster.inventory-suppliers.destroy');

        // Routes for item suppliers
        Route::get('item-suppliers', [HeadmasterController::class, 'indexItemSuppliers'])->name('headmaster.item-suppliers.index');
        Route::get('item-suppliers/create', [HeadmasterController::class, 'createItemSupplier'])->name('headmaster.item-suppliers.create');
        Route::post('item-suppliers', [HeadmasterController::class, 'storeItemSupplier'])->name('headmaster.item-suppliers.store');
        Route::get('item-suppliers/{id}/edit', [HeadmasterController::class, 'editItemSupplier'])->name('headmaster.item-suppliers.edit');
        Route::put('item-suppliers/{id}', [HeadmasterController::class, 'updateItemSupplier'])->name('headmaster.item-suppliers.update');
        Route::delete('item-suppliers/{id}', [HeadmasterController::class, 'destroyItemSupplier'])->name('headmaster.item-suppliers.destroy');


    Route::get('/', [HeadmasterController::class, 'indexInventoryAllocations'])->name('headmaster.inventory-allocations.index');
    Route::get('/create', [HeadmasterController::class, 'createInventoryAllocation'])->name('headmaster.inventory-allocations.create');
    Route::post('/', [HeadmasterController::class, 'storeInventoryAllocation'])->name('headmaster.inventory-allocations.store');
    Route::delete('/{id}', [HeadmasterController::class, 'destroyInventoryAllocation'])->name('headmaster.inventory-allocations.destroy');

    Route::get('/return', [HeadmasterController::class, 'createReturn'])->name('headmaster.inventory-allocations.createReturn');
    Route::post('/return', [HeadmasterController::class, 'storeReturn'])->name('headmaster.inventory-allocations.storeReturn');
    Route::get('/returns', [HeadmasterController::class, 'viewReturns'])->name('headmaster.inventory-allocations.returns');
    // Inventory Items
    Route::post('inventory-items/{id}/return', [HeadmasterController::class, 'returnInventoryItem'])->name('headmaster.inventory-items.return');


        // bursar
        Route::get('/headmaster/bursars', [HeadmasterController::class, 'indexBursars'])->name('headmaster.bursars.index');
        Route::get('/headmaster/bursars/create', [HeadmasterController::class, 'createBursar'])->name('headmaster.bursars.create');
        Route::post('/headmaster/bursars', [HeadmasterController::class, 'storeBursar'])->name('headmaster.bursars.store');
        Route::get('/headmaster/bursars/{id}/edit', [HeadmasterController::class, 'editBursar'])->name('headmaster.bursars.edit');
        Route::put('/headmaster/bursars/{id}', [HeadmasterController::class, 'updateBursar'])->name('headmaster.bursars.update');
        Route::delete('/headmaster/bursars/{id}', [HeadmasterController::class, 'destroyBursar'])->name('headmaster.bursars.destroy');
        Route::get('/headmaster/bursars/{id}/download-password', [HeadmasterController::class, 'downloadBursarPassword'])->name('headmaster.bursars.download-password');


        Route::get('financials', [HeadmasterController::class, 'indexFinance'])->name('headmaster.finance.index');

        Route::get('reports/income', [HeadmasterController::class, 'income'])->name('headmaster.finance.income');
       Route::get('reports/expenditure', [HeadmasterController::class, 'expenditure'])->name('headmaster.finance.expenditure');
       Route::get('reports/summary', [HeadmasterController::class, 'financialSummary'])->name('headmaster.finance.summary');
       Route::get('/headmaster/students/search', [HeadmasterController::class, 'searchStudents'])->name('headmaster.students.search');
    Route::get('/headmaster/staff/search', [HeadmasterController::class, 'searchStaff'])->name('headmaster.staff.search');
    });
});


// Bursar routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/bursar/dashboard', function () {
        if (auth()->user()->role !== 'Bursar') {
            return redirect('/');
        }
        return app(BursarController::class)->index();
    })->name('bursar.dashboard');

     // Transaction routes
     Route::get('transactions', [BursarTransactionController::class, 'index'])->name('bursar.transactions.index');
     Route::get('transactions/create', [BursarTransactionController::class, 'create'])->name('bursar.transactions.create');
     Route::post('transactions', [BursarTransactionController::class, 'store'])->name('bursar.transactions.store');
     Route::get('transactions/{id}/edit', [BursarTransactionController::class, 'edit'])->name('bursar.transactions.edit');
     Route::put('transactions/{id}', [BursarTransactionController::class, 'update'])->name('bursar.transactions.update');
     Route::delete('transactions/{id}', [BursarTransactionController::class, 'destroy'])->name('bursar.transactions.destroy');

     // Income routes
     Route::get('income', [BursarIncomeController::class, 'index'])->name('bursar.income.index');
     Route::get('income/create', [BursarIncomeController::class, 'create'])->name('bursar.income.create');
     Route::post('income', [BursarIncomeController::class, 'store'])->name('bursar.income.store');
     Route::get('income/{id}/edit', [BursarIncomeController::class, 'edit'])->name('bursar.income.edit');
     Route::put('income/{id}', [BursarIncomeController::class, 'update'])->name('bursar.income.update');
     Route::delete('income/{id}', [BursarIncomeController::class, 'destroy'])->name('bursar.income.destroy');

     // Expenditure routes
     Route::get('expenditure', [BursarExpenditureController::class, 'index'])->name('bursar.expenditure.index');
     Route::get('expenditure/create', [BursarExpenditureController::class, 'create'])->name('bursar.expenditure.create');
     Route::post('expenditure', [BursarExpenditureController::class, 'store'])->name('bursar.expenditure.store');
     Route::get('expenditure/{id}/edit', [BursarExpenditureController::class, 'edit'])->name('bursar.expenditure.edit');
     Route::put('expenditure/{id}', [BursarExpenditureController::class, 'update'])->name('bursar.expenditure.update');
     Route::delete('expenditure/{id}', [BursarExpenditureController::class, 'destroy'])->name('bursar.expenditure.destroy');

     Route::get('financials', [BursarFinancialController::class, 'index'])->name('bursar.financials.index');

     Route::get('reports/income', [BursarReportController::class, 'income'])->name('bursar.reports.income');
    Route::get('reports/expenditure', [BursarReportController::class, 'expenditure'])->name('bursar.reports.expenditure');
    Route::get('reports/summary', [BursarReportController::class, 'financialSummary'])->name('bursar.reports.summary');


     Route::get('profile/edit', [BursarProfileController::class, 'edit'])->name('bursar.profile.edit');
     Route::post('profile/update', [BursarProfileController::class, 'update'])->name('bursar.profile.update');

});

// Staff routes
// Staff routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/staff/dashboard', function () {
        if (auth()->user()->role !== 'Staff') {
            return redirect('/');

     }
        return app(StaffController::class)->index();
    })->name('staff.dashboard');

    Route::prefix('staff')->group(function () {
        // Add more staff routes as needed
    Route::get('/staff/students', [StaffController::class, 'indexStudents'])->name('staff.students.index');
    Route::get('/staff/logbook', [StaffController::class, 'logBook'])->name('staff.logbook');
    Route::post('/staff/log-in', [StaffController::class, 'logIn'])->name('staff.log.in');
    Route::post('/staff/log-out', [StaffController::class, 'logOut'])->name('staff.log.out');
    Route::get('/staff/attendance', [StaffController::class, 'attendance'])->name('staff.attendance');
    Route::get('/staff/attendance', [StaffController::class, 'attendance'])->name('staff.attendances.view');
    Route::post('/staff/attendance', [StaffController::class, 'storeAttendance'])->name('staff.attendance.store');
    Route::post('/staff/attendance', [StaffController::class, 'storeAttendance'])->name('staff.attendance.store');

    });
});

// Guardians
Route::prefix('guardians')->group(function () {
    // Route::get('/', [GuardianController::class, 'index'])->name('guardians.index');
    // Route::get('/create', [GuardianController::class, 'create'])->name('guardians.create');
    // Route::post('/', [GuardianController::class, 'store'])->name('guardians.store');
    // Route::get('/{id}', [GuardianController::class, 'show'])->name('guardians.show');
    // Route::get('/{id}/edit', [GuardianController::class, 'edit'])->name('guardians.edit');
    // Route::put('/{id}', [GuardianController::class, 'update'])->name('guardians.update');
    // Route::delete('/{id}', [GuardianController::class, 'destroy'])->name('guardians.destroy');
    Route::get('/dashboard', [GuardianController::class, 'dashboard'])->name('guardian.dashboard');

    // Records
    Route::get('/records/personal-information', [GuardianController::class, 'personalInformation'])->name('guardian.records.personalInformation');
    Route::get('/records/contacts', [GuardianController::class, 'contacts'])->name('guardian.records.contacts');
    Route::get('/records/addresses', [GuardianController::class, 'addresses'])->name('guardian.records.addresses');

    // Access Child's Data
    Route::get('/child-data', [GuardianController::class, 'childData'])->name('guardian.childData');

    // Posted Events
    Route::get('/events', [GuardianController::class, 'events'])->name('guardian.events');

    // Communication with Staff
    Route::get('/communication', [GuardianController::class, 'communication'])->name('guardian.communication');

// Guardian routes
Route::get('guardian/profile', [GuardianController::class, 'editProfile'])->name('guardian.records.editProfile');
Route::put('guardian/profile', [GuardianController::class, 'updateProfile'])->name('guardian.records.updateProfile');

});

//Student routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/student/profile', [StudentController::class, 'editProfile'])->name('student.profile.edit');
    Route::post('/student/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/student/attendance', [StudentController::class, 'attendance'])->name('student.attendance');
    Route::get('/student/terms', [StudentController::class, 'viewTerms'])->name('student.terms.view');
    Route::post('/student/terms/pay', [StudentController::class, 'makePayment'])->name('student.terms.pay');
});




// Guardians
Route::prefix('guardians')->group(function () {
    Route::get('/', [GuardianController::class, 'index'])->name('guardians.index');
    Route::get('/create', [GuardianController::class, 'create'])->name('guardians.create');
    Route::post('/', [GuardianController::class, 'store'])->name('guardians.store');
    Route::get('/{id}', [GuardianController::class, 'show'])->name('guardians.show');
    Route::get('/{id}/edit', [GuardianController::class, 'edit'])->name('guardians.edit');
    Route::put('/{id}', [GuardianController::class, 'update'])->name('guardians.update');
    Route::delete('/{id}', [GuardianController::class, 'destroy'])->name('guardians.destroy');
});

// Events
Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/', [EventController::class, 'store'])->name('events.store');
    Route::get('/{id}', [EventController::class, 'show'])->name('events.show');
    Route::get('/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/{id}', [EventController::class, 'destroy'])->name('events.destroy');
});

// Communications
Route::prefix('communications')->group(function () {
    Route::get('/', [CommunicationController::class, 'index'])->name('communications.index');
    Route::get('/create', [CommunicationController::class, 'create'])->name('communications.create');
    Route::post('/', [CommunicationController::class, 'store'])->name('communications.store');
    Route::get('/{id}', [CommunicationController::class, 'show'])->name('communications.show');
    Route::get('/{id}/edit', [CommunicationController::class, 'edit'])->name('communications.edit');
    Route::put('/{id}', [CommunicationController::class, 'update'])->name('communications.update');
    Route::delete('/{id}', [CommunicationController::class, 'destroy'])->name('communications.destroy');
});

// Finances
Route::prefix('finances')->group(function () {
    Route::get('/', [FinanceController::class, 'index'])->name('finances.index');
    Route::get('/create', [FinanceController::class, 'create'])->name('finances.create');
    Route::post('/', [FinanceController::class, 'store'])->name('finances.store');
    Route::get('/{id}', [FinanceController::class, 'show'])->name('finances.show');
    Route::get('/{id}/edit', [FinanceController::class, 'edit'])->name('finances.edit');
    Route::put('/{id}', [FinanceController::class, 'update'])->name('finances.update');
    Route::delete('/{id}', [FinanceController::class, 'destroy'])->name('finances.destroy');
});

// Asset Management
Route::prefix('asset-management')->group(function () {
    Route::get('/', [AssetManagementController::class, 'index'])->name('assetManagement.index');
    Route::get('/create', [AssetManagementController::class, 'create'])->name('assetManagement.create');
    Route::post('/', [AssetManagementController::class, 'store'])->name('assetManagement.store');
    Route::get('/{id}', [AssetManagementController::class, 'show'])->name('assetManagement.show');
    Route::get('/{id}/edit', [AssetManagementController::class, 'edit'])->name('assetManagement.edit');
    Route::put('/{id}', [AssetManagementController::class, 'update'])->name('assetManagement.update');
    Route::delete('/{id}', [AssetManagementController::class, 'destroy'])->name('assetManagement.destroy');
});

// Inventory
Route::prefix('inventory')->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/{id}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
});

// Subscriptions
Route::prefix('subscriptions')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/{id}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::get('/{id}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
    Route::put('/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::delete('/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
});
