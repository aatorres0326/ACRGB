<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
    <li class="nav-item { (request()->is('dashboard')) ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Reports
    </div>

    <li class="nav-item {{ (request()->is('assets')) ? 'active' : '' }}">
        <a class="nav-link" href="/assets">
            <i class="fas fa-fw fa-coins"></i>
            <span>Assets</span></a>
    </li>
    <li class="nav-item  {{ (request()->is('budgetmanagement')) ? 'active' : '' }}">
        <a class="nav-link" href="/budgetmanagement">
            <i class="fas fa-fw fa-chart-pie"></i>
            <span>Budget Management</span></a>
    </li>
    <li class="nav-item {{ (request()->is('table')) ? 'active' : '' }}">
        <a class="nav-link" href="/table">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Claims</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('facilities')) ? 'active' : '' }}" href="/facilities">
            <i class="fas fa-fw fa-hospital-alt"></i>
            <span>Facilities</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('xmlupload')) ? 'active' : '' }}" href="/xmlupload">
            <i class="fas fa-fw fa-upload"></i>
            <span>XML Upload</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Utilities
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ (request()->is('users')) ? 'active' : '' }}">
        <a class="nav-link active" href="/users">
            <i class="fas fa-fw fa-users"></i>
            <span>User Management</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="budget_logs.html">
            <i class="fas fa-fw fa-list"></i>
            <span>Logs</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<!-- End of Admin Sidebar -->