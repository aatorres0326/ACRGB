@extends('layouts.app')

@section('contents')
<div id="content">
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive-sm"
                    style="overflow-y:auto; min-height: 440px; max-height: 440px; margin-top:25px; margin-bottom: 10px;"
                    id="content">
                    <div style="position:absolute; top:13px; right:320px ">
                        <a class="btn btn-sm btn-outline-primary mr-3" data-toggle="modal" data-target="#add-contract">
                            <i class="fas fa-plus fa-sm text-info-40"></i> Release Funds
                        </a>
                        <input type="text" id="searchInput">
                    </div>
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
                                    <th class="text-center disableSort">Allocated Budget</th>
                                    <th class="text-center disableSort">Utilized Budget</th>
                                    <th class="text-center disableSort disableFilterBy">Remaining Budget</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="add-contract">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h6 class="modal-title">Release Budget</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card shadow">
                            <div class="card-body">
                                <form action="{{ route('AddContract') }}" method="POST">
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
                                            <label for="hcpn">HCPN</label>
                                            <select name="mb" id="selectedhcf" class="form-control" required>
                                                <option value="" data-base-amount="">SELECT REGIONAL OFFICE</option>
                                                @foreach ($RegionalOffices as $pro)
                                                    <option value="{{ $pro['procode']}}"
                                                        data-base-amount="{{ $pro['conamount'] }}">
                                                        {{ $pro['proname']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="hcpn">Contract Period</label>
                                            <select name="contractperiod" class="form-control" id="select2" required>
                                                <option value="">Select Contract Period</option>
                                                @foreach ($ContractDate as $condate)
                                                    <option value="{{ $condate['condateid']}}">
                                                        {{ DateTime::createFromFormat('m-d-Y', $condate['datefrom'])->format('M j, Y') }}
                                                        -
                                                        {{ DateTime::createFromFormat('m-d-Y', $condate['dateto'])->format('M j, Y') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label for="baseamount">Base Amount</label>
                                            <input type="text" name="baseamount" id="baseamount" class="form-control"
                                                oninput="formatNumber(this)" placeholder="0" double required readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label for="amount">Amount To Be Released</label>
                                            <input type="text" name="amount" class="form-control"
                                                oninput="formatNumber(this)" placeholder="Enter amount" double required
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Add</button> <button type="button"
                                            class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function formatNumber(input) {
            let value = input.value.replace(/[^0-9.]/g, '');
            let parts = value.split('.');
            let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            let decimalPart = parts[1] ? '.' + parts[1].slice(0, 2) : '';
            let formattedValue = integerPart + decimalPart;
            input.value = formattedValue;
        }

        document.getElementById('selectedhcf').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            var baseAmount = selectedOption.getAttribute('data-base-amount');

            if (!baseAmount || baseAmount.trim() === '' || baseAmount.trim().toUpperCase() === 'NO DATA FOUND') {
                baseAmount = '0';
            } else {
                baseAmount = parseFloat(baseAmount).toFixed(2);
                baseAmount = baseAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
            document.getElementById('baseamount').value = baseAmount;
        });
    </script>
    @endsection