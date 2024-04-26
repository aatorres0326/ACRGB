@extends('layouts.app')

@section('contents')
<div class="container-fluid">
    <?php
$now = new DateTime();
$now->format('Y-m-d');
    ?>

    <!-- USERS TABLE -->
    <div class="card shadow mb-4">
        <div class="card-body bg-gradient-light">
            <div class="table-responsive-sm" style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
             <div style="position:absolute; top:13px; right:460px">
                  
                         <input type="text" id="searchInput">
                    </div>
                   
                <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%" cellspacing="0">
                    <div class="row" style="margin-bottom: 7px;">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                    <caption>List of Facilities</caption>

                    @if (session()->get('leveid') == 'PHIC')
                     <thead>
                        <tr class="exclude-row">
                            
                            <th class="disableSort">Facility</th>
                            <th class="text-center disableSort">Address</th>
                            <th class="text-center disableSort">TYPE</th>
                            <th class="text-center disableSort {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}{{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}">Regional Office</th>
                            <th class="text-center disableSort">Accreditation</th>
                            <th class="text-center disableSort">HCPN</th>
                            <th class="disableSort disableFilterBy text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($HCFUnderPro as $facility)
                        <tr>
                            
                            <td>{{ $facility['hcfname'] }}</td>
                            <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                            <td class="text-center">{{ $facility['type'] }}</td>
                            @if ($facility['proid'] == null)
                            <td class="text-center">N/A</td>
                            @else
                            <td class="text-center">{{ $facility['proid'] }}</td>
                            @endif
                            <td class="text-center">{{ $facility['hcfcode'] }}</td>
                            @php
        $matchFound = false;
                            @endphp
                            @foreach ($ManagingBoard as $mb)
                            @if ($mb['controlnumber'] == $facility['mb'])
                            <td class="text-center">{{ $mb['mbname'] }}</td>
                            @php
                $matchFound = true;
                            @endphp
                            @endif
                            @endforeach
                            @if (!$matchFound)
                            <td class="text-center">N/A</td>
                            @endif
                            <td class="text-center">
                                <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal" data-target="#hcftagging">
                                    <i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit" onclick="HCFTagging('<?=$facility['hcfcode']?>','<?=$facility['hcfname']?>','<?=$facility['type']?>')"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @elseif (session()->get('leveid') == 'PRO')
                      <thead>
                        <tr class="exclude-row">
                            <th class="disableSort">Facility</th>
                            <th class="text-center disableSort">Address</th>
                            <th class="text-center disableSort">Accreditation</th>
                            <th class="text-center disableSort">HCPN</th>
                        </tr>
                    </thead>
                    <tbody>
                         @if ($HCFUnderPro == null)
                            <tr><td>No Data Found</td></tr>
                            @else
                        @foreach($HCFUnderPro as $facility)
                        <tr>
                            <td class="d-none">{{ $facility['hcfid'] }}</td>
                            <td>{{ $facility['hcfname'] }}</td>
                            <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                            @php
            $mb = json_decode($facility['mb']);
                            @endphp
                                 <td class="text-center">{{ $facility['hcfcode'] }}</td>
                            <td class="text-center">{{ $mb->mbname }}</td>
                       
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    @else
                    @foreach($HCFUnderPro as $facility)
                    <tr>
                        <td class="d-none" name="hcfid" id="hcfid">{{ $facility['hcfid'] }}</td>
                        <td>{{ $facility['hcfname'] }}</td>
                        <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                        <td class="text-center">{{ $facility['hcfcode'] }}</td>
                        <td class="text-center">
                            <center><input class="form-control" style="width: 16px; height: 16px;" type="checkbox" id="addaccesbox" value="" data-hcf="{{ $facility['hcfid'] }}"></center>
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
                <form action="{{ route('EditHCFTagging') }}" id="editForm" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="t_hcfname">Facility</label>
                            <input type="text" name="t_hcfname" class="form-control" readonly required> 
                        </div>
                        <div class="form-group col-md-6">
                            <label for="e_transcode">Accreditation Number</label>
                            <input type="text" name="t_hcfcode" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="hcpn">Facility Type</label>
                            <select name="t_type" id="t_type" class="form-control" required>
                                <option value="" disabled selected>SELECT AN OPTION</option>
                                <option value="APEX">APEX</option>
                                <option value="NONAPEX">NON APEX</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col d-none" id="appelate">
                            <label for="appelate">APEX Appellate</label>
                            <select name="appellate" class="form-control" id="select">
                                <option value="" disabled selected>SELECT AN HCPN</option>
                                @foreach ($ManagingBoard as $mb)
                                <option value="{{ $mb['controlnumber'] }}">{{ $mb['mbname'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button> <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function HCFTagging(hcfcode, hcfname, type) {
        document.getElementsByName("t_hcfcode")[0].setAttribute("value", hcfcode);
        document.getElementsByName("t_hcfname")[0].setAttribute("value", hcfname);
        document.getElementsByName("t_type")[0].setAttribute("value", type);
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const typeSelect = document.getElementById('t_type');
        const Appelate = document.getElementById('appelate');
        const appellateSelect = document.querySelector('#appelate select');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'APEX') {
                Appelate.classList.remove('d-none');
                appellateSelect.setAttribute('required', 'required');
            } else {
                Appelate.classList.add('d-none');
                appellateSelect.removeAttribute('required');
            }
        });
    });
</script>

@endsection
