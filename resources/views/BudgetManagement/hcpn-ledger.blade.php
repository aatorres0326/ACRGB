@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">
        <center>
            <strong>
                <h4 class="text-primary">

                   
                </h4>
                <br>
            </strong>
        </center>
   <div class="row text-center align-items-end">

    <div class="col-md-12">
        <!-- Adjusted the columns -->
        <div class="row">
            <div class="col-md-4 mb-2">
            @foreach ($ManagingBoard as $hcpn)
@if ($hcpn['controlnumber'] == $SelectedConNumber)
                    <strong class="text-primary">{{$hcpn['mbname'] }}</strong>
                    @endif
                    @endforeach
              
            </div>
            <div class="col-md-4 mb-2">
                          @foreach ($Contract as $con)
@if ($con['conid'] == $SelectedConID)
                    <span>CONTRACT NUMBER : </span>&nbsp;<strong class="text-success">{{$con['transcode'] }}</strong>
                   
            
            </div>
            <div class="col-md-4 mb-2">
          
                          <strong> <p class="card-text">CONTRACT AMOUNT: &nbsp;<span class="text-warning">&#8369; {{ number_format((double) $con['amount'], 2)}}</span></p></strong>
      @endif
                    @endforeach
            </div>
        </div>
   
</div>
</div>

        <div class="row d-flex">
            <div class="col-md-12 col-12">
                <div class="table-responsive-sm">
        <table class="table table-sm table-hover table-bordered" id="assetsTable" width="100%"
                        cellspacing="0">
                        <div class="row" style="margin-bottom: 5px;">
                            <div class="col"></div>
           
                        </div>
                        <thead>
                            <tr>
                                <th class="d-none">Asset ID</th>
                                <th class="text-center">Transaction Date</th>
                                <th class="text-center">Particulars</th>
                                <th class="text-center">Receipt Number</th>
                                <th class="text-center">Account</th>
                                <th class="text-center">Credit</th>
                                <th class="text-center">Debit</th>
                                <th class="text-center"> Running Balance</th>
                               
                            </tr>
                        </thead>
                        <tbody>


        @if ($HCPNledger && count($HCPNledger) > 0)
        @foreach ($HCPNledger as $ledger)
        


                            <tr>
                                
                               
                                          <td class="text-center">{{ DateTime::createFromFormat('m-d-Y', $ledger['datetime'])->format('F j, Y') }}</td>

                                
                                <td class="text-center">{{ $ledger['particular'] }}</td>

                                <td class="text-center">{{ $ledger['voucher'] }}</td>
                                <td class="text-center">{{ $ledger['account'] }}</td>

                                <td class="text-center text-success font-weight-bold">&#8369; {{ number_format((double) $ledger['credit'], 2)}}</td>
                                <td class="text-center text-danger font-weight-bold">&#8369; {{ number_format((double) $ledger['debit'], 2)}}</td>
                                <td class="text-center text-primary font-weight-bold">&#8369; {{ number_format((double) $ledger['balance'], 2)}}</td>
                      

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
