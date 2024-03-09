@extends('layouts.app')


@section('contents')

<div class="container-fluid">

    <!-- ADD AREA TYPE MODAL -->
    
    <div class="modal" id="add-area-t">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD AREA TYPE</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('addAreaType') }}" method="POST" id="add-area-t">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="typename">Area Type</label>
                                <input type="text" class="form-control" name="typename" placeholder="">
                            </div>
                            <div class="form-group col-md d-none">

                                <input type="text" class="form-control d-none" name="createdby" placeholder="aatorres"
                                    value="86">
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

    <div class="modal" id="add-area">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD AREA</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('addArea') }}" method="POST" id="add-area-t">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="areaname">Area</label>
                                <input type="text" class="form-control" name="areaname" placeholder="">
                            </div>
                            <div class="form-group col-md d-none">

                                <input type="text" class="form-control d-none" name="createdby" placeholder="aatorres"
                                    value="57">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="areatype">Facility</label>
                                <select name="areatype" class="form-control">
                                    @foreach($AreaType as $AreaT)
                                    <option value="{{ $AreaT['typeid'] }}">{{ $AreaT['typename'] }}</option>
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



    <!-- AREA TABLE -->

    <div class="row">
        <div class="col-md-6">

            <div class="card shadow mb-5">
                <div class="card-body">
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                        <div style="position:absolute; top:13px;">
                            <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-area" style="text-decoration:
                                                        none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Area
                            </a>
                        </div>
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>

                                    <th>Area</th>
                                    <th>Area Type</th>
                                    <th>Created By</th>
                                    <th>Date Created</th>


                                    <th class="disableSort disableFilterBy">
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($Area as $Area)
                                <tr>


                                    <td>{{ $Area['areaname'] }}</td>
                                    @php
    $AreaTypeName = "Facility Not Found" . " ( Area Type ID " . $Area['typeid'] . " )";
    foreach ($AreaType as $AreaT) {
        if ($AreaT['typeid'] === $Area['typeid']) {
            $AreaTypeName = $AreaT['typename'];
            break;
        }
    }
                                    @endphp
                                    @if (Str::contains($AreaTypeName, 'Facility Not Found'))
                                    <td style="color: #e9967a">{{ $AreaTypeName }}</td>
                                    @else
                                    <td>{{ $AreaTypeName }}</td>
                                    @endif


                                    <td>{{ $Area['createdby'] }}</td>

                                    <td>{{ $Area['datecreated'] }}</td>

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

        <!-- AREA TYPE TABLE -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        <div style="position:absolute; top:13px;">
                            <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-area-t" style="text-decoration:
                                none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Area Type
                            </a>
                        </div>
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>

                                    <th>Area Type</th>
                                    <th>Created By</th>
                                    <th>Date Created</th>


                                    <th class="disableSort disableFilterBy">
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($AreaType as $AreaT)
                                <tr>


                                    <td>{{ $AreaT['typename'] }}</td>

                                    <td>{{ $AreaT['createdby'] }}</td>

                                    <td>{{ $AreaT['datecreated'] }}</td>



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
    </div>

</div>







@endsection