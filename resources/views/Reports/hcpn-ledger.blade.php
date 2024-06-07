@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">

        <div class="card shadow mb-2" style="height:60px">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
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
                                                <span>CONTRACT NUMBER : </span>&nbsp;<strong
                                                    class="text-primary">{{$con['transcode'] }}</strong>
                                            </div>
                                            <div class="col-md-4 mb-2">

                                                <p class="card-text">CONTRACT AMOUNT: &nbsp;<strong><span class="text-primary">&#8369;
                                                            {{ number_format((double) $con['amount'], 2)}}</span></strong></p>

                                        @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-2">
            <div class="card-body">
                <div class="row d-flex">
                    <div class="col-md-12 col-12">
                        <div class="table-responsive-sm">
                            <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                                cellspacing="0">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col"></div>
                                </div>
                                <thead>
                                    <tr>

                                        <th class="text-center">Transaction Date</th>
                                        <th class="text-center disableSort">Particulars</th>
                                        <th class="text-center disableSort">Total Claims</th>
                                        <th class="text-center disableSort">Receipt Number</th>
                                        <th class="text-center disableSort">Account</th>
                                        <th class="text-center disableSort">Credit</th>
                                        <th class="text-center disableSort">Debit</th>
                                        <th class="text-center disableSort"> Running Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($HCPNledger && count($HCPNledger) > 0)

                                        @foreach ($HCPNledger as $ledger)
                                            <tr>
                                                <td class="text-center">{{ $ledger['datetime']}}</td>
                                                <td class="text-center">{{ $ledger['particular'] }}</td>
                                                @if ($ledger['totalclaims'] == null)
                                                    <td class="text-center"><span class="text-secondary font-weight-bold"
                                                            style="font-size: 11px;">N/A</span></td>
                                                @else
                                                    <td class="text-center">{{ $ledger['totalclaims'] }}</td>
                                                @endif
                                                <td class="text-center">{{ $ledger['voucher'] }}</td>
                                                <td class="text-center">{{ $ledger['account'] }}</td>
                                                <td class="text-center text-success font-weight-bold">&#8369;
                                                    {{ number_format((double) $ledger['credit'], 2)}}
                                                </td>
                                                <td class="text-center text-danger font-weight-bold">&#8369;
                                                    {{ number_format((double) $ledger['debit'], 2)}}
                                                </td>
                                                <td class="text-center text-primary font-weight-bold">&#8369;
                                                    {{ number_format((double) $ledger['balance'], 2)}}
                                                </td>
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
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var totalReleasedAmount = 0;
                var releasedAmounts = document.querySelectorAll("#assetsTable tbody tr td:nth-child(5)");
                releasedAmounts.forEach(function (element) {
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

            document.addEventListener('DOMContentLoaded', function () {

                sortTableByDateReleased();
            });

            function sortTableByDateReleased() {
                var table = document.getElementById('assetsTable');
                var tbody = table.querySelector('tbody');
                var rows = Array.from(tbody.querySelectorAll('tr'));

                rows.sort(function (rowA, rowB) {
                    var dateA = new Date(rowA.cells[5].textContent);
                    var dateB = new Date(rowB.cells[5].textContent);
                    return dateA - dateB;
                });

                rows.forEach(function (row) {
                    tbody.appendChild(row);
                });
            }

            window.setTimeout(function () {
                window.location.reload();

            }, 10000);

        </script>

        @endsection