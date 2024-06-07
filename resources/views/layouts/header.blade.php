<div class="container-fluid">
    <div class="card shadow mb-2" style="margin-top: -12px">
        <div class="card-body">
            @if (request()->is('login'))
                <span class="text-uppercase font-weight-bold text-secondary" style="font-size:14px;">
                    {{ (request()->is('login')) ? '  User Information Management' : '' }}
                </span>
            @else
                <span class="text-uppercase font-weight-bold text-secondary" style="font-size:14px;">
                    <a href="{{ url()->previous() }}"><i class="fa fa-fw fa-arrow-left mr-3"></i></a>&nbsp;
                    {{ (request()->is('hcpncontract')) ? '  Budget Utilization / HCPN Contracts' : '' }}
                    {{ (request()->is('users')) ? '  User Management' : '' }}
                    {{ (request()->is('userlogins')) ? '  User Login Management' : '' }}
                    {{ (request()->is('userinfo')) ? '  User Information Management' : '' }}

                    {{ (request()->is('useraccess')) ? '  User Login Management / Access Assignments' : '' }}
                    {{ (request()->is('pro')) ? '  Regional Offices' : '' }}
                    {{ (request()->is('ActivityLogs')) ? '  Activity Logs' : '' }}
                    {{ (request()->is('proaccess')) ? '  Regional Offices / Access Management' : '' }}
                    {{ (request()->is('managingboard')) ? '  Health Care Provider Networks' : '' }}
                    {{ (request()->is('mbaccess')) ? '  Health Care Provider Networks / Access Management' : '' }}
                    {{ (request()->is('facilities')) ? '  Facilities / Non Apex' : '' }}
                    {{ (request()->is('apexfacilities')) ? '  Facilities / Apex' : '' }}
                    {{ (request()->is('budgetutilization/probudget')) ? '  Budget Utilization / Pro Budget Management' : '' }}
                    {{ (request()->is('Reports/GeneralLedger')) ? '  Reports / General Ledger ' : '' }}
                    {{ (request()->is('hcpnassets')) ? '  Budget Utilization / HCPN Contracts / Tranches ' : '' }}
                    {{ (request()->is('VIEWBUDGET')) ? '  View Base Amount ' : '' }}
                    {{ (request()->is('apexcontract')) ? '  APEX Facility Contracts' : '' }}
                    {{ (request()->is('ledger')) ? '  Ledger Report Forms' : '' }}
                    {{ (request()->is('dashboard')) ? '  Dashboard' : '' }}
                    {{ (request()->is('Reports/Booking')) ? '  Booking' : '' }}
                    {{ (request()->is('DATESETTINGS')) ? '  Date Settings' : '' }}
                    {{ (request()->is('CONTRACTPERIOD')) ? '  Contract Period' : '' }}
                    @if (session()->get('leveid') === 'PHIC' || session()->get('leveid') === 'PHIC')
                        {{ (request()->is('facilitycontracts')) ? '  Budget Utilization / HCPN Contracts / ' . $MBName : '' }}
                        {{ (request()->is('facilityassets')) ? '  Budget Utilization / HCPN Contracts /  ' . $SelectedHCF : '' }}
                    @else
                        {{ (request()->is('facilitycontracts')) ? '  Budget Utilization / HCPN Contracts ' : '' }}
                        {{ (request()->is('facilityassets')) ? '  Budget Utilization / HCPN Contracts /  ' . $SelectedHCF : '' }}
                    @endif
                </span>
            @endif
        </div>
    </div>
</div>