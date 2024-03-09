@extends('layouts.app')


@section('contents')

<div id="content">
    <div class="container-fluid">


        <!-- CLAIMS TABLE -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                    <div style="position:absolute; top:13px; right:470px">
                        <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-assets" text-decoration:
                            none;"><i class="fas fa-upload fa-sm text-info-40"></i> Export
                        </a>
                    </div>
                    <table class="table table-sm table-hover table-bordered table-striped" id="tablemanager"
                        width="100%" cellspacing="0">
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <thead>
                            <tr>
                                <th>Facility</th>
                                <th>Address</th>
                                <th>Area</th>
                                <th>Regional Office</th>
                                <th>Accreditation</th>
                                <th>Amount</th>
                                <th>Date Created</th>
                                <th>Created By</th>
                                <th class="disableSort disableFilterBy">Action</th>
                                <!-- <th>Approval Date</th>
                <th>Completion Date</th> -->
                            </tr>
                        </thead>
                        <tbody>
 @foreach($FacilityBudget as $budget)
                            <tr>
                               <td class="text-center d-none">{{ $budget['hcfid'] }}</td>
<td class="text-center">{{ $budget['hcfname'] }}</td>
<td class="text-center">{{ $budget['hcfaddress'] }}</td>                            
<td class="text-center">{{ $budget['areaid'] }}</td>
<td class="text-center">{{ $budget['proid'] }}</td>
<td class="text-center">{{ $budget['hcfcode'] }}</td>
<td class="text-center">{{ number_format((double) $budget['amount'], 1) }}</td>
<td class="text-center">{{ date('F j, Y', strtotime($budget['datecreated'])) }}</td>

<td class="text-center" >{{ $budget['createdby'] }}</td>
<td class="text-center">
                                <a class="btn btn-sm btn-link text-primary" href="/viewhcfbudget"><i
                                        class="fas fa-fw fa-eye" data-toggle="tooltip" title="View"></i></a>
                                
                            </td>
</tr>
@endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @endsection