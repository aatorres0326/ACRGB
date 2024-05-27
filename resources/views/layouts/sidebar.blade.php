<ul class="navbar-nav sidebar bg-dark sidebar-dark accordion" id="accordionSidebar">


    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon">
            <i class="fas fa-globe" style="color:#7DB343;"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="font-family:impact; color:#7DB343; padding-top: 5px;">
            <h3>ACR-GB</h3>
        </div>

    </a>


    <hr class="sidebar-divider my-0">




    @if (session()->get('leveid') ===
    'ADMIN')<!--------------------------------------------------------------------------------------------------------------------------->

    <li class="nav-item {{ (request()->is('userinfo')) ? 'active' : '' }}">
        <a class="nav-link " href="/userinfo">
            <i class="fas fa-fw fa-users"></i>
            <span>User Details</span></a>
    </li>
    <li
        class="nav-item {{ (request()->is('userlogins')) ? 'active' : '' }} {{ (request()->is('useraccess')) ? 'active' : '' }}">
        <a class="nav-link" href="/userlogins">
            <i class="fas fa-fw fa-lock"></i>
            <span>Login Details</span></a>
    </li>

    @elseif (session()->get('leveid') ===
    'PHIC')<!--------------------------------------------------------------------------------------------------------------------------->

    <li
        class="nav-item {{ (request()->is('pro')) ? 'active' : '' }} {{ (request()->is('proaccess')) ? 'active' : '' }}">
        <a class="nav-link" href="/pro">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>Regional Offices</span></a>
    </li>
    <li
        class="nav-item {{ (request()->is('managingboard')) ? 'active' : '' }} {{ (request()->is('mbaccess')) ? 'active' : '' }}">
        <a class="nav-link" href="/managingboard">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>HCPN</span></a>
    </li>

    <li class="nav-item {{ (request()->is('facilities')) ? 'active' : '' }}{{ (request()->is('apexfacilities')) ? 'active' : '' }}"
        id="accordion">
        <a class="nav-link" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-hospital-alt"></i><span>&nbsp;Facilities</span>
        </a>
        <div id="collapseReports" class="collapse
            {{ (request()->is('facilities')) ? 'show' : '' }}
            {{ (request()->is('apexfacilities')) ? 'show' : '' }}" data-parent="#accordion">

            <div class="bg-white py-2 collapse-inner rounded">
                <ul class="navbar-nav">
                    <li class="nav-item {{ (request()->is('facilities')) ? 'active' : '' }}">
                        <a class="collapse-item" href="/facilities">

                            <span>Non-Apex Facilities</span></a>
                    </li>
                    <li class="nav-item {{ (request()->is('apexfacilities')) ? 'active' : '' }}">
                        <a class="collapse-item" href="/apexfacilities">

                            <span>Apex Facilities</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}" id="accordion">
        <a class="nav-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;Budget Utilization</span>
        </a>
        <div id="collapseOne" class="collapse
            {{ (request()->is('hcpncontract')) ? 'show' : '' }}
            {{ (request()->is('apexcontract')) ? 'show' : '' }}
            {{ (request()->is('apexassets')) ? 'show' : '' }}
            {{ (request()->is('hcpnassets')) ? 'show' : '' }}
            {{ (request()->is('facilitycontracts')) ? 'show' : '' }}
            {{ (request()->is('userlevel')) ? 'show' : '' }}
            {{ (request()->is('useraccess')) ? 'show' : '' }}
            {{ (request()->is('budgetutilization/probudget')) ? 'show' : '' }}
            {{ (request()->is('facilityassets')) ? 'show' : '' }}" data-parent="#accordion">

            <div class="bg-white py-2 collapse-inner rounded">
                <ul class="navbar-nav">
                    <li class="nav-item">

                        <a class="collapse-item {{ (request()->is('budgetutilization/probudget')) ? 'active' : '' }}"
                            href="/budgetutilization/probudget">
                            <span>PRO Funds</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="collapse-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}
                                    {{ (request()->is('hcpnassets')) ? 'active' : '' }}
            {{ (request()->is('facilitycontracts')) ? 'active' : '' }}
            {{ (request()->is('facilityassets')) ? 'active' : '' }}" href="/hcpncontract">
                            <span>HCPN Contracts</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="collapse-item {{ (request()->is('apexcontract')) ? 'active' : '' }} {{ (request()->is('apexassets')) ? 'active' : '' }}"
                            href="/apexcontract">
                            <span>APEX Facility Contracts</span></a>
                    </li>

                </ul>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}" id="accordion">
        <a class="nav-link" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;Reports</span>
        </a>
        <div id="collapseReports" class="collapse
            {{ (request()->is('ledger')) ? 'show' : '' }}
            {{ (request()->is('apexreports')) ? 'show' : '' }}
            {{ (request()->is('apexreports/ledger')) ? 'show' : '' }}" data-parent="#accordion">

            <div class="bg-white py-2 collapse-inner rounded">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="collapse-item {{ (request()->is('ledger')) ? 'active' : '' }}" href="/ledger">
                            <span>Subsidiary Ledger</span></a>
                    </li>
                    <li class="nav-item d-none">
                        <a class="collapse-item {{ (request()->is('terminatedcontract')) ? 'active' : '' }}" href="#">
                            <span>Terminated Contracts</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="nav-item {{ (request()->is('viewbudget')) ? 'active' : '' }}">
        <a class="nav-link" href="/VIEWBUDGET">
            <i class="fas fa-fw fa-money-bill-alt"></i>
            <span>View Budget</span></a>
    </li>
    <li class="nav-item {{ (request()->is('viewbudget')) ? 'active' : '' }}">
        <a class="nav-link" href="/DATESETTINGS">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Date Settings</span></a>
    </li>
