@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">


        <div class="card shadow mb-2">
            <div class="card-body">

                <div class="col col-md-12">
                    <div class="form-row">
                        <div class="col col-md-3">
                            <form>
                                @csrf

                                <select class="form-control" id="selectType">

                                    <option value="APEX">APEX FACILITY</option>
                                    <option value="HCPN">HCPN</option>
                                </select>
                        </div>
                        <div class="col col-md-4 select" style="display: none;" id="hcpn">

                            <select type="text" class="form-control hcpn-select" id="select2">
                                <option value="">SELECT HCPN</option>

                                @if ($HCPN == null)
                                <option></option>
                                @else
                                @foreach ($HCPN as $hcpn)
                                <option value="{{ $hcpn['controlnumber'] }}">{{ $hcpn['mbname'] }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col col-md-4" id="apex">

                            <select type="text" class="form-control" id="select3">
                                <option value="">SELECT APEX FACILITY</option>

                                @if ($Facilities == null || $APEXFacilities == null)
                                <option></option>
                                @else

                                @if (session()->get('leveid') === 'PRO')
                                @foreach ($APEXFacilities as $hcf)
                                @if ($hcf['type'] === "AH")
                                <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                                @endif
                                @endforeach
                                @endif
                                @endif
                            </select>
                        </div>

                        <div class="col col-md-4">

                            <select class="form-control hcpn-contract" id="contract" required>
                                <option value="">SELECT CONTRACT PERIOD</option>
                            </select>

                        </div>
                        <input type="text" name="controlnumber" id="selectedTranscode" class="d-none" required>
                        <input type="text" name="controlnumber" id="selectedHCF-HCPN" class="d-none" required>
                        <input type="text" name="controlnumber" id="selectedValueInput" class="d-none" required>
                        <input type="text" name="conidnumber" id="selectedContract" class="d-none" required>
                        </br>
                        <div class="col col-md-1" style="margin-top: -20px">
                            </br>
                            <button class="btn-sm btn-outline-primary" type="button"
                                onclick="setControlNumberAndRedirect()">Generate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow mt-2">
            <div class="card-body">
                @if ($SelectedHCFHCPN != "0")
                <span class="text-primary font-weight-bold ml-2 mt-1"
                    style="font-size: 17px;">{{ $SelectedHCFHCPN }}</span>
                @else
                <span class="text-secondary font-weight-bold ml-2 mt-1" style="font-size: 17px;">NO SELECTED
                    HCF/HCPN</span>
                @endif
                <div class="card shadow mt-2">
                    <div class="card-body">

                        <div class="table-responsive-sm"
                            style="overflow-y:auto; min-height:320px;max-height: 320px;margin-top:25px; margin-bottom: 10px; font-size: 10px;">
                            <div style="position:absolute; top:13px; right:320px">

                                <input type="text" id="searchInput">&nbsp;
                            </div>
                            <table class="table table-sm table-hover table-bordered mt-1" id="tablemanager" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center disableSort">Claim Series</th>
                                        <th class="text-center disableSort">Facility</th>

                                        <th class="text-center disableSort">Accre No</th>
                                        <th class="text-center disableSort">PMCC No</th>
                                        <th class="text-center disableSort">Date Received</th>

                                        <th class="text-center disableSort">Amount</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @if($Claims == null)
                                        <td>NO DATA</td>
                                        @else

                                        @foreach ($Claims as $claims)
                                    <tr>
                                        @php
                                        $hcf = json_decode($claims['pmccno'], true);
                                        @endphp
                                        <td class="text-center">{{ $claims['series'] }}</td>
                                        <td>{{ $hcf['hcfname'] }}</td>
                                        <td class="text-center">{{ $claims['accreno']}}</td>
                                        <td class="text-center">{{ $hcf['hcfcode'] }}</td>
                                        <td class="text-center">{{ $claims['datesubmitted'] }}</td>
                                        <td>&#8369;{{ number_format((double) $claims['claimamount'], 2)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </tr>
                                </tbody>
                            </table>
                            <center>
                                <div class="mt-2">
                                    <button class="btn-sm btn btn-outline-success mr-1"
                                        onclick="exportTableToExcel('tablemanager', 'members-data')"><i
                                            class="fas fa-fw fa-download"></i>&nbsp;Export</button><button
                                        class="btn-sm btn btn-outline-warning mr-1"><i
                                            class="fas fa-fw fa-print"></i>&nbsp;Print</button>

                                    @if($Claims != null)
                                    <button class="btn-sm btn btn-outline-danger" data-toggle="modal"
                                        data-target="#confirm-book"><i class="fas fa-fw fa-lock"></i>Lock Data</button>
                                    @else
                                    <a class="btn-sm btn btn-outline-danger disabled"><i
                                            class="fas fa-fw fa-lock"></i>Lock Data</a>
                                    @endif

                                </div>
                            </center>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="confirm-book">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="modal-title">Booking Confirmation</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('BookData') }}" method="POST">
                            @csrf
                            <input type="text" name="code" class="form-control d-none" value="{{$ConNumber}}" readonly
                                required>
                            <input type="text" name="conid" class="d-none" value="{{$SelectedConID }}" required>

                            <div class="form-group col-md">
                                <label for="e_amount">HCF/HCPN</label>
                                <input type="text" value="{{ $SelectedHCFHCPN }}" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md">
                                <label for="e_amount">Contract Reference</label>
                                <input type="text" value="{{ $transCode }}" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md">
                                <label for="e_amount">Book number</label>
                                <input type="text" placeholder="Please Input Booking Number" name="booknum"
                                    class="form-control" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-sm btn-outline-warning">Lock</button> <button type="button"
                            class="btn-sm btn-outline-danger" data-dismiss="modal">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var hcpnSelect = document.getElementById("select2");
    var hcfSelect = document.getElementById("select3");

    var contractSelect = document.querySelector('.hcpn-contract');
    var contracts = @json($Contract);

    function convertDateToText(dateString) {
        let [year, month, day] = dateString.split('-');
        let date = new Date(`${year}-${month}-${day}`);
        return date.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }

    function updateContractOptions() {


        var selectedHCF = hcfSelect.value;

        contractSelect.innerHTML = '<option value="">SELECT CONTRACT PERIOD</option>';
        contracts.forEach(function(contract) {

            var mb = JSON.parse(contract.hcfid);
            var condate = JSON.parse(contract.contractdate);
            if (mb.hcfcode === selectedHCF) {
                var option = document.createElement('option');
                option.value = contract.conid;
                option.textContent =
                    `${convertDateToText(condate.datefrom)} to ${convertDateToText(condate.dateto)}`;
                contractSelect.appendChild(option);

            }
        });
    }

    function updateContractOptions2() {

        var selectedHCPN = hcpnSelect.value;

        contractSelect.innerHTML = '<option value="">SELECT CONTRACT PERIOD</option>';
        contracts.forEach(function(contract) {

            var mb = JSON.parse(contract.hcfid);
            var condate = JSON.parse(contract.contractdate);
            if (mb.controlnumber === selectedHCPN) {
                var option = document.createElement('option');
                option.value = contract.conid;
                option.textContent =
                    `${convertDateToText(condate.datefrom)} to ${convertDateToText(condate.dateto)}`;
                contractSelect.appendChild(option);

            }
        });


    }



    hcpnSelect.addEventListener('change', updateContractOptions2);
    hcfSelect.addEventListener('change', updateContractOptions);


});
</script>


