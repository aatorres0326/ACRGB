@extends('layouts.app')

@section('contents')
<div id="content">
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive-sm"
                    style="overflow-y:auto; min-height: 440px; max-height: 440px; margin-top:25px; margin-bottom: 10px;"
                    id="content">

                    <div class="card-body border rounded mt-2">
                        <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                            cellspacing="0">
                            <caption>List of Pegional Office Funds</caption>
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr class="exclude-row">
                                    <th class="text-center disableSort">Reference Number</th>
                                    <th class="text-center disableSort" id="max-width-column">Regional Office</th>
                                    <th class="text-center disableSort">Released Budget</th>
                                    <th class="text-center disableSort">Utilized Budget</th>
                                    <th class="text-center disableSort disableFilterBy">Remaining Budget</th>
                                    <th class="text-center disableSort disableFilterBy">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($RegionalOffices != null)
                                @foreach($RegionalOffices as $pro)
                                <tr>
                                    <td>{{ $pro['transcode'] }}</td>
                                    <td>{{ $pro['proname'] }}</td>
                                    <td><span
                                            class="text-primary font-weight-bold">&#8369;{{ number_format((double) intval($pro['contractamount']), 2) }}
                                    </td>
                                    <td><span
                                            class="text-danger font-weight-bold">{{ number_format(abs((double) $pro['percentage']), 2) }}%</span>
                                        &nbsp; EQUIVALENT TO &nbsp; <span
                                            class="text-danger font-weight-bold">&#8369;{{ number_format((double) intval($pro['utilize']), 2) }}</span>
                                    </td>
                                    <td><span
                                            class="text-success font-weight-bold">&#8369;{{ number_format((double) intval($pro['unutilize']), 2) }}
                                    </td>
                                    <td class="text-center" style="width:50px;">
                                        <center><button class="btn-sm btn-outline-primary btn"
                                                onclick="ViewBudget('<?=$pro['procode']?>','<?=$pro['proname']?>')">View</button>
                                        </center>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>NO DATA</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
    function ViewBudget(proid, proname) {

        window.location.href = "/releaseprobudget?proid=" + proid + "&proname=" + proname;
    }
    </script>

    @endsection