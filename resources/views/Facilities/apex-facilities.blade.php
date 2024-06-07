@extends('layouts.app')

@section('contents')
<?php
$now = new DateTime();
$now->format('Y-m-d');
    ?>
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive-sm" style="overflow-y:auto; margin-top:25px; margin-bottom: 10px;"
                id="content">
                <div style="position:absolute; top:13px; right:320px">

                    <input type="text" id="searchInput">
                </div>
                <div class="card-body border rounded mt-2">
                    <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%"
                        cellspacing="0">
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <caption>List of Facilities</caption>
                        @if ($HCFUnderPro == null)
                            <thead>
                                <tr class="exclude-row">
                                    <th class="disableSort">Facility</th>
                                    <th class="text-center disableSort">Address</th>
                                    <th class="text-center disableSort">TYPE</th>
                                    <th
                                        class="text-center disableSort {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}{{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}">
                                        Regional Office</th>
                                    <th class="text-center disableSort">Accreditation</th>
                                    <th class="text-center disableSort">HCPN</th>
                                    <th class="disableSort disableFilterBy text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <span>No Data Found</span>
                                </tr>
                            </tbody>
                        @else

                                    @if (session()->get('leveid') == 'PHIC')
                                                <thead>
                                                    <tr class="exclude-row">
                                                        <th class="disableSort">Facility</th>
                                                        <th class="text-center disableSort">Address</th>
                                                        <th class="text-center disableSort">Type</th>

                                                        <th class="text-center disableSort">Accreditation</th>
                                                        <th class="text-center disableSort">HCPN</th>
                                                        <th class="disableSort disableFilterBy text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($HCFUnderPro as $facility)
                                                                    @if ($facility['type'] == "APEX")
                                                                                    <tr>
                                                                                        <td>{{ $facility['hcfname'] }}</td>
                                                                                        <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                                                                                        <td class="text-center">{{ $facility['type'] }}</td>
                                                                                        @if ($facility['proid'] == null)
                                                                                            <td class="text-center">N/A</td>
                                                                                        @else
                                                                                                    @if ($facility['type'] == "APEX")
                                                                                                                @php
                                                                                                                    $apexhcpn = $facility['mb'];

                                                                                                                    $parsedApexhcpn = json_decode($apexhcpn);


                                                                                                                @endphp
                                                                                                    @endif

                                                                                        @endif
                                                                                        <td class="text-center">{{ $facility['hcfcode'] }}</td>
                                                                                        @php
                                                                                            $matchFound = false;
                                                                                        @endphp
                                                                                        <td class="text-center">
                                                                                            @foreach ($ManagingBoard as $mb)
                                                                                                        @if ($facility['type'] == "NONAPEX")
                                                                                                                    @if ($mb['controlnumber'] == $facility['mb'])
                                                                                                                                <p>{{ $mb['mbname'] }}</p>
                                                                                                                                @php
                                                                                                                                    $matchFound = true;
                                                                                                                                @endphp
                                                                                                                    @endif
                                                                                                        @elseif ($facility['type'] == "APEX")
                                                                                                                @foreach ($parsedApexhcpn as $appellate)
                                                                                                                        @if ($mb['controlnumber'] == $appellate)
                                                                                                                                <p>{{ $mb['mbname'] }}</p>
                                                                                                                                @php
                                                                                                                                    $matchFound = true;
                                                                                                                                @endphp
                                                                                                                        @endif
                                                                                                                @endforeach
                                                                                                        @endif

                                                                                            @endforeach
                                                                                        </td>
                                                                                        @if (!$matchFound)
                                                                                            <td class="text-center">N/A</td>
                                                                                        @endif
                                                                                        <td class="text-center">
                                                                                            <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                                                                                data-target="#hcftagging">
                                                                                                <i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit"
                                                                                                    onclick="HCFTagging('<?= $facility['hcfcode'] ?>','<?= $facility['hcfname'] ?>','<?= $facility['type'] ?>')"></i>
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                    @endif
                                                    @endforeach
                                                </tbody>
                                    @elseif (session()->get('leveid') == 'PRO')
                                                <thead>
                                                    <tr class="exclude-row">
                                                        <th class="disableSort">Facility</th>
                                                        <th class="text-center disableSort">Address</th>
                                                        <th class="text-center disableSort">Type</th>
                                                        <th
                                                            class="text-center disableSort {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}{{ session()->get('leveid') === 'MB' ? 'd-none' : '' }}">
                                                            Regional Office</th>
                                                        <th class="text-center disableSort">Accreditation</th>
                                                        <th class="text-center disableSort">HCPN Appellate</th>
                                                        <th class="disableSort disableFilterBy text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($HCFUnderPro as $facility)
                                                                    @if ($facility['type'] == "APEX")
                                                                                    <tr>
                                                                                        <td>{{ $facility['hcfname'] }}</td>
                                                                                        <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                                                                                        <td class="text-center">{{ $facility['type'] }}</td>
                                                                                        @if ($facility['proid'] == null)
                                                                                            <td class="text-center">N/A</td>
                                                                                        @else
                                                                                                    @if ($facility['type'] == "APEX")
                                                                                                                @php
                                                                                                                    $apexhcpn = $facility['mb'];

                                                                                                                    $parsedApexhcpn = json_decode($apexhcpn);


                                                                                                                @endphp
                                                                                                    @endif

                                                                                        @endif
                                                                                        <td class="text-center">{{ $facility['hcfcode'] }}</td>
                                                                                        @php
                                                                                            $matchFound = false;
                                                                                        @endphp
                                                                                        <td class="text-center">
                                                                                            @foreach ($ManagingBoard as $mb)
                                                                                                        @if ($facility['type'] == "NONAPEX")
                                                                                                                    @if ($mb['controlnumber'] == $facility['mb'])
                                                                                                                                <p>{{ $mb['mbname'] }}</p>
                                                                                                                                @php
                                                                                                                                    $matchFound = true;
                                                                                                                                @endphp
                                                                                                                    @endif
                                                                                                        @elseif ($facility['type'] == "APEX")
                                                                                                                @foreach ($parsedApexhcpn as $appellate)
                                                                                                                        @if ($mb['controlnumber'] == $appellate)
                                                                                                                                <p>{{ $mb['mbname'] }}</p>
                                                                                                                                @php
                                                                                                                                    $matchFound = true;
                                                                                                                                @endphp
                                                                                                                        @endif
                                                                                                                @endforeach
                                                                                                        @endif

                                                                                            @endforeach
                                                                                        </td>
                                                                                        @if (!$matchFound)
                                                                                            <td class="text-center">N/A</td>
                                                                                        @endif
                                                                                        <td class="text-center">
                                                                                            <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                                                                                data-target="#hcftagging">
                                                                                                <i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit"
                                                                                                    onclick="HCFTagging('<?= $facility['hcfcode'] ?>','<?= $facility['hcfname'] ?>','<?= $facility['type'] ?>')"></i>
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                    @endif
                                                    @endforeach
                                                </tbody>
                                    @else
                                                <thead>
                                                    <tr class="exclude-row">
                                                        <th class="disableSort">Facility</th>
                                                        <th class="text-center disableSort">Address</th>
                                                        <th class="text-center disableSort">Type</th>
                                                        <th
                                                            class="text-center disableSort {{ session()->get('leveid') === 'PRO' ? 'd-none' : '' }}{{ session()->get('leveid') === 'HCPN' ? 'd-none' : '' }}">
                                                            Regional Office</th>
                                                        <th class="text-center disableSort">Accreditation</th>
                                                        <th class="text-center disableSort">HCPN</th>
                                                        <th class="disableSort disableFilterBy text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($HCFUnderPro as $facility)
                                                                    @if ($facility['type'] == "APEX")
                                                                                    <tr>
                                                                                        <td>{{ $facility['hcfname'] }}</td>
                                                                                        <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                                                                                        <td class="text-center">{{ $facility['type'] }}</td>
                                                                                        @if ($facility['proid'] == null)
                                                                                            <td class="text-center">N/A</td>
                                                                                        @else
                                                                                                    @if ($facility['type'] == "APEX")
                                                                                                                @php
                                                                                                                    $apexhcpn = $facility['mb'];

                                                                                                                    $parsedApexhcpn = json_decode($apexhcpn);


                                                                                                                @endphp
                                                                                                    @endif

                                                                                        @endif
                                                                                        <td class="text-center">{{ $facility['hcfcode'] }}</td>
                                                                                        @php
                                                                                            $matchFound = false;
                                                                                        @endphp

                                                                                        @foreach ($ManagingBoard as $mb)
                                                                                                @if ($facility['type'] == "NONAPEX")
                                                                                                        @if ($mb['controlnumber'] == $facility['mb'])
                                                                                                                <td class="text-center">{{ $mb['mbname'] }}</td>
                                                                                                                @php
                                                                                                                    $matchFound = true;
                                                                                                                @endphp
                                                                                                        @endif
                                                                                                @elseif ($facility['type'] == "APEX")
                                                                                                        @if ($mb['controlnumber'] == $parsedApexhcpn[0])
                                                                                                                <td class="text-center">{{ $mb['mbname'] }}</td>
                                                                                                                @php
                                                                                                                    $matchFound = true;
                                                                                                                @endphp
                                                                                                        @endif
                                                                                                @endif

                                                                                        @endforeach
                                                                                        @if (!$matchFound)
                                                                                            <td class="text-center">N/A</td>
                                                                                        @endif
                                                                                        <td class="text-center">
                                                                                            <a class="btn btn-sm btn-link text-darker-warning" data-toggle="modal"
                                                                                                data-target="#hcftagging">
                                                                                                <i class="fas fa-fw fa-edit" data-toggle="tooltip" title="Edit"
                                                                                                    onclick="HCFTagging('<?= $facility['hcfcode'] ?>','<?= $facility['hcfname'] ?>','<?= $facility['type'] ?>')"></i>
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                    @endif
                                                    @endforeach
                                                </tbody>
                                    @endif
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="hcftagging">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header  bg-light">
                    <h6 class="modal-title">Add Appellate</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
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
                                <input type="text" name="t_type" id="t_type" value="APEX" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col" id="appelate">
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
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button> <button
                                type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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

        document.addEventListener("DOMContentLoaded", function () {
            const typeSelect = document.getElementById('t_type');
            const Appelate = document.getElementById('appelate');
            const appellateSelect = document.querySelector('#appelate select');

            typeSelect.addEventListener('change', function () {
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