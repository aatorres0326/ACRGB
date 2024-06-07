@extends('layouts.app')


@section('contents')

<div id="content">
    <div class="container-fluid">
        @if (session()->get('leveid') === 'PRO')
            <div class="card shadow mb-2">
                <div class="card-body" style="padding:3px">
                    <div class="row">
                        <div class="col-md-4 mt-1 text-center text-primary">
                            <h4><strong>{{ $MBName }}</strong></h4>
                        </div>
                        <div class="col-md-4 mt-2 text-center">
                            <h6>Reference Number : {{ $TransCode }}</h6>
                        </div>
                        <div class="col-md-4 mt-2 text-center">
                            <h6>Contract Amount :<strong>&#8369;</strong>
                                &nbsp;{{ number_format((double) $ContractAmount, 2) }}
                            </h6>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <!-- CONTRACT TABLE -->
       <div class="card shadow mb-2">
    <div class="card-body">
        <div class="table-responsive-sm"
            style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
            <div style="position:absolute; top:13px; right:320px">
                @if (session()->get('leveid') == 'HCPN')
                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#add-contract">
                        <i class="fas fa-plus fa-sm text-info-40"></i> New Contract
                    </button>&nbsp;
                @endif
                <input type="text" id="searchInput">
            </div>
            <div class="card-body border rounded mt-2">
                <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%" cellspacing="0">
                    <div class="row" style="margin-bottom: 7px;">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                    <thead>
                        <tr class="exclude-row">
                            <th class="text-center disableSort">Reference Number</td>
                            <th class="text-center disableSort" id="max-width-column">HCPN</th>
                            <th class="text-center disableSort">Contract Amount</th>
                            <th class="text-center">Current Tranch</th>
                            <th class="text-center disableSort disableFilterBy">Used Tranch Budget</th>
                            <th class="text-center disableSort disableFilterBy">No. of Claims</th>
                            <th class="disableSort disableFilterBy text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
    @if(isset($Contract) && is_iterable($Contract) && count($Contract) > 0)
    @foreach($Contract as $contract)
    @if ($contract != null)
    <tr>
        <td class="d-none">{{ $contract['conid'] }}</td>
        <td>{{ $contract['transcode'] }}</td>
        @php
        $hcf = json_decode($contract['hcfid'], true);
        @endphp

        <td>{{ $hcf['hcfname'] }}</td>

        <td><strong>&#8369;</strong>
            &nbsp;{{ number_format((double) $contract['amount'], 2) }}
        </td>
        @if ($contract['traches'] == 1)
        <td class="text-center">1ST</td>
        @if ($contract['percentage'] < 0) <td class="text-center"><span class="text-danger font-weight-bold">{{
                number_format(abs((double)
                $contract['percentage']), 2) }}%</span>
            OVER OF 1ST TRANCH</td>
            @elseif ($contract['percentage'] < 45) <td class="text-center"><span
                    class="text-success font-weight-bold">{{ number_format((double)
                    $contract['percentage'], 2) }}%</span>
                USED OF 1ST TRANCH</td>
                @elseif ($contract['percentage'] < 55) <td class="text-center"><span
                        class="text-darker-warning font-weight-bold">{{ number_format((double)
                        $contract['percentage'], 2) }}%</span>
                    USED OF 1ST TRANCH</td>
                    @else

                    <td class="text-center"><span class="text-danger font-weight-bold">{{
                            number_format((double) $contract['percentage'], 2) }}%</span>
                        USED OF 1ST TRANCH</td>
                    @endif
                    @elseif ($contract['traches'] == 2)
                    <td class="text-center">2ND</td>
                    @if ($contract['percentage'] < 0) <td class="text-center"><span
                            class="text-danger font-weight-bold">{{ number_format(abs((double)
                            $contract['percentage']), 2) }}%</span>
                        OVER OF 2ND TRANCH</td>
                        @elseif ($contract['percentage'] < 60) <td class="text-center"><span
                                class="text-success font-weight-bold">{{ number_format((double)
                                $contract['percentage'], 2) }}%</span>
                            USED OF 2ND TRANCH</td>
                            @elseif ($contract['percentage'] < 70) <td class="text-center"><span
                                    class="text-darker-warning font-weight-bold">{{
                                    number_format((double) $contract['percentage'], 2) }}%</span>
                                USED OF 2ND TRANCH</td>
                                @else
                                <td class="text-center"><span class="text-danger font-weight-bold">{{
                                        number_format((double) $contract['percentage'], 2)
                                        }}%</span>
                                    USED OF 2ND TRANCH</td>
                                @endif
                                @elseif ($contract['traches'] == 3)
                                <td class="text-center">3RD</td>
                                @if ($contract['percentage'] < 0) <td class="text-center"><span
                                        class="text-danger font-weight-bold">{{
                                        number_format(abs((double) $contract['percentage']), 2)
                                        }}%</span>
                                    OVER OF 3RD TRANCH</td>
                                    @elseif ($contract['percentage'] < 80) <td class="text-center">
                                        <span class="text-success font-weight-bold">{{
                                            number_format((double) $contract['percentage'], 2)
                                            }}%</span>
                                        USED OF 3RD TRANCH</td>
                                        @elseif ($contract['percentage'] < 90) <td class="text-center"><span
                                                class="text-darker-warning font-weight-bold">{{
                                                number_format((double) $contract['percentage'], 2)
                                                }}%</span>
                                            USED OF 3RD TRANCH</td>
                                            @else
                                            <td class="text-center"><span class="text-danger font-weight-bold">{{
                                                    number_format(
                                                    (double) $contract['percentage'],
                                                    2
                                                    ) }}%</span>
                                                USED OF 3RD TRANCH</td>
                                            @endif
                                            @else
                                            <td class="text-center">N/A</td>
                                            <td class="text-center">N/A</td>
                                            @endif
                                            <td class="text-center">{{$contract['totalclaims']}}
                                            </td>
                                            <td class="text-center">
                                                <button class="btn-outline-primary btn-sm"
                                                    id="{{$contract['transcode']}}"
                                                    onclick="toggleDetails('{{$contract['transcode']}}')">View</button>
                                            </td>
    </tr>
    <tr id="{{$contract['transcode']}}-details" class="d-none exclude-row">
        <td colspan="8">
            <div class="card card-body border border-secondary">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-2">
                        <span class="text-secondary font-weight-bold">ESTIMATED
                            AMOUNT</span></br>
                        <span><strong>&#8369;</strong>
                            &nbsp;{{ number_format((double) $contract['baseamount'], 2) }}</span>
                    </div>
                    <div class="col-sm-2">
                        <span class="text-secondary font-weight-bold">RELEASED
                            BY</span></br>
                        <?php
                        $createdby = json_decode($contract['createdby'], true);
                        ?>
                        @if ($createdby == null)
                        <span>NO DATA FOUND</span>
                        @else
                        <span>{{ $createdby['firstname'] . " " . $createdby['lastname'] }}</span>
                        @endif
                    </div>
                    <div class="col-sm-2">
                        <span class="text-secondary font-weight-bold">DATE
                            RELEASED</span></br>
                        <span>{{ DateTime::createFromFormat(
                            'm-d-Y',
                            $contract['datecreated']
                            )->format('M j, Y') }}</span>
                    </div>
                    <div class="col-sm-3">
                        <span class="text-secondary font-weight-bold">CONTRACT
                            COVERAGE</span></br>
                        @php
                        $condate = json_decode($contract['contractdate'], true);
                        @endphp

                        <span>{{ DateTime::createFromFormat(
                            'm-d-Y',
                            $condate['datefrom']
                            )->format('M j, Y') }}
                            to
                            {{ DateTime::createFromFormat('m-d-Y', $condate['dateto'])->format('M j,
                            Y') }}</span>
                    </div>
                    <div class="col-sm-3 text-right">
                        <button class="btn btn-sm btn-outline-info" title="View Tranches"
                            onclick="ViewTranches('<?= $contract['conid'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['amount'] ?>', '<?= $contract['transcode'] ?>', '<?= $contract['percentage'] ?>' )">Tranches</button>
                        @if (session()->get('leveid') == 'HCPN')
                        <a class="btn btn-sm btn-outline-danger" data-toggle="modal" title="Terminate Contract"
                            data-target="#editcontractstatus"
                            onclick="EditContractStatus('<?= $contract['conid'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                class="fas fa-fw fa-trash"></i></a>
                        @if ($contract['traches'] == 0)
                        <a class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#editcontract"
                            onclick="EditContract('<?= $contract['conid'] ?>','<?= $contract['amount'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit Contract"></i></a>
                        @else
                        <a class="btn btn-sm btn-outline-warning disabled" data-toggle="modal"
                            data-target="#editcontract"
                            onclick="EditContract('<?= $contract['conid'] ?>','<?= $contract['amount'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit Contract"></i></a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </td>
    </tr>
    @else
    <tr>
        <td colspan="5" class="text-center">NO DATA FOUND</td>
    </tr>
    @endif
    @endforeach
    @else
    <tr>
        <td colspan="5" class="text-center">NO DATA FOUND</td>
    </tr>
    @endif
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if (session()->get('leveid') == 'HCPN')
    <!-- ADD CONTRACT MODAL -->
    <div class="modal" id="add-contract">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header  bg-light">
                    <h6 class="modal-title">New HCPN Contract</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card shadow">
                        <div class="card-body">
                            @if ($Facilities == null)
                                <h5 class="text-center">NO ASSIGNED ACCESS</h5>
                            @else
                                <form action="{{ route('AddContract') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label for="transcode">Reference Number</label>
                                            <input type="text" name="transcode" class="form-control" placeholder="Transaction #"
                                                double>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="hcpn">Facility</label>
                                            <select name="mb" id="selectedhcf" class="form-control" required>
                                                <option value="" data-base-amount="">Select Facility</option>
                                                @foreach ($Facilities as $facility)
                                                    <option value="{{ $facility['hcfcode']}}"
                                                        data-base-amount="{{ $facility['baseamount'] }}">
                                                        {{ $facility['hcfname']}}
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
                                            <label for="amount">Set Contract Amount</label>
                                            <input type="text" name="amount" class="form-control" oninput="formatNumber(this)"
                                                placeholder="Enter amount" double required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Add</button> <button
                                            type="button" class="btn btn-sm btn-outline-danger"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF ADD CONTRACT MODAL -->

    <!-- EDIT CONTRACT MODAL -->
    <div class="modal" id="editcontract">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h6 class="modal-title">Edit Contract</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="{{ route('EditHCPNContract') }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md">
                                        <label for="e_transcode">Reference Number</label>
                                        <input type="text" name="e_transcode" class="form-control"
                                            placeholder="Transaction #" double>
                                        <input type="text" name="e_conid" class="d-none" placeholder="Transaction #" double>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">

                                        <label for="hcpn">HCPN</label>
                                        <input type="text" name="e_mbname" id="e_mbname" class="form-control" readonly>
                                        <input type="text" name="e_controlnumber" class="d-none">
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="hcpn">Contract Period</label>
                                        <select name="e_contractperiod" class="form-control" id="select2" required>
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
                                        <label for="e_amount">Set Contract Amount</label>
                                        <input type="text" name="e_amount" class="form-control" oninput="formatNumber(this)"
                                            placeholder="Enter amount" double>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Save</button> <button
                                        type="button" class="btn-sm btn btn-outline-danger"
                                        data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF EDIT CONTRACT MODAL -->

    <!-- EDIT CONTRACT STATUS MODAL -->
    <div class="modal" id="editcontractstatus">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h6 class="modal-title">TERMINATE CONTRACT</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="{{ route('EditContractStatus') }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="es_hcpn">HCPN</label>
                                        <input type="text" name="es_conid" class="form-control d-none">
                                        <input type="text" name="es_hcpn" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="contract">Reference Number</label>
                                        <input type="text" name="contract" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="contract">End Date</label>
                                        <input type="date" id="todayDate" name="endDate" class="form-control">
                                    </div>
                                </div>
                                <input name="status" value="TERMINATE" class="d-none">
                                <div class="form-row">
                                    <div class="form-group col-md" id="remarks-field">
                                        <label for="remarks">Remarks</label>
                                        <input type="text" name="remarks" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Save</button> <button
                                        type="button" class="btn btn-outline-warning btn-sm"
                                        data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF EDIT CONTRACT STATUS MODAL -->
    </div>
@endif
<!-- SCRIPT FOR EDIT CONTRACT -->
<script>
    function EditContract(conid, amount, hcpn, transcode) {
        var hcpnObject = JSON.parse(hcpn);
        var mbname = hcpnObject.hcfname;
        var controlnumber = hcpnObject.hcfcode;
        document.getElementsByName("e_conid")[0].setAttribute("value", conid);
        document.getElementsByName("e_amount")[0].setAttribute("value", amount);
        document.getElementsByName("e_controlnumber")[0].setAttribute("value", controlnumber);
        document.getElementsByName("e_mbname")[0].setAttribute("value", mbname);
        document.getElementsByName("e_transcode")[0].setAttribute("value", transcode);
    }
</script>
<script>
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    var formattedDate = yyyy + '-' + mm + '-' + dd;
    document.getElementById('todayDate').value = formattedDate;
</script>
<script>
    function EditContractStatus(conid, hcpn, contract) {
        var hcpnObject = JSON.parse(hcpn);
        var mbname = hcpnObject.hcfname;
        document.getElementsByName("es_conid")[0].setAttribute("value", conid);
        document.getElementsByName("es_hcpn")[0].setAttribute("value", mbname);
        document.getElementsByName("contract")[0].setAttribute("value", contract);
    }
</script>
<!-- SCRIPT FOR GETTING BASE AMOUNT ON ADD CONTRACT MODAL -->
<script>
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
<script>
    function formatNumber(input) {
        let value = input.value.replace(/[^0-9.]/g, '');
        let parts = value.split('.');
        let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        let decimalPart = parts[1] ? '.' + parts[1].slice(0, 2) : '';
        let formattedValue = integerPart + decimalPart;
        input.value = formattedValue;
    }
</script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const statusSelect = document.getElementById('status');
                const endDateField = document.getElementById('enddate-field');
                const remarksField = document.getElementById('remarks-field');

                statusSelect.addEventListener('change', function () {
                    if (this.value === 'END') {
                        endDateField.style.display = 'block';
                        remarksField.style.display = 'block';
                    } else {
                        endDateField.style.display = 'none';
                        remarksField.style.display = 'none';
                    }
                });
            });
        </script>

        <script>
            function ViewTranches(conid, hcfid, amount, transcode, percentage) {
                var hcfObject = JSON.parse(hcfid);
                var hcfname = hcfObject.hcfname;
                var hcfcode = hcfObject.hcfcode;
                localStorage.setItem("getConID", conid);
                localStorage.setItem("getHCFName", hcfname);
                localStorage.setItem("getHCFCode", hcfcode);
                localStorage.setItem("getAmount", amount);
                localStorage.setItem("getTransCode", transcode);
                localStorage.setItem("getPercentage", percentage);
                window.location.href =
                    "/facilityassets?conid=" +
                    conid +
                    "&hcfname=" +
                    hcfname +
                    "&amount=" +
                    amount +
                    "&transcode=" +
                    transcode +
                    "&hcfcode=" +
                    hcfcode +
                    "&percentage=" +
                    percentage;
            }
        </script>
        <script>
            function toggleDetails(transcode) {
                var detailsRow = document.getElementById(transcode + "-details");
                if (detailsRow.classList.contains("d-none")) {
                    detailsRow.classList.remove("d-none");
                } else {
                    detailsRow.classList.add("d-none");
                }
            }
        </script>
        @endsection