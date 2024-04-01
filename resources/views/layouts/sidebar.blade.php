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
    <li class="nav-item {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ (request()->is('dashboard')) ? 'active' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


   
  



    <!-- Divider -->
    <hr class="sidebar-divider {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}">

    <!-- Heading -->

   
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
<!--               
                    <li class="nav-item {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
                        <a class="nav-link  {{ (request()->is('userlevel')) ? 'active' : '' }}" href="/userlevel">
                        <i class="fas fa-fw fa-list"></i>
                            <span>Role Management</span></a>
                    </li> -->


    <!-- <li class="nav-item  {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}
    {{ (request()->is('area')) ? 'active' : '' }}
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
        <a class="nav-link" href="/area">
            <i class="fas fa-fw fa-cog"></i>
            <span>Area</span></a>
    </li> -->
    <li class="nav-item  {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ (request()->is('pro')) ? 'active' : '' }}
    {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }} 
    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
    {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}">
        <a class="nav-link" href="/pro">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>Regional Offices</span></a>
    </li>
    <li class="nav-item  {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
    {{ (request()->is('managingboard')) ? 'active' : '' }}
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

     <li class="nav-item {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}
                    {{ (request()->is('hcpncontract')) ? 'active' : '' }}
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
            {{ (request()->is('userlevel')) ? 'show' : '' }}
            {{ (request()->is('useraccess')) ? 'show' : '' }}" data-parent="#accordion">
            <!-- Nav Item - Pages Collapse Menu -->
            <div class="bg-white py-2 collapse-inner rounded">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="collapse-item {{ (request()->is('hcpncontract')) ? 'active' : '' }}" href="/hcpncontract">
                        <span>HCPN</span></a>
                    </li>
                    <li class="nav-item}">
                        <a class="collapse-item {{ (request()->is('apexcontract')) ? 'active' : '' }}" href="/apexcontract">
                        <span>APEX</span></a>
                    </li>
                </ul>
</div>
</div>
</li>

 <li class="nav-item {{ (request()->is('viewbudget')) ? 'active' : '' }}
 {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}
 {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}">
        <a class="nav-link" href="/facilities" data-toggle="modal" data-target="#view-budget">
            <i class="fas fa-fw fa-money-bill-alt"></i>
            <span>View Budget</span></a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<!-- VIEW BUDGET MODAL -->
<div class="modal" id="view-budget">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">View Budget</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
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
                <!-- Modal footer -->
            </div>
        </div>
    </div>



<!-- End of Admin Sidebar -->