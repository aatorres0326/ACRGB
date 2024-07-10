@extends('layouts.app')

@section('contents')
<div id="content">
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive-sm" id="content">
                    <div class="d-flex flex-row-reverse">
                        <input type="text" id="searchInput">

                    </div>

                    <table class="table table-sm table-hover table-bordered " id="tablemanager" width="100%"
                        cellspacing="0">
                        <caption>List of Pegional Office Funds</caption>
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <thead>
                            <tr class="exclude-row">

                                <th class="text-center disableSort" id="max-width-column">Regional Office</th>
                                <th class="text-center disableSort">Contract Amount</th>
                                <th class="text-center disableSort">Released Tranches</th>
                                <th class="text-center disableSort">Utilized Budget</th>
                                <th class="text-center disableSort disableFilterBy">Remaining Budget</th>
                                <th class="text-center disableSort disableFilterBy">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($RegionalOffices != null)
                            @foreach($RegionalOffices as $pro)
                            <tr>

                                <td>{{ $pro['proname'] }}</td>
                                <td><span class="text-dark">&#8369;
                                        {{ number_format((double) intval($pro['contractamount']), 2) }}
                                </td>
                                <td><span class="text-dark">&#8369;
                                        {{ number_format((double) intval($pro['totaltranhceamount']), 2) }}
                                        <span class="text-dark"> | </span><span
                                            class="text-primary">{{ number_format(abs((double) $pro['percentage']), 2) }}%</span>
                                </td>
                                <td><span class="text-dark">&#8369;
                                        {{ number_format((double) intval($pro['claimsamount']), 2) }}</span><span
                                        class="text-dark"> | </span><span
                                        class="text-primary">{{ number_format(abs((double) $pro['claimspercentage']), 2) }}%</span>
                                </td>
                                <td><span
                                        class="text-dark">&#8369;{{ number_format((double) intval($pro['unutilize']), 2) }}<span
                                            class="text-dark"> | </span><span
                                            class="text-primary">{{ number_format(abs((double) $pro['totalpercentage']), 2) }}%
                                            Utilized</span>
                                </td>
                                <td class="text-center" style="width:50px;">
                                    <center><button class="btn-sm btn-outline-primary btn p-1 font-weight-bold"
                                            style="font-size: 12px"
                                            onclick="ViewBudget('<?=$pro['procode']?>','<?=$pro['proname']?>','<?=$pro['totaltranhceamount']?>','<?=$pro['percentage']?>','<?=$pro['claimsamount']?>','<?=$pro['claimspercentage']?>','<?=$pro['unutilize']?>')">View</button>
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
function ViewBudget(procode, proname, totaltranhceamount, percentage, claimsamount, claimspercentage, unutilized) {

    window.location.href = "/GetPROBudget?procode=" + procode + "&proname=" + proname + "&totaltranhceamount=" +
        totaltranhceamount + "&percentage=" + percentage + "&claimsamount=" + claimsamount + "&claimspercentage=" +
        claimspercentage + "&unutilized=" + unutilized;
}
</script>

@endsection