@extends('layouts.app')

@section('contents')
<div id="content">
    <div class="container-fluid">



        @php
        $last = end($PROContract);
        $selected = json_decode($last['hcfid'], true);
        @endphp
        <div class="card-deck font-weight-bold">

            <div class="card shadow mb-2 border">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary text-center">{{$selected['proname']}}</h6>
                </div>
                <div class="card-body text-center">

                    <p><span class="">1ST QUARTER :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $last['amount'], 2) }}</span></p>
                </div>
            </div>


            <div class="card shadow mb-2 border" style="min-height: 110px;">
                <div class="card-header text-center">
                    <h6 class="font-weight-bold text-primary">RELEASED TRANCHES</h6>
                </div>
                <div class="card-body text-center">

                    <p><span>AMOUNT
                            :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $last['totaltrancheamount'], 2) }}</span></p>
                    <p> <span>PERCENTAGE
                            :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $last['percentage'], 2) }}%</span></p>
                </div>
            </div>


            <div class="card shadow mb-2 border" style="min-height: 110px;">
                <div class="card-header text-center">
                    <h6 class="font-weight-bold text-primary">UTILIZATION</h6>
                </div>
                <div class="card-body text-center">

                    <p><span>AMOUNT :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $last['totalclaimsamount'], 2) }}</span></p>
                    <p><span>PERCENTAGE :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $last['totalclaimspercentage'], 2) }}%</span>
                    </p>
                </div>
            </div>


        </div>

        <div class="card shadow mb-4">
            <div class="card-body">

                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                    <div style="position:absolute; top:13px; right:320px">
                        @if (session()->get('leveid') == 'PRO')
                        <a class="btn btn-outline-primary btn-sm" title="Add New Contract"
                            href="/Contracts/NewContract">
                            <i class="fas fa-plus fa-sm text-info-40"></i> New HCPN Contract
                        </a>&nbsp;
                        @endif
                        <input type="text" id="searchInput">
                    </div>

                    <div class="card-body border rounded mt-2">
                        <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                            cellspacing="0">
                            <caption>List of HCPN Contracts</caption>
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr class="exclude-row">
                                    <th class="text-center align-middle disableSort">Reference Number</th>
                                    <th class="text-center align-middle disableSort" id="max-width-column">HCPN</th>
                                    <th class="text-center align-middle disableSort">Contract Amount</th>
                                    <th class="text-center align-middle disableSort">Supplementary Budget</th>
                                    <th class="text-center align-middle disableSort">Current Tranche</th>
                                    <th class="text-center align-middle disableSort disableFilterBy">Utilization</th>
                                    <th class="text-center align-middle disableSort disableFilterBy">Claims
                                    </th>
                                    <th class="text-center align-middle disableSort disableFilterBy">Commited Claims
                                        Volume</th>
                                    <th class="disableSort align-middle disableFilterBy text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(isset($Contract) && is_iterable($Contract) && count($Contract) > 0)
                                @foreach($Contract as $contract)
                                @if ($contract != null)
                                <tr>
                                    <td class="d-none">{{ $contract['conid'] }}</td>
                                    <td class="text-center" id="transcode">{{ $contract['transcode'] }}</td>
                                    @php
                                    $mb = json_decode($contract['hcfid'], true);
                                    @endphp
                                    <td>{{ $mb['mbname'] }}</td>
                                    <td class="text-right">
                                        &nbsp;{{ number_format((double) $contract['amount'], 2) }}</td>
                                    <td class="text-right">

                                        &nbsp;{{ number_format((double) $contract['sb'], 2) }}
                                    </td>
                                    @if ($contract['traches'] == 1)
                                    <td class="text-center">1ST</td>
                                    @if ($contract['percentage'] < 0) <td class="text-center">
                                        <span
                                            class="text-danger font-weight-bold">{{ number_format(abs((double) $contract['totalclaimspercentage']), 2)}}%</span>
                                        OVER
                                        </td>
                                        @elseif ($contract['totalclaimspercentage'] < 45) <td class="text-center">
                                            <span
                                                class="text-success font-weight-bold">{{ number_format((double) $contract['totalclaimspercentage'], 2)}}%</span>
                                            USED
                                            </td>
                                            @elseif ($contract['totalclaimspercentage'] < 55) <td class="text-center">
                                                <span class="text-darker-warning font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                USED
                                                </td>
                                                @else
                                                <td class="text-center">
                                                    <span
                                                        class="text-danger font-weight-bold">{{ number_format((double) $contract['totalclaimspercentage'], 2)}}%</span>
                                                    USED
                                                </td>
                                                @endif
                                                @elseif ($contract['traches'] == 2)
                                                <td class="text-center">2ND</td>
                                                @if ($contract['totalclaimspercentage'] < 0) <td class="text-center">
                                                    <span class="text-danger font-weight-bold">{{ number_format(abs((double) 
                        $contract['totalclaimspercentage']), 2) }}%</span>
                                                    OVER
                                                    </td>
                                                    @elseif ($contract['totalclaimspercentage'] < 60) <td
                                                        class="text-center">
                                                        <span class="text-success font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                        USED
                                                        </td>
                                                        @elseif ($contract['totalclaimspercentage'] < 70) <td
                                                            class="text-center">
                                                            <span class="text-darker-warning font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                            USED
                                                            </td>
                                                            @else
                                                            <td class="text-center">
                                                                <span class="text-danger font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                                USED
                                                            </td>
                                                            @endif
                                                            @elseif ($contract['traches'] == 3)
                                                            <td class="text-center">3RD</td>
                                                            @if ($contract['totalclaimspercentage'] < 0) <td
                                                                class="text-center">
                                                                <span class="text-danger font-weight-bold">{{ number_format(abs((double) 
                        $contract['totalclaimspercentage']), 2) }}%</span>
                                                                OVER
                                                                </td>
                                                                @elseif ($contract['totalclaimspercentage'] < 80) <td
                                                                    class="text-center">
                                                                    <span class="text-success font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                                    USED
                                                                    </td>
                                                                    @elseif ($contract['totalclaimspercentage'] < 90)
                                                                        <td class="text-center">
                                                                        <span
                                                                            class="text-darker-warning font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                                        USED
                                                                        </td>
                                                                        @else
                                                                        <td class="text-center">
                                                                            <span class="text-danger font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                                            USED
                                                                        </td>
                                                                        @endif
                                                                        @else
                                                                        <td class="text-center">N/A</td>
                                                                        <td class="text-center">N/A</td>
                                                                        @endif

                                                                        <td class="text-center">
                                                                            {{ $contract['totalclaims'] }}</td>
                                                                        <td class="text-center">
                                                                            {{ $contract['comittedClaimsVol'] }}</td>
                                                                        <td class="text-center">
                                                                            <button
                                                                                class="btn btn-outline-primary btn-sm"
                                                                                id="{{ $contract['transcode'] }}"
                                                                                onclick="toggleDetails('{{ $contract['transcode'] }}')">View</button>
                                                                        </td>
                                </tr>
                                <tr id="{{ $contract['transcode'] }}-details" class="d-none exclude-row">
                                    <td colspan="10">
                                        <div class="card card-body border border-secondary">
                                            <div class="row d-flex align-items-center">

                                                <div class="col-sm-3">
                                                    <span class="text-secondary font-weight-bold">RELEASED BY</span><br>
                                                    @php
                                                    $createdby = json_decode($contract['createdby'], true);
                                                    @endphp
                                                    @if ($createdby == null)
                                                    <span>NO DATA FOUND</span>
                                                    @else
                                                    <span>{{ $createdby['firstname'] . " " . $createdby['lastname'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="text-secondary font-weight-bold">DATE
                                                        CREATED</span><br>
                                                    <span>{{ DateTime::createFromFormat('m-d-Y', $contract['datecreated'])->format('M j, Y')}}</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="text-secondary font-weight-bold">CONTRACT
                                                        PERIOD</span><br>
                                                    @php
                                                    $condate = json_decode($contract['contractdate'], true);
                                                    @endphp
                                                    <span>{{ DateTime::createFromFormat('m-d-Y', $condate['datefrom'])->format('M j, Y') }}
                                                        to
                                                        {{ DateTime::createFromFormat('m-d-Y', $condate['dateto'])->format('M j, Y') }}</span>
                                                </div>
                                                <div class="col-sm-3 text-right">
                                                    <button class="btn btn-sm btn-outline-info" title="View Tranches"
                                                        onclick="ViewTranches('<?= $contract['conid'] ?>','<?= htmlspecialchars(json_encode($mb), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['amount'] ?>', '<?= $contract['transcode'] ?>', '<?= $contract['totalclaimspercentage'] ?>', '<?= $contract['totalclaimsamount'] ?>' )">Tranches</button>
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        title="View Facility Contracts"
                                                        onclick="GetContractDetails('<?= htmlspecialchars(json_encode($mb), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['amount'] ?>', '<?= $contract['transcode'] ?>' )">Facilities</button>
                                                    @if (session()->get('leveid') == 'PRO')
                                                    <a class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                        title="Terminate Contract" data-target="#editcontractstatus"
                                                        onclick="EditContractStatus('<?= $contract['conid'] ?>','<?= htmlspecialchars(json_encode($mb), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                                            class="fas fa-fw fa-trash"></i></a>
                                                    @if ($contract['traches'] == 0)
                                                    <a class="btn btn-sm btn-outline-warning" data-toggle="modal"
                                                        data-target="#editcontract"
                                                        onclick="EditContract('<?= $contract['conid'] ?>','<?= $contract['amount'] ?>','<?= htmlspecialchars(json_encode($mb), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                                            class="fas fa-fw fa-edit" data-toggle="tooltip"
                                                            title="Edit Contract"></i></a>
                                                    @else
                                                    <a class="btn btn-sm btn-outline-warning disabled"
                                                        data-toggle="modal" data-target="#editcontract"
                                                        onclick="EditContract('<?= $contract['conid'] ?>','<?= $contract['amount'] ?>','<?= htmlspecialchars(json_encode($mb), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                                            class="fas fa-fw fa-edit" data-toggle="tooltip"
                                                            title="Edit Contract"></i></a>
                                                    @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @else
                                <tr>
                                    <td>NO DATA FOUND</td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td>NO DATA FOUND</td>
                                </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->get('leveid') == 'PRO')
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
                            <form action="{{ route('EditHCPNContract') }}" method=" POST">
                                @method('PUT')
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md">
                                        <label for="e_transcode">Reference Number</label>
                                        <input type="text" name="e_transcode" class="form-control"
                                            placeholder="Transaction #" double>
                                        <input type="text" name="e_conid" class="d-none" placeholder="Transaction #"
                                            double>
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
                                <div class=" form-row">
                                    <div class="form-group col-md">
                                        <label for="e_amount">Set Contract Amount</label>
                                        <input type="text" name="e_amount" class="form-control"
                                            oninput="formatNumber(this)" placeholder="Enter amount" double>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                                    <button type="button" class="btn-sm btn btn-outline-danger"
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
                            <form action="{{ route('EditContractStatus') }}" method=" POST">
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
    var mbname = hcpnObject.mbname;
    var controlnumber = hcpnObject.controlnumber;
    document.getElementsByName("e_conid")[0].setAttribute("value", conid);
    document.getElementsByName("e_amount")[0].setAttribute("value", amount);
    document.getElementsByName("e_controlnumber")[0].setAttribute("value", controlnumber);
    document.getElementsByName("e_mbname")[0].setAttribute("value", mbname);
    document.getElementsByName("e_transcode")[0].setAttribute("value", transcode);
}

var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0');
var yyyy = today.getFullYear();
var formattedDate = yyyy + '-' + mm + '-' + dd;
document.getElementById('todayDate').value = formattedDate;

function EditContractStatus(conid, hcpn, contract) {
    var hcpnObject = JSON.parse(hcpn);
    var mbname = hcpnObject.mbname;
    document.getElementsByName("es_conid")[0].setAttribute("value", conid);
    document.getElementsByName("es_hcpn")[0].setAttribute("value", mbname);
    document.getElementsByName("contract")[0].setAttribute("value", contract);
}
</script>
<!-- SCRIPT FOR GETTING BASE AMOUNT ON ADD CONTRACT MODAL -->
<script>
function formatNumber(input) {
    let value = input.value.replace(/[^0-9.]/g, '');
    let parts = value.split('.');
    let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    let decimalPart = parts[1] ? '.' + parts[1].slice(0, 2) : '';
    let formattedValue = integerPart + decimalPart;
    input.value = formattedValue;
}

function GetContractDetails(hcpn, conamount, transcode) {
    var hcpnObject = JSON.parse(hcpn);
    var mbname = hcpnObject.mbname;
    var controlnumber = hcpnObject.controlnumber;
    localStorage.setItem('ConNumber', controlnumber);
    localStorage.setItem('MBName', mbname);
    localStorage.setItem('ConAmount', conamount);
    localStorage.setItem('TransCode', transcode);
    window.location.href = "/facilitycontracts?controlnumber=" + controlnumber + "&mbname=" + mbname + "&conamount=" +
        conamount + "&transcode=" + transcode;
}

function ViewTranches(conid, hcpn, amount, transcode, percentage, claimsamount) {
    var hcpnObject = JSON.parse(hcpn);
    var mbname = hcpnObject.mbname;
    var controlnumber = hcpnObject.controlnumber;

    window.location.href = "/hcpnassets?conid=" + conid + "&hcpn=" + mbname + "&amount=" + amount + "&transcode=" +
        transcode + "&controlnumber=" + controlnumber + "&percentage=" + percentage + "&claimsamount=" + claimsamount;
}
</script>


@endsection