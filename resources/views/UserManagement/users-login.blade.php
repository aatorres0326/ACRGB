@extends('layouts.app')


@section('contents')

<div class="container-fluid">

    <!-- ADD USER MODAL -->
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
                    <form action="" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>
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
                                <label for="userlevel">User Level</label>
                                <select name="role" class="form-control">

                                    <option value="">Admin</option>
                                    <option value="">Staff</option>

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
                            <th class="text-center">Role</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Date Created</th>
                            <th class="text-center d-none">Status</th>
                            <th class="disableSort disableFilterBy text-center"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($userList as $user)
                        <tr>


                            <td class="text-center">{{ $user['userid'] }}</td>
                            <td class="text-center">{{ $user['username'] }}</td>

                            <td class="text-center">{{ $user['leveid'] }}</td>



                            <td class="text-center">{{ $user['createdby'] }}</td>
                            <td class="text-center">{{ $user['datecreated'] }}</td>


                            <td class="text-center d-none">{{ $user['status'] }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-link text-darker-warning"><i class="fas fa-fw fa-edit"
                                        data-toggle="tooltip" title="Edit"></i></a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection