@extends('layouts.app')


@section('contents')

<div class="container-fluid">

    <!-- ADD USER MODAL -->
    <div class="modal" id="add-user">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">ADD USER</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form>
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
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="firstname" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                        </div>
                        <div class="form-row">
                            <!-- <div class="form-group col-md-7">
                <label for="ulocation">User Location</label>
                <input type="text" class="form-control" id="ulocation">
              </div> -->
                            <div class="form-group col-md-5">
                                <label for="userlevel">Facility</label>
                                <select name="hfid" class="form-control">

                                    <option value=""></option>

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
                <div style="position:absolute; top:13px; right:470px">
                    <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-user" text-decoration:
                        none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add User
                    </a>
                </div>
                <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%" cellspacing="0">
                    <div class="row" style="margin-bottom: 7px;">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Facility Assignment</th>
                            <th class="disableSort disableFilterBy">Creation Date</th>
                            <th class="disableSort disableFilterBy"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Facility Assignment</th>
                            <th>Creation Date</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>

                            @foreach($userList['result'] as $user)
                            <td>{{ $user['userid'] }}</td>
                            <td>Alexander Amoroso Torres</td>
                            <td>aatorres</td>
                            <td>Super Admin</td>
                            <td>PhilHealth</td>
                            <td>November 9, 2023</td>
                            <td>
                                @endforeach
                                <center><a class=" btn btn-sm btn-warning">Edit</a></center>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection