@extends('layouts.app')


@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-md">

            <h3 class="text-center text-primary">{{ $SelectedMbName }}</h3>
        </div>
    </div>
    </br>

 

    <div class="row">

        <div class="col-md">
            <h5 class="text-success" style="position:absolute; left:20px;">ENABLED ACCESS PERMISSION</h5>
            <div style="position:absolute; top:13px; right:20px"
                class="{{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }} {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}">
                <a class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add-access" style="text-decoration:
                        none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Access
                </a> <a class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#remove-access" style="text-decoration:
                        none;"><i class="fas fa-trash fa-sm "></i> Remove Access
                </a>
            </div>
            </br>
            </br>


            <div class="card shadow mb-4">

                <div class="card-body">

                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                        id="content">
                        <table class="table table-sm table-hover table-bordered table-light" id="tablemanager"
                            width="100%" cellspacing="0">


                            <thead>
                                <tr>

                                    <th>Facilities</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Accreditation</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Facilities as $facility)
                                                                @php
                                                                    $roleIndexData = $RoleIndex->where('accessid', $facility['hcfcode'])->where('userid', $SelectedMbID)->where('userid', $SelectedMbID)->first();
                                                                @endphp
                                                                @if($roleIndexData)
                                                                    <tr>
                                                                        <td class="d-none">{{ $roleIndexData['roleid'] }}</td>
                                                                        <td>{{ $facility['hcfname'] }}</td>
                                                                        <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                                                                        <td class="text-center">{{ $facility['hcfcode'] }}</td>

                                                                    </tr>
                                                                @endif
                                @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD ACCESS MODAL -->
<div class="modal" id="add-access">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
         
            <div class="modal-header" <center><span>ADD ACCESS PERMISSION</span></center>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="overflow-y:auto; ">
                <div class="col-md-">

                    <form action="{{ route('INSERTROLEINDEXMB') }}" method="POST">
                        @csrf
                        <div class="card shadow mb-4">

                            <div class="card-body">
                                <span> Add Facility access to </span><span
                                    class="text-primary">{{ $SelectedMbName }}</span>
                                <div class="table-responsive-sm"
                                    style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size; 10px;">
                                    <table class="table table-sm table-hover table-bordered table-striped table-light"
                                        width="100%" cellspacing="0">


                                        <thead>
                                            <tr>
                                                <th class="d-none"></th>
                                                <th>Facilities</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Accreditation</th>
                                                <th class="disableSort disableFilterBy text-center">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Facilities as $facility)
                                                                                    @if($facility['type'] === "NONAPEX")
                                                                                                                            @php
                                                                                                                                $roleIndexData = null;
                                                                                                                                foreach ($ManagingBoard as $HCPN) {
                                                                                                                                    $roleIndexData = $RoleIndex->where('accessid', $facility['hcfcode'])
                                                                                                                                        ->where('userid', $HCPN['controlnumber'])
                                                                                                                                        ->first();
                                                                                                                                    if ($roleIndexData) {
                                                                                                                                        break;
                                                                                                                                    }
                                                                                                                                }
                                                                                                                            @endphp

                                                                                                                            @if(!$roleIndexData)
                                                                                                                                <tr>
                                                                                                                                   
                                                                                                                                    <td>{{ $facility['hcfname'] }}</td>
                                                                                                                                    <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                                                                                                                                    <td class="text-center">{{ $facility['hcfcode'] }}</td>
                                                                                                                                    <td class="text-center">
                                                                                                                                        <center><input class="form-control"
                                                                                                                                                style="width: 16px; height: 16px;" type="checkbox"
                                                                                                                                                id="addaccesbox" value=""
                                                                                                                                                data-hcfid="{{ $facility['hcfcode'] }}"></center>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            @endif
                                                                                    @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center" id="pagination"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                        <input type="text" class="d-none" name="mbid" value="{{ $SelectedMbID }}" />
                        <input type="text" class="d-none" name="mbname" value="{{ $SelectedMbName }}" />

                        <textarea class="d-none" name="accessid" id="accessid" required></textarea>
                        <div class="mt-5 text-center"><button style="margin-top:-50px;"
                                class="btn btn-outline-primary btn-sm" type="submit">Save</button>
                            <button type="button" style="margin-top:-50px;" class="btn btn-outline-warning btn-sm"
                                data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END OF ADD ACCESS MODAL -->
