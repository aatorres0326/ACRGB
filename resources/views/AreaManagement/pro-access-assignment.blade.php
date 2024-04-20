@extends('layouts.app')


@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-md">

            <h4 class="text-center text-white">{{ $SelectedProName }}</h4>
        </div>
    </div>
    </br>
   


    <!-- ADDED TABLE -->
    <div class="row">
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="text-success" style="position:absolute; left:20px; top:13px;">ENABLED ACCESS PERMISSION
                    </h5>
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;"
                        id="content">
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div style="position:absolute; top:13px; right:20px" class="{{ session()->get('leveid') === 'ADMIN' ? 'd-none' : '' }}">
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-access" style="text-decoration:
                        none;"><i class="fas fa-plus fa-sm"></i> Add Access
                                </button> <button class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#remove-access" style="text-decoration:
                        none;"><i class="fas fa-minus fa-sm"></i> Remove Access
                                </button>
                            </div>

                            <thead>
                                <tr>
                                    <th class="d-none"></th>
                                    <th>Health Care Provider Networks</th>
                                    <th class="text-center">Accreditation</th>
                                    <th class="text-center {{ session()->get('leveid') === 'ADMIN' ? 'd-none' : ''}} {{ session()->get('leveid') === 'PHIC' ? 'd-none' : ''}}">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                 @if ($HCFUnderPro === null)
                            <tr><td class="text-center">NO DATA FOUND</td></tr>
                             @else
                                @foreach($HCFUnderPro as $mb)
  
                           
                           
                                <tr>
                              
                                    <td>{{ $mb['mbname'] }}</td>
                                     <td class="text-center">{{ $mb['controlnumber'] }}</td>
                                   
                                </tr>
                           
                                @endforeach
                                    @endif
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<!-- ADD ACCESS MODAL ****************************************************************************************************************************************** -->
<div class="modal" id="add-access">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-info text-white"> <h5 >ADD ACCESS PERMISSION</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="overflow-y:auto; ">
                <div class="col-md-">

                    <form action="" method="POST">
                        @csrf
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                    <h6><span> Add access to </span><span class="text-primary">{{ $SelectedProName }}</span></h6>
                                <div class="table-responsive-sm"
                                    style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size; 10px;">
                                    
                                    <table class="table table-sm table-hover table-bordered table-striped table-light"
                                        width="100%" cellspacing="0">

                                
                                        <thead>
                                            <tr>
                                                
                                                <th>Health Care Provider Networks</th>
                                                <th class="text-center">Accreditation</th>
                                                <th class="disableSort disableFilterBy text-center">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="protable">
                                            @foreach($ManagingBoard as $mb)
                                            @php
    $roleIndexData = $RoleIndex->where(
        'accessid',
        $mb['controlnumber']
    )->where('userid', $SelectedProID)->first();
                                            @endphp
                                            @if(!$roleIndexData)
                                            <tr>
                                                <td type="text" class="d-none" name="mbid" id="mbid">{{
            $mb['controlnumber'] }}</td>
                                                <td>{{ $mb['mbname'] }}</td>
                                                <td class="text-center">{{ $mb['controlnumber'] }}</td>
                                                <td class="text-center">
                                                    <center><input class="form-control"
                                                            style="width: 16px; height: 16px;" type="checkbox"
                                                            id="addaccesbox" value=""
                                                            data-mbid="{{ $mb['controlnumber'] }}">
                                                        <center>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>




                                    </table>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center" id="pagination"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                        <input type="text" class="d-none" name="proid" value="{{ $SelectedProID }}" />
                        <input type="text" class="d-none" name="proname" value="{{ $SelectedProName }}" />

                        <textarea id="accessid" class="d-none" required></textarea>
                        
                        </div>
                    </form>
                    <div class="mt-5 text-center"><button id="openAddAccessModal" style="margin-top:-50px;" class="btn btn-info" data-toggle="modal" data-target="#addaccess" >Add</button>
                            <button type="button" style="margin-top:-50px;" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




    <div class="modal" id="addaccess">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-info text-white">
                    <h6 class="modal-title">ADD ACCESS TO SELECTED NETWORKS</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    
                    <form action="{{ route('INSERTROLEINDEXPRO') }}" method="POST">
                        @csrf
                        <h5 class="text-center">{{ $SelectedProName }}</h5>
                        <div class="card bg-light text-dark" style="color:black; max-height: 250px; overflow-y:scroll; overflow-x:hidden;">
                                                </br>                      
                         @foreach($ManagingBoard as $mb)
                       <h6 id="confirmsubmission"><span class="col-md-8">{{$mb['mbname']}}</span><span class="col-md-4 text-center controlnumber" style="float:right">{{$mb['controlnumber']}}</span></h6>
                       @endforeach
                                                </br>
                                                </div>

                       <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                        <input type="text" class="d-none" name="proid" value="{{ $SelectedProID }}" />
                        <textarea id="confirmaccessid" class="d-none" name="accessid" required></textarea>
                        <input type="text" class="d-none" name="proname" value="{{ $SelectedProName }}" />
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Save</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF ADD ACCESS MODAL *************************************************************************************************************************************************** -->
<!-- REMOVE ACCESS ***************************************************************************************************************************************************************** -->
<div class="modal" id="remove-access">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-warning text-white"> <h5 >REMOVE ACCESS PERMISSION</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="overflow-y:auto; ">
                <div class="col-md-">

                    <form action="" method="POST">
                       
                        @csrf
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                    <h6><span> Remove access from </span><span class="text-primary">{{ $SelectedProName }}</span></h6>
                                <div class="table-responsive-sm"
                                    style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size; 10px;">
                                    
                                    <table class="table table-sm table-hover table-bordered table-striped table-light"
                                        width="100%" cellspacing="0">

                                
                                        <thead>
                                            <tr>
                                                <th class="d-none"></th>
                                                <th>Health Care Provider Networks</th>
                                                <th class="text-center">Accreditation</th>
                                                <th class="text-center">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                 @if ($HCFUnderPro === null)
                            <tr><td class="text-center">NO DATA FOUND</td></tr>
                             @else
                                @foreach($HCFUnderPro as $mb)
  
                           
                           
                                <tr>
                              
                                    <td>{{ $mb['mbname'] }}</td>
                                     <td class="text-center">{{ $mb['controlnumber'] }}</td>
                                   
                         
                           
                               
                                                <td class="text-center">
                                                    <center><input class="form-control"
                                                            style="width: 16px; height: 16px;" type="checkbox"
                                                            id="addaccesbox" value=""
                                                            data-mbid="{{ $mb['controlnumber'] }}">
                                                        <center>
                                                </td>
                                            </tr>
                                              @endforeach
                                            @endif
                                          
                                        </tbody>




                                    </table>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center" id="pagination"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                        <input type="text" class="d-none" name="proid" value="{{ $SelectedProID }}" />
                        <input type="text" class="d-none" name="proname" value="{{ $SelectedProName }}" />

                        <textarea id="accessid" class="d-none" required></textarea>
                        
                        </div>
                    </form>
                    <div class="mt-5 text-center"><button id="openRemoveAccessModal" style="margin-top:-50px;" class="btn btn-warning" data-toggle="modal" data-target="#removeaccess" >Remove</button>
                            <button type="button" style="margin-top:-50px;" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




    <div class="modal" id="removeaccess">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-warning text-white">
                    <h6 class="modal-title">REMOVE ACCESS TO SELECTED NETWORKS</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    
                    <form action="{{ route('REMOVEROLEINDEXPRO') }}" method="POST">
                     @method('PUT')
                        @csrf
                        <h5 class="text-center">{{ $SelectedProName }}</h5>
                        <div class="card bg-light text-dark" style="color:black; max-height: 250px; overflow-y:scroll; overflow-x:hidden;">
                                                </br> 
                                                @if ($HCFUnderPro === null)    
                                                <h6> No Data Found </h6>
                                                @else                 
                         @foreach($HCFUnderPro as $mb)
                       <h6 id="confirmremovesubmission"><span class="col-md-8">{{$mb['mbname']}}</span><span class="col-md-4 text-center controlnumber" style="float:right">{{$mb['controlnumber']}}</span></h6>
                       @endforeach
                       @endif
                                                </br>
                                                </div>

                       <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}" />
                        <input type="text" class="d-none" name="proid" value="{{ $SelectedProID }}" />
                        <textarea id="confirmremoveaccessid" class="d-none" name="accessid" required></textarea>
                        <input type="text" class="d-none" name="proname" value="{{ $SelectedProName }}" />
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Save</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF REMOVE ACCESS MODAL ******************************************************************************************************************************************************************* -->

