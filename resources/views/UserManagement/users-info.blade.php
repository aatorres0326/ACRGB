@extends('layouts.app')


@section('contents')

<div class="container-fluid">

    <!-- ADD USER INFO MODAL -->
    <div class="modal" id="add-user">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD USER</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('addUserInfo') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" name="firstname" placeholder="Firstname">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="middlename">Middlename</label>
                                <input type="text" class="form-control" name="middlename" placeholder="Middlename">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="lastname">Lastname</label>
                                <input type="text" class="form-control" name="lastname" placeholder="Lastname">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="area">Area</label>
                                <select name="area" class="form-control">

                                    @foreach($area as $areaid)
                                    <option value="{{ $areaid['areaid'] }}">{{ $areaid['areaname'] }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md d-none">

                                <input type="text" class="form-control d-none" name="createdby" placeholder="aatorres"
                                    value="86">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col">
                                <label for="userlevel">Facility</label>
                                <select name="hcfid" class="form-control">
                                    @foreach($facilities as $facility)
                                    <option value="{{ $facility['hcfid'] }}">{{ $facility['hcfname'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>





    <!-- USERS TABLE -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive-sm"
                style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                id="content">
                <div style="position:absolute; top:13px; right:470px">
                    <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-user" style="text-decoration:
                        none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add User
                    </a>
                </div>
                <table class="table table-sm table-hover table-bordered table-light" id="tablemanager" width="100%"
                    cellspacing="0">
                    <div class="row" style="margin-bottom: 7px;">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Login Credential</th>
                            <th class="text-center">Facility</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">Creation Date</th>
                            <th class="text-center d-none">Created By</th>

                            <th class="disableSort disableFilterBy text-center">Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($userInfoList as $user)
                        <tr>
                            <td>{{ $user['firstname'] ." ". $user['middlename'] ." ". $user['lastname']}}</td>

                            @php
                            $login = "No Login Credentials";
                            foreach ($userlogin as $userlog) {
                            if ($userlog['did'] === $user['did']) {
                            $login = $userlog['username'];
                            break;
                            }
                            }
                            @endphp
                            @if (Str::contains($login, 'No Login Credentials'))
                            <td class="text-center" style="color: #e9967a">{{ $login }}</td>
                            @else
                            <td class="text-center">{{ $login }}</td>
                            @endif

                            @php
                            $facilityName = "Facility Not Found" . " (Facility ID " . $user['hcfid'] . " )";
                            foreach ($facilities as $facility) {
                            if ($facility['hcfid'] === $user['hcfid']) {
                            $facilityName = $facility['hcfname'];
                            break;
                            }
                            }
                            @endphp
                            @if (Str::contains($facilityName, 'Facility Not Found'))
                            <td class="text-center" style="color: #e9967a">{{ $facilityName }}</td>
                            @else
                            <td class="text-center">{{ $facilityName }}</td>
                            @endif

                            @php
                            $areaName = "Facility Not Found" . " (Facility ID " . $areaid['areaid'] . " )";
                            foreach ($area as $areaid) {
                            if ($areaid['areaid'] === $user['areaid']) {
                            $areaName = $areaid['areaname'];
                            break;
                            }
                            }
                            @endphp
                            @if (Str::contains($areaName, 'Facility Not Found'))
                            <td style="color: #e9967a">{{ $areaName }}</td>
                            @else
                            <td class="text-center">{{ $areaName }}</td>
                            @endif


                            <td class="text-center">{{ $user['datecreated'] }}</td>
                            <td class="text-center d-none">{{ $user['createdby'] }}</td>


                            <td>
                                <center>
                                    @php
                                    $login = "Credentials Not Found";
                                    foreach ($userlogin as $userlog) {
                                    if ($userlog['did'] === $user['did']) {
                                    $login = $userlog['username'];
                                    break;
                                    }
                                    }
                                    @endphp
                                    @if (Str::contains($login, 'Credentials Not Found'))
                                    <a class="btn btn-sm btn-link" data-toggle="modal" data-target="#addlogin" onclick="addLogin(
                                                    '<?=$user['did']?>',
                                                    '<?=$user['lastname']?>'
                                 )"><i class="fas fa-fw fa-plus" data-toggle="tooltip" title="Create Login"></i></a>
                                    @else
                                    <a class="btn btn-sm btn-link disabled"><i class="fas fa-fw fa-plus"
                                            data-toggle="tooltip" title="Create Login"></i></a>
                                    @endif


                                    <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                        data-target="#editUser" onclick="EditUserDetails(
                                                    '<?=$user['did']?>',
                                                     '<?=$user['firstname']?>',
                                                      '<?=$user['middlename']?>',
                                                    '<?=$user['lastname']?>'
                                 )"><i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                                    <a class="btn btn-sm btn-link text-danger"><i class="fas fa-fw fa-file-archive"
                                            data-toggle="tooltip" title="Archive"></i></a>
                                </center>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- ADD LOGIN MODAL -->
                <div class="modal" id="addlogin" name="addlogin">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <!-- Claim Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="titlemodal">Add Login Credentials</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!--Claim Modal body -->
                            <div class="modal-body" id="modal-body-content">
                                <form action="{{ route('addUserLogin') }}" method="POST">
                                    @csrf
                                    <input class="form-control d-none" type="text" name="did" id="did" />
                                    <input class="d-none" type="text" name="userlastname" id="lastname" />
                                    <div class="form-row">

                                        <div class="form-group col-md-7">
                                            <label for="firstnamee">Username</label>
                                            <input class="form-control" type="text" name="username" id="username" />
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="password">Password</label>
                                            <input class="form-control" type="text" name="password" id=" password" />
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="level">User Level</label>
                                            <select name="level" class="form-control">
                                                @foreach($userLevel as $level)
                                                <option value="{{ $level['levelid'] }}">{{ $level['levdetails'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                            </div>
                            <!--Claim Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" name="submitAdd" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- END OF ADD LOGIN MODAL -->

                <!-- MODIFY USER DETAILS MODAL -->

                <div class="modal" id="editUser" name="editUser">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <!-- Claim Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="titlemodal">Add Login Credentials</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!--Claim Modal body -->
                            <div class="modal-body" id="modal-body-content">
                                <form action="{{ route('addUserLogin') }}" method="POST">
                                    @csrf
                                    <input class="form-control d-none" type="text" name="did" id="did" />
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" class="form-control" name="firstname"
                                                placeholder="Firstname">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="middlename">Middlename</label>
                                            <input type="text" class="form-control" name="middlename"
                                                placeholder="Middlename">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="lastname">Lastname</label>
                                            <input type="text" class="form-control" name="lastname"
                                                placeholder="Lastname">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="area">Area</label>
                                            <select name="area" class="form-control">

                                                @foreach($area as $areaid)
                                                <option value="{{ $areaid['areaid'] }}">{{ $areaid['areaname'] }}
                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                            </div>
                            <!--Claim Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" name="submitAdd" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END OF MODIFY USER DETAILS MODAL -->

            </div>
        </div>
    </div>
</div>


@endsection