@extends('layouts.app')


@section('contents')


<div id="content">
    <div class="container-fluid">

        <!-- CONTRACT TABLE -->
        <div class="card shadow mb-4">
            <div class="card-body bg-gradient-light">
                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                    <div style="position:absolute; top:13px; right:460px">
                   @if (session()->get('leveid') == 'PRO')
                        <a class="btn btn-link btn-sm " data-toggle="modal" data-target="#add-contract" text-decoration:
                            none;><i class="fas fa-plus fa-sm text-info-40"></i> Add Contract
                        </a>
                       
                        @endif
                         <input type="text" id="searchInput">
                    </div>

                    <table class="table table-sm table-hover table-bordered display" id="tablemanager"
                        width="100%" cellspacing="0">
                        <caption>List of APEX Contracts</caption>
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <thead>
                            <tr>
                                <thead>
                            <tr class="exclude-row">
                                <th class="text-center disableSort">Contract Number</td>
                                <th  class="text-center disableSort" id="max-width-column"  data-sortable="true">APEX Facility</th>

                                <th class="text-center disableSort">Contract Amount</th>
                                    <th class="text-center disableSort">Tranch</th>
                                    <th class="text-center disableSort disableFilterBy">Used Budget</th>
                                    <th class="text-center disableSort disableFilterBy">No. of Claims</th>
                           @if (session()->get('leveid') == 'PRO')
                                <th class="disableSort disableFilterBy text-center">Action</th>
                                @endif
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
                                <td id="max-width-column" data-toggle=" tooltip" title="{{ $hcf['hcfname'] }}">{{ $hcf['hcfname'] }}</td>
                                <td><strong>&#8369;</strong> &nbsp;{{ number_format((double) $contract['amount'], 2) }}</td>
                                 @if ($contract['traches'] == 1)
                                                <td class="text-center">1ST</td>
                                                @if ($contract['percentage'] < 0)
                                                <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format(abs((double) $contract['percentage']), 2) }}%</span> OVER OF 1ST TRANCH</td>
                                                @elseif ($contract['percentage'] < 45)
                                                <td class="text-center"><span class="text-success font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 1ST TRANCH</td>
                                                @elseif ($contract['percentage'] < 55)
                                                <td class="text-center"><span class="text-darker-warning font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 1ST TRANCH</td>
                                                @else
                                                <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 1ST TRANCH</td>
                                                @endif
                                 @elseif ($contract['traches'] == 2)
                                                <td class="text-center">2ND</td>
                                                @if ($contract['percentage'] < 0)
                                                <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format(abs((double) $contract['percentage']), 2) }}%</span> OVER OF 2ND TRANCH</td>
                                                @elseif ($contract['percentage'] < 60)
                                                <td class="text-center"><span class="text-success font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 2ND TRANCH</td>
                                                @elseif ($contract['percentage'] < 70)
                                                <td class="text-center"><span class="text-darker-warning font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 2ND TRANCH</td>
                                                @else
                                                <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 2ND TRANCH</td>
                                                @endif
                                @elseif ($contract['traches'] == 3)
                                                <td class="text-center">3RD</td>
                                                 @if ($contract['percentage'] < 0)
                                                <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format(abs((double) $contract['percentage']), 2) }}%</span> OVER OF 3RD TRANCH</td>
                                                @elseif ($contract['percentage'] < 80)
                                                <td class="text-center"><span class="text-success font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 3RD TRANCH</td>
                                                @elseif ($contract['percentage'] < 90)
                                                <td class="text-center"><span class="text-darker-warning font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 3RD TRANCH</td>
                                                @else
                                                <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format((double) $contract['percentage'], 2) }}%</span> USED OF 3RD TRANCH</td>
                                                @endif
                                                @else
                                                <td class="text-center">N/A</td>
                                                <td class="text-center">N/A</td>
                                @endif
                                                 
                                                
                                               
                                                <td class="text-center">{{$contract['totalclaims']}}</td>
                                @php
            $createdby = json_decode($contract['createdby'], true);
                                @endphp
                                <td class="text-center">
                                    <button class="btn-info btn-sm" id="{{$contract['transcode']}}" onclick="toggleDetails('{{$contract['transcode']}}')"><i class="fas fa-fw fa-eye" data-toggle="tooltip" title="View"></i></button>
                                </td>
                            </tr>
                             <tr id="{{$contract['transcode']}}-details" class="d-none exclude-row">
                                                <td colspan="8">
                                                    <div class="card card-body bg-light">
                                                        <div class="row d-flex align-items-center">
                                                            <div class="col-sm-2">
                                                                <span class="text-secondary font-weight-bold">ESTIMATED AMOUNT</span></br>
                                                                <span><strong>&#8369;</strong> &nbsp;{{ number_format((double) $contract['baseamount'], 2) }}</span>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <span class="text-secondary font-weight-bold">RELEASED BY</span></br>
                                                                @if ($createdby == null)
                                                                    <span>NO DATA FOUND</span>      
                                                                @else
                                                                    <span>{{ $createdby['firstname'] . " " . $createdby['lastname'] }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <span class="text-secondary font-weight-bold">DATE RELEASED</span></br>
                                                                <span>{{ DateTime::createFromFormat('m-d-Y', $contract['datecreated'])->format('M j, Y') }}</span>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-secondary font-weight-bold">CONTRACT COVERAGE</span></br>
                                                                <span>{{ DateTime::createFromFormat('m-d-Y', $contract['datefrom'])->format('M j, Y') }} to {{ DateTime::createFromFormat('m-d-Y', $contract['dateto'])->format('M j, Y') }}</span>
                                                            </div>
                                                            <div class="col-sm-3 text-right">
                                                                <button class="btn btn-sm btn-info text-darker-primary" onclick="GetAPEXContractDetails('{{$contract['conid']}}', '{{$contract['hcfid']}}', '<?= $contract['dateto'] ?>','<?= $contract['datefrom'] ?>','<?= $contract['amount'] ?>')">
                                                                    Tranches
                                                                </button>
                                                                 @if (session()->get('leveid') == 'PRO')
                                                                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editcontractstatus" onclick="EditContractStatus('<?= $contract['conid'] ?>',
                                                                    '<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>',
                                                                    '<?= $contract['transcode'] ?>',
                                                                    '<?= $contract['baseamount'] ?>',
                                                                    '<?= $contract['datefrom'] ?>',
                                                                    '<?= $contract['dateto'] ?>')">Status</a> 
                                                                    <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal" data-target="#editcontract" onclick="EditContract('<?= $contract['conid'] ?>','<?= $contract['amount'] ?>','<?= $contract['transcode'] ?>','<?= htmlspecialchars(json_encode($hcf), ENT_QUOTES, 'UTF-8') ?>')"><i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit Contract"></i></a> 
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var filterInput = document.getElementById("filterInput");
        var table = document.getElementById("table");
        var paginationDiv = document.getElementById("pagination");

     


        // Filter table on input change
        filterInput.addEventListener("keyup", function() {
            // Reset to first page when filtering
            currentPage = 1;

            var filterValue = filterInput.value.toLowerCase();
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) { // Start from index 1 to exclude header
                var row = rows[i];
                if (!row.classList.contains("exclude-row")) {
                    var cells = row.getElementsByTagName("td");
                    var found = false;

                    for (var j = 0; j < 3; j++) { // Iterate only over the first three columns
                        var cell = cells[j];
                        if (cell.textContent.toLowerCase().indexOf(filterValue) > -1) {
                            found = true;
                            break;
                        }
                    }

                    if (found) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }
            }

            
       
        });
    });
