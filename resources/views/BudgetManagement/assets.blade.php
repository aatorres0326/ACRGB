@extends('layouts.app')


@section('contents')
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- <div class="modal" id="add-assets">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">ADD ASSETS</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="TransNumber">Transaction Number</label>
                <input type="text" class="form-control" id="TransNumber" placeholder="">
              </div>
              <div class="form-group col-md-6">
                <label for="Amount">Amount</label>
                <input type="Text" class="form-control" id="Amount" placeholder="">
              </div>
            </div>
            <div class="form-group">
              <label for="TypeOfAssets">Type of Assets</label>
              <input type="text" class="form-control" id="TypeOfAssets" placeholder="">
            </div>
            <div class="form-group">
              <label for="SourceOfFunds">Source of Funds</label>
              <input type="text" class="form-control" id="SourceOfFunds" placeholder="">
            </div>
            <div class="form-group">
              <label for="DateReceived">Date Received</label>
              <input type="date" class="form-control" id="DateReceived">
            </div>
            <div class="form-group">
              <label for="EncodedBy">Encoded By</label>
              <input type="text" class="form-control" id="EncodedBy" value="" disabled>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Add</button> <button type="button" class="btn btn-danger"
                data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div> -->

  <!-- ASSETS TABLE -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive-sm"
        style="overflow-y:auto; max-height: 520px; min-height: 515px; margin-top:25px; margin-bottom: 10px;"
        id="content">
        <div style="position:absolute; top:13px; right:430px" class="pb-2">
          <a class=" btn btn-link btn-sm" data-toggle="modal" data-target="#add-assets" text-decoration: none;"><i
              class="fas fa-plus fa-sm text-info-40"></i> Add Assets
          </a>
          <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-assets" text-decoration: none;"><i
              class="fas fa-upload fa-sm text-info-40"></i> Export
          </a>
        </div>
        <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%" cellspacing="0">
          <div class="row" style="margin-bottom: 7px;">
            <div class="col"></div>
            <div class="col"></div>
          </div>
          <thead>
            <tr>
              <th class="text-center">Facility</th>
              <th class="text-center">Tranch</th>
              <th class="text-center">Receipt</th>
              <th class="text-center">Amount</th>
              <th class="text-center">Created By</th>
              <th class="text-center">Date Released</th>
              <th class="text-center">Dare Created</th>
              <!-- <th>Accreditation</th> -->
              <th class="disableSort disableFilterBy text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($Assets as $asset)
                        <tr>


<!-- FACILITY ROW -->
                             @php
  $facilityName = "Facility Not Found" . " (Facility ID " . $asset['hcfid'] . " )";
  foreach ($Facilities as $facility) {
    if ($facility['hcfid'] === $asset['hcfid']) {
      $facilityName = $facility['hcfname'];
      break;
    }
  }
                            @endphp
                            @if (Str::contains($facilityName, 'Facility Not Found'))
                            <td class="text-center" style="color: #e9967a">{{ $facilityName }}</td>
                            @else
                            <td class="text-center">{{ $facilityName }}</td>
                            @endif
<!-- END OF FACILITY ROW -->

<!-- TRANCH ROW -->
                                                        @php
  $TranchName = "Tranch Not Found" . " (Tranch ID " . $asset['tranchid'] . " )";
  foreach ($Tranch as $tranchid) {
    if ($tranchid['tranchid'] === $asset['tranchid']) {
      $TranchName = $tranchid['tranchtype'];
      break;
    }
  }
                            @endphp
                            @if (Str::contains($TranchName, 'Tranch Not Found'))
                            <td class="text-center" style="color: #e9967a">{{ $TranchName }}</td>
                            @else
                            <td class="text-center">{{ $TranchName }}</td>
                            @endif

<!-- END OF TRANCH ROW -->
                            <td class="text-center">{{ $asset['receipt'] }}</td>
                            <td class="text-center">{{ $asset['amount'] }}</td>
                            <td class="text-center">{{ $asset['createdby'] }}</td>
                            <td class="text-center">{{ $asset['datereleased'] }}</td>
                            <td class="text-center">{{ $asset['datecreated'] }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-link text-darker-warning"><i class="fas fa-fw fa-edit"
                                        data-toggle="tooltip" title="Edit"></i></a>
                            </td>

                        </tr>
                        @endforeach
          </tbody>
        </table>
      </div>
      <div id="paginationContainer">
        <!-- Pagination were generated here -->
      </div>
    </div>
  </div>
</div>

@endsection