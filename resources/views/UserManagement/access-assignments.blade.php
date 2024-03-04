@extends('layouts.app')


@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <label>Username</label>
            <input type="text" class="form-control" disabled value="{{ session()->get('username')}}">
        </div>
        <div class="col-md-6">
            <label>User Level</label>
            <input type="text" class="form-control" disabled value="{{ session()->get('leveid')}}">
        </div>


    </div>
    </br>


    <!-- ADDED TABLE -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <center><span class="text-success">ENABLED ACCESS PERMISSION<span></center>
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                        id="content">
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
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
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" value="">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="mt-5 text-center"><button id="btn" style="margin-top:-50px;"
                    class="btn btn-warning profile-button" type="submit">Remove Acess</button>
            </div>
        </div>



        <!-- USERS TABLE -->

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <center><span class="text-danger">DISABLED ACCESS PERMISSION<span></center>
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                        id="content">
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
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

                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" value="">
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>





                    </div>
                </div>

            </div>
            <div class="mt-5 text-center"><button id="btn" style="margin-top:-50px;"
                    class="btn btn-primary profile-button" type="submit">Add Access</button>
            </div>
        </div>

    </div>

</div>


@endsection