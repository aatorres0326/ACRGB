@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">
        <center>
            <strong>
                <h4 class="text-primary">
@php
$hcfname = json_decode($SelectedHCFID, true);
@endphp
                    <strong>{{ $hcfname['hcfname'] }}</strong>
                   
                </h4>
                <br>
            </strong>
        </center>
   <div class="row text-center align-items-end">

    <div class="col-md-10">
        <div class="row">
            <div class="col-md-4 mb-2">
                <strong><p class="card-text">CONTRACT AMOUNT : &nbsp;<span id="contractamount" class="text-primary">{{ number_format((double) $SelectedAmount, 2) }}</span></p></strong>
            </div>
            <div class="col-md-4 mb-2">
                <strong><p class="card-text">RELEASED AMOUNT : &nbsp;<span id="totalreleased" class="text-success"></span></p></strong>   
            </div>
            <div class="col-md-4 mb-2">
                <strong> <p class="card-text">REMAINING AMOUNT : &nbsp;<span id="remainingamount" class="text-warning"></span></p></strong>
            </div>
        </div>
    </div>
        <div class="col-md-2 mb-2">
        <div class="mt-auto">
                     @if ($Assets != null)
           @php
    $releaseTranch = false;
    foreach ($Assets as $assets) {
        $conid = json_decode($assets['conid'], true);
        $tranch = json_decode($assets['tranchid'], true);
        if (str_contains($tranch['tranchtype'], '3RD')) {
            $releaseTranch = true;
            break;
        }
    }
@endphp

@if ($releaseTranch)
    <a class="btn btn-sm btn-outline-primary disabled" data-toggle="modal" data-target="#release-tranch" style="float:right;">Release Tranch</a>
@else
    <button class="btn-sm btn-outline-primary" data-toggle="modal" data-target="#release-tranch" style="float:right;">Release Tranch</button>
@endif
@else
    <button class="btn-sm btn-outline-primary" data-toggle="modal" data-target="#release-tranch" style="float:right;">Release Tranch</button>
@endif
        </div>
    </div>
