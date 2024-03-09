<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    {{ (request()->is('facilities')) ? 'Facility Management' : '' }}
    {{ (request()->is('users')) ? 'User Management' : '' }}
    {{ (request()->is('budgetmanagement')) ? 'Budget Management' : '' }}
    {{ (request()->is('viewhcfbudget')) ? 'Budget Management / Facility Budget' : '' }}
    {{ (request()->is('userlogins')) ? 'User Login Management' : '' }}
    {{ (request()->is('userinfo')) ? 'User Information Management' : '' }}
    {{ (request()->is('area')) ? 'Area Management' : '' }}
    {{ (request()->is('userlevel')) ? 'Role Management' : '' }}
    {{ (request()->is('useraccess')) ? 'User Login Management / Access Assignments' : '' }}
    {{ (request()->is('managingboard')) ? 'Managing Board' : '' }}
    {{ (request()->is('pro')) ? 'PhilHealth Regional Offices' : '' }}


    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ session()->get('firstname') . " " . session()->get('lastname') . " "}}
                    <br>



                </span>
                <img class="img-profile rounded-circle"
                    src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>