@extends('layouts.app')


@section('contents')

<div class="container-fluid">

    <!-- ADD ROLE MODAL -->
    <div class="modal" id="add-role">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD ROLE</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('addUserLevel') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="levname">Role</label>
                                <input type="text" class="form-control" name="levname">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="levdetails">Details</label>
                                <input type="text" class="form-control" name="levdetails">
                            </div>
                        </div>
                        <input type="text" class="form-control d-none" name="createdby" value="90">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
                style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                <div style="position:absolute; top:13px; right:450px">
                    <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-role" style="text-decoration:
                        none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Role
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
                            <th class="text-center">Role</th>
                            <th class="text-center">Details</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Date Created</th>
                            <th class="text-center">Status</th>
                            <th class="disableSort disableFilterBy text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($userLevel as $level)
                        <tr>
                            <td class="text-center">{{ $level['levname'] }}</td>
                            <td class="text-center">{{ $level['levdetails'] }}</td>
                            <td class="text-center">{{ $level['createdby'] }}</td>
                            <td class="text-center">{{ $level['datecreated'] }}</td>
                            <td class="text-center d-none">{{ $level['stats'] }}</td>
                            <td class="text-center">
                                @if($level['stats'] == 1)
                                <span>Change</span>
                                @elseif($level['stats'] == 2)
                                <span>Active</span>
                                @endif
                            </td>
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