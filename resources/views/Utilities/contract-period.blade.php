@extends('layouts.app')


@section('contents')

<div class="container-fluid">
    <div class="card shadow mt-2">
        <div class="card-body">

            <div class="table-responsive-sm"
                style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                id="content">
                <div style="position:absolute; top:13px; right:20px">
                    <button class="btn-outline-primary btn-sm" data-toggle="modal" data-target="#add-period" style="text-decoration:
                                                none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Period
                    </button>
                </div>
                <div class="card shadow mt-2">
                    <div class="card-body">
                        <table class="table table-sm table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">Date From</th>
                                    <th class="text-center">Date To</th>
                                    <th class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ContractDate as $ConDate)
                                    <tr>
                                        <td class="d-none"></td>
                                        <td class="text-center">
                                            {{ DateTime::createFromFormat('m-d-Y', $ConDate['datefrom'])->format('M j, Y') }}
                                        </td>
                                        <td class="text-center">
                                            {{ DateTime::createFromFormat('m-d-Y', $ConDate['dateto'])->format('M j, Y') }}
                                        </td>
                                        <td class="text-center"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal" id="add-period">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="modal-title">Add Contract Period</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('INSERTCONTRACTPERIOD') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="datefrom">Date From</label>
                                    <input type="date" name="datefrom" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dateto">Date To</label>
                                    <input type="date" name="dateto" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Add</button> <button
                                    type="button" class="btn btn-sm btn-outline-danger"
                                    data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection