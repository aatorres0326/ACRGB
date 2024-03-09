@extends('layouts.app')


@section('contents')

<div id="content">
    <div class="container-fluid">

        <!-- CLAIM MODAL -->
       
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
              
            
       



       
    </div>

    @endsection