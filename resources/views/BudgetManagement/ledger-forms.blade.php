@extends('layouts.app')
@section('contents')
<div id="content">
  <div class="container-fluid" >

    <div class="row">
        <div class="col col-md-5 container bg-light p-3 border border-info rounded">
            <h4 class="text-center">HCPN Ledger</h4><br>
       
            <div class="form-row">
                <div class="col col-md-3 mt-2">
                    <label>HCPN</label>
                </div>
                <div class="col col-md-9">
                    <select type="text" class="form-control" id="select">
                        @foreach ($MBUnderPro as $hcpn)
                        <option value="{{ $hcpn['controlnumber']}}">{{ $hcpn['mbname']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
           <br>
            <h5>Select Date Range</h5>
            <form>
                <div class="form-row">
                    <div class="col col-md-3 mt-2">
                        <label>Date From</label>
                    </div>
                    <div class="col col-md-9">
                        <input type="text" class="form-control" id="formattedDate"  style="position:absolute; width:85%; z-index:1;" required readonly>
                        <input type="date" class="form-control" style="position:absolute; width:97%;"id="datePicker" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col col-md-3 mt-2">
                        <label>Date To</label>
                    </div>
                    <div class="col col-md-9">
                         <input type="text" class="form-control" id="formattedDate2"  style="position:absolute; width:85%; z-index:1;" required readonly>
                        <input type="date" class="form-control" style="position:absolute; width:97%;"id="datePicker2" required>
                </div>
            </div>
            </form>
            </br>
            <div class="text-center">
                <button class="btn btn-info">View</button>
            </div>
        </div>
            <!-- NONAPEX LEDGER FORM -->
            <div class="col col-md-6 container bg-light p-3 border border-info rounded">
            <h4 class="text-center">Facility Ledger</h4><br>
       
        <div class="form-row">
    <div class="col col-md-3">
        <select class="form-control" id="selectType">
            <option value="NONAPEX">NON APEX</option>
            <option value="APEX">APEX</option>
        </select>
    </div>
    <div class="col col-md-9" id="nonapex">
        <select class="form-control" id="nonapexSelect">
            @foreach ($HCFUnderPro as $hcf)
                <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col col-md-9" id="apex" style="display: none;">
        <select class="form-control" id="apexSelect">
            @foreach ($HCFapex as $apex)
                @if ($apex['type'] == "APEX")
                    <option value="{{ $apex['hcfcode'] }}">{{ $apex['hcfname'] }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>



           <br>
            <h5>Select Date Range</h5>
            <form>
                <div class="form-row">
                    <div class="col col-md-3 mt-2">
                        <label>Date From</label>
                    </div>
                    <div class="col col-md-9">
                        <input type="text" class="form-control" id="formattedDate"  style="position:absolute; width:85%; z-index:1;" required readonly>
                        <input type="date" class="form-control" style="position:absolute; width:97%;"id="datePicker" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col col-md-3 mt-2">
                        <label>Date To</label>
                    </div>
                    <div class="col col-md-9">
                         <input type="text" class="form-control" id="formattedDate2"  style="position:absolute; width:85%; z-index:1;" required readonly>
                        <input type="date" class="form-control" style="position:absolute; width:97%;"id="datePicker2" required>
                </div>
            </div>
            </form>
            </br>
            <div class="text-center">
                <button class="btn btn-info">View</button>
            </div>
        </div>

        
    </div>

  </div>
</div>

<div class="modal" id="confirmdatesetting">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">CONFIRMATION</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('INSERTManagingBoard') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="proname">DATE SETTINGS WILL BE CHANGED INTO :</label>
                                <div class="form-row">
                                    <div class="col col-md-6">
                                        <label>Date From</label>
                                        <input type="text" class="form-control" name="cdatefrom" id="cdatefrom" readonly>
                                    </div>
                                    <div class="col col-md-6">
                                        <label>Date To</label>
                                        <input type="text" class="form-control" name="cdateto" id="cdateto" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md d-none">

                                <input type="text" class="form-control d-none" name="createdby" 
                                    value="{{ session()->get('userid')}}">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>

<script>
  function setupDatePicker(datePickerId, formattedDateInputId) {
    const datePicker = document.getElementById(datePickerId);
    const formattedDateInput = document.getElementById(formattedDateInputId);

    datePicker.addEventListener('change', function() {
      const selectedDate = new Date(this.value);
      const month = selectedDate.toLocaleString('default', { month: 'long' });
      const day = selectedDate.getDate();
      const year = selectedDate.getFullYear();
      formattedDateInput.value = `${month} ${day}, ${year}`;
    });
  }

  // Set up date pickers
  setupDatePicker('datePicker', 'formattedDate');
  setupDatePicker('datePicker2', 'formattedDate2');
  setupDatePicker('datePicker3', 'formattedDate3');
  setupDatePicker('datePicker4', 'formattedDate4');
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  
    document.getElementById("DateSettingConfirm").addEventListener("click", function() {
     
        var accessIdValue = document.getElementById("formattedDate").value;
        document.getElementById("cdatefrom").value = accessIdValue;

        var accessIdValue = document.getElementById("formattedDate2").value;
        document.getElementById("cdateto").value = accessIdValue;

       
    });
});
</script>
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


@endsection