<div class="sidebar bg-purple" id="sidebar">
    <div class="sidebar-heading text-white">
        <i class="fas fa-graduation-cap"></i> Headmaster's Dashboard
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <a href="{{ route('headmaster.dashboard') }}" class="text-white">
               <span><i class="fas fa-tachometer-alt"></i> Dashboard</span>
            </a>
        </li>
        <li class="list-group-item">
            <a href="#schoolCalendarSubmenu" class="text-white d-flex justify-content-between" onclick="toggleSubmenu('schoolCalendarSubmenu')">
                <span><i class="fas fa-calendar-alt"></i> School Calendar</span>
                <i class="fas fa-angle-down"></i>
            </a>

            <ul class="list-unstyled submenu" id="schoolCalendarSubmenu">
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.school-years.index') }}" class="text-white">School Years</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.terms.index') }}" class="text-white">Terms</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.grades.index') }}" class="text-white">Grades</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.grade_classes.index') }}" class="text-white">Classes</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Events</a></li>
            </ul>
        </li>

        <li class="list-group-item">
            <a href="#manageTeachersSubmenu" class="text-white d-flex justify-content-between" onclick="toggleSubmenu('manageTeachersSubmenu')">
                <span><i class="fas fa-chalkboard-teacher"></i> Manage Teachers</span>
                <i class="fas fa-angle-down"></i>
            </a>
            <ul class="list-unstyled submenu" id="manageTeachersSubmenu">
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.staff.index') }}" class="text-white">Records</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Attendance</a></li>
            </ul>
        </li>
        <li class="list-group-item">
            <a href="#manageStudentsSubmenu" class="text-white d-flex justify-content-between" onclick="toggleSubmenu('manageStudentsSubmenu')">
                <span><i class="fas fa-user-graduate"></i> Manage Students</span>
                <i class="fas fa-angle-down"></i>
            </a>
            <ul class="list-unstyled submenu" id="manageStudentsSubmenu">
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.students.index') }}" class="text-white">Records</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Attendance</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Fees</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Performance</a></li>
            </ul>
        </li>
        <li class="list-group-item">
            <a href="#manageStaffSubmenu" class="text-white d-flex justify-content-between" onclick="toggleSubmenu('manageStaffSubmenu')">
                <span><i class="fas fa-users"></i> Manage Staff</span>
                <i class="fas fa-angle-down"></i>
            </a>
            <ul class="list-unstyled submenu" id="manageStaffSubmenu">
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Front Office</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.bursars.index') }}" class="text-white">Bursars</a></li>
            </ul>
        </li>
        <li class="list-group-item">
            <a href="#inventoryManagementSubmenu" class="text-white d-flex justify-content-between" onclick="toggleSubmenu('inventoryManagementSubmenu')">
                <span><i class="fas fa-boxes"></i> Inventory Management</span>
                <i class="fas fa-angle-down"></i>
            </a>
            <ul class="list-unstyled submenu" id="inventoryManagementSubmenu">
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.inventory-items.index') }}" class="text-white">Track Stock</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.inventory-allocations.index') }}" class="text-white">Allocate Inventory</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.inventory-items.create') }}" class="text-white">Add Item</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.inventory-categories.index') }}" class="text-white">Categories</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.inventory-suppliers.index') }}" class="text-white">Suppliers</a></li>
            </ul>
        </li>
        <li class="list-group-item">
            <a href="#subscriptionsSubmenu" class="text-white d-flex justify-content-between" onclick="toggleSubmenu('subscriptionsSubmenu')">
                <span><i class="fas fa-money-check-alt"></i> Subscriptions</span>
                <i class="fas fa-angle-down"></i>
            </a>
            <ul class="list-unstyled submenu" id="subscriptionsSubmenu">
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Current Subscription</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Available Packages</a></li>
            </ul>
        </li>
        <li class="list-group-item">
            <a href="#financialManagementSubmenu" class="text-white d-flex justify-content-between" onclick="toggleSubmenu('financialManagementSubmenu')">
                <span><i class="fas fa-chart-line"></i> Financial Management</span>
                <i class="fas fa-angle-down"></i>
            </a>
            <ul class="list-unstyled submenu" id="financialManagementSubmenu">
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Fees Management</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.finance.income') }}" class="text-white">Income Tracking</a></li>
                <li class="list-group-item bg-purple"><a href="{{ route('headmaster.finance.expenditure') }}" class="text-white">Expenditure Tracking</a></li>
            </ul>
        </li>
        <li class="list-group-item">
            <a href="#reportsSubmenu" class="text-white d-flex justify-content-between" onclick="toggleSubmenu('reportsSubmenu')">
                <span><i class="fas fa-file-alt"></i> Reports</span>
                <i class="fas fa-angle-down"></i>
            </a>
            <ul class="list-unstyled submenu" id="reportsSubmenu">
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Students</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Teachers</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Financials</a></li>
                <li class="list-group-item bg-purple"><a href="#" class="text-white">Events</a></li>
            </ul>
        </li>
    </ul>
</div>
