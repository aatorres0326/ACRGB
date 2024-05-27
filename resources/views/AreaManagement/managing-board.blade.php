@extends('layouts.app')


@section('contents')

<div class="container-fluid">


    <!-- FOR PHIC -->
    <!-- ************************************************************************************************************************************************ -->
    @if (session()->get('leveid') == 'PHIC')

        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body bg-gradient-light">
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        <div style="position:absolute; top:13px; right:460px">

                            <input type="text" id="searchInput">
                        </div>
                        <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                            cellspacing="0">
                            <caption>List of Health Care Provider Networks</caption>
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Health Care Provider Networks</th>
                                    <th class="text-center disableSort">Accreditation</th>
                                    <th class="text-center disableSort">Address</th>
                                    <th class="text-center disableSort">Bank Account</th>
                                    <th class="text-center disableSort">Bank Name</th>
                                    <th class="text-center disableSort">Regional Office</th>
                                    <th class="text-center disableSort">License Validity</th>



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
                                            <td class="d-none">{{ $MB['mbid'] }}</td>
                                            <td>{{ $MB['mbname'] }}</td>
                                            <td class="text-center">{{ $MB['controlnumber'] }}</td>
                                            <td class="text-center">{{ $MB['address'] }}</td>
                                            <td class="text-center">{{ $MB['bankaccount'] }}</td>
                                            <td class="text-center">{{ $MB['bankname'] }}</td>
                                            <td class="text-center">{{ $MB['pro'] }}</td>
                                            <td class="text-center">
                                                {{ DateTime::createFromFormat('m-d-Y', $MB['licensedatefrom'])->format('F j, Y') }}
                                                to {{ DateTime::createFromFormat('m-d-Y', $MB['licensedateto'])->format('F j, Y') }}
                                            </td>
                                            <td class="text-center" style="width:50px;">
                                                <center><button class="btn-sm btn-outline-primary"
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

        </div>

        <!-- FOR PRO USER -->
        <!-- ************************************************************************************************************************************************ -->
    @else
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body bg-gradient-light">
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        <div style="position:absolute; top:13px; right:460px">
                            <a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#add-hcpn" style="text-decoration:
                                                                                        none; "><i
                                    class="fas fa-plus fa-sm text-info-40"></i>
                                Add
                                HCPN
                            </a>&nbsp;
                            <input type="text" id="searchInput">
                        </div>
                        <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                            cellspacing="0">
                            <caption>List of Health Care Provider Networks</caption>
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr class="exclude-row">
                                    <th class="disableSort">Health care Provider Networks</th>
                                    <th class="text-center disableSort">Accreditation</th>
                                    <th class="text-center disableSort">Address</th>
                                    <th class="text-center disableSort">Bank Account</th>
                                    <th class="text-center disableSort">Bank Name</th>
                                    <th class="text-center disableSort">License Validity</th>
                                    <th class="text-center disableSort">Remaining Days</th>
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
                                            <td class="d-none">{{ $MB['mbid'] }}</td>
                                            <td>{{ $MB['mbname'] }}</td>
                                            <td class="text-center">{{ $MB['controlnumber'] }}</td>
                                            <td class="text-center">{{ $MB['address'] }}</td>
                                            <td class="text-center">{{ $MB['bankaccount'] }}</td>
                                            <td class="text-center">{{ $MB['bankname'] }}</td>
                                            <td class="text-center">
                                                {{ DateTime::createFromFormat('m-d-Y', $MB['licensedatefrom'])->format('F j, Y') }}
                                                to {{ DateTime::createFromFormat('m-d-Y', $MB['licensedateto'])->format('F j, Y') }}
                                            </td>
                                            <td class="text-center">
                                                <span id="demo{{$index}}"></span>
                                            </td>
                                            <td class="text-center" style="width:50px;">
                                                <center>
                                                    <button class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                                        title="View"
                                                        onclick="DisplayMbDetails('{{$MB['controlnumber']}}', '{{$MB['mbname']}}')">View</button>
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

        </div>
    @endif

</div>

</div>
@if (session()->get('leveid') == 'PRO')
    <div class="modal" id="add-hcpn">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD HEALTHCARE PROVIDER NETWORK</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    @if ($HCFUnderPro == null)
                        <h5 class="text-center">NO ASSIGNED ACCESS</h5>

                    @else
                        <form action="{{ route('INSERTManagingBoard') }}" method="POST" class=" p-2">
                            @csrf
                            <input type="text" class="form-control d-none" name="createdby"
                                value="{{ session()->get('userid')}}">
                            <div class="form-row mb-2">
                                <div class="col col-md-3 mt-2">
                                    <label>HCPN</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" name="mbname" class="form-control" placeholder="Enter Netwrok Name"
                                        required>

                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col col-md-3 mt-2">
                                    <label>Accreditation</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" name="accreditation" class="form-control"
                                        placeholder="Enter Accreditation #" required>

                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col col-md-3 mt-2">
                                    <label>Address</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" name="address" class="form-control" placeholder="Enter Network Address"
                                        required>

                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col col-md-3 mt-2">
                                    <label>Bank Account</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" name="bankaccount" class="form-control"
                                        placeholder="Enter Account Number" required>

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
                            <h6 class="mt-3 mb-3">ACCREDITATION VALIDITY</h6>
                            <div class="form-row mb-2">
                                <div class="col col-md-3 mt-2">
                                    <label>Date From</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" class="form-control" id="formattedDate5"
                                        style="position:absolute; width:85%; z-index:1;" readonly required>
                                    <input type="date" class="form-control" name="licensedatefrom"
                                        style="position:absolute; width:97%;" id="datePicker5" required>
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


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add</button> <button type="button"
                                    class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endif
<script src="{{ asset('js/managing-board.js') }}"></script>
<script>
    var countDownDate{{$index}} = new Date("{{$MB['licensedateto']}}").getTime();

    var x{{$index}} = setInterval(function () {
        var now{{$index}} = new Date().getTime();
        var distance{{$index}} = countDownDate{{$index}} - now{{$index}};

        var days{{$index}} = Math.floor(distance{{$index}} / (1000 * 60 * 60 * 24));
        var hours{{$index}} = Math.floor((distance{{$index}} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes{{$index}} = Math.floor((distance{{$index}} % (1000 * 60 * 60)) / (1000 * 60));
        var seconds{{$index}} = Math.floor((distance{{$index}} % (1000 * 60)) / 1000);

        document.getElementById("demo{{$index}}").innerHTML = days{{$index}} + "d " + hours{{$index}} + "h " + minutes{{$index}} + "m " + seconds{{$index}} + "s ";

        if (distance{{$index}} < 0) {
            clearInterval(x{{$index}});
            document.getElementById("demo{{$index}}").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>


@endsection