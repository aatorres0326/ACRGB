<ul class="navbar-nav sidebar bg-light sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon">
            <i class="fas fa-globe" style="color:#ffffff;"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="font-family:impact; color:#fffffe; padding-top: 5px;">
            <h3>ACR-GB</h3>
        </div>
    </a>
    <hr class="sidebar-divider my-0">
    @if (session()->get('leveid') === 'ADMIN')
    <!--------------------------------------------------------------------------------------------------------------------------->
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
    <li class="nav-item {{ (request()->is('ActivityLogs')) ? 'active' : '' }}">
        <a class="nav-link" href="/ActivityLogs">
            <i class="fas fa-fw fa-list"></i>
            <span>Activity Logs</span></a>
    </li>

    @elseif (session()->get('leveid') === 'PHIC')
    <!--------------------------------------------------------------------------------------------------------------------------->

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

    <li class="nav-item  {{ (request()->is('apexfacilities')) ? 'active' : '' }}">
        <a class="nav-link" href="/apexfacilities">

            <i class="fas fa-fw fa-hospital"></i><span> Apex Facilities</span></a>
    </li>
    <li class="nav-item" id="accordion">
        <a class="nav-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;GB Utilization</span>
        </a>
        <div id="collapseOne"
            class="collapse {{ (request()->is('budgetutilization/probudget')) ? 'show' : '' }}{{ (request()->is('hcpncontract')) ? 'show' : '' }} {{ (request()->is('apexcontract')) ? 'show' : '' }} {{ (request()->is('apexassets')) ? 'show' : '' }} {{ (request()->is('hcpnassets')) ? 'show' : '' }} {{ (request()->is('facilitycontracts')) ? 'show' : '' }} {{ (request()->is('userlevel')) ? 'show' : '' }} {{ (request()->is('useraccess')) ? 'show' : '' }} {{ (request()->is('budgetutilization/probudget')) ? 'show' : '' }} {{ (request()->is('facilityassets')) ? 'show' : '' }}"
            data-parent="#accordion">

            <div class="bg-white py-2 collapse-inner rounded">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a style="font-size: 11px;"
                            class="collapse-item {{ (request()->is('budgetutilization/probudget')) ? 'active' : '' }}"
                            href="/budgetutilization/probudget">
                            <i class="fas fa-fw fa-handshake"></i><span> PRO Budget</span></a>
                    </li>
                    <li class="nav-item">
                        <a style="font-size: 11px;"
                            class="collapse-item {{ (request()->is('hcpncontract')) ? 'active' : '' }} {{ (request()->is('hcpnassets')) ? 'active' : '' }} {{ (request()->is('facilitycontracts')) ? 'active' : '' }} {{ (request()->is('facilityassets')) ? 'active' : '' }}"
                            href="/hcpncontract">
                            <i class="fas fa-fw fa-handshake"></i><span> HCPN Contracts</span></a>
                    </li>
                    <li class="nav-item">
                        <a style="font-size: 11px;"
                            class="collapse-item {{ (request()->is('apexcontract')) ? 'active' : '' }} {{ (request()->is('apexassets')) ? 'active' : '' }}"
                            href="/apexcontract">
                            <i class="fas fa-fw fa-handshake"></i><span> APEX Facility Contracts</span></a>
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
        <div id="collapseReports"
            class="collapse {{ (request()->is('VIEWBUDGET')) ? 'show' : '' }}{{ (request()->is('Reports/SubsidiaryLedger')) ? 'show' : '' }}{{ (request()->is('Reports/GeneralLedger')) ? 'show' : '' }}{{ (request()->is('Reports/Booking')) ? 'show' : '' }}"
            data-parent="#accordion">

            <div class="bg-white py-2 collapse-inner rounded">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="collapse-item {{ (request()->is('VIEWBUDGET')) ? 'active' : '' }}" href="/VIEWBUDGET">

                            <span>GB Computation</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="collapse-item {{ (request()->is('Reports/SubsidiaryLedger')) ? 'active' : '' }}"
                            href="/Reports/SubsidiaryLedger">
                            <span>Ledger</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="collapse-item {{ (request()->is('Reports/GeneralLedger')) ? 'active' : '' }}"
                            href="/Reports/GeneralLedger">
                            <span>Reconciliation</span></a>
                    </li>

                </ul>
            </div>
        </div>
    </li>
    <li class="nav-item  {{ (request()->is('ContractHistory')) ? 'active' : '' }}">
        <a class="nav-link" href="/ContractHistory">
            <i class="fas fa-fw fa-calendar"></i><span> Contract History</span></a>
    </li>
