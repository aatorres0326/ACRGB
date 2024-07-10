@extends('layouts.app')


@section('contents')

<div class="container-fluid">





    <div class="card" style="border:none; background-color: transparent;">
        <div class="card-header border border-secondary bg-light p-1">
            <h6 class="text-white ml-2 font-weight-bold">{{ $SelectedHCFName }}</h6>

        </div>



        <div class="card shadow mb-4 border border-secondary">
            <div class="card-body">
                <div class="d-flex flex-row-reverse">
                    <input type="text" id="searchInput">&nbsp;
                    <a class="btn btn-outline-primary btn-sm {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}"
                        data-toggle="modal" data-target="#add-access" style="text-decoration:
                        none;"><i class="fas fa-plus fa-sm"></i> Add Affiliates
                    </a> &nbsp;<a
                        class="btn btn-outline-danger btn-sm {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}"
                        data-toggle="modal" data-target="#remove-access" style="text-decoration:
                        none;"><i class="fas fa-trash fa-sm "></i> Remove Affiliates
                    </a>

                </div>
                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                    id="content">
                    <table class="table table-sm table-hover table-bordered table-light" id="tablemanager" width="100%"
                        cellspacing="0">


                        <thead>
                            <tr>
                                <th class="text-center">HCPN</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Registration Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ManagingBoard as $mb)
                            @php
                            $roleIndexData = $RoleIndex->where('accessid', $mb['controlnumber'])->where(
                            'userid',
                            $SelectedHCFCode
                            )->first();
                            @endphp
                            @if($roleIndexData)
                            <tr>
                                <td>{{ $mb['mbname'] }}</td>

                                <td class="text-center">{{ $mb['address'] }}</td>
                                <td class="text-center">{{ $mb['controlnumber'] }}</td>

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





<div class="modal" id="add-access">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-light text-white">
                <center><span>ADD FACILITY</span></center>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="overflow-y:auto; ">
                <div class="col-md-">

                    <form action="{{ route('INSERTROLEINDEXMB') }}" method="POST">
                        @csrf
                        <div class="card shadow mb-4">

                            <div class="card-body">
                                <span> Add Facility Access to </span><span
                                    class="text-primary">{{ $SelectedHCFName }}</span>
                                <div class="table-responsive-sm"
                                    style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size; 10px;">
                                    <div style="position:absolute; top:18px; right:320px">

                                        <input type="text" id="searchInput">
                                    </div>
                                    <table class="table table-sm table-hover table-bordered table-striped table-light"
                                        width="100%" cellspacing="0">


                                        <thead>
                                            <tr>

                                                <th class="text-center">HCPN</th>

                                                <th class="text-center">Address</th>
                                                <th class="text-center">Accreditation</th>
                                                <th class="disableSort disableFilterBy text-center">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ManagingBoard as $mb)

                                            @php
                                            $roleIndexData = $RoleIndex->where('accessid', $mb['controlnumber'])->where(
                                            'userid',
                                            $SelectedHCFCode
                                            )->first();
                                            @endphp

                                            @if(!$roleIndexData)


                                            <tr>
                                                <td class="text-center">{{ $mb['mbname'] }}</td>

                                                <td class="text-center">{{ $mb['address'] }}</td>
                                                <td class="text-center">{{ $mb['controlnumber'] }}</td>


                                                <td class="text-center">
                                                    <center><input class="form-control"
                                                            style="width: 16px; height: 16px;" type="checkbox"
                                                            id="addaccesbox" value=""
                                                            data-hcfid="{{ $mb['controlnumber'] }}"></center>
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
                        <input type="text" class="d-none" name="mbid" value="{{ $SelectedHCFCode }}" />
                        <input type="text" class="d-none" name="mbname" value="{{ $SelectedHCFName }}" />

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

<div class="modal" id="remove-access">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-light text-white">
                <center><span>REMOVE ACCESS PERMISSION</span></center>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="overflow-y:auto;">
                <div class="col-md">
                    <form action="" method="POST">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6><span> Remove access from </span><span
                                        class="text-primary">{{ $SelectedHCFName }}</span></h6>
                                <div class="table-responsive-sm"
                                    style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size: 10px;">
                                    <table class="table table-sm table-hover table-bordered table-light"
                                        id="tablemanager" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">HCPN</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Accreditation</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        @foreach($ManagingBoard as $mb)
                                        @php
                                        $roleIndexData = $RoleIndex->where('accessid', $mb['controlnumber'])->where(
                                        'userid',
                                        $SelectedHCFCode
                                        )->first();
                                        @endphp
                                        @if($roleIndexData)
                                        <tr>
                                            <td class="text-center">{{ $mb['mbname'] }}</td>

                                            <td class="text-center">{{ $mb['address'] }}</td>
                                            <td class="text-center">{{ $mb['controlnumber'] }}</td>

                                            <td class="text-center">
                                                <center><input class="form-control" style="width: 16px; height: 16px;"
                                                        type="checkbox" id="addaccesbox" value=""
                                                        data-hcfid="{{ $mb['controlnumber'] }}"></center>
                                            </td>
                                        </tr>
                                        @endif

                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                        <input type="text" class="d-none" name="proid" value="{{ $SelectedHCFCode }}" />
                        <input type="text" class="d-none" name="proname" value="{{ $SelectedHCFName }}" />

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
                <span class="modal-title">REMOVE ACCESS</span>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form action="{{ route('REMOVEROLEINDEXPRO') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <h5 class="text-center"></h5>
                    <span>Remove Affiliates</span>
                    <div class="card text-dark"
                        style="color:black; max-height: 250px; overflow-y:auto; overflow-x:hidden;">

                        <div class="card-body">

                            @if ($ManagingBoard === null)
                            <h6> No Data Found </h6>
                            @else
                            @foreach($ManagingBoard as $mb)
                            <div id="confirmremovesubmission" style="font-size: 13px;"><span
                                    class="col-md-8">{{ $mb['mbname'] }}</span><span
                                    class="col-md-4 text-center controlnumber"
                                    style="float:right">{{ $mb['controlnumber'] }}</span></div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                    <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                    <input type="text" class="d-none" name="proid" value="{{ $SelectedHCFCode }}" />
                    <textarea id="confirmremoveaccessid" class="d-none" name="accessid" required></textarea>
                    <input type="text" class="d-none" name="proname" value="{{ $SelectedHCFName }}" />
                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Remove</button>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END OF REMOVE ACCESS MODAL -->
<script src="{{ asset('js/mb-access.js') }}"></script>



@endsection