<!-- REMOVE ACCESS MODAL -->
<div class="modal" id="remove-access">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
     
            <div class="modal-header" <center><span>REMOVE ACCESS PERMISSION</span></center>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="overflow-y:auto;">
                <div class="col-md">
                    <form action="" method="POST">
                        @csrf
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h6><span> Remove access from </span><span
                                        class="text-primary">{{ $SelectedMbName }}</span></h6>
                                <div class="table-responsive-sm"
                                    style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size: 10px;">
                                    <table class="table table-sm table-hover table-bordered table-light"
                                        id="tablemanager" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Facilities</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Accreditation</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Facilities as $facility)
                                                                                        @php
                                                                                            $roleIndexData = $RoleIndex->where('accessid', $facility['hcfcode'])->where('userid', $SelectedMbID)->first();
                                                                                        @endphp
                                                                                        @if($roleIndexData)
                                                                                            <tr>
                                                                                                <td class="d-none">{{ $roleIndexData['roleid'] }}</td>
                                                                                                <td>{{ $facility['hcfname'] }}</td>
                                                                                                <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                                                                                                <td class="text-center">{{ $facility['hcfcode'] }}</td>
                                                                                                <td class="text-center">
                                                                                                    <center><input class="form-control"
                                                                                                            style="width: 16px; height: 16px;" type="checkbox"
                                                                                                            id="addaccesbox" value=""
                                                                                                            data-hcfid="{{ $facility['hcfcode'] }}"></center>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center" id="pagination"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                        <input type="text" class="d-none" name="proid" value="{{ $SelectedMbID }}" />
                        <input type="text" class="d-none" name="proname" value="{{ $SelectedMbName }}" />

                    </form>
                </div>
                <div class="mt-5 text-center">
                    <button id="openRemoveAccessModal" style="margin-top:-50px;" class="btn btn-sm btn-outline-warning"
                        data-toggle="modal" data-target="#removeaccess">Remove</button>
                    <button type="button" style="margin-top:-50px;" class="btn btn-outline-danger btn-sm"
                        data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="removeaccess">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
       
            <div class="modal-header bg-warning text-white">
                <h6 class="modal-title">REMOVE ACCESS TO SELECTED FACILITIES</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
         
            <div class="modal-body">
                <form action="{{ route('REMOVEROLEINDEXPRO') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <h5 class="text-center">{{ $SelectedMbName }}</h5>
                    <div class="card bg-light text-dark"
                        style="color:black; max-height: 250px; overflow-y:scroll; overflow-x:hidden;">
                        <br>
                        @if ($Facilities === null)                          <h6> No Data Found </h6>
                            @else                           @foreach($Facilities as $facility)
                            <h6 id="confirmremovesubmission"><span class="col-md-8">{{ $facility['hcfname'] }}</span><span
                                    class="col-md-4 text-center controlnumber"
                                    style="float:right">{{ $facility['hcfcode'] }}</span></h6>
                            @endforeach
                        @endif
                        <br>
                    </div>
                    <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                    <input type="text" class="d-none" name="proid" value="{{ $SelectedMbID }}" />
                    <textarea id="confirmremoveaccessid" class="d-none" name="accessid" required></textarea>
                    <input type="text" class="d-none" name="proname" value="{{ $SelectedMbName }}" />
                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END OF REMOVE ACCESS MODAL -->
<script src="{{ asset('js/mb-access.js') }}"></script>



@endsection