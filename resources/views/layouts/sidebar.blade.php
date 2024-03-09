<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon">
            <i class="fas fa-globe" style="color:#7DB343;"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="font-family:impact; color:#7DB343; padding-top: 5px;">
            <h3>ACR-GB</h3>
        </div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->is('dashboard')) ? 'active' : '' }} {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }} {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <li class="nav-item  {{ (request()->is('budgetmanagement')) ? 'active' : '' }} {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }} {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }} {{ (request()->is('viewhcfbudget')) ? 'active' : '' }} {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
        <a class="nav-link" href="/budgetmanagement">
            <i class="fas fa-fw fa-chart-pie"></i>
            <span>Budget Management</span></a>
    </li>
  



    <!-- Divider -->
    <hr class="sidebar-divider {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }} {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }} {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}">

    <!-- Heading -->

    <li class="nav-item {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }} {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}" id="accordion">
        <a class="nav-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-users"></i><span>&nbsp;Users</span>
        </a>
        <div id="collapseOne" class="collapse
            {{ (request()->is('userlogins')) ? 'show' : '' }}
            {{ (request()->is('userinfo')) ? 'show' : '' }}
            {{ (request()->is('userlevel')) ? 'show' : '' }}
            {{ (request()->is('useraccess')) ? 'show' : '' }}" data-parent="#accordion">
            <!-- Nav Item - Pages Collapse Menu -->
            <div class="bg-white py-2 collapse-inner rounded">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="collapse-item
                        {{ (request()->is('userlogins')) ? 'active' : '' }}
                        {{ (request()->is('useraccess')) ? 'active' : '' }}" href="/userlogins">

                            <span>Login Details</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="collapse-item  {{ (request()->is('userinfo')) ? 'active' : '' }}" href="/userinfo">

                            <span>User Details</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="collapse-item  {{ (request()->is('userlevel')) ? 'active' : '' }}" href="/userlevel">

                            <span>Role Management</span></a>
                    </li>

                </ul>
            </div>
        </div>
    </li>
    <li class="nav-item  {{ (request()->is('area')) ? 'active' : '' }} {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }} {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
        <a class="nav-link" href="/area">
            <i class="fas fa-fw fa-cog"></i>
            <span>Area</span></a>
    </li>
    <li class="nav-item  {{ (request()->is('pro')) ? 'active' : '' }} {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }} {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
        <a class="nav-link" href="/pro">
            <i class="fas fa-fw fa-cog"></i>
            <span>Regional Offices</span></a>
    </li>
    <li class="nav-item  {{ (request()->is('managingboard')) ? 'active' : '' }} {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}">
        <a class="nav-link" href="/managingboard">
            <i class="fas fa-fw fa-cog"></i>
            <span>Managing Board</span></a>
    </li>
    <li class="nav-item {{ (request()->is('assets')) ? 'active' : '' }} {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }} {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
        <a class="nav-link" href="/assets">
            <i class="fas fa-fw fa-coins"></i>
            <span>Assets</span></a>
    </li>
    <li class="nav-item {{ (request()->is('facilities')) ? 'active' : '' }} {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}">
        <a class="nav-link" href="/facilities">
            <i class="fas fa-fw fa-hospital-alt"></i>
            <span>Facilities</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<!-- End of Admin Sidebar -->