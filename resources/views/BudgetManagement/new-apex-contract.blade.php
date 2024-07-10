@extends('layouts.app')

@section('contents')
<div id="content">
    <div class="container-fluid">
        <div class="card shadow mb-2">
            <div class="card-body">

                @if ($Facilities == null && session()->get('leveid') === 'PRO')


                <h5 class="text-center">NO ASSIGNED ACCESS</h5>
                @else


                                                                        <form name="form1" action="{{ route('AddAPEXContract') }}" class="font-weight-bold" method="POST"
                                                                            style="font-size: 13px;">
                                                                            @method('post')
                                                                            @csrf
                                                                            <div class="card-body">
                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="transcode">Reference Number</label>
                                                                                        @if ($transcode == null)
                                                                                        <input type="text" name="transcode" id="transcode" class="form-control"
                                                                                            placeholder="Reference #" required>
                                                                                        @else


                                                                                        <input type="text" name="transcode" value="{{$transcode}}" class="form-control" readonly
                                                                                            required>
                                                                                        @endif


                                                                                    </div>
                                                                                    <div class="form-group col-md-4">
                                                                                        @if (session()->get('leveid') === 'PRO')
                                                                                        <label for="hcpn">HCPN</label>
                                                                                        @else
                                                                                        <label for="hcpn">Facilities</label>
                                                                                        @endif
                                                                                        @if($SelectedHCFHCPN == null)
                                                                                        <select name="mb" id="hcfhcpn" class="form-control" required>
                                                                                            <option value="" data-hcfhcpn="">Select Facility</option>
                                                                                            @foreach ($Facilities as $facility)
                                                                                            @if($facility['type'] == "AH")
                                                                                            <option value="{{ $facility['hcfcode']}}" data-hcfhcpn="{{ $facility['hcfname'] }}">
                                                                                                {{ $facility['hcfname']}}
                                                                                            </option>
                                                                                            @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <input type="text" class="d-none" name="hcfhcpn" id="selectedValueInput" required>
                                                                                        @else


                                                                                        <input class="form-control d-none" name="connumber" value="{{ $ConNumber }}" readonly>
                                                                                        <input class="form-control" name="hcfhcpn" value="{{ $SelectedHCFHCPN }}" readonly>
                                                                                        @endif


                                                                                    </div>
                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="hcpn">Contract Period</label>
                                                                                        <a style="font-size: 12px; text-decoration:none; margin-top: -10px; "
                                                                                            class="btn-outline-primary btn-sm btn p-1 ml-2 font-weight-bold" data-toggle="modal"
                                                                                            data-target="#add-period"><i class="fas fa-plus fa-sm text-info-40"></i> Add
                                                                                            Period
                                                                                        </a>
                                                                                        @if ($SelectedConDate == null)
                                                                                        <select name="contractperiod" class="form-control" id="select2" required>
                                                                                            <option value="">Select Contract Period</option>
                                                                                            @foreach ($ContractDate as $condate)
                                                                                            <option value="{{ $condate['condateid']}}"
                                                                                                data-date-from="{{ $condate['datefrom'] }}"
                                                                                                data-date-to="{{ $condate['dateto'] }}">
                                                                                                {{ DateTime::createFromFormat('m-d-Y', $condate['datefrom'])->format('M j, Y') }}
                                                                                                -
                                                                                                {{ DateTime::createFromFormat('m-d-Y', $condate['dateto'])->format('M j, Y') }}
                                                                                            </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @else


                                                                                        <input value="{{ $SelectedConDate }}" name="condateid" class="d-none">
                                                                                        <input class="form-control"
                                                                                            value="{{ DateTime::createFromFormat('m-d-Y', $DateFrom)->format('M j, Y') }} &nbsp;to&nbsp;{{DateTime::createFromFormat('m-d-Y', $DateTo)->format('M j, Y')}}"
                                                                                            readonly>
                                                                                        @endif


                                                                                    </div>
                                                                                </div>

                                                                                @if ($Budget != null)
                                                                                @foreach ($Budget as $base)
                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="baseamount">Claims Average</label>
                                                                                        <input type="text" name="baseamount" id="baseamount" class="form-control"
                                                                                            value="{{ $base['totalamount'] }}" required readonly>
                                                                                    </div>
                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="sb">30% Case Rate Adjustment</label>
                                                                                        <input type="text" name="thirty" value="{{ $base['thirty'] }}" class="form-control"
                                                                                            placeholder="0" required readonly>
                                                                                    </div>
                                                                                    @php
                    $total = $base['totalamount'] + $base['thirty'];
                                                                                    @endphp
                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="claims_volume">Total Claims Average + 30%</label>
                                                                                        <input type="text" name="total_claims_amount" value="{{ $total }}" class="form-control"
                                                                                            placeholder="0" required readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-row">

                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="sb">Supplementary Budget</label>
                                                                                        <input type="text" name="sb" value="{{ $base['sb'] }}" class="form-control"
                                                                                            placeholder="0" required readonly>
                                                                                    </div>
                                                                                    <div class="form-group col-md-3">
                                                                                        <label for="claims_volume">Average Claims Volume</label>
                                                                                        <input type="text" name="claims_volume" value="{{ $base['totalclaims'] }}"
                                                                                            class="form-control" placeholder="0" required readonly>
                                                                                    </div>


                                                                                    <div class="form-group col-md-2" style="margin-top: 30px;">
                                                                                        <a type="button" class="btn btn-sm btn-outline-warning" onclick="clearForm()"><i
                                                                                                class="fas fa-trash fa-sm"></i>&nbsp;Clear</a>
                                                                                    </div>


                                                                                </div>

                                                                                @endforeach


                                                                                @else


                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="baseamount">Claims Average</label>
                                                                                        <input type="text" name="baseamount" id="baseamount" class="form-control"
                                                                                            placeholder="0" required readonly>
                                                                                    </div>
                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="sb">30% Case Rate Adjustment</label>
                                                                                        <input type="text" name="sb" value="" class="form-control" placeholder="0" required
                                                                                            readonly>
                                                                                    </div>

                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="total_claims_amount">Total Claims Average + 30%</label>
                                                                                        <input type="text" name="total_claims_amount" value="" class="form-control"
                                                                                            placeholder="0" required readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-row">


                                                                                    <div class="form-group col-md-3">
                                                                                        <label for="claims_volume">Average Claims Volume</label>
                                                                                        <input type="text" name="claims_volume" value="" class="form-control" placeholder="0"
                                                                                            required readonly>
                                                                                    </div>



                                                                                    @if ($ConNumber == null)
                                                                                    <div class="form-group col-md-2" style="margin-top: 30px;">
                                                                                        <a href="#" class="btn btn-outline-primary btn-sm" title="Generate Computation"
                                                                                            onclick="setControlNumberAndRedirect()">
                                                                                            <i class="fas fa-plus fa-sm text-info-40"></i>&nbsp;Compute
                                                                                        </a>
                                                                                    </div>
                                                                                    @else

                                                                                    <div class="form-group col-md-2" style="margin-top: 30px;">
                                                                                        <a type="button" class="btn btn-sm btn-outline-warning" onclick="clearForm()"><i
                                                                                                class="fas fa-trash fa-sm"></i>&nbsp;Clear</a>
                                                                                    </div>
                                                                                    @endif


                                                                                </div>

                                                                                @endif



                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md-3">
                                                                                        <label for="claims_volume">Committed Claims Volume <span ><em>*</em></span> </label>
                                                                                        <input type="text" id="committed_claims_volume" onkeyup="numberonly(document.form1.committed_claims_volume)"
                                                                                        name="committed_claims_volume" class=" form-control" placeholder="0"
                                                                                            required>
                                                                                    </div>
                                                                                    <div class="form-group col-md-4">
                                                                                        <label for="amount">Set Contract Amount</label>
                                                                                        <input type="text" id="contract_amount"  onkeyup="numberonly(document.form1.contract_amount)"
                                                                                        name="contract_amount" class="form-control"
                                                                                            placeholder="Enter amount" required>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <center>
                                                                                    <button type="submit" class="btn btn-sm btn-outline-primary">Submit</button>
                                                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                                                        data-dismiss="modal">Cancel</button>
                                                                                </center>
                                                                            </div>
                                                                        </form>
                @endif


            </div>
        </div>
    </div>