</ul>

@elseif (session()->get('leveid')==='PRO')
<!--------------------------------------------------------------------------------------------------------------------------->
<style>
.badge {
    position: absolute;
    top: 20px;
    right: 124px;
    padding: 1px 4px;
    border-radius: 50%;
    background-color: red;
    color: white;
}
</style>
<li class="nav-item {{ (request()->is('dashboard')) ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard">
        <i class="fas fa-fw fa-home"></i><span>Dashboard</span></a>
</li>
<li
    class="nav-item {{ (request()->is('managingboard')) ? 'active' : '' }} {{ (request()->is('mbaccess')) ? 'active' : '' }}">
    <a class="nav-link" href="/managingboard">
        <i class="fas fa-fw fa-users"></i><span>HCPN</span></a>
</li>


<li class="nav-item  {{ (request()->is('apexfacilities')) ? 'active' : '' }}">
    <a class="nav-link" href="/apexfacilities">

        <i class="fas fa-fw fa-hospital"></i><span> Apex Facilities</span></a>
</li>
<li class="nav-item" id="accordion">
    <a class="nav-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
        aria-controls="collapseOne">
        <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;GB Utilization</span>
    </a>
    <div id="collapseOne"
        class="collapse {{ (request()->is('hcpncontract')) ? 'show' : '' }} {{ (request()->is('apexcontract')) ? 'show' : '' }} {{ (request()->is('apexassets')) ? 'show' : '' }} {{ (request()->is('hcpnassets')) ? 'show' : '' }} {{ (request()->is('facilitycontracts')) ? 'show' : '' }} {{ (request()->is('userlevel')) ? 'show' : '' }} {{ (request()->is('useraccess')) ? 'show' : '' }} {{ (request()->is('budgetutilization/probudget')) ? 'show' : '' }} {{ (request()->is('facilityassets')) ? 'show' : '' }}"
        data-parent="#accordion">

        <div class="bg-white py-2 collapse-inner rounded">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('hcpncontract')) ? 'active' : '' }} {{ (request()->is('hcpnassets')) ? 'active' : '' }} {{ (request()->is('facilitycontracts')) ? 'active' : '' }} {{ (request()->is('facilityassets')) ? 'active' : '' }}"
                        href="/hcpncontract">
                        <i class="fas fa-fw fa-handshake"></i><span> HCPN Contracts</span></a>
                </li>
                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('apexcontract')) ? 'active' : '' }} {{ (request()->is('apexassets')) ? 'active' : '' }}"
                        href="/apexcontract">
                        <i class="fas fa-fw fa-handshake"></i><span> APEX Facility Contracts</span></a>
                </li>

            </ul>
        </div>
    </div>
