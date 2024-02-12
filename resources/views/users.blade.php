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
                    <form action="{{ route('addUserAccount') }}" method="POST">
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
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="userlevel">Facility</label>
                                <select name="hfid" class="form-control">
                                    @foreach($facilities as $facility)
                                    <option value="{{ $facility['id'] }}">{{ $facility['hciname'] }}</option>
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

    <div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- User details will be displayed here -->
                </div>
            </div>
        </div>
    </div>


    <?php
    $now = new DateTime();

    $now->format('Y-m-d');
    
    ?>
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
                <table class="table table-sm table-hover table-bordered table-light" id="tablemanager" width="100%"
                    cellspacing="0">
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
                            <th>Creation Date</th>
                            <th class="disableSort disableFilterBy"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($userList as $user)
                        <tr>


                            <td>{{ $user['userid'] }}</td>
                            <td>{{ $user['firstname'] . ' ' . $user['middlename'] . ' ' . $user['lastname'] }}</td>
                            <td>{{ $user['username'] }}</td>
                            <td>Super Admin</td>
                            @foreach ($facilities as $facility)
                            @if ($facility['id'] === $user['hfid'])
                            <!-- Display the relevant data from the other table here -->
                            <td>{{ $facility['hciname'] }}</td>
                            @endif
                            @endforeach
                            <td>{{ $user['datecreated'] }}</td>
                            <td>
                                <center><button class="btn-sm btn-warning edit-user" data-userid="{{ $user['userid'] }}"
                                        data-name="{{ $user['firstname'] . ' ' . $user['middlename'] . ' ' . $user['lastname'] }}"
                                        data-username="{{ $user['username'] }}" data-hfid="{{ $user['hfid'] }}"
                                        data-datecreated="{{ $user['datecreated'] }}">Edit
                                    </button></center>
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