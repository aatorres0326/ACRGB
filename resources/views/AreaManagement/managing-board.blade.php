@extends('layouts.app')


@section('contents')

<div class="container-fluid">

<!-- ADD REGIONAL OFFICE MODAL-->
<div class="modal" id="add-pro">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD AREA TYPE</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('INSERTManagingBoard') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="proname">Area Type</label>
                                <input type="text" class="form-control" name="mbname" required>
                            </div>
                            <div class="form-group col-md d-none">

                                <input type="text" class="form-control d-none" name="createdby" 
                                    value="{{ session()->get('userid')}}">
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
<!-- END OF ADD REGIONAL OFFICE MODAL -->

<!-- FOR ADMIN -->
<!-- ************************************************************************************************************************************************ -->
@if (session()->get('leveid') == 'ADMIN')
        <!-- REGIONAL OFFICE TABLE -->
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        <div style="position:absolute; top:13px;">
                            <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-pro" style="text-decoration:
                                none;"><i class="fas fa-plus fa-sm text-info-40"></i> Add Managing Board
                            </a>
                        </div>
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Managing Board</th>
                              
                                    <th class="disableSort disableFilterBy">
                                    </th>
                                </tr>
                            </thead>
 

                            <tbody>
                                @foreach($ManagingBoard as $MB)
                                <tr>
                                    <td class="d-none">{{ $MB['mbid'] }}</td>
                                    <td>{{ $MB['mbname'] }}</td>
                                 
                                    <td style="width:50px;">
                                        <center><button class="btn btn-sm btn-link text-darker-primary" onclick="DisplayMbDetails(
                                                    '<?=$MB['mbid']?>',
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
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Managing Board</th>
                              
                                    <th class="disableSort disableFilterBy">
                                    </th>
                                </tr>
                            </thead>
 

                           <tbody>
@foreach(collect($HCFUnderPro)->unique('mb.mbid') as $MB)
       @php
        $mb = json_decode($MB['mb']);
        @endphp
            <tr>
                <td class="d-none">{{ $mb->mbid }}</td>
                <td>{{ $mb->mbname }}</td>
                <td style="width:50px;">
                    <center>
                        <button class="btn btn-sm btn-link text-darker-primary" onclick="DisplayMbDetails('{{$mb->mbid}}', '{{$mb->mbname}}')">
                            <i class="fas fa-fw fa-eye" data-toggle="tooltip" title="View"></i>
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

  <script>
function DisplayMbDetails(mbid, mbname) {
    // Storing user details in localStorage
    localStorage.setItem('getMbId', mbid);
    localStorage.setItem('getMbname', mbname);
    
    // Redirecting to the new page
      window.location.href = "/mbaccess?mbid=" + mbid + "&mbname=" + mbname;
}
  </script>



@endsection