</li>
<li class="nav-item" id="accordion">
    <a class="nav-link" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true"
        aria-controls="collapseOne">
        <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;Reports</span>
    </a>
    <div id="collapseReports"
        class="collapse {{ (request()->is('VIEWBUDGET')) ? 'show' : '' }} {{ (request()->is('Reports/SubsidiaryLedger')) ? 'show' : '' }} {{ (request()->is('Reports/Booking')) ? 'show' : '' }} {{ (request()->is('Reports/GeneralLedger')) ? 'show' : '' }}"
        data-parent="#accordion">
        <div class="bg-white py-2 collapse-inner rounded">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('VIEWBUDGET')) ? 'active' : '' }}" href="/VIEWBUDGET">

                        <i class="fas fa-fw fa-calculator"></i><span> GB Computation</span></a>
                </li>
                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('Reports/SubsidiaryLedger')) ? 'active' : '' }}"
                        href="/Reports/SubsidiaryLedger">
                        <i class="fas fa-fw fa-print"></i><span> Ledger</span></a>
                </li>
                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('Reports/GeneralLedger')) ? 'active' : '' }}"
                        href="/Reports/GeneralLedger">
                        <i class="fas fa-fw fa-map"></i><span> Reconciliation</span></a>
                </li>
                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('Reports/Booking')) ? 'active' : '' }}"
                        href="/Reports/Booking">
                        <i class="fas fa-fw fa-lock"></i><span> Booking</span></a>
                </li>
                <li class="nav-item d-none">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('terminatedcontract')) ? 'active' : '' }}" href="#">
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
<li class="nav-item" id="accordion">
    <a class="nav-link" data-toggle="collapse" data-target="#userManagement" aria-expanded="true"
        aria-controls="collapseOne">
        <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;User Management</span>
    </a>
    <div id="userManagement"
        class="collapse {{ (request()->is('userinfo')) ? 'show' : '' }} {{ (request()->is('userlogins')) ? 'show' : '' }}"
        data-parent="#accordion">

        <div class="bg-white py-2 collapse-inner rounded">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="collapse-item {{ (request()->is('userinfo')) ? 'active' : '' }}" href="/userinfo">
                        <i class="fas fa-fw fa-users"></i>
                        <span>User Details</span></a>
                </li>
                <li class="nav-item">
                    <a class="collapse-item {{ (request()->is('userlogins')) ? 'active' : '' }}" href="/userlogins">
                        <i class="fas fa-fw fa-lock"></i>
                        <span>Login Details</span></a>
                </li>

            </ul>
        </div>
    </div>
</li>

</ul>

<!-- FOR HCPN USER -------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
@elseif (session()->get('leveid') === 'HCPN')



<li class="nav-item  {{ (request()->is('facilities')) ? 'active' : '' }}">
    <a class="nav-link" href="/facilities">
        <i class="fas fa-fw fa-hospital"></i> <span>Facilities</span></a>
</li>



<li
    class="nav-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}{{ (request()->is('hcpnassets')) ? 'active' : '' }}{{ (request()->is('facilitycontracts')) ? 'active' : '' }}{{ (request()->is('facilityassets')) ? 'active' : '' }}">
    <a class=" nav-link" href="/facilitycontracts"><i class="fas fa-fw fa-hospital"></i>
        <span>Facility Contracts</span></a>
</li>

<li class="nav-item" id="accordion">
    <a class="nav-link" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true"
        aria-controls="collapseOne">
        <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;Reports</span>
    </a>
    <div id="collapseReports"
        class="collapse {{ (request()->is('Reports/SubsidiaryLedger')) ? 'show' : '' }}{{ (request()->is('apexreports')) ? 'show' : '' }}{{ (request()->is('apexreports/ledger')) ? 'show' : '' }}{{ (request()->is('Reports/GeneralLedger')) ? 'show' : '' }}"
        data-parent="#accordion">

        <div class="bg-white py-2 collapse-inner rounded">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item  {{ (request()->is('VIEWBUDGET')) ? 'active' : '' }}" href="/VIEWBUDGET">
                        <span>GB Computation</span></a>
                </li>

                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('Reports/SubsidiaryLedger')) ? 'active' : '' }}"
                        href="/Reports/SubsidiaryLedger">
                        <span>Ledger</span></a>
                </li>
                <li class="nav-item">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('Reports/GeneralLedger')) ? 'active' : '' }}"
                        href="/Reports/GeneralLedger">
                        <span>Reconciliation</span></a>
                </li>
                <li class="nav-item d-none">
                    <a style="font-size: 11px;"
                        class="collapse-item {{ (request()->is('terminatedcontract')) ? 'active' : '' }}" href="#">
                        <span>Terminated Contracts</span></a>
                </li>
            </ul>
        </div>
    </div>
</li>


@endif
</ul>