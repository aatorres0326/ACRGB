@extends('layouts.app')


@section('contents')

<div class="container-fluid">

    <!-- ADD USER INFO MODAL -->
    <div class="modal" id="add-user">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header  bg-light">
                    <h6 class="modal-title">NEW USER</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                 
                    <form action="{{ route('addUserInfo') }}" method="POST">
                        @csrf
                        <div class="form-row mb-2 font-weight-bold">PERSONAL INFORMATION</div>
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
                        </div>
                        <div class="form-row mb-2 font-weight-bold">CONTACT DETAILS</div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstname">Email</label>
                                <input type="email" class="form-control" name="email"
                                    placeholder="ex. philhealth@email.com" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="middlename">Mobile Number</label>
                                <input type="text" class="form-control" name="contact" placeholder="ex. 09012345678"
                                    required>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Save</button> <button type="button"
                                class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- USERS TABLE -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive-sm"
                style="overflow-y:auto; max-height: 520px; min-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                id="content">
                <div style="position:absolute; top:13px; right:320px">
                    <a class="btn-outline-success btn btn-sm" href="/UploadUsers"><i class="fas fa-upload fa-sm"></i> Upload Users
                    </a>
                    <button class="btn-outline-primary btn btn-sm" data-toggle="modal" data-target="#add-user" style="text-decoration:
                                            none; cursor:pointer;"><i class="fas fa-plus fa-sm"></i> New User
                    </button>&nbsp;
                    <input type="text" id="searchInput">
                </div>
                <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%" cellspacing="0">
                    <div class="row" style="margin-bottom: 7px;">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Login Credential</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Contact Number</th>
                          
                            
                            <th class="disableSort disableFilterBy text-center">Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($userInfoList as $user)
                                                <tr>
                                                    <td>{{ $user['firstname'] . " " . $user['middlename'] . " " . $user['lastname']}}</td>

                                                    @php
    $login = "No Login Credentials";
    $level = "Not Assigned Yet";
    foreach ($userlogin as $userlog) {
        if ($userlog['did'] === $user['did']) {
            $login = $userlog['username'];
            $level = $userlog['leveid'];
            break;
        }
    }
                                                    @endphp
                                                    @if (Str::contains($login, 'No Login Credentials'))
                                                        <td class="text-center" style="color: #e9967a">{{ $login }}</td>
                                                        <td class="text-center" style="color: #e9967a">{{ $level }}</td>
                                                    @else
                                                        <td class="text-center">{{ $login }}</td>
                                                        <td class="text-center">{{ $level }}</td>
                                                    @endif
                                                    <td class="text-center">{{ $user['email'] }}</td>
                                                    <td class="text-center">{{ $user['contact'] }}</td>




                                                    
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
                                                                                    '<?=$user['email']?>'
                                                                )"><i class="fas fa-fw fa-plus" data-toggle="tooltip" title="Create Login"></i></a>
                                                            @else
                                                                <a class="btn btn-sm btn-link disabled"><i class="fas fa-fw fa-plus"
                                                                        data-toggle="tooltip" title="Create Login"></i></a>
                                                            @endif


                                                            <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                                                data-target="#editUser" onclick="UpdateDetails('<?=$user['did']?>',
                                                            '<?=$user['firstname']?>',
                                                            '<?=$user['middlename']?>',
                                                            '<?=$user['lastname']?>',
                                                                '<?=$user['email']?>',
                                                                '<?=$user['contact']?>')"><i class="fas fa-fw fa-edit" data-toggle="tooltip"
                                                                    title="Edit"></i></a>

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

                            <div class="modal-header">
                                <h5 class="modal-title" id="titlemodal">Add Login Credentials</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body" id="modal-body-content">
                                <form action="{{ route('addUserLogin') }}" method="POST">
                                    @csrf
                                    <input class="form-control d-none" type="text" name="did" id="did" />
                                
                                    <div class="form-row">

                                        <div class="form-group col-md-7">
                                            <label for="email">Username</label>
                                            <input class="form-control" type="email" name="emailc" id="emailc" readonly/>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="password">Password</label>
                                            <input class="form-control" type="text" name="password" id="password" readonly/>
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

                            <div class="modal-footer">
                                <button type="submit" name="submitAdd" class="btn btn-outline-primary">Save</button>
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
                         
                            <div class="modal-header bg-light">
                                <h6 class="modal-title">UPDATE USER DETAILS</h6>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('UPDATEUSERINFO') }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-row mb-2 font-weight-bold">PERSONAL INFORMATION</div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="editfirstname">Firstname</label>
                                            <input type="text" class="form-control" name="editfirstname">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="editmiddlename">Middlename</label>
                                            <input type="text" class="form-control" name="editmiddlename">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="editlastname">Lastname</label>
                                            <input type="text" class="form-control" name="editlastname">
                                        </div>
                                    </div>
                                    <div class="form-row mb-2 font-weight-bold">CONTACT DETAILS</div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="editemail">Email</label>
                                            <input type="email" class="form-control" name="editemail" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="editcontact">Mobile Number</label>
                                            <input type="text" class="form-control" name="editcontact" required>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control d-none" name="edid" required>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function UpdateDetails(did, firstname, middlename, lastname, email, contact) {
                        document.getElementsByName("edid")[0].setAttribute("value", did);
                        document.getElementsByName("editfirstname")[0].setAttribute("value", firstname);
                        document.getElementsByName("editmiddlename")[0].setAttribute("value", middlename);
                        document.getElementsByName("editlastname")[0].setAttribute("value", lastname);
                        document.getElementsByName("editemail")[0].setAttribute("value", email);
                        document.getElementsByName("editcontact")[0].setAttribute("value", contact);
                    }
                </script>

               

            </div>
        </div>
    </div>
</div>


@endsection