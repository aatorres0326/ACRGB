@extends('layouts.app')


@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <label>Username</label>
            <input type="text" class="form-control" disabled id="displayusername">
        </div>
        <div class="col-md-6">
            <label>User Level</label>
            <input type="text" class="form-control" disabled id="displaylevel">
        </div>
        <div class="col-md-6 d-none">
            <input type="text" class="form-control" disabled id="displayuserid">
        </div>
    </div>
    </br>

    <!-- ADDED TABLE -->
    <div class="row">
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="text-success" style="position:absolute; left:20px; top:13px;">ENABLED ACCESS PERMISSION
                    </h5>
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                        id="content">
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div style="position:absolute; top:13px; right:20px">
                                <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-access" style="text-decoration:
                        none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Access
                                </a> <a class="btn btn-link btn-sm text-warning" data-toggle="modal"
                                    data-target="#add-user" style="text-decoration:
                        none;"><i class="fas fa-trash fa-sm text-info-40"></i> Remove Access
                                </a>
                            </div>
                            @if ($SelectedUserRole == 'PRO')
                                                    <thead>
                                                        <tr>
                                                            <th class="d-none"></th>
                                                            <th>Regional Office</th>
                                                            <th class="disableSort disableFilterBy text-center">Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($RegionalOffices as $pro)
                                                                                    @php
                                                                                        $roleIndexData = $RoleIndex->where('accessid', $pro['procode'])->where('userid', $SelectedUserID)->first();

                                                                                    @endphp
                                                                                    @if($roleIndexData)
                                                                                        <tr>
                                                                                            <td class="d-none">{{ $roleIndexData['roleid'] }}</td>
                                                                                            <td>{{ $pro['proname'] }}</td>
                                                                                            <td class="text-center">
                                                                                                <input class="form-check-input" type="checkbox" value="">
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                        @endforeach
                                                    </tbody>

                            @else
                                                    <thead>
                                                        <tr>
                                                            <th class="d-none"></th>
                                                            <th>Managing Board</th>

                                                            <th class="disableSort disableFilterBy text-center">Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($ManagingBoard as $mb)
                                                                                    @php
                                                                                        $roleIndexData = $RoleIndex->where('accessid', $mb['controlnumber'])->where('userid', $SelectedUserID)->first();

                                                                                    @endphp
                                                                                    @if($roleIndexData)
                                                                                        <tr>
                                                                                            <td class="d-none">{{ $roleIndexData['roleid'] }}</td>
                                                                                            <td>{{ $mb['mbname'] }}</td>
                                                                                            <td class="text-center">
                                                                                                <input class="form-check-input" type="checkbox" value="">
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                        @endforeach
                                                    </tbody>
                            @endif
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

                    <form action="{{ route('INSERTROLEINDEX') }}" method="POST">
                        @csrf
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive-sm"
                                    style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size; 10px;">
                                    <table class="table table-sm table-hover table-bordered table-striped table-light"
                                        width="100%" cellspacing="0">

                                        @if ($SelectedUserRole == 'PRO')
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="d-none"></th>
                                                                                    <th>Regional Offices</th>
                                                                                    <th class="disableSort disableFilterBy text-center">Action
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="protable">
                                                                                @foreach($RegionalOffices as $pro)
                                                                                                                        @php
                                                                                                                            $roleIndexData = $RoleIndex->where('accessid', $pro['procode'])->where('userid', $SelectedUserID)->first();

                                                                                                                        @endphp
                                                                                                                        @if(!$roleIndexData)
                                                                                                                            <tr>
                                                                                                                                <td type="text" class="d-none" name="proid" id="proid">
                                                                                                                                    {{ $pro['procode'] }}</td>
                                                                                                                                <td>{{ $pro['proname'] }}</td>
                                                                                                                                <td class="text-center">
                                                                                                                                    <center><input class="form-control"
                                                                                                                                            style="width: 16px; height: 16px;" type="checkbox"
                                                                                                                                            id="addaccesbox" value=""
                                                                                                                                            data-proid="{{ $pro['procode'] }}">
                                                                                                                                        <center>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        @endif
                                                                                @endforeach
                                                                            </tbody>

                                        @else
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="d-none"></th>
                                                                                    <th>Managing Board</th>

                                                                                    <th class="disableSort disableFilterBy text-center">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($ManagingBoard as $mb)
                                                                                                                        @php
                                                                                                                            $roleIndexData = $RoleIndex->where('accessid', $mb['controlnumber'])->where('userid', $SelectedUserID)->first();

                                                                                                                        @endphp
                                                                                                                        @if(!$roleIndexData)
                                                                                                                            <tr>
                                                                                                                                <td class="d-none" name="mbid" id="mbid">{{ $mb['mbid'] }}</td>
                                                                                                                                <td class="text-center">{{ $mb['mbname'] }}</td>

                                                                                                                                <td class="text-center">
                                                                                                                                    <center><input class="form-control"
                                                                                                                                            style="width: 16px; height: 16px;" type="checkbox"
                                                                                                                                            id="addaccesbox" value="" data-mbid="{{ $mb['controlnumber'] }}">
                                                                                                                                        <center>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        @endif
                                                                                @endforeach
                                                                            </tbody>
                                        @endif

                                    </table>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center" id="pagination"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                        <input type="text" class="d-none" name="userid" value="{{ $SelectedUserID }}" />
                        <input type="text" class="d-none" name="passleveid" id="passlevel" />
                        <textarea class="d-none" name="accessid" required></textarea>
                        <div class="mt-5 text-center"><button style="margin-top:-50px;" class="btn btn-primary"
                                type="submit">Save</button>
                            <button type="button" style="margin-top:-50px;" class="btn btn-warning"
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

<script>

    var proCheckboxes = document.querySelectorAll('input[type="checkbox"][data-proid]');

    proCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var proid = this.getAttribute('data-proid');
            var textarea = document.querySelector('#add-access textarea');

            if (this.checked) {
                textarea.value += proid + ', ';
            } else {
                textarea.value = textarea.value.replace(proid + ', ', '');
            }
        });
    });


    var mbCheckboxes = document.querySelectorAll('input[type="checkbox"][data-mbid]');

    mbCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var mbid = this.getAttribute('data-mbid');
            var textarea = document.querySelector('#add-access textarea');

            if (this.checked) {
                textarea.value += mbid + ', ';
            } else {
                textarea.value = textarea.value.replace(mbid + ', ', '');
            }
        });
    });
</script>

<script>
    window.onload = function () {

        var userid = localStorage.getItem('getUserId');
        var username = localStorage.getItem('getUsername');
        var leveid = localStorage.getItem('getLevel');

        document.getElementById("displayusername").value = username;
        document.getElementById("displaylevel").value = leveid;
        document.getElementById("passlevel").value = leveid;
        document.getElementById("displayuserid").value = userid;
    };

</script>



@endsection