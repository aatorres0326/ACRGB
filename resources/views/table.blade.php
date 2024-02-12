@extends('layouts.app')


@section('contents')

<div id="content">
  <div class="container-fluid">



    <!-- CLAIMS TABLE -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive-sm"
          style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;" id="content">

          <table class="table table-sm table-hover table-bordered table-striped" id="tablemanager" width="100%"
            cellspacing="0">
            <div class="row" style="margin-bottom: 7px;">
              <div class="col"></div>
              <div class="col"></div>
            </div>
            <thead>
              <tr>
                <th>Claim Series</th>
                <th>Amount</th>
                <!-- <th class="disableSort disableFilterBy">Claim Amount</th> -->
                <th>Date Released</th>
                <th>Created By</th>
                <th>Paid To</th>
                <th>Mode of Payment</th>

                <th class="disableSort disableFilterBy"></th>
                <!-- <th>Approval Date</th>
                <th>Completion Date</th> -->
              </tr>
            </thead>
            <tbody>
              @foreach ($result as $data)

              <tr>
                <td>{{ $data['claimseries'] }}</td>
                <td>{{ $data['amount'] }}</td>
                <td>{{ $data['datereleased'] }}</td>
                <td>{{ $data['createdby'] }}</td>
                @php
                $facilityName = "Facility Not Found" . " ( Facility ID " . $data['paidto'] . " )";
                foreach ($facilities as $facility) {
                if ($facility['id'] === $data['paidto']) {
                $facilityName = $facility['hciname'];
                break;
                }
                }
                @endphp
                @if (Str::contains($facilityName, 'Facility Not Found'))
                <td style="color: #e9967a">{{ $facilityName }}</td>
                @else
                <td>{{ $facilityName }}</td>
                @endif
                <td>{{ $data['modeofpayment'] }}</td>
                <td>
                  <button data-toggle="modal" class="btn-sm btn-warning">Edit</button>
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