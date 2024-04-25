@extends('layouts.app')
@section('contents')
<div id="content">
  <div class="container-fluid" >

    <div class="row">
        <div class="col col-md-5 container bg-light p-3 border border-info rounded">
            <h4 class="text-center">HCPN Ledger</h4><br>
       <form id="hcpnledgerform">
    <div class="form-row">
        <div class="col col-md-4 mt-2">
            <label for="hcpn">HCPN</label>
        </div>
        <div class="col col-md-8">
            <select class="form-control hcpn-select" id="hcpn" required>
                <option value="">SELECT NETWORK</option>
                <!-- Iterate over $MBUnderPro array to generate options -->
                @foreach ($MBUnderPro as $hcpn)
                    <option value="{{ $hcpn['controlnumber'] }}">{{ $hcpn['mbname'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>
    <div class="form-row">
        <div class="col col-md-4 mt-2">
            <label for="contract">Contract Number</label>
        </div>
        <div class="col col-md-8">
            <select class="form-control contract-select" id="contract" required>
                <option value="">SELECT CONTRACT</option>
                <!-- Options will be dynamically populated based on selection in HCPN -->
            </select>
        </div>
    </div>
    <br>
    <div class="text-center">
        <button class="btn btn-info" type="submit">View</button>
    </div>
</form>

<script>
    // Get references to select elements
    var hcpnSelect = document.querySelector('.hcpn-select');
    var contractSelect = document.querySelector('.contract-select');

    // Define JavaScript object with contract data
    var contracts = {!! json_encode($HCPNContract) !!};

    // Function to update contract options based on selected HCPN
    function updateContractOptions() {
        var selectedHCPN = hcpnSelect.value;
        // Clear existing options
        contractSelect.innerHTML = '<option value="">SELECT CONTRACT</option>';
        // Iterate over contracts data and add options that meet the condition
        contracts.forEach(function(contract) {
            var mb = JSON.parse(contract.hcfid);
            if (mb.controlnumber === selectedHCPN) {
                var option = document.createElement('option');
                option.value = contract.conid;
                option.textContent = contract.transcode;
                contractSelect.appendChild(option);
            }
        });
    }

    // Call updateContractOptions initially to set up the initial state
    updateContractOptions();

    // Attach event listener to HCPN select element to trigger updateContractOptions when selection changes
    hcpnSelect.addEventListener('change', updateContractOptions);
</script>

        </div>

            <!-- NONAPEX LEDGER FORM -->
            <div class="col col-md-6 container bg-light p-3 border border-info rounded">
            <h4 class="text-center">Facility Ledger</h4><br>
       
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
            @foreach ($HCFUnderPro as $hcf)
                <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col col-md-8" id="apex" style="display: none;">
         <select type="text" class="form-control" id="select3" required>
                        <option value="">SELECT FACILITY</option>
            @foreach ($HCFapex as $apex)
                @if ($apex['type'] == "APEX")
                    <option value="{{ $apex['hcfcode'] }}">{{ $apex['hcfname'] }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>

</br>

            <div class="form-row">
                <div class="col col-md-4 mt-2">
                    <label>Contract Number</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" class="form-control" required>
                </div>
            </div>
</br>
            <div class="text-center">
                <button class="btn btn-info">View</button>
            </div>
        </div>

        
    </div>

  </div>
</div>
<script>
    document.getElementById('selectType').addEventListener('change', function() {
        var selectedValue = this.value;
        if (selectedValue === 'NONAPEX') {
            document.getElementById('nonapex').style.display = 'block';
            document.getElementById('apex').style.display = 'none';
        } else if (selectedValue === 'APEX') {
            document.getElementById('nonapex').style.display = 'none';
            document.getElementById('apex').style.display = 'block';
        }
    });
</script>

<script>
    function redirectToHCPNLedger() {
        // Get the selected contract and HCPN values
        var selectedContract = document.querySelector('.contract-select').value;
        var selectedHCPN = document.querySelector('.hcpn-select').value;

        // Redirect to the new page with selected values as parameters
        window.location.href = "/ledger/hcpn?conid=" + selectedContract + "&controlnumber=" + selectedHCPN;
    }

    // Add event listener to specific form submit event
    document.getElementById('hcpnledgerform').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        redirectToHCPNLedger(); // Call the function to redirect
    });
</script>




@endsection