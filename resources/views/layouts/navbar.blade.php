<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    {{ (request()->is('facilities')) ? 'FACILITY MANAGEMENT' : '' }}
    {{ (request()->is('users')) ? 'USER MANAGEMENT' : '' }}
    {{ (request()->is('table')) ? 'CLAIMS' : '' }}
    {{ (request()->is('budgetmanagement')) ? 'BUDGET MANAGEMENT' : '' }}
    {{ (request()->is('userlogins')) ? 'USER LOGIN MANAGEMENT' : '' }}
    {{ (request()->is('userinfo')) ? 'USER INFORMATION MANAGEMENT' : '' }}
    {{ (request()->is('area')) ? 'AREA MANAGEMENT' : '' }}
    {{ (request()->is('userlevel')) ? 'ROLE MANAGEMENT' : '' }}


    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ session()->get('lastname').','.session()->get('firstname') }}
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
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
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