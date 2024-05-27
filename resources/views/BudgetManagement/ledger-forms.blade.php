@extends('layouts.app')
@section('contents')
<div id="content">
    <div class="container-fluid">
        @if ($HCFUnderPro == null)
            <h4 class="text-center">NO ASSIGNED ACCESS</h4>
        @else
                <div class="row">
                    <!-- HCPN LEDGER FORM -->
                    <div class="col col-md-5 container bg-light p-3 border border-info rounded">
                        <h5 class="text-center">HCPN Ledger</h5><br>
                        <form id="hcpnledgerform">
                            <div class="form-row">
                                <div class="col col-md-4 mt-2">
                                    <label for="hcpn">HCPN</label>
                                </div>
                                <div class="col col-md-8">
                                    <select class="form-control hcpn-select" id="hcpn" required>
                                        <option class="ml-2" value="">&nbsp;&nbsp;SELECT NETWORK</option>
                                        @if ($MBUnderPro == null)
                                            <option></option>
                                        @else
                                            @foreach ($MBUnderPro as $hcpn)
                                                <option value="{{ $hcpn['controlnumber'] }}">{{ $hcpn['mbname'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col col-md-4 mt-2">
                                    <label for="contract">Reference Number</label>
                                </div>
                                <div class="col col-md-8">
                                    <select class="form-control contract-select" id="contract" required>
                                        <option value="">SELECT CONTRACT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col col-md-4 mt-2">
                                    <label for="contract">Contract Coverage</label>
                                </div>
                                <div class="col col-md-8">
                                    <input id="coverage" class="form-control" readonly>
                                </div>
                            </div>
                            <br>
                            <div class="text-center">
                                <button class="btn btn-outline-info" type="submit">View</button>
                            </div>
                        </form>
                    </div>

                    <!-- FACILITY LEDGER FORM -->
                    <div class="col col-md-6 container bg-light p-3 border border-info rounded">
                        <h5 class="text-center">Facility Ledger</h5><br>
                        <div class="form-row">
                            <div class="col col-md-4">
                                <select class="form-control" id="selectType">
                                    <option value="NONAPEX">NON APEX</option>
                                    <option value="APEX">APEX</option>
                                </select>
                            </div>
                            <div class="col col-md-8" id="nonapex">
                                <select type="text" class="form-control" id="select2" required>
                                    <option value="">SELECT FACILITY</option>
                                    @if ($HCFUnderPro == null)
                                        <option></option>
                                    @else
                                        @foreach ($HCFUnderPro as $hcf)
                                            <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col col-md-8" id="apex" style="display: none;">
                                <select type="text" class="form-control" id="select3" required>
                                    <option value="">SELECT FACILITY</option>
                                    @if ($HCFapex == null)
                                        <option></option>
                                    @else
                                        @foreach ($HCFapex as $apex)
                                            @if ($apex['type'] == "APEX")
                                                <option value="{{ $apex['hcfcode'] }}">{{ $apex['hcfname'] }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        </br>
                        <div class="form-row">
                            <div class="col col-md-4 mt-2">
                                <label>Reference Number</label>
                            </div>
                            <div class="col col-md-8">
                                <input type="text" class="form-control" required>
                            </div>
                        </div>
                        </br>
                        <div class="text-center">
                            <button class="btn btn-outline-info" type="submit">View</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
<script>
    var hcpnSelect = document.querySelector('.hcpn-select');
    var contractSelect = document.querySelector('.contract-select');
    var coverageInput = document.getElementById('coverage');
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

        updateCoverage();
    }

    function updateCoverage() {
        var selectedContractId = contractSelect.value;
        var selectedContract = contracts.find(function (contract) {
            return contract.conid === selectedContractId;
        });

        if (selectedContract) {
            var contractCoverage = JSON.parse(selectedContract.contractdate);
            var fromDate = new Date(contractCoverage.datefrom);
            var toDate = new Date(contractCoverage.dateto);
            var fromDateFormatted = fromDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            var toDateFormatted = toDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            var coverageText = `${fromDateFormatted} to ${toDateFormatted}`;
            coverageInput.value = coverageText;
        } else {
            coverageInput.value = '';
        }
    }

    updateContractOptions();

    hcpnSelect.addEventListener('change', updateContractOptions);
    contractSelect.addEventListener('change', updateCoverage);

    document.getElementById('selectType').addEventListener('change', function () {
        var selectedValue = this.value;
        if (selectedValue === 'NONAPEX') {
            document.getElementById('nonapex').style.display = 'block';
            document.getElementById('apex').style.display = 'none';
        } else if (selectedValue === 'APEX') {
            document.getElementById('nonapex').style.display = 'none';
            document.getElementById('apex').style.display = 'block';
        }
    });


    function redirectToHCPNLedger() {
        var selectedContract = document.querySelector('.contract-select').value;
        var selectedHCPN = document.querySelector('.hcpn-select').value;

        window.location.href = "/ledger/hcpn?conid=" + selectedContract + "&controlnumber=" + selectedHCPN;
    }

    document.getElementById('hcpnledgerform').addEventListener('submit', function (event) {
        event.preventDefault();
        redirectToHCPNLedger();
    });
</script>




@endsection