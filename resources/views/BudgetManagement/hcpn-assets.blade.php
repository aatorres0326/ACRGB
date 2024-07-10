@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">
        <div class="card-deck">
            <div class="card shadow mb-2 border border-secondary">
                <div class="card-header p-1 bg-light">
                    <h6 class="text-white text-center font-weight-bold">
                        <strong>{{ $SelectedHCPN }}</strong>
                    </h6>
                </div>

                <div class="card-body p-1 text-center font-weight-bold">

                    <p class="card-text">Contract Amount :&nbsp;<span
                            class="text-primary">{{ number_format((double) $SelectedAmount, 2) }}</span></p>

                </div>
            </div>

            <div class="card shadow mb-2 border border-secondary">
                <div class="card-header p-1 bg-light">
                    <h6 class="text-white text-center font-weight-bold">
                        Released Tranche
                    </h6>
                </div>
                <div class="card-body p-1 font-weight-bold text-center">
                    <strong>
                        <p class="card-text">Total Amount : &nbsp;<span id="totalreleased" class="text-primary"></span>
                        </p>
                    </strong>
                </div>
            </div>
            <div class="card shadow mb-2 border border-secondary">
                <div class="card-header p-1 bg-light">
                    <h6 class="text-white text-center font-weight-bold">
                        Utilization
                    </h6>
                </div>
                <div class="card-body p-1 text-center font-weight-bold">
                    <strong>
                        <p class="card-text">Claims Amount : &nbsp;<span
                                class="text-primary">{{ number_format((double) $SelectedClaimsAmount, 2) }}</span>
                        </p>
                        <p class="card-text">Percentage : &nbsp;<span
                                class="text-primary">{{  number_format((double) $SelectedPercent, 2)}}%</span></p>


                    </strong>
                </div>
            </div>




        </div>

        <div class="row d-flex">
            <div class="col-md-12 col-12">
                <div class="table-responsive-sm" style="height: 375px;">
                    <div class="card shadow mb-2">

                        <div class="card-body">
                            @if (session()->get('leveid') == 'PRO')
                            <div class="d-flex flex-row-reverse">


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

                                <a class="btn btn-sm btn-outline-primary disabled" data-toggle="modal"
                                    data-target="#release-tranch" style="float:right;">Release Tranche</a>
                                @else

                                <button class="btn-sm btn-outline-primary btn" data-toggle="modal"
                                    data-target="#release-tranch" style="float:right;">Release
                                    Tranche</button>
                                @endif

                                @else

                                <button class="btn-sm btn-outline-primary" data-toggle="modal"
                                    data-target="#release-tranch" style="float:right;">Release
                                    Tranche</button>
                                @endif

                            </div>
                            @endif

                            <table class="table table-sm table-hover table-bordered" id="assetsTable" width="100%"
                                cellspacing="0">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col"></div>

                                </div>
                                <thead>
                                    <tr>

                                        <th class="text-center disableSort">Reference Number</th>
                                        <th class="text-center disableSort">Tranche</th>
                                        <th class="text-center disableSort">Receipt Number</th>

                                        <th class="text-center disableSort">Released Amount</th>
                                        <th class="text-center disableSort">Date Released</th>
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

                                        <td class="text-center">{{ $conid['transcode']}}</td>
                                        <td class="text-center">{{ $tranch['tranchtype']}}</td>
                                        <td class="text-center">{{ $assets['receipt']}}</td>



                                        <td class="text-center">
                                            {{ number_format((double) $assets['amount'], 2)}}
                                        </td>
                                        <td class="text-center">
                                            {{ DateTime::createFromFormat('m-d-Y', $assets['datereleased'])->format('F j, Y') }}
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


                <!-- ADD ASSETS MODAL -->
                <div class="modal" id="release-tranch">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <span class="modal-title">Release Tranche to <span
                                        class="text-info font-weight-bold">{{ $SelectedHCPN }}</span></span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="margin-top: -15px;">
                                <form action="{{ route('INSERTASSETS') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md text-center">

                                            <input type="text" name="hcfid" class="form-control d-none"
                                                value="{{ $SelectedControlNumber }}" readonly required>
                                            <input type="text" name="conid" class="d-none" value="{{ $SelectedConID }}"
                                                required>
                                        </div>
                                    </div>
                                    <div id="prevbal" style="display:none">
                                        <div class="card">
                                            <div class="card-body">
                                                <p>PREVIOUS CONTRACT</p>
                                                <hr>
                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="e_amount">Contract Period</label>
                                                        @if ($PreviousBalance != null)
                                                        <input type="text" value="{{ $PreviousBalance['condateid'] }}"
                                                            class="form-control" double readonly>

                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="e_amount">Previous Balance</label>
                                                        <input type="text" name="previous_balance"
                                                            value="{{ $PreviousBalance['conbalance'] }}"
                                                            id="previous-bal" class="form-control" double readonly>

                                                    </div>
                                                    @else
                                                    <input type="text" value="N/A" class="form-control" double readonly>

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="e_amount">Previous Balance</label>
                                                    <input type="text" name="previous_balance" value="0"
                                                        id="previous-bal" class="form-control" double readonly>

                                                </div>
                                                @endif
                                            </div>



                                        </div>
                                    </div>
                                    <br>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p>TRANCHE RELEASE</p>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label for="e_amount">Contract Amount</label>
                                            <input type="text"
                                                value="&#8369; &nbsp;{{ number_format((double) $SelectedAmount, 2) }}"
                                                class="form-control" double readonly>
                                            <input type="text" name="contract_amount" id="contract"
                                                value="{{ $SelectedAmount }}" class="form-control d-none" double
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label for="tranch">Tranche</label>
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

                                                <option value="{{ $tranch['tranchid'] }}"
                                                    data-percent="{{ $tranch['percentage'] }}">
                                                    {{ $tranch['tranchtype'] }} TRANCHE
                                                </option>
                                                @endif

                                                @endif

                                                @endforeach
                                                @else

                                                @foreach ($Tranch as $tranch)
                                                <option value="{{ $tranch['tranchid'] }}"
                                                    data-percent="{{ $tranch['percentage'] }}">
                                                    {{ $tranch['tranchtype'] }}
                                                </option>
                                                @endforeach
                                                @endif






                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="e_amount">&nbsp;&nbsp;%</label>
                                            <input type="num" id="percent" class="form-control" name="percent" value=""
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="e_amount">Tranche Amount</label>
                                            <input type="text" name="tranch_amount" id="tranch_amount" value=""
                                                class="form-control" oninput="formatNumber(this)" double required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label for="e_amount">Released Amount</label>

                                            <input type="text" name="released_amount" id="released_amount" value=""
                                                class="form-control" double readonly>
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
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn-sm btn-outline-primary">Save</button> <button
                                    type="button" class="btn-sm btn-outline-danger" data-dismiss="modal">Cancel</button>
                            </div>
                            </form>
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
                    var previousBal = parseFloat(document.getElementById('previous-bal').value);
                    computedAmount = (selectContract * percent) / 100;
                    releasedAmount = computedAmount - previousBal;
                    document.getElementById('tranch_amount').value = computedAmount.toFixed(2);
                    if (selectedOption.value == "46") {
                        document.getElementById('released_amount').value = releasedAmount.toFixed(2);
                    } else {
                        document.getElementById('released_amount').value = computedAmount.toFixed(2);
                    }

                } else {

                    document.getElementById('tranch_amount').value = computedAmount;
                }


                document.getElementById('percent').value = percent;
            }
            </script>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var totalReleasedAmount = 0;
                var releasedAmounts = document.querySelectorAll("#assetsTable tbody tr td:nth-child(4)");
                releasedAmounts.forEach(function(element) {
                    totalReleasedAmount += parseFloat(element.textContent.replace(/[^0-9.-]+/g, ""));
                });
                document.getElementById("totalreleased").textContent = numberWithCommas(totalReleasedAmount
                    .toFixed(2));
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
            <script>
            document.getElementById('tranch').addEventListener('change', function() {
                var selectedValue = this.value;
                if (selectedValue === '46') {
                    document.getElementById('prevbal').style.display = 'block';

                } else {
                    document.getElementById('prevbal').style.display = 'none';

                }
            });
            </script>

            @endsection