<script>
document.getElementById("selectType").addEventListener("change", function() {
    var selectType = this.value;
    var Hcpn = document.getElementById("hcpn");

    var Apex = document.getElementById("apex");
    var ApexSelect = document.getElementById("select3");

    var HcpnSelect = document.getElementById("select2");

    HcpnSelect.removeAttribute("required");

    ApexSelect.removeAttribute("required");

    if (selectType === "HCPN") {
        Hcpn.style.display = "block";
        HcpnSelect.setAttribute("required", "required");

        Apex.style.display = "none";
    } else {
        Hcpn.style.display = "none";

        Apex.style.display = "block";
        ApexSelect.setAttribute("required", "required");

    }
});

document.getElementById("select3").addEventListener("change", function() {
    var select = document.getElementById("select3");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedValueInput").value = selectedOption.value;
});
document.getElementById("select2").addEventListener("change", function() {
    var select = document.getElementById("select2");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedValueInput").value = selectedOption.value;
});

document.getElementById("contract").addEventListener("change", function() {
    var select = document.getElementById("contract");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedContract").value = selectedOption.value;
});
document.getElementById("contract").addEventListener("change", function() {
    var select = document.getElementById("contract");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedTranscode").value = selectedOption.textContent;
});
document.getElementById("select3").addEventListener("change", function() {
    var select = document.getElementById("select3");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedHCF-HCPN").value = selectedOption.textContent;
});
document.getElementById("select2").addEventListener("change", function() {
    var select = document.getElementById("select2");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedHCF-HCPN").value = selectedOption.textContent;
});
</script>

<script>
function setControlNumberAndRedirect() {
    var controlNumber = document
        .getElementById("selectedValueInput")
        .value.trim();
    var conID = document
        .getElementById("selectedContract")
        .value.trim();
    var hcfHCPN = document
        .getElementById("selectedHCF-HCPN")
        .value.trim();
    var transCode = document
        .getElementById("selectedTranscode")
        .value.trim();
    localStorage.setItem("controlNumber", controlNumber);
    localStorage.setItem("conID", conID);
    window.location.href = "/Reports/Booking?controlNumber=" + controlNumber + "&conID=" + conID + "&hcfHCPN=" +
        hcfHCPN + "&transCode=" + transCode;
}
</script>

@endsection