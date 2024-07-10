@extends('layouts.app')


@section('contents')


<div id="content">
    <div class="container-fluid">

        <!-- CONTRACT TABLE -->
        <div class="card shadow mb-4 border border-secondary">
            <div class="card-body">
                <div class="table-responsive-sm" style="overflow-y:auto; max-height: 420px; margin-bottom: 10px;"
                    id="content">
                    <div class="d-flex flex-row-reverse">
                        <input type="text" id="searchInput">&nbsp;
                        @if (session()->get('leveid') == 'PRO')
                        <a class="btn btn-outline-primary btn-sm" title="Add New Contract"
                            href="/Contracts/NewAPEXContract">
                            <i class="fas fa-plus fa-sm text-info-40"></i> New Contract
                        </a>
                        @endif

                    </div>
                    <div class="card-body border rounded mt-2">
                        <table class="table table-sm table-hover table-bordered display" id="tablemanager" width="100%"
                            cellspacing="0">
                            <caption>List of APEX Contracts</caption>
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <thead>
                                        <tr class="exclude-row">
                                            <th class="text-center align-middle disableSort">Reference Number</td>
                                            <th class="text-center align-middle disableSort" id="max-width-column"
                                                data-sortable="true">
                                                APEX Facility</th>

                                            <th class="text-center align-middle disableSort">Contract Amount</th>
                                            <th class="text-center align-middle disableSort">Current Tranche</th>
                                            <th class="text-center align-middle disableSort disableFilterBy">Utilization
                                            </th>
                                            <th class="text-center align-middle disableSort disableFilterBy">No. of
                                                Claims</th>

                                            <th class="disableSort align-middle disableFilterBy text-center">Action</th>

                                        </tr>
                                    </thead>
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
                                    <td id="max-width-column" data-toggle=" tooltip" title="{{ $hcf['hcfname'] }}">
                                        {{ $hcf['hcfname'] }}
                                    </td>
                                    <td class="text-right"><strong>&#8369;</strong>
                                        &nbsp;{{ number_format((double) $contract['amount'], 2) }}
                                    </td>
                                    @if ($contract['traches'] == 1)


                                    <td class="text-center">1ST</td>
                                    @if ($contract['percentage'] < 0) <td class="text-center"><span
                                            class="text-danger font-weight-bold">{{ number_format(abs((double) $contract['percentage']), 2) }}%</span>
                                        OVER OF 1ST TRANCHE</td>
                                        @elseif ($contract['percentage'] < 45) <td class="text-center"><span
                                                class="text-success font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                            USED OF 1ST TRANCHE</td>
                                            @elseif ($contract['percentage'] < 55) <td class="text-center"><span
                                                    class="text-darker-warning font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                                USED OF 1ST TRANCHE</td>
                                                @else
                                                <td class="text-center"><span
                                                        class="text-danger font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                                    USED OF 1ST TRANCHE</td>
                                                @endif
                                                @elseif ($contract['traches'] == 2)
                                                <td class="text-center">2ND</td>
                                                @if ($contract['percentage'] < 0) <td class="text-center"><span
                                                        class="text-danger font-weight-bold">{{ number_format(abs((double) $contract['percentage']), 2) }}%</span>
                                                    OVER OF 2ND TRANCHE</td>
                                                    @elseif ($contract['percentage'] < 60) <td class="text-center"><span
                                                            class="text-success font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                                        USED OF 2ND TRANCHE</td>
                                                        @elseif ($contract['percentage'] < 70) <td class="text-center">
                                                            <span
                                                                class="text-darker-warning font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                                            USED OF 2ND TRANCHE</td>
                                                            @else
                                                            <td class="text-center"><span
                                                                    class="text-danger font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                                                USED OF 2ND TRANCHE</td>
                                                            @endif
                                                            @elseif ($contract['traches'] == 3)
                                                            <td class="text-center">3RD</td>
                                                            @if ($contract['percentage'] < 0) <td class="text-center">
                                                                <span
                                                                    class="text-danger font-weight-bold">{{ number_format(abs((double) $contract['percentage']), 2) }}%</span>
                                                                OVER OF 3RD TRANCHE</td>
                                                                @elseif ($contract['percentage'] < 80) <td
                                                                    class="text-center"><span
                                                                        class="text-success font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                                                    USED OF 3RD TRANCHE</td>
                                                                    @elseif ($contract['percentage'] < 90) <td
                                                                        class="text-center"><span
                                                                            class="text-darker-warning font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                                                        USED OF 3RD TRANCHE</td>
                                                                        @else
                                                                        <td class="text-center"><span
                                                                                class="text-danger font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span>
                                                                            USED OF 3RD TRANCHE</td>
                                                                        @endif
                                                                        @else
                                                                        <td class="text-center">N/A</td>
                                                                        <td class="text-center">N/A</td>
                                                                        @endif
                                                                        <td class="text-center">
                                                                            {{$contract['totalclaims']}}</td>
                                                                        @php
                                                                        $createdby = json_decode(
                                                                        $contract['createdby'],
                                                                        true
                                                                        );
                                                                        @endphp
                                                                        <td class="text-center">
                                                                            <button
                                                                                class="btn btn-outline-primary btn-sm"
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
                                                    @if ($createdby == null)
                                                    <span>NO DATA FOUND</span>
                                                    @else
                                                    <span>{{ $createdby['firstname'] . " " . $createdby['lastname'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-2">
                                                    <span class="text-secondary font-weight-bold">DATE
                                                        RELEASED</span></br>
                                                    <span>{{ DateTime::createFromFormat('m-d-Y', $contract['datecreated'])->format('M j, Y') }}</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="text-secondary font-weight-bold">CONTRACT
                                                        COVERAGE</span></br>
                                                    @php
                                                    $condate = json_decode($contract['contractdate'], true);
                                                    @endphp
                                                    <span>{{ DateTime::createFromFormat('m-d-Y', $condate['datefrom'])->format('M j, Y') }}
                                                        to
                                                        {{ DateTime::createFromFormat('m-d-Y', $condate['dateto'])->format('M j, Y') }}</span>
                                                </div>
                                                <div class="col-sm-3 text-right">
                                                    <button class="btn btn-sm btn-outline-info" title="View Tranches"
                                                        onclick="ViewTranches('<?= $contract['conid'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES,'UTF-8') ?>','<?= $contract['amount'] ?>', '<?= $contract['transcode'] ?>','<?= $contract['totalclaimspercentage'] ?>', '<?= $contract['totalclaimsamount'] ?>' )">Tranches</button>
                                                    @if (session()->get('leveid') == 'PRO')
                                                    <a class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                        title="Terminate Contract" data-target="#editcontractstatus"
                                                        onclick="EditContractStatus('<?= $contract['conid'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>','<?= $contract['transcode'] ?>')"><i
                                                            class="fas fa-fw fa-trash"></i></a>
                                                    @if ($contract['traches'] == 0)
                                                    <a class="btn btn-sm btn-outline-warning" data-toggle="modal"
                                                        data-target="#editcontract"
                                                        onclick="EditContract('<?= $contract['conid'] ?>','<?= $contract['amount'] ?>','<?= $contract['transcode'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>')"><i
                                                            class="fas fa-fw fa-edit" data-toggle="tooltip"
                                                            title="Edit Contract"></i></a>
                                                    @else
                                                    <a class="btn btn-sm btn-outline-warning disabled"><i
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




        <!-- EDIT CONTRACT MODAL -->
        <div class="modal" id="editcontract">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">

                    <div class="modal-header bg-light">
                        <h6 class="modal-title">Edit Contract</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('EditHCPNContract') }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label for="e_transcode">Reference Number</label>
                                            <input type="text" name="e_transcode" class="form-control"
                                                placeholder="Transaction #">
                                            <input type="text" name="e_conid" class="d-none" double>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="hcpn">APEX Facility</label>
                                            <input name="hcpn" id="e_apex" class="form-control" readonly>
                                            <input name="e_controlnumber" id="e_controlnumber"
                                                class="form-control d-none">


                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="hcpn">Contract Period</label>
                                            <select name="contractperiod" class="form-control" id="select2" required>
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
                                        <button type="button" class="btn btn-sm btn-outline-danger"
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
                    <div class="modal-header  bg-light">
                        <h6 class="modal-title">TERMINATE CONTRACT</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('EditContractStatus') }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="es_hcpn">APEX Facility</label>
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

        <script>
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var formattedDate = yyyy + '-' + mm + '-' + dd;
        document.getElementById('todayDate').value = formattedDate;
        </script>
        <script src="{{ asset('js/apex-contract.js') }}"></script>

        @endsection