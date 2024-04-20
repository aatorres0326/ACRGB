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




    <hr class="sidebar-divider {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}">

      <li class="nav-item {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
                        <a class="nav-link  {{ (request()->is('userinfo')) ? 'active' : '' }}" href="/userinfo">
                        <i class="fas fa-fw fa-users"></i>
                            <span>User Details</span></a>
                    </li>
                    <li class="nav-item {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
                        <a class="nav-link
                        {{ (request()->is('userlogins')) ? 'active' : '' }}
                        {{ (request()->is('useraccess')) ? 'active' : '' }}" href="/userlogins">
                        <i class="fas fa-fw fa-lock"></i>
                            <span>Login Details</span></a>
                    </li>
    <li class="nav-item  {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ (request()->is('pro')) ? 'active' : '' }} {{ (request()->is('proaccess')) ? 'active' : '' }}
    {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }} 
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
        <a class="nav-link" href="/pro">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>Regional Offices</span></a>
    </li>
    <li class="nav-item  {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ (request()->is('managingboard')) ? 'active' : '' }}
    {{ (request()->is('mbaccess')) ? 'active' : '' }}
    {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }} 
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}">
        <a class="nav-link" href="/managingboard">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>HCPN</span></a>
    </li>
    <li class="nav-item {{ (request()->is('facilities')) ? 'active' : '' }}
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }} ">
        <a class="nav-link" href="/facilities">
            <i class="fas fa-fw fa-hospital-alt"></i>
            <span>Facilities</span></a>
    </li>

    <li class="nav-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}
                    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
                    {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}
                    {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}" id="accordion">
        <a class="nav-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-chart-bar"></i><span>&nbsp;Budget Utilization</span>
        </a>
        <div id="collapseOne" class="collapse
            {{ (request()->is('hcpncontract')) ? 'show' : '' }}
            {{ (request()->is('apexcontract')) ? 'show' : '' }}
            {{ (request()->is('apexassets')) ? 'show' : '' }}
            {{ (request()->is('userlevel')) ? 'show' : '' }}
            {{ (request()->is('useraccess')) ? 'show' : '' }}" data-parent="#accordion">
       
            <div class="bg-white py-2 collapse-inner rounded">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="collapse-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}" href="/hcpncontract">
                        <span>HCPN Contracts</span></a>
                    </li>
                    <li class="nav-item}">
                        <a class="collapse-item {{ (request()->is('apexcontract')) ? 'active' : '' }} {{ (request()->is('apexassets')) ? 'active' : '' }}" href="/apexcontract">
                        <span>APEX Facility Contracts</span></a>
                    </li>
                     <li class="nav-item}">
                        <a class="collapse-item {{ (request()->is('terminatedcontract')) ? 'active' : '' }}" href="/terminatedcontract">
                        <span>Terminated Contracts</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}
                    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
                    {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}
                    {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}" id="accordion">
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
                    <li class="nav-item}">
                        <a class="collapse-item {{ (request()->is('apexreports/ledger')) ? 'active' : '' }} {{ (request()->is('apexreports')) ? 'active' : '' }}" href="/apexreports">
                        <span>APEX Facilities</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </li>

 <li class="nav-item {{ (request()->is('viewbudget')) ? 'active' : '' }}
 {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
 {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}">
        <a class="nav-link" data-toggle="modal" data-target="#view-budget">
            <i class="fas fa-fw fa-money-bill-alt"></i>
            <span>View Budget</span></a>
    </li>
    <li class="nav-item {{ (request()->is('viewbudget')) ? 'active' : '' }}
 {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
 {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}
 {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}">
        <a class="nav-link" href="/DATESETTINGS">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Date Settings</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<!-- VIEW BUDGET MODAL -->
<div class="modal" id="view-budget">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
               
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">View Budget</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <div class="modal-body">
                    <form action="{{ route('GetHealthFacilityBudget') }}">
                        @csrf   
                         <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="userlevel">Date From</label>
                                <input type="date" name="datefrom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="userlevel">Date To</label>
                                <input type="date" name="dateto" class="form-control">
                            </div>
                        </div>
                        <div class="form-row {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }} ">
                            <div class="form-group col">
                                <label for="userlevel">HCPN</label>
                                <select name="mb" class="form-control">
                                    
@foreach ($ManagingBoard as $mb)
                                    <option value="{{ $mb['mbid']}}">{{ $mb['mbname']}}</option>
@endforeach

                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">View</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>



