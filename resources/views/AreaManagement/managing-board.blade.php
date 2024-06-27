@extends('layouts.app')


@section('contents')

<div class="container-fluid">


    <!-- FOR PHIC -->
    <!-- ************************************************************************************************************************************************ -->
    @if (session()->get('leveid') == 'PHIC')


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive-sm" style="overflow-y:auto; margin-top:25px; margin-bottom: 10px;"
                id="content2">
                <div style="position:absolute; top:13px; right:320px">

                    <input type="text" id="searchInput">
                </div>
                <div class="card-body border rounded mt-2">
                    <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                        cellspacing="0">
                        <caption>List of Health Care Provider Networks</caption>
                        <div class="row" style="margin-bottom: 7px;">

                        </div>
                        <thead>
                            <tr>
                                <th class="text-center">Network</th>
                                <th class="text-center disableSort">Registration</th>
                                <th class="text-center disableSort">Address</th>
                                <th class="text-center disableSort">Bank Account</th>
                                <th class="text-center disableSort">Bank Name</th>
                                <th class="text-center disableSort">Regional Office</th>
                                <th class="text-center disableSort">Registration Validity</th>



                                <th class="text-center disableSort disableFilterBy">Action
                                </th>
                            </tr>
                        </thead>


                        <tbody>
                            @if ($ManagingBoard == null)
                            <tr>
                                <span>No Data Found</span>
                            </tr>
                            @else
                            @foreach($ManagingBoard as $MB)
                            <tr>

                                <td class="text-center">{{ $MB['mbname'] }}</td>
                                <td class="text-center">{{ $MB['controlnumber'] }}</td>
                                <td class="text-center">{{ $MB['address'] }}</td>
                                <td class="text-center">{{ $MB['bankaccount'] }}</td>
                                <td class="text-center">{{ $MB['bankname'] }}</td>
                                <td class="text-center">{{ $MB['pro'] }}</td>
                                <td class="text-center">
                                    {{ $MB['licensedatefrom']}}
                                    to {{$MB['licensedateto']}}
                                </td>
                                <td class="text-center" style="width:50px;">
                                    <center><button class="btn-sm btn-outline-primary btn"
                                            onclick="DisplayMbDetails('<?=$MB['controlnumber']?>','<?=$MB['mbname']?>')">View</button>
                                    </center>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!-- FOR PRO USER -->
        <!-- ************************************************************************************************************************************************ -->
        @else

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                    <div style="position:absolute; top:13px; right:320px">
                        <a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#add-existing-hcpn"
                            style="text-decoration: none; "><i class="fas fa-plus fa-sm text-info-40"></i>&nbsp;Add
                            Network
                        </a>&nbsp;<a class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#add-hcpn"
                            style="text-decoration: none; "><i class="fas fa-plus fa-sm text-info-40"></i>&nbsp;New
                            Network
                        </a>&nbsp;
                        <input type="text" id="searchInput">
                    </div>
                    <div class="card-body border rounded mt-2">
                        <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                            cellspacing="0">
                            <caption>List of Health Care Provider Networks</caption>
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr class="exclude-row">
                                    <th class="text-center">Network</th>
                                    <th class="text-center disableSort">Registration</th>
                                    <th class="text-center disableSort">Address</th>
                                    <th class="text-center disableSort">Bank Account</th>
                                    <th class="text-center disableSort">Bank Name</th>
                                    <th class="text-center disableSort">Registration Validity</th>
                                    <th class="text-center disableSort">Status</th>
                                    <th class="text-center disableSort disableFilterBy">Action
                                    </th>
                                </tr>
                            </thead>


                            <tbody>
                                @if ($HCFUnderPro == null)
                                <tr><span>No Data Found</spans>
                                </tr>
                                @else
                                @foreach ($HCFUnderPro as $index => $MB)
                                <tr>

                                    <td class="text-center">{{ $MB['mbname'] }}</td>
                                    <td class="text-center">{{ $MB['controlnumber'] }}</td>
                                    <td class="text-center">{{ $MB['address'] }}</td>
                                    <td class="text-center">{{ $MB['bankaccount'] }}</td>
                                    <td class="text-center">{{ $MB['bankname'] }}</td>
                                    <td class="text-center">
                                        {{$MB['licensedatefrom']}}
                                        to
                                        {{$MB['licensedateto']}}


                                    </td>
                                    <td class="text-center">
                                        <span id="demo{{$index}}"></span>
                                    </td>
                                    <td class="text-center">
                                        <center>
                                            <button class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                                title="View Network"
                                                onclick="DisplayMbDetails('{{$MB['controlnumber']}}', '{{$MB['mbname']}}')"><i
                                                    class="fas fa-fw fa-eye" data-toggle="tooltip"></i></button>
                                            <button title="Edit Network" class="btn btn-sm btn-outline-warning"
                                                data-toggle="modal" data-target="#editNetwork"><i
                                                    class="fas fa-fw fa-edit"></i></button>
                                            <button title="Remove Access" class="btn btn-sm btn-outline-danger"
                                                data-toggle="modal" data-target="#RemoveAccess"><i
                                                    class="fas fa-fw fa-trash" data-toggle="tooltip"></i></button>
                                        </center>
                                    </td>


                                </tr>
                                <script>
                                var countDownDate {
                                    {
                                        $index
                                    }
                                } = new Date("{{$MB['licensedateto']}}").getTime();

                                var x {
                                        {
                                            $index
                                        }
                                    } = setInterval(function() {
                                            var now {
                                                {
                                                    $index
                                                }
                                            } = new Date().getTime();
                                            var distance {
                                                {
                                                    $index
                                                }
                                            } = countDownDate {
                                                {
                                                    $index
                                                }
                                            } - now {
                                                {
                                                    $index
                                                }
                                            };

                                            var days {
                                                    {
                                                        $index
                                                    }
                                                } = Math.floor(distance {
                                                        {
                                                            $index
                                                        }
                                                    }
                                                    / (1000 * 60 * 60 * 24));
                                                    var hours {
                                                        {
                                                            $index
                                                        }
                                                    } = Math.floor((distance {
                                                        {
                                                            $index
                                                        }
                                                    } % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    var minutes {
                                                        {
                                                            $index
                                                        }
                                                    } = Math.floor((distance {
                                                        {
                                                            $index
                                                        }
                                                    } % (1000 * 60 * 60)) / (1000 * 60));
                                                    var seconds {
                                                        {
                                                            $index
                                                        }
                                                    } = Math.floor((distance {
                                                        {
                                                            $index
                                                        }
                                                    } % (1000 * 60)) / 1000);

                                                    document.getElementById("demo{{$index}}").innerHTML = "ACTIVE";

                                                    if (distance {
                                                            {
                                                                $index
                                                            }
                                                        } < 0) {
                                                        clearInterval(x {
                                                            {
                                                                $index
                                                            }
                                                        });
                                                        document.getElementById("demo{{$index}}").innerHTML = "EXPIRED";
                                                    }
                                                },
                                                1000);
                                </script>
                                @endforeach

                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
        @endif

    </div>



    @if (session()->get('leveid') == 'PRO')
    <div class="modal" id="add-hcpn">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header bg-light">
                    <h6 class="modal-title">NEW HEALTHCARE PROVIDER NETWORK</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <form action="{{ route('INSERTManagingBoard') }}" method="POST" class=" p-2">
                        @csrf
                        <input type="text" class="form-control d-none" name="createdby"
                            value="{{ session()->get('userid')}}">
                        <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>HCPN</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" name="mbname" class="form-control" placeholder="Enter Network Name"
                                    required>

                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>Registration</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" name="accreditation" class="form-control"
                                    placeholder="Enter Registration #" required>

                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>Address</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" name="address" class="form-control"
                                    placeholder="Enter Network Address" required>

                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>Account</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" name="bankaccount" class="form-control"
                                    placeholder="Enter Bank Account Number" required>

                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>Bank Name</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" name="bankname" class="form-control" placeholder="Enter Bank Name"
                                    required>

                            </div>
                        </div>
                        <h6 class="mt-3 mb-3">Registration Registration</h6>
                        <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>Date From</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" class="form-control" id="formattedDate5"
                                    style="position:absolute; width:85%; z-index:1;" readonly required>
                                <input type="date" class="form-control" name="licensedatefrom"
                                    style="position:absolute; width:97%;" id="datePicker5" required
                                    onchange="setMinDateTo()">
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>Date To</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" class="form-control" id="formattedDate6"
                                    style="position:absolute; width:85%; z-index:1;" readonly required>
                                <input type="date" class="form-control" name="licensedateto"
                                    style="position:absolute; width:97%;" id="datePicker6" required>
                            </div>
                        </div>
                        <script>
                        function setMinDateTo() {

                            const dateFrom = document.getElementById('datePicker5').value;
                            const dateTo = document.getElementById('datePicker6');
                            dateTo.min = dateFrom;

                        }
                        </script>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Add</button> <button
                                type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="add-existing-hcpn">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-light">
                    <h6 class="modal-title">ADD HEALTHCARE PROVIDER NETWORK</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>



                <div class="modal-body" style="overflow-y:auto; ">


                    <form action="{{ route('INSERTROLEINDEXMB') }}" method="POST">
                        @csrf
                        <div class="card shadow mb-4">

                            <div class="card-body">

                                <div class="table-responsive-sm"
                                    style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size; 10px;">
                                    <div style="position:absolute; top:9px; right:320px">

                                        <input type="text" id="searchInput2">
                                    </div>
                                    <table class="table table-sm table-hover table-bordered table-striped table-light"
                                        id="tablemanager2" width="100%" cellspacing="0">


                                        <thead>
                                            <tr>

                                                <th>Network</th>

                                                <th class="text-center">Address</th>
                                                <th class="text-center">Registration</th>
                                                <th class="disableSort disableFilterBy text-center">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ManagingBoard as $mb)

                                            @php
                                            $existing = $RoleIndex->where('accessid', $mb['controlnumber'])->first();
                                            @endphp
                                            @if(!$existing)
                                            <tr>

                                                <td>{{ $mb['mbname'] }}</td>
                                                <td class="text-center">{{ $mb['address'] }}</td>
                                                <td class="text-center">{{ $mb['controlnumber'] }}</td>
                                                <td class="text-center">
                                                    <center><input class="form-control"
                                                            style="width: 16px; height: 16px;" type="checkbox"
                                                            id="addaccesbox" value=""
                                                            data-controlnumber="{{ $mb['controlnumber'] }}"></center>
                                                </td>
                                            </tr>
                                            @endif

                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />


                        <textarea class="d-none" name="accessid" id="accessid" required></textarea>

                    </form>
                    <div class="mt-5 text-center"><button style="margin-top:-50px;" id="openAddAccessModal"
                            class="btn btn-outline-primary btn-sm" data-toggle="modal"
                            data-target="#confirmadd">Add</button>
                        <button type="button" style="margin-top:-50px;" class="btn btn-outline-danger btn-sm"
                            data-dismiss="modal">Cancel</button>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <div class="modal" id="confirmadd">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header bg-light text-white">
                    <span class="modal-title">ADD SELECTED NETWORKS</span>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('INSERTROLEINDEXMB') }}" method="POST">

                        @csrf
                        <h5 class="text-center"></h5>

                        <div class="card text-dark"
                            style="color:black; max-height: 250px; overflow-y:auto; overflow-x:hidden;">

                            <div class="card-body">

                                @if ($ManagingBoard === null)
                                <h6> No Data Found </h6>
                                @else
                                @foreach($ManagingBoard as $mb)
                                <div id="confirmaddsubmission" style="font-size: 13px;"><span
                                        class="col-md-8">{{ $mb['mbname'] }}</span><span
                                        class="col-md-4 text-center controlnumber"
                                        style="float:right">{{ $mb['controlnumber'] }}</span></div>
                                @endforeach
                                @endif

                            </div>
                        </div>
                        <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />

                        @php

                        $user = session()->get('userid');

                        $userRoleIndex = $RoleIndex->where('userid', $user);
                        @endphp

                        @foreach($userRoleIndex as $index)
                        <input name="mbid" class="d-none" value="{{ $index['accessid'] }}">
                        @endforeach


                        <textarea id="confirmaddaccessid" class="d-none" name="accessid" required></textarea>

                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script src="{{ asset('js/managing-board.js') }}"></script>



    @endsection