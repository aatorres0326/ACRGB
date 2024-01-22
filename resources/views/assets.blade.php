@extends('layouts.app')


@section('contents')
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="modal" id="add-assets">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">ADD ASSETS</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Add Asset Modal body -->
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
              <input type="text" class="form-control" id="EncodedBy" value="{{ auth()->user()->name }}" disabled>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Add</button> <button type="button" class="btn btn-danger"
                data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
        <!-- Modal footer -->
      </div>
    </div>
  </div>

  <!-- ASSETS TABLE -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive-sm"
        style="overflow-y:auto; max-height: 520px; min-height: 515px; margin-top:25px; margin-bottom: 10px;"
        id="content">
        <div style="position:absolute; top:13px; right:470px" class="pb-2">
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
              <th>Asset ID</th>
              <th>Amount</th>
              <th>Transaction Number</th>
              <th>Type of Asset</th>
              <th>Source of Funds</th>
              <th>Date Received</th>
              <th>Encoded By</th>
              <!-- <th>Accreditation</th> -->
              <th class="disableSort disableFilterBy"></th>
            </tr>
          </thead>
          <tbody>
            <?php
          for ($i = 1; $i <= 20; $i++) {
              echo '<tr>';
              echo '<td>00000000' . $i . '</td>';
              echo '<td>' . number_format(10000000 + $i * 500000, 0) . '</td>';
              echo '<td>TRX000' . $i . '</td>';
              echo '<td>Cash</td>';
              echo '<td>Bank</td>';
              echo '<td>November ' . ($i % 30 + 1) . ', 2023</td>';
              echo '<td>Admin</td>';
              // echo '<td>Encoder ' . $i . '</td>';
              echo '<td><button data-toggle="modal" class="btn-sm btn-warning">Edit</button></td>';
              echo '</tr>';
          }
          ?>
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