<script>
    var mbCheckboxes = document.querySelectorAll('input[type="checkbox"][data-mbid]');

    mbCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var mbid = this.getAttribute('data-mbid');
            var textarea = document.querySelector('#add-access #accessid');

            if (this.checked) {
                textarea.value += mbid + ', ';
            } else {
                textarea.value = textarea.value.replace(mbid + ', ', '');
            }
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  
    document.getElementById("openAddAccessModal").addEventListener("click", function() {
     
        var accessIdValue = document.getElementById("accessid").value;

        
        document.getElementById("confirmaccessid").value = accessIdValue;

       
        var h6Elements = document.querySelectorAll('#addaccess h6');

       
        h6Elements.forEach(function(element) {
          
            var controlNumberElement = element.querySelector('.text-center.controlnumber');
            if (controlNumberElement) {
            
                var controlNumber = controlNumberElement.innerText.trim();

        
                if (!accessIdValue.includes(controlNumber)) {
                
                    element.classList.add('d-none');
                } else {
                 
                    element.classList.remove('d-none');
                }
            }
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Add event listener to the "Add" button
    document.getElementById("openRemoveAccessModal").addEventListener("click", function() {
        // Retrieve the value of the textarea
        var accessIdValue = document.getElementById("accessid").value;

        // Set the value of the textarea in the modal with id "confirmaccessid"
        document.getElementById("confirmremoveaccessid").value = accessIdValue;

        // Get all h6 elements
        var h6Elements = document.querySelectorAll('#removeaccess h6');

        // Loop through each h6 element
        h6Elements.forEach(function(element) {
            // Check if the element contains the class "text-center" and "controlnumber"
            var controlNumberElement = element.querySelector('.text-center.controlnumber');
            if (controlNumberElement) {
                // Get the control number from the h6 element
                var controlNumber = controlNumberElement.innerText.trim();

                // Check if the control number exists in the accessIdValue
                if (!accessIdValue.includes(controlNumber)) {
                    // If it does not exist, hide the h6 element
                    element.classList.add('d-none');
                } else {
                    // If it exists, make sure the element is visible
                    element.classList.remove('d-none');
                }
            }
        });
    });
});
</script>



   




@endsection