</div>
        <div class="row d-flex">
            <div class="col-md-12 col-12">
                <div class="table-responsive-sm">                  
                    <table class="table table-sm table-hover table-bordered table-light" id="assetsTable" width="100%"
                        cellspacing="0">
                        <div class="row" style="margin-bottom: 5px;">
                            <div class="col"></div>
                        </div>
                        <thead>
                            <tr>
                                <th class="d-none">Asset ID</th>
                                <th class="text-center">Tranch</th>
                                <th class="text-center">Receipt Number</th>
                                <th class="text-center">Contract Number</th>
                                <th class="text-center">Released Amount</th>
                                <th class="text-center">Date Released</th>
                            </tr>
                        </thead>
                        <tbody>


        @if ($Assets && count($Assets) > 0)
        @foreach ($Assets as $assets)
        @php
        $conid = json_decode($assets['conid'], true);
        $tranch = json_decode($assets['tranchid'], true);
        @endphp

                            <tr>
                                <td class="d-none">{{ $assets['assetid']}}</td>
                                <td class="text-center">{{ $tranch['tranchtype']}}</td>
                                <td class="text-center">{{ $assets['receipt']}}</td>
                                <td class="text-center">{{ $conid['transcode']}}</td>
                                <td class="text-center">{{ number_format((double) $assets['amount'], 2)}}</td>
                                <td class="text-center">{{ DateTime::createFromFormat('m-d-Y', $assets['datereleased'])->format('F j, Y') }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">No data found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ADD ASSETS MODAL -->
        <div class="modal" id="release-tranch">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">

                    <div class="modal-header bg-gradient-light">
                        <h6 class="modal-title">Release Tranch</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('INSERTASSETS') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md">

                                    @php
$hcfname = json_decode($SelectedHCFID, true);
                                    @endphp
                                    <input type="text" name="hcfid" class="form-control d-none"
                                        value="{{ $hcfname['hcfcode'] }}" readonly>
                                    <input type="text" name="conid" class="d-none"
                                        value="{{ $SelectedConID }}">
                                    <input type="text" name="datefrom" value="{{ $SelectedDateFrom }}"
                                        class="form-control d-none" readonly>
                                    <input type="text" name="dateto" value="{{ $SelectedDateTo}}"
                                        class="form-control d-none" readonly>
                                    <h4>{{ $hcfname['hcfname'] }}</h4>


                                    <input type="text" name="selectedhcfid" class="d-none"
                                        value="{{ $SelectedHCFID }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="datefrom">Date Covered</label>
                                    <input type="text" name="datecovered"
                                        value="{{ $SelectedDateFrom }} to {{ $SelectedDateTo }}" class="form-control"
                                        readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="e_amount">Contract Amount</label>
                                   <input type="text" value="&#8369; &nbsp;{{ number_format((double) $SelectedAmount, 2) }}" class="form-control" double readonly>
                                    <input type="text" name="contract_amount" id="contract" value="{{ $SelectedAmount }}" class="form-control d-none" double readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="tranch">Tranch</label>
                                    <select name="tranch" id="tranch" class="form-control"
                                        onchange="updatePercentage()" required>
                                        <option>Select Tranche</option>
                                       @if ($Assets != null)
                                                                          @php
    $hasFirstTranch = false;
    $hasSecondTranch = false;
    $hasThirdTranch = false;
    foreach ($Assets as $asset) {
        $tranch = json_decode($asset['tranchid'], true);
        if (str_contains($tranch['tranchtype'], '1ST')) {
            $hasFirstTranch = true;
        }
        if (str_contains($tranch['tranchtype'], '2ND')) {
            $hasSecondTranch = true;
        }
        if (str_contains($tranch['tranchtype'], '3RD')) {
            $hasThirdTranch = true;
        }
    }
@endphp

@php
    $displayedTranchTypes = [];
@endphp

@foreach ($Tranch as $tranch)
    @if (!($hasFirstTranch && str_contains($tranch['tranchtype'], '1ST')))
        @if (!($hasSecondTranch && str_contains($tranch['tranchtype'], '2ND')))
            <option value="{{ $tranch['tranchid'] }}" data-percent="{{ $tranch['percentage'] }}">{{ $tranch['tranchtype'] }} TRANCHE</option>
        @endif
    @endif
@endforeach
@else
@foreach ($Tranch as $tranch)
<option value="{{ $tranch['tranchid'] }}" data-percent="{{ $tranch['percentage'] }}">{{ $tranch['tranchtype'] }} TRANCHE</option>
@endforeach
@endif

                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="e_amount">%</label>
                                    <input type="num" id="percent" class="form-control" name="percent"
                                        value="" readonly>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="e_amount">Tranch Amount</label>
                                    <input type="text" name="tranch_amount" id="tranch_amount" value=""
                                        class="form-control" oninput="formatNumber(this)" double readonly required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="e_amount">Receipt Number</label>
                                    <input type="text" name="receipt" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="datereleased">Released Date</label>
                                    <input type="date" name="datereleased" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn-sm btn-outline-primary">Save</button> <button type="button"
                                    class="btn-sm btn-outline-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
function updatePercentage() {
    var selectElement = document.getElementById('tranch');
    var selectedIndex = selectElement.selectedIndex;
    var selectedOption = selectElement.options[selectedIndex];
    
    var percent = "";
    var computedAmount = "";

    if (selectedOption.textContent !== "Select Tranche") {
        percent = parseFloat(selectedOption.getAttribute('data-percent'));
        var selectContract = parseFloat(document.getElementById('contract').value);
        computedAmount = (selectContract * percent) / 100;
        document.getElementById('tranch_amount').value = computedAmount.toFixed(2);
    } else {

document.getElementById('tranch_amount').value = computedAmount;
    }

    
    document.getElementById('percent').value = percent;
}

    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var totalReleasedAmount = 0;
        var releasedAmounts = document.querySelectorAll("#assetsTable tbody tr td:nth-child(5)");
        releasedAmounts.forEach(function(element) {
            totalReleasedAmount += parseFloat(element.textContent.replace(/[^0-9.-]+/g, ""));
        });
        document.getElementById("totalreleased").textContent = numberWithCommas(totalReleasedAmount.toFixed(2));

        var contractAmount = parseFloat(document.getElementById("contractamount").textContent.replace(/[^0-9.-]+/g, ""));
        var remainingAmount = contractAmount - totalReleasedAmount;
        document.getElementById("remainingamount").textContent = numberWithCommas(remainingAmount.toFixed(2));
    });

    function numberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        sortTableByDateReleased();
    });

    function sortTableByDateReleased() {
        var table = document.getElementById('assetsTable');
        var tbody = table.querySelector('tbody');
        var rows = Array.from(tbody.querySelectorAll('tr'));

        rows.sort(function(rowA, rowB) {
            var dateA = new Date(rowA.cells[5].textContent);
            var dateB = new Date(rowB.cells[5].textContent);
            return dateA - dateB;
        });

        rows.forEach(function(row) {
            tbody.appendChild(row);
        });
    }
</script>

@endsection
