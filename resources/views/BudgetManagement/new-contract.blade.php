@extends('layouts.app')

@section('contents')
<div id="content">
    <div class="container-fluid">
        <div class="card shadow mb-2">
            <div class="card-body">

                @if (
                ($ManagingBoard == null && session()->get('leveid') === 'PRO') ||
                ($Facilities == null && session()->get('leveid') === 'HCPN')
                )


                <h5 class="text-center">NO ASSIGNED ACCESS</h5>
                @else


                <form action="{{ route('AddContract') }}" class="font-weight-bold" method="POST"
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
                                    @if (session()->get('leveid') === 'PRO')
                                    <option value="" data-hcfhcpn="">Select HCPN</option>

                                    @foreach ($ManagingBoard as $mb)
                                    <option value="{{ $mb['controlnumber']}}" data-hcfhcpn="{{ $mb['mbname'] }}">
                                        {{ $mb['mbname']}}
                                    </option>
                                    @endforeach
                                    @else
                                    <option value="" data-hcfhcpn="">Select Facility</option>
                                    @foreach ($Facilities as $facility)
                                    <option value="{{ $facility['hcfcode']}}" data-hcfhcpn="{{ $facility['hcfname'] }}">
                                        {{ $facility['hcfname']}}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                <input type="text" class="d-none" name="hcfhcpn" id="selectedValueInput" required>
                                @else


                                <input class="form-control d-none" name="connumber" value="{{ $ConNumber }}" readonly>
                                <input class="form-control" name="hcfhcpn" value="{{ $SelectedHCFHCPN }}" readonly>
                                @endif


                            </div>
                            <div class="form-group col-md-4">
                                <label for="hcpn">Contract Period</label>
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
                                <label for="baseamount">Average Claims Amount</label>
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
                                <input type="text" name="baseamount" id="baseamount" value="0" class="form-control"
                                    placeholder="0" required readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sb">30% Case Rate Adjustment</label>
                                <input type="text" name="sb" value="0" class="form-control" placeholder="0" required
                                    readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="total_claims_amount">Total Claims Average + 30%</label>
                                <input type="text" name="total_claims_amount" class="form-control" placeholder="0"
                                    required readonly>
                            </div>
                        </div>
                        <div class="form-row">


                            <div class="form-group col-md-4">
                                <label for="sb">Supplementary Budget</label>
                                <input type="text" name="" class="form-control" placeholder="0" required readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="claims_volume">Average Claims Volume</label>
                                <input type="text" name="claims_volume" class="form-control" placeholder="0" required
                                    readonly>
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
                                <label for="claims_volume">Committed Claims Volume</label>
                                <input type="text" name="committed_claims_volume" class=" form-control" placeholder="0"
                                    required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="amount">Set Contract Amount</label>
                                <input type="text" name="contract_amount" class="form-control"
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



    var url = "/Contracts/NewContract?" +
        "controlNumber=" + encodeURIComponent(controlNumber) +
        "&DateFrom=" + encodeURIComponent(DateFrom) +
        "&DateTo=" + encodeURIComponent(DateTo) +
        "&TransCode=" + encodeURIComponent(TransCode) +
        "&HCFHCPN=" + encodeURIComponent(HcfHcpn) +
        "&ConDate=" + encodeURIComponent(ConDate);

    window.location.href = url;

}




function clearForm() {
    var url = "/Contracts/NewContract";

    window.location.href = url;
}
</script>
@endsection