</script>
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
                                <label for="hcpn">APEX Facility</label>
                                <select name="mb" id="seledtedhcf" class="form-control" required>
                                    <option value="" data-base-amount="">Select Facility</option>
                                   @foreach ($Facilities as $facility)
    @if($facility['type'] == 'APEX')
        <option value="{{ $facility['hcfcode'] }}" data-base-amount="{{ $facility['baseamount'] }}">{{ $facility['hcfname'] }}</option>
    @endif
@endforeach
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
                                <input type="text" name="e_transcode" class="form-control" placeholder="Transaction #" readonly
                                    double>
                                <input type="text" name="e_conid"  class="d-none" double>
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
                                <label for="es_apex">APEX Facility</label>
                                <input type="text" name="es_conid" class="form-control d-none">
                                <input type="text" name="es_apex" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="contract">Contract Number</label>
                              
                                <input type="text" name="contract" class="form-control" readonly>
                            </div>
                        </div>
                             <div class="form-row">
                            <div class="form-group col-md" id="covereddate-field" style="display: none;">
                                <label for="enddate">Covered Date</label>
                                <input type="text" name="covereddate-field" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md" id="baseamount-field" style="display: none;">
                                <label for="remarks">Base Amount</label>
                                <input type="text" name="baseamountfield" class="form-control" readonly>
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
                       <div class="form-row">
                            <div class="form-group col-md">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Change Status</option>
                                    <option value="RENEW">RENEWAL</option>
                                    <option value="NONRENEW">NON RENEWAL</option>
                                    <option value="TERMINATE">END OF CONTRACT</option>
                                </select>
                            </div>
                        </div>
                        <div id="new-contract-form" style="display: none;">
                            <hr class="sidebar-divider d-none d-md-block">
                            <h5 class="text-center"> New Contract Details</h5>
                                   <hr class="sidebar-divider d-none d-md-block">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="contract">Contract Number</label>
                                    <input type="text" name="contract" class="form-control" placeholder="Enter Contract Number" 
                                    >
                                </div>
                                <div class="form-group col">
                                    <label for="contract">Amount</label>
                                    <input type="text" name="contract" class="form-control" oninput="formatNumber(this)"
                                    placeholder="Enter amount" double>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="contract">Date From</label>
                                    <input type="date" name="contract" class="form-control">
                                </div>
                                <div class="form-group col">
                                    <label for="contract">Date To</label>
                                    <input type="date" name="contract" class="form-control">
                                </div>
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
        function EditContract(conid, amount, transcode, hcfid) {
              var hcfidObject = JSON.parse(hcfid);

        // Extract the value of hcfname
        var hcfname = hcfidObject.hcfname;
            document.getElementsByName("e_conid")[0].setAttribute("value", conid);
            document.getElementsByName("e_amount")[0].setAttribute("value", amount);
            document.getElementsByName("e_transcode")[0].setAttribute("value", transcode);
            document.getElementsByName("hcpn")[0].setAttribute("value", hcfname);


        }
    </script>
