@extends('layouts.app')

@section('contents')

<div class="container-fluid">
    <!-- REGIONAL OFFICE TABLE -->
    <div class="col-md">
        <div class="card shadow mb-4">
            <div class="card-body bg-gradient-light">
                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="tablemanager">
                    <div style="position:absolute; top:13px; right:460px">
                        <input type="text" class="form-control" id="searchInput">
                    </div>
                    <table class="table table-sm table-hover table-bordered" width="100%" cellspacing="0">
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <thead>
                            <tr>
                                <th>Regional Offices</th>
                                <th class="text-center">PRO Code</th>
                                <th class="text-center disableSort disableFilterBy">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($RegionalOffices == null)
                                <tr>
                                    <span>No Data Found</span>
                                </tr>
                            @else
                                @foreach($RegionalOffices as $pro)
                                    <tr>
                                        <td class="d-none">{{ $pro['proid'] }}</td>
                                        <td>{{ $pro['proname'] }}</td>
                                        <td class="text-center">{{ $pro['procode'] }}</td>
                                        <td class="text-center" style="width:50px;">
                                            <center><button class="btn-sm btn-outline-primary"
                                                    onclick="DisplayMbDetails('<?=$pro['procode']?>','<?=$pro['proname']?>')">View</button>
                                            </center>
                                        </td>
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

<script>
    function DisplayMbDetails(proid, proname) {
        localStorage.setItem('getProId', proid);
        localStorage.setItem('getProName', proname);
        window.location.href = "/proaccess?proid=" + proid + "&proname=" + proname;
    }
</script>

@endsection