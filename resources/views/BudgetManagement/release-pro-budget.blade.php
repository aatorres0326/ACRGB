@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">
        <div class="card-deck">
            <div class="card shadow mb-2 border border-secondary">
                <div class="card-header p-1 bg-light">
                    <h6 class="text-white text-center font-weight-bold">
                        <strong>{{ $PROName }}</strong>
                    </h6>
                </div>

                <div class="card-body p-1 text-center font-weight-bold">
                    <p class="card-text">Total Budget :&nbsp;<span class="text-primary" id="totalbudget"></span></p>
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
                        <p class="card-text">Total Amount : &nbsp;<span class="text-primary">
                                {{ number_format((double) $ReleasedTranche, 2) }}</span>
                        <p class="card-text">Total Percentage : &nbsp;<span class="text-primary">
                                {{ number_format((double) $ReleasedPercent, 2) }}%</span>
                        </p>
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
                                class="text-primary">{{ number_format((double) $ClaimsAmount, 2) }}</span>
                        </p>
                        <p class="card-text">Percentage : &nbsp;<span
                                class="text-primary">{{  number_format((double) $ClaimsPercentage, 2)}}%</span></p>
                    </strong>
                </div>
            </div>
        </div>

        <div class="row d-flex">
            <div class="col-md-12 col-12">
                <div class="table-responsive-sm" style="height: 375px;">
                    <div class="card shadow mb-2">
                        <div class="card-body">
                            <div class="d-flex flex-row-reverse">
                                @if (session()->get('leveid') == 'PHIC')
                                    <a class="btn btn-outline-primary btn-sm" title="Add New Contract" data-toggle="modal"
                                        data-target="#release_budget">
                                        <i class="fas fa-plus fa-sm text-info-40"></i> Release Budget
                                    </a>&nbsp;
                                @endif
                            </div>
                            <table class="table table-sm table-hover table-bordered" id="assetsTable" width="100%"
                                cellspacing="0">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col"></div>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="text-center disableSort">Quarter</th>
                                        <th class="text-center disableSort">Reference Number</th>
                                        <th class="text-center disableSort">Released Amount</th>
                                        <th class="text-center disableSort">Date Released</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($PROBudget && count($PROBudget) > 0)
                                        @foreach (array_slice($PROBudget, 0, -1) as $Budget)
                                            <tr>
                                                <td class="text-center">{{ $Budget['quarter']}}</td>
                                                <td class="text-center">{{ $Budget['transcode']}}</td>
                                                <td class="text-center">
                                                    {{ number_format((double) $Budget['amount'], 2)}}
                                                </td>
                                                <td class="text-center">
                                                    {{ $Budget['datecreated'] }}
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

                <div class="modal" id="release_budget">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h6 class="modal-title">Release Budget</h6>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <form action="{{ route('AddPROBudget') }}" method="POST">
                                            @method('post')
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md">
                                                    <label for="transcode">Reference Number</label>
                                                    <input type="text" name="transcode" class="form-control"
                                                        placeholder="Reference #" double autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="hcpn">Regional Office</label>
                                                    <input class="d-none" name="pro" value="{{ $PROCode }}">
                                                    <input class="form-control" value="{{ $PROName }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="hcpn">Contract Period</label>
                                                    @if ($PROBudget != null && count($PROBudget) > 0)
                                                                                                        @php
                                                                                                            $firstBudget = $PROBudget[0];
                                                                                                            $contractdate = json_decode($firstBudget['contractdate'], true);
                                                                                                        @endphp
                                                                                                        <input class="d-none" name="contractperiod"
                                                                                                            value="{{ $contractdate['condateid'] }}">
                                                                                                        <input class="form-control"
                                                                                                            placeholder="{{ $contractdate['datefrom'] }} to {{ $contractdate['dateto'] }}"
                                                                                                            readonly>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md">
                                                    <label for="amount">Amount To Be Released</label>
                                                    <input type="text" name="amount" class="form-control"
                                                        oninput="formatNumber(this)" placeholder="Enter amount" double
                                                        required autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="quarter">Quarter</label>
                                                <select name="quarter" class="form-control"
                                                    onchange="updatePercentage()" required>
                                                    <option>Select Quarter</option>
                                                    @if ($PROBudget != null)
                                                                                                        @php
                                                                                                            $quarters = [
                                                                                                                'Q1' => '1st Quarter',
                                                                                                                'Q2' => '2nd Quarter',
                                                                                                                'Q3' =>
                                                                                                                    '3rd Quarter',
                                                                                                                'Q4' => '4th Quarter'
                                                                                                            ];
                                                                                                            $existingQuarters = [];
                                                                                                            foreach ($PROBudget as $Budget) {
                                                                                                                foreach ($quarters as $key => $value) {
                                                                                                                    if (str_contains($Budget['quarter'], $key)) {
                                                                                                                        $existingQuarters[] = $key;
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        @endphp

                                                                                                        @foreach ($quarters as $key => $value)
                                                                                                            @if (!in_array($key, $existingQuarters))
                                                                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                                                                            @endif
                                                                                                        @endforeach

                                                    @else
                                                        @foreach ($quarters as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Add</button> <button
                                                    type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var totalReleasedAmount = 0;
                        var releasedAmounts = document.querySelectorAll("#assetsTable tbody tr td:nth-child(3)");
                        releasedAmounts.forEach(function (element) {
                            totalReleasedAmount += parseFloat(element.textContent.replace(/[^0-9.-]+/g,
                                ""));
                        });
                        document.getElementById("totalbudget").textContent = numberWithCommas(totalReleasedAmount
                            .toFixed(2));
                    });

                    function numberWithCommas(number) {
                        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                </script>


                <script>
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
                </script>


                @endsection