<script>
    function formatDate(dateString) {
        var date = new Date(dateString);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function EditContractStatus(conid, hcfid, contract, baseamount, datefrom, dateto) {
        // Parse the JSON string
        var hcfidObject = JSON.parse(hcfid);

        // Extract the value of hcfname
        var hcfname = hcfidObject.hcfname;
        var dateFromFormatted = formatDate(datefrom);
        var dateToFormatted = formatDate(dateto);
        var datecovered = dateFromFormatted + " TO " + dateToFormatted;

        // Convert baseamount to dollars and cents format with commas
        var baseamountDecimal = (baseamount / 1).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Set the value of the element with the name 'es_conid'
        document.getElementsByName("es_conid")[0].setAttribute("value", conid);
        // Set the value of the element with the name 'es_apex'
        document.getElementsByName("es_apex")[0].setAttribute("value", hcfname);
        document.getElementsByName("contract")[0].setAttribute("value", contract);
        document.getElementsByName("baseamountfield")[0].setAttribute("value", baseamountDecimal);
        document.getElementsByName('covereddate-field')[0].setAttribute("value", datecovered);
    }
</script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const statusSelect = document.getElementById('status');
        const endDateField = document.getElementById('enddate-field');
        const remarksField = document.getElementById('remarks-field');
        const coveredDateField = document.getElementById('covereddate-field');
        const baseAmountField = document.getElementById('baseamount-field');
        const newContractForm = document.getElementById('new-contract-form');

        statusSelect.addEventListener('change', function() {
            if (this.value === 'TERMINATE') {
                endDateField.style.display = 'block';
                remarksField.style.display = 'block';
                 coveredDateField.style.display = 'none';
                baseAmountField.style.display = 'none';
                newContractForm.style.display = 'none';
            } else if (this.value === 'RENEW') {
                coveredDateField.style.display = 'block';
                baseAmountField.style.display = 'block';
                 endDateField.style.display = 'none';
                remarksField.style.display = 'none';
                newContractForm.style.display = 'block';
            } else {
                endDateField.style.display = 'none';
                remarksField.style.display = 'none';
                coveredDateField.style.display = 'none';
                baseAmountField.style.display = 'none';
                newContractForm.style.display = 'none';
            }
        });
    });
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