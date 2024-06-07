@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <center>
                    <h4 class="text-primary">
                        @php

                        @endphp
                        <strong>{{ $SelectedHCF }}</strong>
                    </h4>
                    <br>
                </center>
                <div class="row text-center align-items-end">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <strong>
                                    <p class="card-text">CONTRACT AMOUNT : &nbsp;<span id="contractamount"
                                            class="text-primary">{{ number_format((double) $SelectedAmount, 2) }}</span>
                                    </p>
                                </strong>
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>
                                    <p class="card-text">RELEASED AMOUNT : &nbsp;<span id="totalreleased"
                                            class="text-primary"></span></p>
                                </strong>
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="text" id="SelectedPercent" value="{{ $SelectedPercent }}" class="d-none">
                                <strong>
                                    <p class="card-text">UTILIZED : &nbsp;<span id="utilizedamount"
                                            class="text-primary"></span> - {{  number_format((double) $SelectedPercent, 1) }}%</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="mt-auto">
                            @if ($Assets != null)
                                                        @php
    $releaseTranch = false;
    foreach ($Assets as $assets) {
        $conid = json_decode($assets['conid'], true);
        $tranch = json_decode($assets['tranchid'], true);
        if (str_contains($tranch['tranchtype'], '3RD')) {
            $releaseTranch = true;
            break;
        }
    }
                                                        @endphp
                                                        @if ($releaseTranch)
                                                            <a class="btn btn-sm btn-outline-primary disabled" data-toggle="modal"
                                                                data-target="#release-tranch" style="float:right;">Release Tranche</a>
                                                        @else
                                                            <button class="btn-sm btn-outline-primary" data-toggle="modal" data-target="#release-tranch"
                                                                style="float:right;">Release Tranche</button>
                                                        @endif
                            @else
                                <button class="btn-sm btn-outline-primary" data-toggle="modal" data-target="#release-tranch"
                                    style="float:right;">Release Tranche</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row d-flex">
                    <div class="col-md-12 col-12">
                        <div class="table-responsive-sm">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                            <table class="table table-sm table-hover table-bordered" id="assetsTable" width="100%"
                                cellspacing="0">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col"></div>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="d-none">Asset ID</th>
                                        <th class="text-center">Tranche</th>
                                        <th class="text-center">Receipt Number</th>
                                        <th class="text-center">Contract Number</th>
                                        <th class="text-center">Released Amount</th>
                                        <th class="text-center">Date Released</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($Assets && count($Assets) > 0)
                                                                    @foreach ($Assets as $assets)
                                                                                                    @php
        $conid = json_decode($assets['conid'], true);
        $tranch = json_decode($assets['tranchid'], true);
                                                                                                    @endphp
                                                                                                    <tr>
                                                                                                        <td class="d-none">{{ $assets['assetid']}}</td>
                                                                                                        <td class="text-center">{{ $tranch['tranchtype']}}</td>
                                                                                                        <td class="text-center">{{ $assets['receipt']}}</td>
                                                                                                        <td class="text-center">{{ $conid['transcode']}}</td>
                                                                                                        <td class="text-center">{{ number_format((double) $assets['amount'], 2)}}</td>
                                                                                                        <td class="text-center">
                                                                                                            {{ DateTime::createFromFormat('m-d-Y', $assets['datereleased'])->format('F j, Y') }}
                                                                                                        </td>
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ADD ASSETS MODAL -->
<div class="modal" id="release-tranch">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="modal-title">Release Tranche to<span class="text-primary font-weight-bold">&nbsp;{{ $SelectedHCF }}</span></h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('INSERTASSETS') }}" method="POST">
                            @csrf
                                    <input type="text" name="hcfid" class="form-control d-none"
                                        value="{{ $SelectedHCFCode }}" readonly required>
                                    <input type="text" name="conid" class="d-none"
                                        value="{{ $SelectedConID }}" required>
                
                            <div id="prevbal" class="card" style="display:none">
                            <div class="card-body">
                            <h6>PREVIOUS CONTRACT</h6><hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="e_amount">Contract Period</label>
                                    <input type="text" value="" class="form-control"
                                        double readonly>
                                   
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="e_amount">Previous Balance</label>
                                    <input type="text" value="" class="form-control"
                                        double readonly>
                                
                                </div>
                            </div>
                          
                        
                           
                            </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="e_amount">Contract Amount</label>
                                    <input type="text" value="&#8369; &nbsp;{{ number_format((double) $SelectedAmount, 2) }}" class="form-control" double readonly>
                                    <input type="text" name="contract_amount" id="contract" value="{{ $SelectedAmount }}" class="form-control d-none" double readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="tranch">Tranche</label>
                                    <select name="tranch" id="tranch" class="form-control"
                                        onchange="updatePercentage()" required>
                                        <option>Select Tranche</option>
                                           @if ($Assets != null)
                                                                          @php
    $hasFirstTranch = false;
    $hasSecondTranch = false;
    $hasThirdTranch = false;
    foreach ($Assets as $asset) {
        $tranch = json_decode($asset['tranchid'], true);
        if (str_contains($tranch['tranchtype'], '1ST')) {
            $hasFirstTranch = true;
        }
        if (str_contains($tranch['tranchtype'], '2ND')) {
            $hasSecondTranch = true;
        }
        if (str_contains($tranch['tranchtype'], '3RD')) {
            $hasThirdTranch = true;
        }
    }
@endphp

@php
    $displayedTranchTypes = [];
@endphp

@foreach ($Tranch as $tranch)
    @if (!($hasFirstTranch && str_contains($tranch['tranchtype'], '1ST')))
        @if (!($hasSecondTranch && str_contains($tranch['tranchtype'], '2ND')))
            <option value="{{ $tranch['tranchid'] }}" data-percent="{{ $tranch['percentage'] }}">{{ $tranch['tranchtype'] }} TRANCHE</option>
        @endif
    @endif
@endforeach
@else
@foreach ($Tranch as $tranch)
<option value="{{ $tranch['tranchid'] }}" data-percent="{{ $tranch['percentage'] }}">{{ $tranch['tranchtype'] }}</option>
@endforeach
@endif





                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="e_amount">&nbsp;&nbsp;%</label>
                                    <input type="num" id="percent" class="form-control" name="percent"
                                        value="" readonly>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="e_amount">Tranche Amount</label>
                                    <input type="text" name="tranch_amount" id="tranch_amount" value="" class="form-control" oninput="formatNumber(this)" double required readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="e_amount">Released Amount</label>
                                    <input type="text" value="" class="form-control"
                                        double readonly>
                                    <input type="text" name="contract_amount" id="contract" value=""
                                        class="form-control d-none" double readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="e_amount">Receipt Number</label>
                                    <input type="text" name="receipt" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="datereleased">Released Date</label>
                                    <input type="date" name="datereleased" class="form-control" required>
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn-sm btn-outline-primary">Save</button> <button type="button"
                                    class="btn-sm btn-outline-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('tranch').addEventListener('change', function () {
        var selectedValue = this.value;
        if (selectedValue === '46') {
            document.getElementById('prevbal').style.display = 'block';
    
        } else {
            document.getElementById('prevbal').style.display = 'none';
          
        }
    });

</script>

<script src="{{ asset('js/apex-assets.js') }}"></script>

@endsection