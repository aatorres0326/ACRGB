@extends('layouts.app')


@section('contents')

<div class="container-fluid">
        <!-- REGIONAL OFFICE TABLE -->
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive-sm"
                        style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="tablemanager">
                        
                        <table class="table table-sm table-hover table-bordered table-light" width="100%"
                            cellspacing="0">
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>

                                    <th>Regional Offices</th>
                                    <th class="text-center">PRO Code</th>
                                    


                                    <th class="disableSort disableFilterBy">
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($RegionalOffices as $pro)
                                <tr>

<td class="d-none">{{ $pro['proid'] }}</td>
                                    <td>{{ $pro['proname'] }}</td>
                                    <td class="text-center">{{ $pro['procode'] }}</td>

                              



                                  <td style="width:50px;">
                                        <center><button class="btn btn-sm btn-link text-darker-primary" onclick="DisplayMbDetails(
                                                    '<?=$pro['procode']?>',
                                                     '<?=$pro['proname']?>'                                                  
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
    </div>

</div>


  <script>
function DisplayMbDetails(proid, proname) {
    // Storing user details in localStorage
    localStorage.setItem('getProId', proid);
    localStorage.setItem('getProName', proname);
    
    // Redirecting to the new page
      window.location.href = "/proaccess?proid=" + proid + "&proname=" + proname;
}
  </script>




@endsection