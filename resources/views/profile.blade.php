@extends('layouts.app')

@section('title', 'Profile')

@section('contents')


<form method="POST" action="{{ route('UpdateProfileLogin') }}">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row" id="res"></div>
                <!-- ROW -->
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Name</label>
                        <input type="text" class="form-control" disabled
                            placeholder="{{ session()->get('firstname') . " " . session()->get('middlename') . " " . session()->get('lastname') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">User Level</label>
                        <input type="text" class="form-control" disabled placeholder="{{ session()->get('leveid') }}">
                    </div>
                </div>
                <!-- END ROW -->

                <!-- ROW -->
                <div class="row mt-2">

                    @php
                    $facilityName = "Facility Not Found" . " (Facility ID " . session()->get('hcfid') . ")";

                    foreach ($facilities as $facility) {
                    $hcfid = session()->get('hcfid');
                    if ($facility['hcfid'] === $hcfid) {
                    $facilityName = $facility['hcfname'];
                    break;
                    }
                    }
                    @endphp

                    @if (Str::contains($facilityName, 'Facility Not Found'))
                    <div class="col-md-6">
                        <label class="labels">Facility Assignment</label>
                        <input type="text" class="form-control" style="color: #e9967a" disabled
                            placeholder="{{ $facilityName }}">
                    </div>
                    @else
                    <div class="col-md-6">
                        <label class="labels">Facility Assignment</label>
                        <input type="text" class="form-control" disabled placeholder="{{ $facilityName }}">
                    </div>
                    @endif

                    @php
                    $areaName = "Area Not Found" . " (Area ID " . session()->get('areaid') . ")";

                    foreach ($area as $area_id) {
                    $areaid = session()->get('areaid');
                    if ($area_id['areaid'] === $areaid) {
                    $areaName = $area_id['areaname'];
                    break;
                    }
                    }
                    @endphp


                    @if (Str::contains($areaName, 'Area Not Found'))
                    <div class="col-md-6">
                        <label class="labels">Area</label>
                        <input type="text" class="form-control" style="color: #e9967a" disabled
                            placeholder="{{ $areaName }}">
                    </div>
                    @else
                    <div class="col-md-6">
                        <label class="labels">Area</label>
                        <input type="text" class="form-control" disabled placeholder="{{ $areaName }}">
                    </div>
                    @endif

                </div>
                <!-- END ROW -->

                <!-- ROW -->
                <div class="row mt-2">

                    <input type="text" name="userid" class="form-control d-none" value="{{ session()->get('userid') }}">
                    @php
                    foreach ($userInfoList as $details) {
                    $userID = session()->get('userid');
                    if ($details['userid'] === $userID) {
                    $username = $details['username'];
                    break;
                    }
                    }
                    @endphp
                    <div class="col-md-6">
                        <label class="labels">Username</label>
                        <input type="text" name="editusername" class="form-control" placeholder="{{ $username }}">

                    </div>
                    <div class="col-md-6">
                        <label class="labels">Password</label>
                        <input type="password" name="editpassword" class="form-control" placeholder="●●●●●●●●●">
                    </div>
                </div>
                <div class="row mt-2">


                </div>

                <div class="mt-5 text-center"><button id="btn" class="btn btn-primary profile-button" type="submit">Save
                        Profile</button></div>
            </div>
        </div>

    </div>

</form>
@endsection