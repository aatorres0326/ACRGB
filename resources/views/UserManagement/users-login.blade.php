@extends('layouts.app')


@section('contents')

<div class="container-fluid">

   

    <!-- USERS TABLE -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive-sm"
                style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">

                <table class="table table-sm table-hover table-bordered table-light" id="tablemanager" width="100%"
                    cellspacing="0">
                    <div class="row" style="margin-bottom: 7px;">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                    <thead>
                        <tr>
                            <th class="text-center">User ID</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Password</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Date Created</th>
                            <th class="text-center">Status</th>
                            <th class="disableSort disableFilterBy text-center"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($userList as $user)
                        <tr>
                            <td class="text-center">{{ $user['userid'] }}</td>
                            <td class="text-center">{{ $user['username'] }}</td>
                            <td class="text-center">{{ $user['userpassword'] }}</td>
                            <td class="text-center">{{ $user['leveid'] }}</td>
                            <td class="text-center">{{ $user['createdby'] }}</td>
                            <td class="text-center">{{ $user['datecreated'] }}</td>
                            <td class="text-center">
                                @if($user['status'] == 1)
                                <span>For Change</span>
                                @elseif($user['status'] == 2)
                                <span>Active</span>
                                @endif
                            </td>

                            <td class="text-center">
                                  <a class="btn btn-sm btn-link text-darker-primary {{ $user['leveid'] === 'HCF' ? 'disabled' : '' }} {{ $user['leveid'] === 'ADMIN' ? 'disabled' : '' }}" onclick="DisplayUserDetails(
                                                    '<?=$user['userid']?>',
                                                     '<?=$user['username']?>',
                                                    '<?=$user['leveid']?>'
                                 )"><i class="fas fa-fw fa-eye" data-toggle="tooltip" title="View"></i></a>
                                <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                    data-target="#editLogin" onclick="EditUserLogin(
                                                    '<?=$user['userid']?>',
                                                     '<?=$user['username']?>',
                                                    '<?=$user['status']?>'
                                 )"><i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- END OF USERS TABLE -->

    <!-- EDIT LOGIN CREDENTIALS MODAL -->
    <div class="modal" id="editLogin" name="editLogin">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="titlemodal">Modify Login Credentials</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="modal-body-content">
                    <form action="{{ route('editUserLogin') }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input class="form-control d-none" type="text" name="userid" id="userid" />
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="username">Username</label>
                                <input autocomplete="off" type="text" class="form-control" name="editusername"
                                    id="username">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input autocomplete="off" type="text" class="form-control" name="editpassword"
                                    placeholder="●●●●●●●●●">
                                <a class="btn btn-link btn-sm float-right" onclick="resetPassword()"> Reset
                                    Password</a>

                            </div>
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" name="submitAdd" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="reset()">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END OF EDIt LOGIN MODAL -->
</div>


@endsection