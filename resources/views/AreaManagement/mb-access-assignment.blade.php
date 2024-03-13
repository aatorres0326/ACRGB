@extends('layouts.app')


@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-md">
       
            <h4 class="text-center">{{ $SelectedMbName }}</h4>
        </div>
    </div>
    </br>

    <!-- ADDED TABLE -->
    <div class="row">
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                   <h5 class="text-success" style="position:absolute; left:20px; top:13px;">ENABLED ACCESS PERMISSION</h5>
                    <div class="table-responsive-sm" style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px; font-size; 10px;" id="content">
                        <table class="table table-sm table-hover table-bordered table-light" width="100%" cellspacing="0">
             <div style="position:absolute; top:13px; right:20px">
                    <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-access" style="text-decoration:
                        none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Access
                    </a> <a class="btn btn-link btn-sm text-warning" data-toggle="modal" data-target="#add-user" style="text-decoration:
                        none;"><i class="fas fa-trash fa-sm text-info-40"></i> Remove Access
                    </a>
                </div>
           
                 <thead>
                                <tr>
                                    <th class="d-none"></th>
                                    <th>Regional Office</th>
                                    <th class="disableSort disableFilterBy text-center">Action
                                    </th>
                                </tr>
                            </thead>
            <tbody>
    @foreach($Facilities as $facility)
        @php
    $roleIndexData = $RoleIndex->where('accessid', $facility['hcfid'])->where('userid', $SelectedMbID)->first();
        @endphp
        @if($roleIndexData)
            <tr>
                <td class="d-none">{{ $roleIndexData['roleid'] }}</td>
                <td>{{ $facility['hcfname'] }}</td>
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" value="">
                </td>
            </tr>
        @endif
    @endforeach
</tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<!-- ADD ACCESS MODAL -->
<div class="modal" id="add-access">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" >
                <!-- Modal Header -->
               <div class="modal-header"
                <center><span>ADD ACCESS PERMISSION</span></center>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                    <div class="modal-body" style="overflow-y:auto; ">
                         <div class="col-md-">

                        <form action="{{ route('INSERTROLEINDEXMB') }}" method="POST">
                            @csrf
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive-sm" style="overflow-y:auto; max-height: 400px;margin-top:25px; margin-bottom: 10px; font-size; 10px;">
                                         <table class="table table-sm table-hover table-bordered table-striped table-light" width="100%" cellspacing="0">       

                        
                                            <thead>
                                                <tr>
                                                    <th class="d-none"></th>
                                                    <th>Facilities</th>
                                                    <th class="disableSort disableFilterBy text-center">Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="protable">
                                            @foreach($Facilities as $facility)
                                            @php
    $roleIndexData = $RoleIndex->where('accessid', $facility['hcfid'])->where('userid', $SelectedMbID)->first();
                                            @endphp
                                            @if(!$roleIndexData)
                                                <tr>
                                                    <td type="text" class="d-none" name="hcfid" id="hcfid">{{ $facility['hcfid'] }}</td>
                                                    <td>{{ $facility['hcfname'] }}</td>
                                                    <td class="text-center">
                                                    <center><input class="form-control" style="width: 16px; height: 16px;" type="checkbox"  id="addaccesbox" value="" data-hcfid="{{ $facility['hcfid'] }}"><center>
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
                            <input type="text" class="d-none" name="createdby" value="{{ session()->get('userid') }}"/>
                            <input type="text" class="d-none" name="mbid" value="{{ $SelectedMbID }}"/>
                             <input type="text" class="d-none" name="mbname" value="{{ $SelectedMbName }}"/>
                            
                            <textarea name="accessid" required></textarea>
                            <div class="mt-5 text-center"><button style="margin-top:-50px;" class="btn btn-primary" type="submit">Save</button>
                                <button type="button" style="margin-top:-50px;" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END OF ADD ACCESS MODAL -->

<script>
    var mbCheckboxes = document.querySelectorAll('input[type="checkbox"][data-hcfid]');

    mbCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var mbid = this.getAttribute('data-hcfid');
            var textarea = document.querySelector('#add-access textarea');
            
            if (this.checked) {
                textarea.value += mbid + ', ';
            } else {
                textarea.value = textarea.value.replace(mbid + ', ', '');
            }
        });
    });
</script> 

<script>
   window.onload = function() {

    var userid = localStorage.getItem('getMbId');
    var username = localStorage.getItem('getMbname');

    document.getElementById("putmbname").value = mbname;
    document.getElementById("putmbid").value = mbid;
    document.getElementById("inputmbid").value = mbid;

};

    </script>



@endsection