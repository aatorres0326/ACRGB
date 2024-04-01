@extends('layouts.app')


@section('contents')

<div id="content">
    <div class="container-fluid">


        <!-- CONTRACT TABLE -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                    <div style="position:absolute; top:13px; right:430px">
                        <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-contract" text-decoration:
                            none;><i class="fas fa-plus fa-sm text-info-40"></i> Add Contract
                        </a>
                    </div>
                    <table class="table table-sm table-hover table-bordered table-striped" id="tablemanager"
                        width="100%" cellspacing="0">
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <thead>
                            <tr>
                                <thead>
                            <tr>
                                <th>Transaction Number</td>
                                <th>APEX Facility</th>
                                <th class="text-center">Estimated Amount</th>
                                <th class="text-center">Released Amount</th>
                                <th class="text-center">Released Date</th>
                                <th class="text-center">Released By</th>
                                <th class="text-center">Date Covered</th>
                                
                                <th class="disableSort disableFilterBy text-center">Action</th>
                            </tr>
                        </thead>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset ($Contract) && is_iterable($Contract) && count($Contract) > 0)
                            @foreach($Contract as $contract)
                            @if ($contract != null)

                            <tr>
                                <td class="d-none">{{ $contract['conid'] }}</td>
@php
            $hcf = json_decode($contract['hcfid'], true);
@endphp
<td class="text-center">{{ $contract['transcode'] }}</td>
                                <td>{{ $hcf['hcfname'] }}</td>
<td></td>
                                
                                <td class="text-center">PHP&nbsp;{{ number_format((double) $contract['amount'], 2) }}
                                </td>
                                <td></td>
                                <td></td>
                                <td class="text-center">{{ $contract['datefrom'] }} to {{ $contract['dateto'] }}</td>
                                
                                <td class="text-center">
                                    <button class="btn btn-sm btn-link text-darker-primary" onclick="GetAPEXContractDetails('{{$contract['conid']}}', '{{$contract['hcfid']}}', '<?= $contract['dateto'] ?>',
                                                    '<?= $contract['datefrom'] ?>','<?= $contract['amount'] ?>')">
                            <i class="fas fa-fw fa-eye" data-toggle="tooltip" title="View"></i>
                        </button>
                        <a class="btn btn-sm btn-link text-danger">
                                        <i class="fas fa-fw fa-archive" data-toggle="tooltip" title="Archive"></i>
                                    </a>
                                    <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                        data-target="#editcontract" onclick="EditContract(
                                                    '<?= $contract['conid'] ?>',
                                                     '<?= $contract['amount'] ?>',
                                                    '<?= $contract['transcode'] ?>'
                                 )"><i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Change Status"></i></a>
                                  <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                        data-target="#editcontractstatus" onclick="EditContractStatus(
                                                    '<?= $contract['conid'] ?>',
                                                    '<?= $contract['hcfid'] ?>')">Change Status</a>
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

    <!-- ADD CONTRACT MODAL -->
    <div class="modal" id="add-contract">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">Add Contract</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('AddHCPNContract') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="transcode">Transaction Number</label>
                                <input type="text" name="transcode" class="form-control" placeholder="Transaction #"
                                    double>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="hcpn">APEX Faccility</label>
                                <select name="mb" class="form-control">
                                   @foreach ($Facilities as $facility)
    @if($facility['type'] == 'APEX')
        <option value="{{ $facility['hcfid'] }}">{{ $facility['hcfname'] }}</option>
    @endif
@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="datefrom">Date From</label>
                                <input type="date" name="datefrom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dateto">Date To</label>
                                <input type="date" name="dateto" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="amount">Set Contract Amount</label>
                                <input type="text" name="amount" class="form-control" oninput="formatNumber(this)"
                                    placeholder="Enter amount" double>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>

    <!-- END OF ADD CONTRACT MODAL -->

    <!-- EDIT CONTRACT MODAL -->
    <div class="modal" id="editcontract">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">Edit Contract</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('EditHCPNContract') }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="e_transcode">Transaction Number</label>
                                <input type="text" name="e_transcode" class="form-control" placeholder="Transaction #" readonly
                                    double>
                                <input type="text" name="e_conid"  placeholder="Transaction #" double>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="hcpn">APEX Facility</label>
                                <input name="hcpn" id="e_apex" class="form-control" readonly>

                    
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="e_datefrom">Date From</label>
                                <input type="date" name="e_datefrom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="e_dateto">Date To</label>
                                <input type="date" name="e_dateto"  class="form-control">
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
                            <button type="submit" class="btn btn-primary">Save</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF EDIT CONTRACT MODAL -->

    <!-- SCRIPT FOR EDIT CONTRACT -->

    <script>
        function formatNumber(input) {
            // Get input value and remove non-numeric characters
            let value = input.value.replace(/[^0-9.]/g, '');

            // Split the value into integer and decimal parts
            let parts = value.split('.');
            let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // Ensure there are only two decimal places
            let decimalPart = parts[1] ? '.' + parts[1].slice(0, 2) : '';

            // Combine integer and decimal parts with commas
            let formattedValue = integerPart + decimalPart;

            // Update input value with formatted number
            input.value = formattedValue;
        }
    </script>
      <script>
        function EditContract(conid, amount, transcode) {
            document.getElementsByName("e_conid")[0].setAttribute("value", conid);
            document.getElementsByName("e_amount")[0].setAttribute("value", amount);
            document.getElementsByName("e_transcode")[0].setAttribute("value", transcode);


        }
    </script>
     <script>
        function EditContractStatus(conid, hcfid) {
            document.getElementsByName("es_conid")[0].setAttribute("value", conid);
            document.getElementsByName("es_hcpn")[0].setAttribute("value", hcfid);
        }
    </script>
    <script>
function GetAPEXContractDetails(conid, hcfid, datefrom, dateto, amount) {
    // Storing user details in localStorage
    localStorage.setItem('getConID', conid);
    localStorage.setItem('getHCFID', hcfid);
    localStorage.setItem('getDateFrom', datefrom);
    localStorage.setItem('getDateTo', dateto);
    localStorage.setItem('getAmount', amount);
 
    // Redirecting to the new page
      window.location.href = "/apexassets?conid=" + conid + "&hcfid=" + hcfid + "&datefrom=" + datefrom + "&dateto=" + dateto + "&amount=" + amount;
}
  </script>
    @endsection