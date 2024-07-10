@extends('layouts.app')
@section('contents')
<div id="content">
    <div class="container-fluid">
        @if(session()->get('leveid') === "PRO")
            @if($PROContract != null)
                @php
                    $last = end($PROContract);
                    $PRO = json_decode($last['hcfid'], true);
                @endphp

                <div class="card shadow mb-2" style="height:50px;">
                    <div class="card-body">
                        <div class="row" style="margin-top: -5px;">
                            <div class="col col-md-6">
                                <span class="text-primary font-weight-bold">
                                    {{ $PRO['proname'] }}</span>
                            </div>
                            <div class="col col-md-6">
                                <span> Allocated Budget
                                    :&nbsp;<span
                                        class="text-primary font-weight-bold">{{ number_format((double) $last['amount'], 2) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col col-md-6">
                        <div class="card shadow mb-2">
                            <div class="card-body">


                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="card shadow mb-2">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-12">
                        <div class="card shadow mb-2">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>


@endsection