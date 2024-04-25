@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">
        <center>
            <strong>
                <h4 class="text-info">
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
        <!-- Adjusted the columns -->
        <div class="row">
            <div class="col-md-4 mb-2">
               
                  
            
                        <strong><p class="card-text text-white">CONTRACT AMOUNT : &nbsp;<span id="contractamount" class="text-info">{{ number_format((double) $SelectedAmount, 2) }}</span></p></strong>
              
            </div>
            <div class="col-md-4 mb-2">
               
                         <strong><p class="card-text text-white">RELEASED AMOUNT : &nbsp;<span id="totalreleased" class="text-success"></span></p></strong>
            
            </div>
            <div class="col-md-4 mb-2">
          
                          <strong> <p class="card-text text-white">REMAINING AMOUNT : &nbsp;<span id="remainingamount" class="text-warning"></span></p></strong>
     
            </div>
        </div>
    </div>
        <div class="col-md-2 mb-2">
        <!-- Move the button here -->
        <div class="mt-auto">
            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#release-tranch" style="float:right;">Release Tranch</a>
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
                                <div class="form-group col-md-3">
                                    <label for="tranch">Tranch</label>
                                    <select name="tranch" id="tranch" class="form-control"
                                        onchange="updatePercentage()">
                                        @foreach ($Tranch as $tranch)
                                        <option value="{{ $tranch['tranchid'] }}"
                                            data-percent="{{ $tranch['percentage'] }}">{{ $tranch['tranchtype'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="e_amount">Percentage</label>
                                    <input type="num" id="percent" class="form-control" name="percent"
                                        value="{{ $Tranch[0]['percentage'] }}" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="e_amount">Tranch Amount</label>
                                    <input type="text" name="tranch_amount" id="tranch_amount" value=""
                                        class="form-control" oninput="formatNumber(this)" double readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="e_amount">Receipt Number</label>
                                    <input type="text" name="receipt" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="datereleased">Released Date</label>
                                    <input type="date" name="datereleased" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button> <button type="button"
                                    class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
            var percent = parseFloat(selectedOption.getAttribute('data-percent'));

            var selectContract = parseFloat(document.getElementById('contract').value);
            var computedAmount = (selectContract * percent) / 100;
            document.getElementById('tranch_amount').value = computedAmount.toFixed(2);
            document.getElementById('percent').value = percent;
        }

        function formatNumber(input) {
            // Implement your own number formatting logic here if needed
        }
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate total released amount
        var totalReleasedAmount = 0;
        var releasedAmounts = document.querySelectorAll("#assetsTable tbody tr td:nth-child(5)");
        releasedAmounts.forEach(function(element) {
            totalReleasedAmount += parseFloat(element.textContent.replace(/[^0-9.-]+/g, ""));
        });
        document.getElementById("totalreleased").textContent = numberWithCommas(totalReleasedAmount.toFixed(2));

        // Calculate remaining amount
        var contractAmount = parseFloat(document.getElementById("contractamount").textContent.replace(/[^0-9.-]+/g, ""));
        var remainingAmount = contractAmount - totalReleasedAmount;
        document.getElementById("remainingamount").textContent = numberWithCommas(remainingAmount.toFixed(2));
    });

    // Function to add commas to numbers
    function numberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sort table by date released
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