</ul>

@elseif (session()->get('leveid')==='PRO')
<!--------------------------------------------------------------------------------------------------------------------------->

<li
    class="nav-item {{ (request()->is('managingboard')) ? 'active' : '' }} {{ (request()->is('mbaccess')) ? 'active' : '' }}">
    <a class="nav-link" href="/managingboard">
        <i class="fas fa-fw fa-layer-group"></i>
        <span>HCPN</span></a>
</li>

<li class="nav-item {{ (request()->is('facilities')) ? 'active' : '' }}{{ (request()->is('apexfacilities')) ? 'active' : '' }}"
    id="accordion">
    <a class="nav-link" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true"
        aria-controls="collapseOne">
        <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;Facilities</span>
    </a>
    <div id="collapseReports" class="collapse
            {{ (request()->is('facilities')) ? 'show' : '' }}
            {{ (request()->is('apexfacilities')) ? 'show' : '' }}" data-parent="#accordion">

        <div class="bg-white py-2 collapse-inner rounded">
            <ul class="navbar-nav">
                <li class="nav-item {{ (request()->is('facilities')) ? 'active' : '' }}">
                    <a class="collapse-item" href="/facilities">

                        <span>Non-Apex Facilities</span></a>
                </li>
                <li class="nav-item {{ (request()->is('apexfacilities')) ? 'active' : '' }}">
                    <a class="collapse-item" href="/apexfacilities">

                        <span>Apex Facilities</span></a>
                </li>
            </ul>
        </div>
    </div>
</li>
<li class="nav-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}" id="accordion">
    <a class="nav-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
        aria-controls="collapseOne">
        <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;Budget Utilization</span>
    </a>
    <div id="collapseOne" class="collapse
            {{ (request()->is('hcpncontract')) ? 'show' : '' }}
            {{ (request()->is('apexcontract')) ? 'show' : '' }}
            {{ (request()->is('apexassets')) ? 'show' : '' }}
            {{ (request()->is('hcpnassets')) ? 'show' : '' }}
            {{ (request()->is('facilitycontracts')) ? 'show' : '' }}
            {{ (request()->is('userlevel')) ? 'show' : '' }}
            {{ (request()->is('useraccess')) ? 'show' : '' }}
            {{ (request()->is('budgetutilization/probudget')) ? 'show' : '' }}
            {{ (request()->is('facilityassets')) ? 'show' : '' }}" data-parent="#accordion">

        <div class="bg-white py-2 collapse-inner rounded">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="collapse-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}
                                    {{ (request()->is('hcpnassets')) ? 'active' : '' }}
            {{ (request()->is('facilitycontracts')) ? 'active' : '' }}
            {{ (request()->is('facilityassets')) ? 'active' : '' }}" href="/hcpncontract">
                        <span>HCPN Contracts</span></a>
                </li>
                <li class="nav-item">
                    <a class="collapse-item {{ (request()->is('apexcontract')) ? 'active' : '' }} {{ (request()->is('apexassets')) ? 'active' : '' }}"
                        href="/apexcontract">
                        <span>APEX Facility Contracts</span></a>
                </li>

            </ul>
        </div>
    </div>
</li>
<li class="nav-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}" id="accordion">
    <a class="nav-link" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true"
        aria-controls="collapseOne">
        <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;Reports</span>
    </a>
    <div id="collapseReports" class="collapse
            {{ (request()->is('ledger')) ? 'show' : '' }}
            {{ (request()->is('apexreports')) ? 'show' : '' }}
            {{ (request()->is('apexreports/ledger')) ? 'show' : '' }}" data-parent="#accordion">

        <div class="bg-white py-2 collapse-inner rounded">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="collapse-item {{ (request()->is('ledger')) ? 'active' : '' }}" href="/ledger">
                        <span>Subsidiary Ledger</span></a>
                </li>
                <li class="nav-item d-none">
                    <a class="collapse-item {{ (request()->is('terminatedcontract')) ? 'active' : '' }}" href="#">
                        <span>Terminated Contracts</span></a>
                </li>
            </ul>
        </div>
    </div>
</li>
<li class="nav-item {{ (request()->is('CONTRACTPERIOD')) ? 'active' : '' }}">
    <a class="nav-link" href="/CONTRACTPERIOD">
        <i class="fas fa-fw fa-calendar-alt"></i>
        <span>Contract Period</span></a>
</li>
<li class="nav-item {{ (request()->is('viewbudget')) ? 'active' : '' }}">
    <a class="nav-link" href="/VIEWBUDGET">
        <i class="fas fa-fw fa-money-bill-alt"></i>
        <span>View Budget</span></a>
</li>

@endif
</ul>