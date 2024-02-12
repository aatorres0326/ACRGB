@extends('layouts.app')


@section('contents')

<div class="container-fluid">

    <!-- ADD USER MODAL -->
    <div class="modal" id="add-user">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD FACILITY</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('addFacility') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="hciname">Facility</label>
                                <input type="text" class="form-control" name="hciname" placeholder="Facility Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="accreditation">Accreditation</label>
                                <input type="text" class="form-control" name="accreditation"
                                    placeholder="Accreditation #">

                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="userlevel">Regional Office</label>
                                <select name="role" class="form-control">

                                    <option value="">PhilHealth Regional Office Area 1</option>
                                    <option value="">PhilHealth Regional Office NCR</option>

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
                        none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Facility
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
                            <th class="d-none">Facility ID</th>
                            <th>Facility</th>
                            <th>Address</th>
                            <th>Accreditation</th>
                            <th>Regional Office</th>
                            <th class="disableSort disableFilterBy">
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($facilities as $facility)
                        <tr>


                            <td class="d-none">{{ $facility['id'] }}</td>
                            <td>{{ $facility['hciname'] }}</td>
                            <td>{{ $facility['address'] }}</td>
                            <td>{{ $facility['accreditation'] }}</td>

                            <td>Sample Regional Office</td>
                            <td>
                                <center><button class="btn-sm btn-warning edit-user">Edit
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