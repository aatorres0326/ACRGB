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
        @if (session()->get('leveid') === 'HCPN')
        <div class="card-deck font-weight-bold">
            @php
            $selected = json_decode($HCPNContract['hcfid'], true);
            @endphp
            <div class="card shadow mb-2 border border-secondary">
                <div class="card-header bg-success">
                    <h6 class="font-weight-bold text-white text-center">{{$selected['mbname']}}</h6>
                </div>
                <div class="card-body text-center">

                    <p> <span>CONTRACT AMOUNT :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $HCPNContract['amount'], 2) }}</span></p>
                    @php
                    $OwnContractDate = json_decode($HCPNContract['contractdate'], true);
                    @endphp

                    <p> <span>DATE COVERED :&nbsp;</span><span
                            class="text-primary">{{ DateTime::createFromFormat('m-d-Y', $OwnContractDate['datefrom'])->format('M j, Y') }}
                            to
                            {{ DateTime::createFromFormat('m-d-Y', $OwnContractDate['dateto'])->format('M j, Y') }}</span>
                    </p>
                </div>
            </div>


            <div class="card shadow mb-2 border border-secondary">
                <div class="card-header bg-success">
                    <h6 class="font-weight-bold text-white text-center">RELEASED TRANCHES</h6>
                </div>
                <div class="card-body text-center">

                    <p><span>AMOUNT
                            :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $HCPNContract['totaltrancheamount'], 2) }}</span>
                    </p>
                    <p><span>PERCENTAGE
                            :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $HCPNContract['percentage'], 2) }}%</span>
                    </p>
                </div>
            </div>


            <div class="card shadow mb-2 border border-secondary">
                <div class="card-header bg-success">
                    <h6 class="font-weight-bold text-white text-center">UTILIZATION</h6>
                </div>
                <div class="card-body text-center">

                    <p> <span>AMOUNT
                            :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $HCPNContract['totalclaimsamount'], 2) }}</span>
                    </p>
                    <p> <span>PERCENTAGE
                            :&nbsp;</span><span
                            class="text-primary">{{ number_format((double) $HCPNContract['totalclaimspercentage'], 2) }}%</span>
                    </p>
                </div>
            </div>


        </div>

        @endif


        <!-- CONTRACT TABLE -->
        <div class="card shadow mb-2 border border-secondary">
            <div class="card-body">
                <div class="d-flex flex-row-reverse">
                    <input type="text" id="searchInput">&nbsp;
                    @if (session()->get('leveid') == 'HCPN')
                    <button class="btn btn-outline-primary btn-sm"
                        onclick="NewContract('<?= htmlspecialchars(json_encode($OwnContractDate), ENT_QUOTES, 'UTF-8') ?>' )">
                        <i class="fas fa-plus fa-sm text-info-40"></i> New Contract
                    </button>
                    &nbsp;
                    @endif

                </div>
                <div class="table-responsive-sm" style="overflow-y:auto; max-height: 520px; margin-bottom: 10px;"
                    id="content">

                    <div class="card-body border rounded mt-2">
                        <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr class="exclude-row">
                                    <th class="text-center align-middle disableSort">Reference Number</td>
                                    <th class="text-center align-middle align-middle disableSort" id="max-width-column">
                                        Facilities</th>
                                    <th class="text-center align-middle">Level</th>
                                    <th class="text-center align-middle disableSort">Contract Amount</th>
                                    <th class="text-center align-middle disableSort">Suplementary Budget</th>
                                    <th class="text-center align-middle">Current Tranche</th>
                                    <th class="text-center align-middle disableSort disableFilterBy">Utilization</th>
                                    <th class="text-center align-middle disableSort disableFilterBy">No. of Claims</th>
                                    <th class="text-center align-middle disableSort">Committed Claims Volume</th>
                                    <th class="disableSort align-middle disableFilterBy text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($Contract) && is_iterable($Contract) && count($Contract) > 0)
                                @foreach($Contract as $contract)
                                @if ($contract != null)
                                <tr>
                                    <td class="d-none">{{ $contract['conid'] }}</td>
                                    <td class="text-center">{{ $contract['transcode'] }}</td>
                                    @php
                                    $hcf = json_decode($contract['hcfid'], true);
                                    @endphp

                                    <td class="text-center align-middle">{{ $hcf['hcfname'] }}</td>
                                    <td class="text-center align-middle">{{ $hcf['hcilevel'] }}</td>

                                    <td class="text-right">{{ number_format((double) $contract['amount'], 2) }}
                                    </td>
                                    <td class="text-right">{{ number_format((double) $contract['sb'], 2) }}
                                    </td>
                                    @if ($contract['traches'] == 1)
                                    <td class="text-center">1ST</td>
                                    @if ($contract['totalclaimspercentage'] < 0) <td class="text-center"><span
                                            class="text-danger font-weight-bold">{{
                        number_format(abs((double) 
                            $contract['totalclaimspercentage']), 2) }}%</span>
                                        OVER OF 1ST TRANCH</td>
                                        @elseif ($contract['totalclaimspercentage'] < 45) <td class="text-center"><span
                                                class="text-success font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                            USED OF 1ST TRANCH</td>
                                            @elseif ($contract['totalclaimspercentage'] < 55) <td class="text-center">
                                                <span class="text-darker-warning font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                USED OF 1ST TRANCH</td>
                                                @else

                                                <td class="text-center"><span class="text-danger font-weight-bold">{{
                        number_format((double) $contract['totalclaimspercentage'], 2) }}%</span>
                                                    USED OF 1ST TRANCH</td>
                                                @endif
                                                @elseif ($contract['traches'] == 2)
                                                <td class="text-center">2ND</td>
                                                @if ($contract['totalclaimspercentage'] < 0) <td class="text-center">
                                                    <span class="text-danger font-weight-bold">{{ number_format(abs((double) 
                        $contract['totalclaimspercentage']), 2) }}%</span>
                                                    OVER OF 2ND TRANCH</td>
                                                    @elseif ($contract['totalclaimspercentage'] < 60) <td
                                                        class="text-center"><span class="text-success font-weight-bold">{{ number_format((double) 
                        $contract['totalclaimspercentage'], 2) }}%</span>
                                                        USED OF 2ND TRANCH</td>
                                                        @elseif ($contract['totalclaimspercentage'] < 70) <td
                                                            class="text-center">
                                                            <span class="text-darker-warning font-weight-bold">{{
                        number_format((double) $contract['totalclaimspercentage'], 2) }}%</span>
                                                            USED OF 2ND TRANCH</td>
                                                            @else
                                                            <td class="text-center"><span
                                                                    class="text-danger font-weight-bold">{{
                        number_format((double) $contract['totalclaimspercentage'], 2)}}%</span>
                                                                USED OF 2ND TRANCH</td>
                                                            @endif
                                                            @elseif ($contract['traches'] == 3)
                                                            <td class="text-center">3RD</td>
                                                            @if ($contract['totalclaimspercentage'] < 0) <td
                                                                class="text-center">
                                                                <span
                                                                    class="text-danger font-weight-bold">{{number_format(abs((double) $contract['totalclaimspercentage']), 2)}}%</span>
                                                                OVER OF 3RD TRANCH</td>
                                                                @elseif ($contract['totalclaimspercentage'] < 80) <td
                                                                    class="text-center">
                                                                    <span class="text-success font-weight-bold">{{
                        number_format((double) $contract['totalclaimspercentage'], 2)}}%</span>
                                                                    USED OF 3RD TRANCH</td>
                                                                    @elseif ($contract['totalclaimspercentage'] < 90)
                                                                        <td class="text-center"><span
                                                                            class="text-darker-warning font-weight-bold">{{
                        number_format((double) $contract['totalclaimspercentage'], 2)}}%</span>
                                                                        USED OF 3RD TRANCH</td>
                                                                        @else
                                                                        <td class="text-center"><span
                                                                                class="text-danger font-weight-bold">{{
                        number_format(
                            (double) $contract['totalclaimspercentage'],
                            2
                        ) }}%</span>
                                                                            USED OF 3RD TRANCH</td>
                                                                        @endif
                                                                        @else
                                                                        <td class="text-center">N/A</td>
                                                                        <td class="text-center">N/A</td>
                                                                        @endif
                                                                        <td class="text-center">
                                                                            {{$contract['totalclaims']}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{$contract['comittedClaimsVol']}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button class="btn-outline-primary btn-sm"
                                                                                id="{{$contract['transcode']}}"
                                                                                onclick="toggleDetails('{{$contract['conid']}}')">View</button>
                                                                        </td>
                                </tr>
                                <tr id="{{$contract['conid']}}-details" class="d-none exclude-row">
                                    <td colspan="10">
                                        <div class="card card-body border border-secondary">
                                            <div class="row d-flex align-items-center">

                                                <div class="col-sm-3">
                                                    <span class="text-secondary font-weight-bold">RELEASED
                                                        BY</span></br>
                                                    <?php
            $createdby = json_decode($contract['createdby'], true); ?>
                                                    @if ($createdby == null)
                                                    <span>NO DATA FOUND</span>
                                                    @else
                                                    <span>{{ $createdby['firstname'] . " " . $createdby['lastname'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="text-secondary font-weight-bold">DATE
                                                        CREATED</span></br>
                                                    <span>{{ DateTime::createFromFormat('m-d-Y', $contract['datecreated'])->format('M j, Y') }}</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="text-secondary font-weight-bold">CONTRACT
                                                        PERIOD</span></br>
                                                    @php
                                                    $condate = json_decode($contract['contractdate'], true);
                                                    @endphp

                                                    <span>{{ DateTime::createFromFormat('m-d-Y', $condate['datefrom'])->format('M j, Y') }}to{{ DateTime::createFromFormat('m-d-Y', $condate['dateto'])->format('M j,Y') }}</span>
                                                </div>
                                                <div class="col-sm-3 text-right">
                                                    <button class="btn btn-sm btn-outline-info" title="View Tranches"
                                                        onclick="ViewTranches('<?= $contract['conid'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['amount'] ?>', '<?= $contract['transcode'] ?>', '<?= $contract['totalclaimspercentage'] ?>',  '<?= $contract['totalclaimsamount'] ?>' )">Tranches</button>
                                                    @if (session()->get('leveid') == 'HCPN')
                                                    <a class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                        title="Terminate Contract" data-target="#editcontractstatus"
                                                        onclick="EditContractStatus('<?= $contract['conid'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                                            class="fas fa-fw fa-trash"></i></a>
                                                    @if ($contract['traches'] == 0)
                                                    <a class="btn btn-sm btn-outline-warning" data-toggle="modal"
                                                        data-target="#editcontract"
                                                        onclick="EditContract('<?= $contract['conid'] ?>','<?= $contract['amount'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                                            class="fas fa-fw fa-edit" data-toggle="tooltip"
                                                            title="Edit Contract"></i></a>
                                                    @else
                                                    <a class="btn btn-sm btn-outline-warning disabled"
                                                        data-toggle="modal" data-target="#editcontract"
                                                        onclick="EditContract('<?= $contract['conid'] ?>','<?= $contract['amount'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
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
                                            <input type="text" name="e_conid" class="d-none" placeholder="Transaction #"
                                                double>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">

                                            <label for="hcpn">HCPN</label>
                                            <input type="text" name="e_mbname" id="e_mbname" class="form-control"
                                                readonly>
                                            <input type="text" name="e_controlnumber" class="d-none">
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="hcpn">Contract Period</label>
                                            <select name="e_contractperiod" class="form-control" id="select2" required>
                                                @if($ContractDate != null)
                                                <option value="">Select Contract Period</option>
                                                @foreach ($ContractDate as $condate)
                                                <option value="{{ $condate['condateid']}}">
                                                    {{ DateTime::createFromFormat('m-d-Y', $condate['datefrom'])->format('M j, Y') }}
                                                    -
                                                    {{ DateTime::createFromFormat('m-d-Y', $condate['dateto'])->format('M j, Y') }}
                                                </option>
                                                @endforeach
                                                @else
                                                <option value="">No Available Contract Period</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
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
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Save</button>
                                        <button type="button" class="btn btn-outline-warning btn-sm"
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

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    var formattedDate = yyyy + '-' + mm + '-' + dd;
    document.getElementById('todayDate').value = formattedDate;

    function EditContractStatus(conid, hcpn, contract) {
        var hcpnObject = JSON.parse(hcpn);
        var mbname = hcpnObject.hcfname;
        document.getElementsByName("es_conid")[0].setAttribute("value", conid);
        document.getElementsByName("es_hcpn")[0].setAttribute("value", mbname);
        document.getElementsByName("contract")[0].setAttribute("value", contract);
    }

    function formatNumber(input) {
        let value = input.value.replace(/[^0-9.]/g, '');
        let parts = value.split('.');
        let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        let decimalPart = parts[1] ? '.' + parts[1].slice(0, 2) : '';
        let formattedValue = integerPart + decimalPart;
        input.value = formattedValue;
    }

    document.addEventListener("DOMContentLoaded", function() {
        const statusSelect = document.getElementById('status');
        const endDateField = document.getElementById('enddate-field');
        const remarksField = document.getElementById('remarks-field');

        statusSelect.addEventListener('change', function() {
            if (this.value === 'END') {
                endDateField.style.display = 'block';
                remarksField.style.display = 'block';
            } else {
                endDateField.style.display = 'none';
                remarksField.style.display = 'none';
            }
        });
    });

    function ViewTranches(conid, hcfid, amount, transcode, percentage, claimsamount) {
        var hcfObject = JSON.parse(hcfid);
        var hcfname = hcfObject.hcfname;
        var hcfcode = hcfObject.hcfcode;

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
            percentage +
            "&claimsamount=" +
            claimsamount;
    }

    function NewContract(contractdate) {
        var condate = JSON.parse(contractdate);
        var condateid = condate.condateid;
        var datefrom = condate.datefrom;
        var dateto = condate.dateto;

        window.location.href =
            "/Contracts/NewContract?condateid=" +
            condateid +
            "&DateFrom=" +
            datefrom +
            "&DateTo=" + dateto;
    }
    </script>

    @endsection