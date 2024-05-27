@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">
  <div class="col col-md-12 container bg-gradient-light p-5 border ml-1 rounded">
            <h5>VIEW BASE AMOUNT COMPUTATION</h5><br>
       
        <div class="form-row">
    <div class="col col-md-3">
        <form>
        @csrf
        <select class="form-control" id="selectType">
            <option value="NONAPEX">NON APEX FACILITY</option>
            <option value="APEX">APEX FACILITY</option>
            <option value="HCPN">HCPN</option>
        </select>
    </div>
    <div class="col col-md-7" style="display: none;" id="hcpn">
       
         <select type="text" class="form-control" id="select2">
                        <option value="">SELECT HEALTH CARE PROVIDER NETWORK</option>
                        @if ($HCPN == null)
                        <option></option>
                        @else
            @foreach ($HCPN as $hcpn)
                <option value="{{ $hcpn['controlnumber'] }}">{{ $hcpn['mbname'] }}</option>
            @endforeach
            @endif
</select>
</div>
<div class="col col-md-7" style="display: none;" id="apex">
 <select type="text" class="form-control" id="select3">
                        <option value="">SELECT APEX FACILITY</option>
            @if ($Facilities == null)
                        <option></option>
                        @else
                        @if (session()->get('leveid') === 'PHIC')
            @foreach ($Facilities as $hcf)
            @if ($hcf['type'] == "APEX")
                <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                @endif
            @endforeach
                    
             @elseif (session()->get('leveid') === 'PRO')
  @foreach ($APEXFacilities as $hcf)
            @if ($hcf['type'] === "APEX")
                <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                @endif
            @endforeach
            @endif
</select>
</div>
<div class="col col-md-7" id="nonapex">
 <select type="text" class="form-control" id="select">
                        <option value="">SELECT NON APEX FACILITY</option>
                        
            @foreach ($Facilities as $hcf)
            @if ($hcf['type'] != "APEX")
                <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                @endif
            @endforeach
            @endif
            
        </select>

 </div>
 <input type="text" name="controlnumber" id="selectedValueInput" class="d-none" required>
 </br>
<div class="col col-md-2 mt-1">
        <button class="btn-sm btn-outline-info" type="button" onclick="setControlNumberAndRedirect()">View Amount</button>
</div>
</form>

 
</div>


</div>
<div class="card shadow mt-5 ml-1">
                            <div class="card-body bg-gradient-light">
                          
                                <div class="table-responsive-sm" style="overflow-y:auto; max-height: 300px;margin-top:25px; margin-bottom: 10px; font-size: 10px;">
@if ($Budget == "123")
                                    <table class="table table-sm table-hover table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>HCF/HCPN</th>
                                                <th class="text-center">Base Amount</th>
                                                <th class="text-center">Total Claims</th>
                                                <th class="text-center">Date From</th>
                                                <th class="text-center">Date To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                    <tr>
                                                        <td>NO DATA FOUND</td>
                                                    </tr>
                                        </tbody>
                                    </table>
@else
<table class="table table-sm table-hover table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th id="max-width-column">HCF/HCPN</th>
                                                <th class="text-center">Accreditation</th>
                                                <th class="text-center">Base Amount</th>
                                                <th class="text-center">Total Claims</th>
                                                <th class="text-center">Date From</th>
                                                <th class="text-center">Date To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                    <tr>
                                                        @if($Budget == null)
                                                        <td>NO DATA FOUND</td>
                                                        @else
                                                        @php
        $selectedhc = json_decode($Budget['hospital'], true);
                                                          @endphp
                                                     @if (isset($selectedhc['mbname']) && $selectedhc['mbname'] !== null)
    <td id="max-width-column">{{ $selectedhc['mbname'] }}</td>
    <td class="text-center">{{ $selectedhc['controlnumber'] }}</td>
@else
    <td id="max-width-column">{{ $selectedhc['hcfname'] ?? '' }}</td>
     <td class="text-center">{{ $selectedhc['hcfcode'] ?? '' }}</td>
@endif
                                                        <td class="text-center">{{ $Budget['totalamount'] }}</td>
                                                        <td class="text-center">{{ $Budget['totalclaims'] }}</td>
                                                        <td class="text-center">{{ $Budget['yearfrom'] }}</td>
                                                        <td class="text-center">{{ $Budget['yearto'] }}</td>
                                                        @endif
                                                    </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center" id="pagination"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
</div>
<script src="{{ asset('js/basebudget.js') }}"></script>

    @endsection