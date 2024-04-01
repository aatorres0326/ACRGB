@extends('layouts.app')


@section('contents')

<div class="container-fluid">

    <!-- ADD USER MODAL -->
    <div class="modal" id="add-user">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">ADD FACILITY</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('addFacility') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="hciname">Facility</label>
                                <input type="text" class="form-control" name="hciname" placeholder="Facility Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="accreditation">Accreditation</label>
                                <input type="text" class="form-control" name="accreditation"
                                    placeholder="Accreditation #">

                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="userlevel">Area</label>
                                <select name="role" class="form-control">

                                    <option value="">PhilHealth Regional Office Area 1</option>
                                    <option value="">PhilHealth Regional Office NCR</option>

                                </select>
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



    <?php
$now = new DateTime();

$now->format('Y-m-d');
    
    ?>
 
    <!-- USERS TABLE -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive-sm"
                style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                <div style="position:absolute; top:13px; right:470px">
                    <a class="btn btn-link btn-sm {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}
                    {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}
                    {{ session()->get('leveid') === 'STAFF' ? 'd-none' : '' }}" data-toggle="modal" data-target="#add-user"><i class="fas fa-plus fa-sm text-info-40"></i> Add Facility
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
                            <th class="d-none">Facility ID</th>
                            <th>Facility</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Type</th>
                            <th class="text-center {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}{{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}">Regional Office</th>
                            <th class="text-center {{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}">HCPN</th>
                            <th class="text-center">Accreditation</th>
                            <th class="text-center">Global Budget</th>
                            <th class="disableSort disableFilterBy text-center">Action
                            </th>
                        </tr>
                    </thead>
 
                    @if (session()->get('leveid') == 'PHIC')
                               <tbody>
    @foreach($HCFUnderPro as $facility)
    <tr>
        <td class="d-none">{{ $facility['hcfid'] }}</td>
        <td>{{ $facility['hcfname'] }}</td>
        <td class="text-center">{{ $facility['hcfaddress'] }}</td>
        <td class="text-center">{{ $facility['type'] }}</td>
   <td class="text-center">{{ $facility['proid'] }}</td>
                          <td class="text-center">{{ $facility['mb'] }}</td>
        <td class="text-center">{{ $facility['hcfcode'] }}</td>
         <td class="text-center">{{ $facility['gbtags'] }}</td>
        <td class="text-center">
            <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                        data-target="#hcftagging"><i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit" onclick="HCFTagging(
                                                    '<?=$facility['hcfcode']?>',
                                                    '<?=$facility['hcfname']?>',
                                                     '<?=$facility['type']?>' ,
                                                     '<?=$facility['gbtags']?>',                                                 
                                 )"></i></a>
        </td>
    </tr>
    
    @endforeach
</tbody>
@elseif (session()->get('leveid') == 'PRO')
<tbody>
    @foreach($HCFUnderPro as $facility)
    <tr>
        <td class="d-none">{{ $facility['hcfid'] }}</td>
        <td>{{ $facility['hcfname'] }}</td>
        <td class="text-center">{{ $facility['hcfaddress'] }}</td>
        @php
        $mb = json_decode($facility['mb']);
        @endphp
                          <td class="text-center">{{ $mb->mbname }}</td>
        <td class="text-center">{{ $facility['hcfcode'] }}</td>
    
  
        <td class="text-center {{ session()->get('leveid') === 'PHIC' ? 'd-none' : '' }}">
            <a class="btn btn-sm btn-link text-darker-warning"><i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit" ></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@else
 @foreach($HCFUnderPro as $facility)
    <tr>
        <td class="d-none" name="hcfid" id="hcfid">{{ $facility['hcfid'] }}</td>
        <td>{{ $facility['hcfname'] }}</td>
        <td class="text-center">{{ $facility['hcfaddress'] }}</td>     
        <td class="text-center">{{ $facility['hcfcode'] }}</td>
       
        <td class="text-center">
            <center><input class="form-control" style="width: 16px; height: 16px;" type="checkbox"  id="addaccesbox" value="" data-hcf="{{ $facility['hcfid'] }}"><center>
        </td>
    </tr>
    @endforeach
<textarea class="d-none" id="add-access"></textarea>
<script>
var mbCheckboxes = document.querySelectorAll('input[type="checkbox"][data-hcf]');

    mbCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var hcf = this.getAttribute('data-hcf');
            var textarea = document.querySelector('#add-access textarea');
            
            if (this.checked) {
                textarea.value += hcf + ', ';
            } else {
                textarea.value = textarea.value.replace(hcf + ', ', '');
            }
        });
    });
</script>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
    <script>
        function HCFTagging(hcfcode, hcfname, type, gbtags) {
            document.getElementsByName("t_hcfcode")[0].setAttribute("value", hcfcode);
            document.getElementsByName("t_hcfname")[0].setAttribute("value", hcfname);
            document.getElementsByName("t_type")[0].setAttribute("value", type);
            document.getElementsByName("t_gbtags")[0].setAttribute("value", gbtags);


        }
    </script>
 <div class="modal" id="hcftagging">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">Edit Facility Tagging</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('EditHCPNContract') }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                             <div class="form-group col-md-6">
                                <label for="t_hcfname">Facility</label>
                                <input type="text" name="t_hcfname" class="form-control" readonly>
                               
                            </div>
                            <div class="form-group col-md-6">
                                <label for="e_transcode">Accreditation Number</label>
                                <input type="text" name="t_hcfcode" class="form-control" readonly>
                               
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col d-none">
                                <label for="hcpn">HCPN</label>
                                <select name="hcpn" class="form-control">

                                    @foreach ($ManagingBoard as $mb)
                                    <option value="{{ $mb['mbid']}}">{{ $mb['mbname']}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">FACILITY TYPE</label>
                                 <select name="hcftype" class="form-control">
                                    <option value="APEX">APEX</option>
                                    <option value="NONAPEX">NON APEX</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gbtags">GB TAGGING</label>
                                 <select name="gbtags" class="form-control">
                                    <option value="GB">Global Budget</option>
                                    <option value="NONGB">Non Global Budget</option>
                                </select>
                            </div>
                            
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection