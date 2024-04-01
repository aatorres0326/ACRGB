@extends('layouts.app')


@section('contents')

<div class="container-fluid">


<!-- FOR ADMIN -->
<!-- ************************************************************************************************************************************************ -->
@if (session()->get('leveid') == 'PHIC')
        
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive-sm" style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Health Care Provider Networks</th>
                              
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
                    <div class="table-responsive-sm" style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content2">
                        
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Health care Provider Networks</th>
                              
                                    <th class="disableSort disableFilterBy">
                                    </th>
                                </tr>
                            </thead>
 

                           <tbody>
@foreach ($HCFUnderPro as $MB)
       
            <tr>
                <td class="d-none">{{ $MB['mbid'] }}</td>
                <td>{{ $MB['mbname'] }}</td>
                <td style="width:50px;">
                    <center>
                        <button class="btn btn-sm btn-link text-darker-primary" onclick="DisplayMbDetails('{{$MB['mbid']}}', '{{$MB['mbname']}}')">
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