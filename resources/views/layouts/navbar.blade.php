<nav class="navbar navbar-expand navbar-dark bg-dark topbar mb-4 static-top shadow">


    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline small font-weight-bold" style="color:#2a3b6d">
                    <br>
                </span>
                <div class="rounded-circle border border-secondary p-1">
                    <i class="fas fa-fw fa-bell"></i>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="#">
                    List of notification comming soon
                </a>
            </div>
        </li>

    </ul> -->





    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline small font-weight-bold" style="color:#2a3b6d">
                    {{ session()->get('firstname') . " " . session()->get('lastname') . " "}}
                    <br>
                </span>
                <div class="rounded-circle border border-secondary p-1">
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