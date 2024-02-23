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
                                <label for="userlevel">Area</label>
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
                            <th class="text-center">Address</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">Accreditation</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Date Created</th>
                            <th class="disableSort disableFilterBy text-center">Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($facilities as $facility)
                        <tr>


                            <td class="d-none">{{ $facility['hcfid'] }}</td>
                            <td>{{ $facility['hcfname'] }}</td>
                            <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                            <td class="text-center">{{ $facility['areaid'] }}</td>
                            <td class="text-center">{{ $facility['hcfcode'] }}</td>
                            <td class="text-center">{{ $facility['createdby'] }}</td>
                            <td class="text-center">{{ $facility['datecreated'] }}</td>
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