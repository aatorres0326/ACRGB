@extends('layouts.app')

@section('contents')
<?php
$now = new DateTime();
$now->format('Y-m-d');
?>
<div class="container-fluid">

    <div class="card shadow mb-4 border border-secondary">
        <div class="card-body">
            <div class="table-responsive-sm" style="overflow-y:auto; margin-bottom: 10px;" id="content">
                <div class="d-flex flex-row-reverse">

                    <input type="text" id="searchInput">
                </div>
                <div class="card-body border rounded mt-2">
                    <table class="table table-sm table-hover table-bordered table-striped" id="tablemanager"
                        width="100%" cellspacing="0">

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
                                <th class="text-center disableSort">PMCC_NO</th>

                                <th class="disableSort disableFilterBy text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span>No Data Found</span></td>
                            </tr>
                        </tbody>
                        @else


                        <thead>
                            <tr class="exclude-row">
                                <th class="disableSort">Facility</th>
                                <th class="text-center disableSort">Address</th>

                                <th class="text-center disableSort">PMCC_NO</th>

                                <th class="disableSort disableFilterBy text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($HCFUnderPro != null)
                            @foreach($HCFUnderPro as $facility)
                            @if ($facility['type'] == "AH")
                            <tr>
                                <td>{{ $facility['hcfname'] }}</td>
                                <td class="text-center">{{ $facility['hcfaddress'] }}</td>
                                <td class="text-center">{{ $facility['hcfcode'] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary" title="View Affiliates"
                                        onclick="ViewAFilliates('<?= $facility['hcfcode'] ?>','<?= $facility['hcfname'] ?>')">
                                        <i class="fas fa-fw fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endif


                            @endforeach
                            @else


                            <tr>
                                <td class="text-center">NO DATA</td>
                            </tr>
                            @endif


                        </tbody>

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
                                <input type="text" name="t_type" id="t_type" value="AH" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col" id="appelate">
                                <label for="appelate">APEX Affiliates</label>
                                <select name="appellate" class="form-control" id="select">
                                    <option value="" disabled selected>SELECT AN HCPN</option>
                                    @if ($ManagingBoard != null)
                                    @foreach ($ManagingBoard as $mb)
                                    <option value="{{ $mb['controlnumber'] }}">{{ $mb['mbname'] }}</option>
                                    @endforeach
                                    @endif
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
    function ViewAFilliates(hcfcode, hcfname) {
        localStorage.setItem("getHFCode", hcfcode);
        localStorage.setItem("getHCFname", hcfname);

        window.location.href = "/ApexAffiliates?hcfcode=" + hcfcode + "&hcfname=" + hcfname;
    }
    </script>

    @endsection