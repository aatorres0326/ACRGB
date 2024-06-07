@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">


        <div class="card shadow mb-2">
            <div class="card-body">

            @if (session()->get('leveid') === 'PHIC' || session()->get('leveid') === 'PRO')
                <div class="col col-md-12">
                    <div class="form-row">
                        <div class="col col-md-3">
                            <form>
                                @csrf

                                <select class="form-control" id="selectType">
                                    <option value="NONAPEX">NON APEX FACILITY</option>
                                    <option value="APEX">APEX FACILITY</option>
                                    <option value="HCPN">HCPN</option>
                                </select>
                        </div>
                        <div class="col col-md-4 select" style="display: none;" id="hcpn">

                            <select type="text" class="form-control hcpn-select" id="select2">
                                <option value="">SELECT HCPN</option>
                                <option value="">ALL</option>
                                @if ($HCPN == null)
                                    <option></option>
                                @else
                                    @foreach ($HCPN as $hcpn)
                                        <option value="{{ $hcpn['controlnumber'] }}">{{ $hcpn['mbname'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col col-md-4" style="display: none;" id="apex">

                            <select type="text" class="form-control" id="select3">
                                <option value="">SELECT APEX FACILITY</option>
                                <option value="">ALL</option>
                                @if ($Facilities == null)
                                    <option></option>
                                @else
                                            @if (session()->get('leveid') === 'PHIC')
                                                @foreach ($Facilities as $hcf)
                                                    @if ($hcf['type'] == "APEX")
                                                        <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                                                    @endif
                                                @endforeach
                                            @elseif (session()->get('leveid') === 'PRO')
                                                @foreach ($APEXFacilities as $hcf)
                                                    @if ($hcf['type'] === "APEX")
                                                        <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col col-md-4" id="nonapex">

                                        <select type="text" class="form-control" id="select">
                                            <option value="">SELECT NON APEX FACILITY</option>
                                            <option value="">ALL</option>
                                            @foreach ($Facilities as $hcf)
                                                @if ($hcf['type'] != "APEX")
                                                    <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                                                @endif
                                            @endforeach
                                @endif                              </select>

                        </div>
                        <div class="col col-md-4">

                            <select class="form-control hcpn-contract" id="contract" required>
                                <option value="">SELECT CONTRACT</option>
                            </select>

                        </div>
<input type="text" name="controlnumber" id="selectedHCF-HCPN" class="d-none" required>
                        <input type="text" name="controlnumber" id="selectedValueInput" class="d-none" required>
                        <input type="text" name="conidnumber" id="selectedContract" class="d-none" required>
                        </br>
                        <div class="col col-md-1" style="margin-top: -20px">
                            </br>
                            <button class="btn-sm btn-outline-success" type="button"
                                onclick="setControlNumberAndRedirect()">Generate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @elseif (session()->get('leveid') === 'HCPN')
    <div class="col col-md-12">
                    <div class="form-row">
                        <div class="col col-md-3">
                            <form>
                                @csrf

                               <input type="text" class="form-control" value="FACILITIES" readonly>
                        </div>
                  
                       
                                    <div class="col col-md-4" id="nonapex">

                                        <select type="text" class="form-control" id="select">
                                            <option value="">SELECT NON APEX FACILITY</option>
                                            <option value="">ALL</option>
                                            @foreach ($Facilities as $hcf)
                                                @if ($hcf['type'] != "APEX")
                                                    <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                                                @endif
                                            @endforeach
                                                          </select>

                        </div>
                        <div class="col col-md-4">

                            <select class="form-control hcpn-contract" id="contract" required>
                                <option value="">SELECT CONTRACT</option>
                            </select>

                        </div>
<input type="text" name="controlnumber" id="selectedHCF-HCPN" class="d-none" required>
                        <input type="text" name="controlnumber" id="selectedValueInput" class="d-none" required>
                        <input type="text" name="conidnumber" id="selectedContract" class="d-none" required>
                        </br>
                        <div class="col col-md-1" style="margin-top: -20px">
                            </br>
                            <button class="btn-sm btn-outline-success" type="button"
                                onclick="setControlNumberAndRedirect()">Generate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

<div class="card shadow mt-2">
    <div class="card-body">
                @if ($SelectedHCFHCPN != "0")
                    <span class="text-primary font-weight-bold ml-2 mt-1" style="font-size: 17px;">{{ $SelectedHCFHCPN }}</span>
                @else
                    <span class="text-secondary font-weight-bold ml-2 mt-1" style="font-size: 17px;">NO SELECTED HCF/HCPN</span>
                @endif
        <div class="card shadow mt-2">
            <div class="card-body" style="margin-top: -27px">
           
                <div class="table-responsive-sm"
                    style="overflow-y:auto; min-height:320px;max-height: 320px;margin-top:25px; margin-bottom: 10px; font-size: 10px;">
            
<div class="col-md-3 mb-2" style="float:right;">
                    <select class="form-control">
                        <option>Daily</option>
                        <option>Weekly</option>
                        <option>Monthly</option>
                    </select>
</div>
                    <table class="table table-sm table-hover table-bordered mt-1" id="tablemanager" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">Transaction Date</th>
                                <th class="text-center disableSort">Particulars</th>
                                <th class="text-center disableSort">Total Claims</th>
                                <th class="text-center disableSort">Receipt Number</th>
                                <th class="text-center disableSort">Account</th>
                                <th class="text-center disableSort">Credit</th>
                                <th class="text-center disableSort">Debit</th>
                                <th class="text-center disableSort"> Running Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @if($Ledger == null)
                                    <td>NO DATA FOUND</td>
                                @else

                                        @foreach ($Ledger as $ledger)
                                            <tr>
                                                <td class="text-center">{{ $ledger['datetime']}}</td>
                                                <td class="text-center">{{ $ledger['particular'] }}</td>
                                                @if ($ledger['totalclaims'] == null)
                                                    <td class="text-center"><span class="text-secondary font-weight-bold"
                                                            style="font-size: 11px;">N/A</span></td>
                                                @else
                                                    <td class="text-center">{{ $ledger['totalclaims'] }}</td>
                                                @endif
                                                <td class="text-center">{{ $ledger['voucher'] }}</td>
                                                <td class="text-center">{{ $ledger['account'] }}</td>
                                                <td class="text-center text-success font-weight-bold">&#8369;
                                                    {{ number_format((double) $ledger['credit'], 2)}}
                                                </td>
                                                <td class="text-center text-danger font-weight-bold">&#8369;
                                                    {{ number_format((double) $ledger['debit'], 2)}}
                                                </td>
                                                <td class="text-center text-primary font-weight-bold">&#8369;
                                                    {{ number_format((double) $ledger['balance'], 2)}}
                                                </td>
                                            </tr>
                                        @endforeach
                                @endif
                            </tr>
                        </tbody>
                    </table>
<center>
                    <div class="mt-2">
                        <button class="btn-sm btn btn-outline-primary mr-1" onclick="exportTableToExcel('tablemanager', 'members-data')"><i
                                class="fas fa-fw fa-download"></i>&nbsp;Export</button><button
                            class="btn-sm btn btn-outline-warning"><i class="fas fa-fw fa-print"></i>&nbsp;Print</button>
                    </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function exportTableToExcel(tableID, filename = '') {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Specify file name
            filename = filename ? filename + '.xls' : 'excel_data.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }
        }
</script>
<script>
    var hcpnSelect = document.querySelector('.hcpn-select');
    var contractSelect = document.querySelector('.hcpn-contract');

    var contracts = {!! json_encode($HCPNContract) !!};
    function updateContractOptions() {
        var selectedHCPN = hcpnSelect.value;
        contractSelect.innerHTML = '<option value="">SELECT CONTRACT</option>';
        contracts.forEach(function (contract) {
            var mb = JSON.parse(contract.hcfid);
            if (mb.controlnumber === selectedHCPN) {
                var option = document.createElement('option');
                option.value = contract.conid;
                option.textContent = contract.transcode;
                contractSelect.appendChild(option);
            }
        });


    }

    updateContractOptions();

    hcpnSelect.addEventListener('change', updateContractOptions);
    contractSelect.addEventListener('change', updateCoverage);


</script>

<script>

    document.getElementById("selectType").addEventListener("change", function () {
        var selectType = this.value;
        var Hcpn = document.getElementById("hcpn");
        var nonApex = document.getElementById("nonapex");
        var Apex = document.getElementById("apex");
        var ApexSelect = document.getElementById("select3");
        var nonApexSelect = document.getElementById("select");
        var HcpnSelect = document.getElementById("select2");

        HcpnSelect.removeAttribute("required");
        nonApexSelect.removeAttribute("required");
        ApexSelect.removeAttribute("required");

        if (selectType === "HCPN") {
            Hcpn.style.display = "block";
            HcpnSelect.setAttribute("required", "required");
            nonApex.style.display = "none";
            Apex.style.display = "none";
        } else if (selectType === "APEX") {
            Hcpn.style.display = "none";
            nonApex.style.display = "none";
            Apex.style.display = "block";
            ApexSelect.setAttribute("required", "required");
        } else {
            Hcpn.style.display = "none";
            nonApex.style.display = "block";
            nonApexSelect.setAttribute("required", "required");
            Apex.style.display = "none";
        }
    });

    document.getElementById("select3").addEventListener("change", function () {
        var select = document.getElementById("select3");
        var selectedOption = select.options[select.selectedIndex];
        document.getElementById("selectedValueInput").value = selectedOption.value;
    });
    document.getElementById("select2").addEventListener("change", function () {
        var select = document.getElementById("select2");
        var selectedOption = select.options[select.selectedIndex];
        document.getElementById("selectedValueInput").value = selectedOption.value;
    });
    document.getElementById("select").addEventListener("change", function () {
        var select = document.getElementById("select");
        var selectedOption = select.options[select.selectedIndex];
        document.getElementById("selectedValueInput").value = selectedOption.value;
    });
    document.getElementById("contract").addEventListener("change", function () {
        var select = document.getElementById("contract");
        var selectedOption = select.options[select.selectedIndex];
        document.getElementById("selectedContract").value = selectedOption.value;
    });

   document.getElementById("select3").addEventListener("change", function () {
        var select = document.getElementById("select3");
        var selectedOption = select.options[select.selectedIndex];
        document.getElementById("selectedHCF-HCPN").value = selectedOption.textContent;
    });
    document.getElementById("select2").addEventListener("change", function () {
        var select = document.getElementById("select2");
        var selectedOption = select.options[select.selectedIndex];
        document.getElementById("selectedHCF-HCPN").value = selectedOption.textContent;
    });
    document.getElementById("select").addEventListener("change", function () {
        var select = document.getElementById("select");
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
        localStorage.setItem("controlNumber", controlNumber);
        localStorage.setItem("conID", conID);
        window.location.href = "/Reports/GeneralLedger?controlNumber=" + controlNumber + "&conID=" + conID + "&hcfHCPN=" + hcfHCPN;
    }
</script>

@endsection