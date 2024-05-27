<nav class="navbar navbar-expand navbar-dark bg-dark topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <span class="text-white">
        {{ (request()->is('facilities')) ? 'Facility Management' : '' }}
        {{ (request()->is('users')) ? 'User Management' : '' }}
        {{ (request()->is('budgetmanagement')) ? 'Budget Management' : '' }}
        {{ (request()->is('viewhcfbudget')) ? 'Budget Management / Facility Budget' : '' }}
        {{ (request()->is('userlogins')) ? 'User Login Management' : '' }}
        {{ (request()->is('userinfo')) ? 'User Information Management' : '' }}
        {{ (request()->is('area')) ? 'Area Management' : '' }}
        {{ (request()->is('userlevel')) ? 'Role Management' : '' }}
        {{ (request()->is('useraccess')) ? 'User Login Management / Access Assignments' : '' }}
        {{ (request()->is('managingboard')) ? 'Health Care Provider Networks' : '' }}
        {{ (request()->is('mbaccess')) ? 'Health Care Provider Networks / Access Management' : '' }}
        {{ (request()->is('pro')) ? 'PhilHealth Regional Offices' : '' }}
        {{ (request()->is('proaccess')) ? 'PhilHealth Regional Offices / Access Management' : '' }}
        {{ (request()->is('hcpncontract')) ? 'Health Care Provider Network Contracts' : '' }}
        {{ (request()->is('apexcontract')) ? 'APEX Facility Contracts' : '' }}
        {{ (request()->is('ledger')) ? 'Ledger Report Forms' : '' }}
        {{ (request()->is('DATESETTINGS')) ? 'Date Settings' : '' }}
        {{ (request()->is('facilitycontracts')) ? 'Health Care Provider Network Contracts / ' . $MBName : '' }}

    </span>
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white-600 small">
                    {{ session()->get('firstname') . " " . session()->get('lastname') . " "}}
                    <br>
                </span>
                <div class="rounded-circle border border-white p-1">
                    <i class="fas fa-fw fa-user"></i>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @if (session()->get('leveid') != 'ADMIN')
                    <a class="dropdown-item" href="/accountsettings">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Account Settings
                    </a>
                    <div class="dropdown-divider"></div>
                @endif
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>