</div>
<div class="modal" id="add-period">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="modal-title">Add Contract Period</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('INSERTCONTRACTPERIOD') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="datefrom">Date From</label>
                                    <input type="date" name="datefrom" id="datefrom" class="form-control" required
                                        onchange="setMinDateTo()">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dateto">Date To</label>
                                    <input type="date" name="dateto" id="dateto" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Add</button> <button
                                    type="button" class="btn btn-sm btn-outline-danger"
                                    data-dismiss="modal">Cancel</button>
                            </div>
                            <script>
                            function setMinDateTo() {

                                const dateFrom = document.getElementById('datefrom').value;
                                const dateTo = document.getElementById('dateto');
                                dateTo.min = dateFrom;

                            }
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById("hcfhcpn").addEventListener("change", function() {
    var select = document.getElementById("hcfhcpn");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedValueInput").value = selectedOption.getAttribute('data-HCFHCPN');
});

function setControlNumberAndRedirect() {

    var transcode = document.getElementById("transcode").value;
    var condate = document.getElementById("select2").value;
    var hcfhcpn = document.getElementById("hcfhcpn").value;

    if (!transcode || !condate || !hcfhcpn) {
        alert("Reference Number, Contract Period, and Network/Facility is required before generating computation.");
        return;
    }
    var selectedContract = $('#select2 option:selected');
    var DateFrom = selectedContract.data('date-from');
    var DateTo = selectedContract.data('date-to');
    var TransCode = document.getElementById("transcode").value;
    var HcfHcpn = document.getElementById("selectedValueInput").value;
    var controlNumber = $('#hcfhcpn').val();

    var ConDate = document.getElementById("select2").value;



    var url = "/Contracts/NewAPEXContract?" +
        "controlNumber=" + encodeURIComponent(controlNumber) +
        "&DateFrom=" + encodeURIComponent(DateFrom) +
        "&DateTo=" + encodeURIComponent(DateTo) +
        "&TransCode=" + encodeURIComponent(TransCode) +
        "&HCFHCPN=" + encodeURIComponent(HcfHcpn) +
        "&ConDate=" + encodeURIComponent(ConDate);

    window.location.href = url;

}


    
function numberonly(inputtxt) {
    var letters = /^[0-9]+$/;
        var x = document.getElementById('committed_claims_volume').value;
         var x = document.getElementById('contract_amount').value;
        if (inputtxt.value.match(letters)) {
                return true;
         } else {
            document.getElementById('contract_amount').value = x.replace(/[^0-9]/g, '');
            document.getElementById('committed_claims_volume').value = x.replace(/[^0-9]/g, '');
        return false;
        }
  }





function clearForm() {
    var url = "/Contracts/NewAPEXContract";

    window.location.href = url;
}
</script>
@endsection