@extends('layouts.app')


@section('contents')

<div id="content">
  <div class="container-fluid">

    <!-- CLAIM MODAL -->
    <div class="modal" id="detail" name="detail">
      <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
          <!-- Claim Modal Header -->
          <div class="modal-header">
            <h5 class="modal-title" id="titlemodal">Claim Details</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!--Claim Modal body -->
          <div class="modal-body" id="modal-body-content">
            <input type="text" name="API" id="API" /><br>
            <input type="text" name="Description" id="Description" />
          </div>
          <!--Claim Modal footer -->
          <div class="modal-footer">
            <button type="submit" name="submitAdd" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
    {{ session()->get('lastname').','.session()->get('firstname') }}
    <!-- CLAIMS TABLE -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive-sm"
          style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">
          <div style="position:absolute; top:13px; right:470px">
            <a class="btn btn-link btn-sm" data-toggle="modal" data-target="#add-assets" text-decoration: none;"><i
                class="fas fa-upload fa-sm text-info-40"></i> Export
            </a>
          </div>
          <table class="table table-sm table-hover table-bordered table-striped" id="tablemanager" width="100%"
            cellspacing="0">
            <div class="row" style="margin-bottom: 7px;">
              <div class="col"></div>
              <div class="col"></div>
            </div>
            <thead>
              <tr>
                <th class="disableSort disableFilterBy">Transaction ID</th>
                <th>Hospital Name</th>
                <!-- <th class="disableSort disableFilterBy">Claim Amount</th> -->
                <th>Submission Date</th>
                <th class="disableSort disableFilterBy">Claim Description</th>
                <th>Claim Status</th>
                <th class="disableSort disableFilterBy"></th>
                <!-- <th>Approval Date</th>
                <th>Completion Date</th> -->
              </tr>
            </thead>
            <tbody>
              @foreach ($result['entries'] as $data)
              <tr>
                <td>
                  <?= $data['API'] ?>
                </td>
                <td>{{ $data['Description'] }}</td>
                <td>{{ $data['Auth'] }}</td>

                <td>{{ $data['Cors'] }}</td>

                <td>{{ $data['Category'] }}</td>
                <td>
                  <button data-toggle="modal" data-target="#detail" onclick="myFunctionEdit(
                                                    '<?=$data['API']?>',
                                                    '<?=$data['Description']?>'
                                 )" class="btn-sm btn-warning">Edit</button>
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