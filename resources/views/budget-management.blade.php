@extends('layouts.app')


@section('contents')

<div id="content">
    <div class="container-fluid">

        <!-- CLAIM MODAL -->
        <div class="modal" id="detail" name="detail">
            <div class="modal-dialog modal-dialog-centered modal-lg"
                style="max-height:800px; overflow-y:auto; overflow-x:hidden; width:95%;">
                <div class="modal-content p-3">

                    <strong>
                        <h3 class="text-center mb-4">FACILITY NAME</h3>
                    </strong>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 col-12 text-center">
                            <div class="table-responsive-sm">
                                <div class="row">
                                    <div class="col-xl-4 col-md-1 mb-1">
                                        <div class="border-left-success shadow h-100 py-1">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-1">
                                                    <div
                                                        class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total Budget Allocated</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                        <span>&#8369;</span>100,000,000
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-md-1 mb-1">
                                        <div class="border-left-success shadow h-100 py-1">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-1">
                                                    <div
                                                        class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Total Budget Disbursed</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                        <span>&#8369;</span>100,000,000
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Earnings (Monthly) Card Example -->
                                    <div class="col-xl-4 col-md-1 mb-1">
                                        <div class="border-left-warning shadow h-100 py-1">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-1">
                                                    <div
                                                        class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Total Budget Used</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                        <span>&#8369;</span>6,000,000
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                            <th>Tranch</th>
                                            <th>Tranch Status</th>
                                            <!-- <th class="disableSort disableFilterBy">Claim Amount</th> -->
                                            <th>Amount Disbursed</th>
                                            <th>Date Requested</th>
                                            <th>Date Disbursed</th>
                                            <th>Action</th>
                                        </tr>


                                        <!-- <th>Approval Date</th>
                <th>Completion Date<    /th> -->
                                    </thead>
                                    <tbody>
                                        <?php
          for ($i = 1; $i <= 3; $i++) {
              echo '<tr>';
              echo '<td>Tranch ' . $i . '</td>';
              echo '<td>Disbursed</td>';
              echo '<td class="editable" contenteditable="false">' . number_format(10000000 + $i * 500000, 0) . '</td>';
            echo '<td class="editable" contenteditable="false">November ' . ($i % 30 + 1) . ', 2023</td>';
              echo '<td class="editable" contenteditable="false"">January 16, 2024</td>';
             
              // echo '<td>Encoder ' . $i . '</td>';
              echo '<td><a class="btn-link pe-auto user-select-none font-weight-bolder" onclick="makeEditable(this)">Change Status</a> </td>';
              echo '</tr>';
          }
          ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary mr-auto">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>

        </div>

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
                                <th>Province</th>
                                <!-- <th class="disableSort disableFilterBy">Claim Amount</th> -->
                                <th>Total Budget</th>
                                <th class="disableSort disableFilterBy">Date Disbursed</th>
                                <th>Tranch 1</th>
                                <th>Tranch 2</th>
                                <th>Tranch 3</th>
                                <th class="disableSort disableFilterBy">Action</th>
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
                                <td></td>
                                <td></td>
                                <td>{{ $data['Cors'] }}</td>

                                <td>{{ $data['Category'] }}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#detail" onclick="myFunctionEdit(
                                                    '<?=$data['API']?>',
                                                    '<?=$data['Description']?>'
                                 )" class="btn-link pe-auto user-select-none font-weight-bolder">Set Budget</a>
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