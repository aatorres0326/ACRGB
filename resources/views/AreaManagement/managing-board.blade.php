@extends('layouts.app')


@section('contents')

<div class="container-fluid">


<!-- FOR PHIC -->
<!-- ************************************************************************************************************************************************ -->
@if (session()->get('leveid') == 'PHIC')
        
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive-sm" style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        <table class="table table-sm table-hover table-bordered table-light" id="tablemanager"width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Health Care Provider Networks</th>
                                    <th class="text-center disableSort">Accreditation</th>
                                    <th class="text-center disableSort">Regional Office</th>
                                    <th class="text-center disableSort">License Validity</th>
                                    

                              
                                    <th class="disableSort disableFilterBy">
                                    </th>
                                </tr>
                            </thead>
 

                            <tbody>
                                @foreach($ManagingBoard as $MB)
                                <tr>
                                    <td class="d-none">{{ $MB['mbid'] }}</td>
                                    <td>{{ $MB['mbname'] }}</td>
                                    <td class="text-center">{{ $MB['controlnumber'] }}</td>
                                    <td class="text-center">{{ $MB['pro'] }}</td>
                                    <td class="text-center">{{ DateTime::createFromFormat('m-d-Y', $MB['licensedatefrom'])->format('F j, Y') }} to {{ DateTime::createFromFormat('m-d-Y', $MB['licensedateto'])->format('F j, Y') }}</td>
                                    
                                    
                                 
                                    <td style="width:50px;">
                                        <center><button class="btn btn-sm btn-success" onclick="DisplayMbDetails(
                                                    '<?=$MB['controlnumber']?>',
                                                     '<?=$MB['mbname']?>'                                                  
                                 )"><i class="fas fa-fw fa-eye" data-toggle="tooltip" title="View"></i></button></center>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

<!-- FOR PRO USER -->
<!-- ************************************************************************************************************************************************ -->
      @else
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive-sm" style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        <div style="position:absolute; top:13px; right:550px">
                            <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-hcpn" style="text-decoration:
                                none; "><i class="fas fa-plus fa-sm text-info-40"></i> Add Health Care Provider Network
                            </a>
                        </div>
                        <table class="table table-sm table-hover table-bordered table-light" id="tablemanager" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Health care Provider Networks</th>
                                    <th class="text-center disableSort">Accreditation</th>
                                    <th class="text-center disableSort">License Validity</th>
                                    <th class="disableSort disableFilterBy">
                                    </th>
                                </tr>
                            </thead>
 

                           <tbody>
@foreach ($HCFUnderPro as $MB)
       
            <tr>
                <td class="d-none">{{ $MB['mbid'] }}</td>
                <td>{{ $MB['mbname'] }}</td>
                 <td class="text-center">{{ $MB['controlnumber'] }}</td>
                                    <td class="text-center">{{ DateTime::createFromFormat('m-d-Y', $MB['licensedatefrom'])->format('F j, Y') }} to {{ DateTime::createFromFormat('m-d-Y', $MB['licensedateto'])->format('F j, Y') }}</td>
                <td style="width:50px;">
                    <center>
                        <button class="btn btn-sm btn-success text-darker-primary"  data-toggle="tooltip" title="View" onclick="DisplayMbDetails('{{$MB['controlnumber']}}', '{{$MB['mbname']}}')">
                            <i class="fas fa-fw fa-eye"></i>
                        </button>
                    </center>
                </td>
            </tr>
       
    @endforeach
</tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
        @endif

    </div>

</div>
@if (session()->get('leveid') == 'PRO')
<div class="modal" id="add-hcpn">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD HEALTHCARE PROVIDER NETWORK</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('INSERTManagingBoard') }}" method="POST" class=" p-2">
                        @csrf
                         <input type="text" class="form-control d-none" name="createdby" 
                                    value="{{ session()->get('userid')}}">
                         <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>HCPN</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" name="mbname"class="form-control" placeholder="Enter Netwrok Name" required>

                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>Accreditation</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" name="accreditation" class="form-control" placeholder="Enter Accreditation #" required>

                            </div>
                        </div>
                        <h6 class="mt-3 mb-3">ACCREDITATION VALIDITY</h6>
                         <div class="form-row mb-2">
                            <div class="col col-md-3 mt-2">
                                <label>Date From</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" class="form-control" id="formattedDate5"  style="position:absolute; width:85%; z-index:1;" readonly required>
                                <input type="date" class="form-control" name="licensedatefrom" style="position:absolute; width:97%;"id="datePicker5" required>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                             <div class="col col-md-3 mt-2">
                                <label>Date To</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" class="form-control" id="formattedDate6"  style="position:absolute; width:85%; z-index:1;" readonly required>
                                <input type="date" class="form-control" name="licensedateto" style="position:absolute; width:97%;"id="datePicker6" required>
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
    @endif
  <script>
function DisplayMbDetails(mbid, mbname) {
    // Storing user details in localStorage
    localStorage.setItem('getMbId', mbid);
    localStorage.setItem('getMbname', mbname);
    
    // Redirecting to the new page
      window.location.href = "/mbaccess?mbid=" + mbid + "&mbname=" + mbname;
}
  </script>
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

    setupDatePicker('datePicker5', 'formattedDate5');
      setupDatePicker('datePicker6', 'formattedDate6');
</script>


@endsection