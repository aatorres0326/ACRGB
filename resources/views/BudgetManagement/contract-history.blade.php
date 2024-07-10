@extends('layouts.app')


@section('contents')


<div id="content">
    <div class="container-fluid">

        <!-- CONTRACT TABLE -->
        <div class="card shadow mb-4 border border-secondary">
            <div class="card-body">
                <div class="table-responsive-sm" style="overflow-y:auto; max-height: 420px; margin-bottom: 10px;"
                    id="content">
                    <div class="d-flex flex-row-reverse">
                        <input type="text" id="searchInput">&nbsp;


                    </div>
                    <div class="card-body border rounded mt-2">
                        <table class="table table-sm table-hover table-bordered display" id="tablemanager" width="100%"
                            cellspacing="0">
                            <caption>List of APEX Contracts</caption>
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                            <thead>
                                <tr>
                                    <thead>
                                        <tr class="exclude-row">
                                            <th class="text-center align-middle disableSort">Reference Number</td>
                                            <th class="text-center align-middle">
                                                HCI/HCPN</th>
                                            <th class="text-center align-middle disableSort">Contract Amount</th>
                                            <th class="text-center align-middle disableSort">Contract Period</th>
                                            <th class="text-center align-middle disableSort">End Date</th>
                                            <th class="text-center align-middle disableSort">Created By</th>
                                            <th class="text-center align-middle disableSort">Date Created</th>
                                        </tr>
                                    </thead>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($EndedContract != null)
                                @foreach ($EndedContract as $contract)
                                <tr>

                                    <td class="text-center">{{ $contract['transcode'] }}</td>
                                    @php
                                    $hcpn = json_decode($contract['hcfid'], true);
                                    @endphp
                                    <td data-toggle=" tooltip" title="{{ $hcpn['mbname'] }}">
                                        {{ $hcpn['mbname'] }}
                                    </td>
                                    <td class="text-right"><strong>&#8369;</strong>
                                        &nbsp;{{ number_format((double) $contract['amount'], 2) }}
                                    </td>
                                    @php
                                    $condate = json_decode($contract['contractdate'], true);
                                    @endphp
                                    <td class="text-center">{{ $condate['datefrom'] }} to {{$condate['dateto']}}</td>
                                    <td class="text-center">{{ $contract['enddate'] }}</td>
                                    <td class="text-center">{{ $contract['datecreated'] }}</td>
                                    <td class="text-center">{{ $contract['createdby'] }}</td>




                                </tr>
                                @endforeach
                                @else

                                <tr>
                                    <td colspan="5" class="text-center">NO DATA FOUND</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>









        @endsection