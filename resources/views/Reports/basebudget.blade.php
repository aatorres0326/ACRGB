@extends('layouts.app')
@section('contents')

<div id="content">
    <div class="container-fluid">


        <div class="card shadow mb-2">
            <div class="card-body">


                <form>
                    <p class="ml-1 font-weight-bold" style="font-size:14px;">HCF/HCPN</p>
                    <div class="form-row">
                        <div class="col col-md-4">
                            @csrf
                            <select class="form-control" id="selectType">

                                <option value="APEX">APEX FACILITY</option>
                                <option value="HCPN">HCPN</option>
                            </select>
                        </div>
                        <div class="col col-md-8" style="display: none;" id="hcpn">
                            <select type="text" class="form-control" id="select2">
                                <option value="">SELECT HEALTH CARE PROVIDER NETWORK</option>
                                @if ($HCPN == null)
                                <option></option>
                                @else
                                @foreach ($HCPN as $hcpn)
                                <option value="{{ $hcpn['controlnumber'] }}">{{ $hcpn['mbname'] }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col col-md-8" id="apex">
                            <select type="text" class="form-control" id="select3">
                                <option value="">SELECT APEX FACILITY</option>
                                @if ($Facilities == null)
                                <option></option>
                                @else
                                @if (session()->get('leveid') === 'PHIC')
                                @foreach ($Facilities as $hcf)
                                @if ($hcf['type'] == "AH")
                                <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                                @endif
                                @endforeach
                                @elseif (session()->get('leveid') === 'PRO')
                                @foreach ($APEXFacilities as $hcf)
                                @if ($hcf['type'] === "AH")
                                <option value="{{ $hcf['hcfcode'] }}">{{ $hcf['hcfname'] }}</option>
                                @endif
                                @endforeach
                                @endif
                                @endif
                            </select>
                        </div>

                        <input type="text" name="controlnumber" id="selectedValueInput" class="d-none" required>
                        </br>

                    </div>



                    <div class="card shadow mb-2 mt-3" style="display: none;" id="facilities">

                        <div class="card-body">

                            <div class="table-responsive-sm"
                                style="overflow-y:auto; max-height: 300px;margin-top:25px; margin-bottom: 10px;">
                                <div style="position:absolute; top:18px; right:320px">

                                    <input type="text" id="searchInput2">

                                </div>
                                <table class="table table-sm table-hover table-bordered table-striped table-light mt-3"
                                    id="tablemanager2" width="100%" cellspacing="0">


                                    <thead>
                                        <tr>

                                            <th>Facilities</th>

                                            <th class="text-center">Address</th>
                                            <th class="text-center">Accreditation</th>
                                            <th class="disableSort disableFilterBy text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($Facilities != null)
                                        @foreach($Facilities as $facility)
                                        @if($facility['type'] != "AH")

                                        <tr>

                                            <td>{{ $facility['hcfname'] }}</td>

                                            <td class="text-center">{{ $facility['hcfaddress'] }}
                                            </td>
                                            <td class="text-center">{{ $facility['hcfcode'] }}</td>
                                            <td class="text-center">
                                                <center><input class="form-control" style="width: 16px; height: 16px;"
                                                        type="checkbox" value=""
                                                        data-hcfcode="{{ $facility['hcfcode'] }}">
                                                </center>
                                            </td>
                                        </tr>
                                        @endif

                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <textarea name="includedfacilities" id="hcfcode" style="display: none;"></textarea>
                            </div>
                        </div>
                    </div>


                    <p class="mt-3 ml-1 font-weight-bold" style="font-size:14px;">CONTRACT PERIOD</p>
                    <div class="form-row">
                        <div class="col col-md-5"><input type="text" class="form-control" id="formattedDate3"
                                placeholder="DATE FROM" style="position:absolute; width:85%; z-index:1;" readonly>
                            <input type="date" class="form-control" style="position:absolute; width:97%;"
                                onchange="setMinDateTo()" id="datePicker3" required>
                        </div>
                        <div class="col col-md-1 mt-1 text-center">TO</div>
                        <div class="col col-md-5"><input type="text" class="form-control" id="formattedDate4"
                                placeholder="DATE TO" style="position:absolute; width:85%; z-index:1;" readonly>
                            <input type="date" class="form-control" style="position:absolute; width:97%;"
                                id="datePicker4" required>
                        </div>
                        <div class="col col-md-1 mt-1">
                            <button class="btn btn-sm btn-outline-success" type="button"
                                onclick="setControlNumberAndRedirect()">Generate</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        &nbsp;

        <div class="card-deck" style="margin-top: -26px;">
            @if($Budget != null)
            <div class="card shadow mt-2 mb-2 bg-light">
                <div class="card-body">

                    @php
                    $last = end($Budget);
                    $selected = json_decode($last['hospital'], true);

                    @endphp
                    <div class="col">
                        @if (isset($selected['mbname']))

                        <h5 class="text-white font-weight-bold">{{ $selected['mbname'] }}</h5>
                        @endif
                    </div>
                    <div class="col">
                        <span class="text-white font-weight-bold">DATE COVERED :&nbsp;</span><span
                            class="text-white font-weight-bold">
                            {{ $last['yearfrom'] }} to {{ $last['yearto']}}</span>
                    </div>
                </div>
            </div>

            @if (isset($selected['mbname']))

            <div class="card shadow mt-2 mb-2 bg-light" style="height: 100px;">
                <div class="card-body">
                    <div class="col">
                        <span class="text-white font-weight-bold">CLAIMS AMOUNT :&nbsp; </span><span
                            class="text-white font-weight-bold">
                            {{ number_format((double) $last['totalamount'], 2) }}</span>
                    </div>

                    <div class="col">
                        <span class="text-white font-weight-bold">TOTAL CLAIMS :&nbsp;</span><span
                            class="text-white font-weight-bold">{{ $last['totalclaims'] }}</span>
                    </div>


                    <div class="col">
                        <span class="text-white font-weight-bold"> SUPPLEMENTARY BUDGET :&nbsp;</span><span
                            class="text-white font-weight-bold">
                            {{ number_format((double) $last['sb'], 2) }}</span>
                    </div>
                </div>
            </div>

            @endif



            @else

            <div class="card shadow mt-1 mb-2">
                <div class="card-body">
                    <span>NO SELECTED HCF/HCPN</span>
                </div>
            </div>

            @endif
        </div>



        <div class="card shadow mt-">
            <div class="card-body">

                <div class="table-responsive-sm" id="tablemanager"
                    style="overflow-y:auto; max-height: 420px;margin-top:25px; margin-bottom: 10px; font-size: 10px;">
                    <div style="position:absolute; top:13px; right:320px">
                        <input type="text" id="searchInput">
                    </div>
                    <br>

                    <table class="table table-sm table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>

                                <th class="text-center">Facilities</th>
                                <th class="text-center">Level</th>
                                <th class="text-center">Accreditation</th>
                                <th class="text-center">Average Claims Amount</th>
                                <th class="text-center">30% Case Rate Adjustment</th>
                                <th class="text-center">Contract Amount</th>
                                <th class="text-center">Claims Volume</th>
                                <th class="text-center">Supplementary Budget</th>


                            </tr>
                        </thead>
                        <tbody>
                            @if($Budget == null)
                            <tr>
                                <td colspan="8">NO DATA FOUND</td>
                            </tr>
                            @else
                            @if ($HCFCodes != "")
                            @php
                            // Collect the data and group by hcfcode
                            $groupedBudgets = collect($Budget)->groupBy(function ($budget) {
                            $hospital = json_decode($budget['hospital'], true);
                            return $hospital['hcfcode'] ?? '';
                            });
                            @endphp

                            @foreach($groupedBudgets as $hcfcode => $budgets)
                            @php
                            // Initialize totals
                            $totalAmount = 0;
                            $totalThirty = 0;
                            $totalClaims = 0;
                            $totalSb = 0;
                            $hasSb = false;

                            // Iterate over each budget in the group to calculate totals
                            foreach ($budgets as $budget) {
                            $totalAmount += $budget['totalamount'];
                            $totalThirty += $budget['thirty'];
                            $totalClaims += $budget['totalclaims'];
                            if ($budget['sb'] !== null) {
                            $totalSb += $budget['sb'];
                            $hasSb = true;
                            }
                            }

                            // Get the first budget's hospital data for display
                            $selectedhc = json_decode($budgets[0]['hospital'], true);
                            @endphp

                            <tr>
                                <td title="{{ $selectedhc['hcfname'] ?? '' }}">
                                    {{ $selectedhc['hcfname'] ?? '' }}
                                </td>
                                <td class="text-center">{{ $selectedhc['hcilevel'] ?? '' }}</td>
                                <td class="text-center">{{ $selectedhc['hcfcode'] ?? '' }}</td>
                                <td class="text-right">
                                    {{ number_format((double) $totalAmount, 2) }}
                                </td>
                                <td class="text-right">
                                    {{ number_format((double) $totalThirty, 2) }}
                                </td>
                                <td class="text-right">
                                    {{ number_format((double) ($totalAmount + $totalThirty), 2) }}
                                </td>
                                <td class="text-center">{{ $totalClaims }}</td>
                                @if($hasSb)
                                <td class="text-center">
                                    {{ number_format((double) $totalSb, 2) }}
                                </td>
                                @else
                                <td class="text-center">N/A</td>
                                @endif
                            </tr>
                            @endforeach


                            @else

                            @foreach (array_slice($Budget, 0, -1) as $budget)
                            @php
                            $selectedhc = json_decode($budget['hospital'], true);
                            @endphp
                            <tr>
                                <td title="{{ $selectedhc['hcfname'] ?? '' }}">
                                    {{ $selectedhc['hcfname'] ?? '' }}
                                </td>
                                <td class="text-center">{{ $selectedhc['hcilevel'] ?? '' }}</td>
                                <td class="text-center">{{ $selectedhc['hcfcode'] ?? '' }}</td>
                                <td class="text-right">
                                    {{ number_format((double) $budget['totalamount'], 2) }}
                                </td>
                                <td class="text-right">
                                    {{ number_format((double) $budget['thirty'], 2) }}
                                </td>
                                <td class="text-right">
                                    {{ number_format((double) ($budget['thirty'] + $budget['totalamount']), 2) }}
                                </td>
                                <td class="text-center">{{ $budget['totalclaims'] }}</td>
                                @if($budget['sb'] != null)
                                <td class="text-center">
                                    {{ number_format((double) $budget['sb'], 2) }}
                                </td>
                                @else
                                <td class="text-center">N/A</td>
                                @endif
                            </tr>
                            @endforeach

                            @endif
                            @endif
                        </tbody>


                    </table>


                </div>
            </div>
        </div>
    </div>
</div>



<script src="{{ asset('js/basebudget.js') }}"></script>
<script>
var mbCheckboxes = document.querySelectorAll(
    'input[type="checkbox"][data-hcfcode]'
);

mbCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener("change", function() {
        var mbid = this.getAttribute("data-hcfcode");
        var textarea = document.querySelector("#hcfcode");

        if (this.checked) {
            textarea.value += mbid + ", ";
        } else {
            textarea.value = textarea.value.replace(mbid + ",", "");
        }
    });
});
</script>
<script>
function setupDatePicker(datePickerId, formattedDateInputId) {
    const datePicker = document.getElementById(datePickerId);
    const formattedDateInput = document.getElementById(formattedDateInputId);
    datePicker.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const month = selectedDate.toLocaleString('default', {
            month: 'long'
        });
        const day = selectedDate.getDate();
        const year = selectedDate.getFullYear();
        formattedDateInput.value = `${month} ${day}, ${year}`;
    });
}



setupDatePicker('datePicker3', 'formattedDate3');
setupDatePicker('datePicker4', 'formattedDate4');

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("DateSettingConfirm").addEventListener("click", function() {
        var datefrom_t = document.getElementById("formattedDate3").value;
        document.getElementById("cdatefrom").value = datefrom_t;
        var dateto_t = document.getElementById("formattedDate4").value;
        document.getElementById("cdateto").value = dateto_t;
        var datefrom = document.getElementById("datePicker3").value;
        document.getElementById("dd_datefrom").value = datefrom;
        var dateto = document.getElementById("datePicker4").value;
        document.getElementById("dd_dateto").value = dateto;
    });
});
</script>
<script>
function setMinDateTo() {

    const dateFrom = document.getElementById('datePicker3').value;
    const dateTo = document.getElementById('datePicker4');
    dateTo.min = dateFrom;

}
</script>
@endsection