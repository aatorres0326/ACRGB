@extends('layouts.app')


@section('contents')

<div id="content">
    <div class="container-fluid">
        <div class="row">
           
            <div class="col-md-4 text-center text-primary"><h4><strong>{{ $MBName }}</strong></h4></div>
            <div class="col-md-4 text-center"><h6>Contract Number : {{ $TransCode }}</h6></div>
            <div class="col-md-4 text-center"><h6>Contract Amount :<strong>&#8369;</strong> &nbsp;{{ number_format((double) $ContractAmount, 2) }}</h6></div>

        </div>

        <!-- CONTRACT TABLE -->
        <div class="card shadow mb-4">
            
            <div class="card-body">
                
                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                  
                    <table class="table table-sm table-hover table-bordered table-striped" id="tablemanager"
                        width="100%" cellspacing="0">
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <thead>
                           <tr>
                                <th class="text-center">Contract Number</td>
                                <th  class="text-center" id="max-width-column">HCPN</th>
                                <th class="text-center">Estimated Amount</th>
                                <th class="text-center">Released Amount</th>
                                <th class="text-center">Released Date</th>
                                <th class="text-center">Released By</th>
                                <th class="text-center disableFilterBy">Date Covered</th>
                          
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
            $mb = json_decode($contract['hcfid'], true);
@endphp

                                <td>{{ $mb['hcfname'] }}</td>
                                <td><strong>&#8369;</strong> &nbsp;{{ number_format((double) $contract['baseamount'], 2) }}</td>
                                <td><strong>&#8369;</strong> &nbsp;{{ number_format((double) $contract['amount'], 2) }}</td>
                                <td class="text-center"> {{ DateTime::createFromFormat('m-d-Y', $contract['datecreated'])->format('M j, Y') }}</td>
                                @php
            $releasedby = json_decode($contract['createdby'], true);
@endphp
                                <td class="text-center">{{ $releasedby['firstname'] . ' ' . $releasedby['lastname'] }}</td>
                                <td class="text-center">{{ DateTime::createFromFormat('m-d-Y', $contract['datefrom'])->format('M j, Y') }} to {{ DateTime::createFromFormat('m-d-Y', $contract['dateto'])->format('M j, Y') }}</td>
                              
                                <td class="text-center">
                                    <button class="btn btn-sm btn-link text-darker-primary" onclick="GetAPEXContractDetails('{{$contract['conid']}}', '<?= htmlspecialchars(json_encode($mb), ENT_QUOTES, 'UTF-8') ?>', '<?= $contract['dateto'] ?>','<?= $contract['datefrom'] ?>','<?= $contract['amount'] ?>')">
                                        <i class="fas fa-fw fa-eye" data-toggle="tooltip" title="View"></i>
                                    </button>
                                   
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
                    <form action="{{ route('AddContract') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="transcode">Contract Number</label>
                                <input type="text" name="transcode" class="form-control" placeholder="Transaction #"
                                    double>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="hcpn">HCPN</label>
                                <select name="mb"id="seledtedhcf" class="form-control">
                                    <option value="" data-base-amount="">Select HCPN</option>
                                   
                                </select>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="datefrom">Date From</label>
                                <input type="date" name="datefrom" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dateto">Date To</label>
                                <input type="date" name="dateto" class="form-control" required>
                            </div>
                        </div>
                           <div class="form-row">
                            <div class="form-group col-md">
                                <label for="baseamount">Base Amount</label>
                                <input type="text" name="baseamount" id="baseamount" class="form-control" oninput="formatNumber(this)"
                                    placeholder="0" double required readonly>
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
                                <label for="e_transcode">Contract Number</label>
                                <input type="text" name="e_transcode" class="form-control" placeholder="Transaction #"
                                    double>
                                <input type="text" name="e_conid" class="d-none" placeholder="Transaction #" double>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="hcpn">HCPN</label>
                                <select name="hcpn" class="form-control">

                                   

                                </select>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="e_datefrom">Date From</label>
                                <input type="date" name="e_datefrom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="e_dateto">Date To</label>
                                <input type="date" name="e_dateto" class="form-control">
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

    <!-- EDIT CONTRACT STATUS MODAL -->
     <div class="modal" id="editcontractstatus">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">Edit Contract Status</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
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
                                <label for="contract">Contract Number</label>
                              
                                <input type="text" name="contract" class="form-control" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="RENEWAL">RENEWAL</option>
                                    <option value="NONRENEWAL">NON RENEWAL</option>
                                    <option value="END">END OF CONTRACT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md" id="enddate-field" style="display: none;">
                                <label for="enddate">End Date</label>
                                <input type="date" name="enddate" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md" id="remarks-field" style="display: none;">
                                <label for="remarks">Remarks</label>
                                <input type="text" name="remarks" class="form-control">
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
    <!-- SCRIPT FOR EDIT CONTRACT -->
    <script>
        function EditContract(conid, amount, transcode) {
            document.getElementsByName("e_conid")[0].setAttribute("value", conid);
            document.getElementsByName("e_amount")[0].setAttribute("value", amount);
            document.getElementsByName("e_transcode")[0].setAttribute("value", transcode);


        }
    </script>
   <script>
    function EditContractStatus(conid, hcpn, contract) {
        // Parse the JSON string
        var hcpnObject = JSON.parse(hcpn);

        // Extract the value of hcfname
        var mbname = hcpnObject.mbname;

        // Set the value of the element with the name 'es_conid'
        document.getElementsByName("es_conid")[0].setAttribute("value", conid);
        // Set the value of the element with the name 'es_apex'
        document.getElementsByName("es_hcpn")[0].setAttribute("value", mbname);
        document.getElementsByName("contract")[0].setAttribute("value", contract);
    }
</script>
      <!-- SCRIPT FOR GETTING BASE AMOUNT ON AD CONTRACT MODAL -->
<script>
    document.getElementById('seledtedhcf').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var baseAmount = selectedOption.getAttribute('data-base-amount');
        
        // Check if baseAmount is "NO DATA FOUND" or not present
        if (!baseAmount || baseAmount.trim() === '' || baseAmount.trim().toUpperCase() === 'NO DATA FOUND') {
            baseAmount = '0'; // Set baseAmount to '0'
        } else {
            // Convert baseAmount to number and round to 2 decimal places
            baseAmount = parseFloat(baseAmount).toFixed(2);
            // Add commas for thousands separators
            baseAmount = baseAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }
        document.getElementById('baseamount').value = baseAmount;
    });
</script>

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
</script>
    <script>
function GetContractDetails(hcpn) {
    // Storing user details in localStorage
   var hcpnObject = JSON.parse(hcpn);

        // Extract the value of hcfname
        var mbname = hcpnObject.mbname;
        var controlnumber = hcpnObject.controlnumber;
         localStorage.setItem('ConNumber', controlnumber);
    localStorage.setItem('MBName', mbname);
   
 
    // Redirecting to the new page
      window.location.href = "/facilitycontracts?controlnumber=" + controlnumber + "&mbname=" + mbname;
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
      window.location.href = "/facilityassets?conid=" + conid + "&hcfid=" + hcfid + "&datefrom=" + datefrom + "&dateto=" + dateto + "&amount=" + amount;
}
  </script>
    @endsection