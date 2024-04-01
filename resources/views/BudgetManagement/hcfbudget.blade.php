@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">

        <!-- CLAIM MODAL -->
       
  
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 col-12 text-center">
                            <div class="table-responsive-sm">
                                <div class="row">
                                    <div class="col-xl-4 col-md-1 mb-1">
                                       <br>
                                       <br>
                                       <strong>      
@foreach($ManagingBoard as $mb)
 
    @if($mbid == $mb['mbid'])
        <h3 class="text-center mb-4">{{ $mb['mbname'] }}</h3>
    @endif
@endforeach

                    </strong>
                                                   
                                             
                                    </div>
                                    <div class="col-xl-4 col-md-1 mb-1">
                                        <br>
                                        <br>
                                        <h5>
                                            DATE COVERED :&nbsp; <h5 class="text-info">{{ $datefromformat }} to {{ $datetoformat }}</h5>
                                        </h5> 
                                    </div>
                                    <div class="col-xl-4 col-md-1 mb-1">
                                                <br>
                                                      <br>
@php
$totalAmount = 0;
@endphp

@if (count($HCFBudget) > 0)
    @foreach ($HCFBudget as $hcf)
        @php
        // Ensure $hcf['amount'] is numeric before adding
        if (is_numeric($hcf['amount'])) {
            $totalAmount += $hcf['amount'];
        }
        @endphp
    @endforeach
    <h5>
        TOTAL AMOUNT : &nbsp;<h4 class="text-info">{{ number_format((double) $totalAmount, 1)}}</h4>
    </h5>
@endif

                                               
                                       
                                    </div>
                                </div>
                                <table class="table table-sm table-hover table-bordered" id="editableTable" width="100%"
                                    cellspacing="0">
                                    <div class="row" style="margin-bottom: 7px;">
                                        <div class="col"></div>
                                        <div class="col"></div>
                                    </div>
                                    <thead>
                                        <tr>
                                            <th>Facility</th>
                                            <th>Address</th>
                                            <th>Regional Office</th>
                                            <th>Managing Board</th>
                                            <th>Accreditation</th>
                                            <th>Amount</th>
                                            <!-- <th class="disableSort disableFilterBy">Claim Amount</th> -->
                                            <th>Number of Claims</th>
                                            <th>Action</th>
                                        </tr>


                                        <!-- <th>Approval Date</th>
                <th>Completion Date<    /th> -->
                                    </thead>
                                    <tbody>


@if (count($HCFBudget) > 0)
    @foreach ($HCFBudget as $hcf)
    <tr>
        <td> {{ $hcf['hcfname']}} </td>
        <td> {{ $hcf['hcfaddress']}} </td>
        <td> {{ $hcf['proid']}} </td>
        <td> {{ $hcf['mb']}} </td>
        <td> {{ $hcf['hcfcode']}} </td>
        <td> {{ number_format((double) $hcf['amount'], 1)}} </td>
        
        <td> {{ $hcf['totalclaims']}} </td>
        <td> <button></button> </td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="8">No data found</td>
    </tr>
@endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
              
            
       



       
    </div>

    @endsection