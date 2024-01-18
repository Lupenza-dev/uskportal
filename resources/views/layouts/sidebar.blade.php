<ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title" key="t-menu">Dashboard</li>
    <li>
        <a href="{{ url('dashboard')}}" class="waves-effect">
            <i class="bx bx-home"></i>
            <span key="t-chat">Home</span>
        </a>
    </li>
    <li class="menu-title" key="t-menu">Members Report</li>
    <li>
        <a href="{{ route('members.index')}}" class="waves-effect">
            <i class="bx bx-user"></i>
            <span key="t-file-manager">Members</span>
        </a>
    </li>
    <li class="menu-title" key="t-menu">Member Report</li>
    <li>
        <a href="{{ route('applications.index')}}" class="waves-effect">
            <i class="bx bx-list-ol"></i>
            <span key="t-file-manager">Loan Applications</span>
        </a>
    </li>
    <li>
        <a href="{{ route('loan.index')}}" class="waves-effect">
            <i class="bx bx-list-check"></i>
            <span key="t-file-manager">Granted Loans</span>
        </a>
    </li>
    <li>
        <a href="{{ route('loan.guarantors')}}" class="waves-effect">
            <i class="bx bx-list-ol"></i>
            <span key="t-file-manager">Loan Guaranting</span>
        </a>
    </li>
    <li class="menu-title" key="t-menu">Payment Report</li>
    <li>
        <a href="{{ route('payment.index')}}" class="waves-effect">
            <i class="bx bx-money"></i>
            <span key="t-file-manager">Payments</span>
        </a>
    </li>
    <li>
        <a href="{{ route('payment.disbursed')}}" class="waves-effect">
            <i class="bx bx-money"></i>
            <span key="t-file-manager">Disbursment Payments</span>
        </a>
    </li>
    <li>
        <a href="{{ route('pending.payments')}}" class="waves-effect">
            <i class="bx bx-money"></i>
            <span key="t-file-manager">Payment Request</span>
        </a>
    </li>
    <li class="menu-title" key="t-menu">User Management</li>
    {{-- <li>
        <a href="{{ url('users.index')}}" class="waves-effect">
            <i class="bx bx-user"></i>
            <span key="t-file-manager">Users</span>
        </a>
    </li> --}}
    {{-- <li>
        <a href="{{ url('roles.index')}}" class="waves-effect">
            <i class="bx bx-align-justify"></i>
            <span key="t-file-manager">Roles</span>
        </a>
    </li> --}}
    {{-- <li>
        <a href="{{ url('permissions.index')}}" class="waves-effect">
            <i class="bx bx-key"></i>
            <span key="t-file-manager">Permissions</span>
        </a>
    </li> --}}
    <li>
        <a href="{{ url('logout')}}" class="waves-effect">
            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
            <span key="t-file-manager">Logout</span>
        </a>
    </li>

</ul>