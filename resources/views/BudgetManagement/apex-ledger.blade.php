@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">
        <center>
            <strong>
                <h4 class="text-primary">
@php
$hcfname = json_decode($SelectedHCFID, true);
@endphp
                    <strong>{{ $hcfname['hcfname'] }}</strong>   
                </h4>
                <br>
            </strong>
        </center>
   <div class="row text-center align-items-end">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 mb-2">
                <strong><p class="card-text">CONTRACT AMOUNT : &nbsp;<span id="contractamount" class="text-primary">{{ number_format((double) $SelectedAmount, 2) }}</span></p></strong>
            </div>
            <div class="col-md-4 mb-2">
                <strong><p class="card-text">CONTRACT NUMBER : &nbsp;<span class="text-success">456453245</span></p></strong>
            </div>
            <div class="col-md-4 mb-2">
          
                <strong> <p class="card-text">BEGINING BALANCE: &nbsp;<span class="text-warning">0.00</span></p></strong>
            </div>
        </div>
</div>
</div>
        <div class="row d-flex">
            <div class="col-md-12 col-12">
                <div class="table-responsive-sm">
                   
        <table class="table table-sm table-hover table-bordered" id="assetsTable" width="100%"
                        cellspacing="0">
                        <div class="row" style="margin-bottom: 5px;">
                            <div class="col"></div>
           
                        </div>
                        <thead>
                            <tr>
                                <th class="d-none">Asset ID</th>
                                <th class="text-center">Transaction Date</th>
                                <th class="text-center">Particulars</th>
                                <th class="text-center">Receipt Number</th>
                                
                                <th class="text-center">Amount</th>
                                <th class="text-center"> Running Balance</th>
                               
                            </tr>
                        </thead>
                        <tbody>
        @if ($Assets && count($Assets) > 0)
        @foreach ($Assets as $assets)
        @php
        $conid = json_decode($assets['conid'], true);
    
        @endphp
                            <tr>  
                                <td class="d-none">{{ $assets['assetid']}}</td>
                                          <td class="text-center">{{ DateTime::createFromFormat('m-d-Y', $assets['datereleased'])->format('F j, Y') }}</td>                               
                                <td class="text-center">Tranch Release</td>
                                <td class="text-center">{{ $assets['receipt']}}</td>
                                <td class="text-center text-success">PHP {{ number_format((double) $assets['amount'], 2)}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="d-none"></td>
                                <td class="text-center">April 6, 2024</td>    
                                <td class="text-center">Liquidation</td>
                                <td class="text-center">12345</td>
                                <td class="text-center text-danger">- PHP 50,000.00</td>
                                <td></td>
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
<script src="{{ asset('js/apex-ledger.js') }}"></script>

@endsection
