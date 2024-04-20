@extends('layouts.app')


@section('contents')

<div id="content">
    <div class="container-fluid">


        <!-- CONTRACT TABLE -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive-sm"
                    style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
                    
                     <table class="table table-sm table-hover table-bordered table-striped" id="tablemanager"
                        width="100%" cellspacing="0">
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <thead>
                            <tr>
                                <thead>
                            <tr>
                                <th class="text-center">Contract Number</td>
                                <th  class="text-center" id="max-width-column">APEX Facility</th>
                             
                                <th class="text-center">Released Amount</th>
                                <th class="text-center">Released Date</th>
                                <th class="text-center">Released By</th>
                                <th class="text-center disableFilterBy">Date Covered</th>
                          
                                <th class="disableSort disableFilterBy text-center">Action</th>
                            </tr>
                        </thead>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($Contract) && is_iterable($Contract) && count($Contract) > 0)
                            @foreach($Contract as $contract)
                            @if ($contract != null)

                            <tr>
                                <td class="d-none">{{ $contract['conid'] }}</td>
                                <td class="text-center">{{ $contract['transcode'] }}</td>
                                @php
            $hcf = json_decode($contract['hcfid'], true);
                                @endphp
                                <td id="max-width-column" data-toggle=" tooltip" title="{{ $hcf['hcfname'] }}">{{ $hcf['hcfname'] }}</td>
                          
                                <td><strong>&#8369;</strong> &nbsp;{{ number_format((double) $contract['amount'], 2) }}</td>
                                <td class="text-center"> {{ DateTime::createFromFormat('m-d-Y', $contract['datecreated'])->format('M j, Y') }}</td>
                                
                                @php
            $createdby = json_decode($contract['createdby'], true);
                                @endphp

                                @if ($createdby == null)
                                <td class="text-center">NO DATA FOUND</td>        
                                @else
                                <td class="text-center"> {{ $createdby['firstname'] . " " . $createdby['lastname'] }}</td>    
                                @endif 

                                <td class="text-center">{{ DateTime::createFromFormat('m-d-Y', $contract['datefrom'])->format('M j, Y') }} to {{ DateTime::createFromFormat('m-d-Y', $contract['dateto'])->format('M j, Y') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-link text-darker-primary" onclick="GetReports('{{$contract['conid']}}', '{{$contract['hcfid']}}', '<?= $contract['dateto'] ?>','<?= $contract['datefrom'] ?>','<?= $contract['amount'] ?>')">
                                        <i class="fas fa-fw fa-eye" data-toggle="tooltip" title="View"></i>
                                    </button>
                                   
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="5" class="text-center">NO DATA FOUND</td>
                            </tr>
                            @endif
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

    <!-- EDIT CONTRACT MODAL -->
    <div class="modal" id="editcontract">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header  bg-gradient-light">
                    <h6 class="modal-title">Edit Contract</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('EditHCPNContract') }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="e_transcode">Contract Number</label>
                                <input type="text" name="e_transcode" class="form-control" placeholder="Transaction #"
                                    double>
                                <input type="text" name="e_conid" class="d-none" placeholder="Transaction #" double>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="hcpn">HCPN</label>
                                <select name="hcpn" class="form-control">

                                    @foreach ($ManagingBoard as $mb)
                                    <option value="{{ $mb['mbid']}}">{{ $mb['mbname']}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="e_datefrom">Date From</label>
                                <input type="date" name="e_datefrom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="e_dateto">Date To</label>
                                <input type="date" name="e_dateto" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="e_amount">Set Contract Amount</label>
                                <input type="text" name="e_amount" class="form-control" oninput="formatNumber(this)"
                                    placeholder="Enter amount" double>


                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button> <button type="button"
                                class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   

  

    <script>
function GetReports(conid, hcfid, datefrom, dateto, amount) {
    // Storing user details in localStorage
    localStorage.setItem('getConID', conid);
    localStorage.setItem('getHCFID', hcfid);
    localStorage.setItem('getDateFrom', datefrom);
    localStorage.setItem('getDateTo', dateto);
    localStorage.setItem('getAmount', amount);
 
    // Redirecting to the new page
      window.location.href = "/apexreports/ledger?conid=" + conid + "&hcfid=" + hcfid + "&datefrom=" + datefrom + "&dateto=" + dateto + "&amount=" + amount;
}
  </script>
    @endsection