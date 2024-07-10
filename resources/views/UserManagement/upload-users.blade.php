@extends('layouts.app')


@section('contents')
<style>
#searchtable {

    padding: 5px;
    width: 300px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 13px;
}
</style>
<div class="container-fluid">

    <div class="card shadow mb-2">
        <div class="card-body">
            <form>
                <div class="row ml-2">
                    <div class="custom-file col col-md-2">
                        <div class="mt-2 font-weight-bold">UPLOAD USERS</div>
                    </div>
                    <div class="custom-file col col-md-4">
                        <input type="file" class="custom-file-input" id="customFile" name="filename"
                            accept=".xlsx, .xls">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <div class="custom-file col col-md-5">
                        <button type="button" class="btn btn-sm btn-outline-success mt-1" id="uploadBtn">
                            <i class="fas fa-upload"></i>&nbsp;Upload
                        </button>&nbsp;
                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="downloadTemplateBtn">
                            <i class="fas fa-download"></i>&nbsp;Download Template
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @if (session('decodedTableData'))

    @php
    $data = json_decode(session('apimessage'), true)
    @endphp

    <div class="alert alert-success alert-warning alert-dismissible fade show" role="alert"
        style="font-size: 13px; padding: 5px;">

        <h6 class="alert-heading ml-3">EMAIL ALREADY IN USE</h6>

        <hr>
        <ul>


            @foreach ($data as $message)
            <li>

                <p class="ml-2">{{$message[0]}} - {{$message[1]}}</p>
            </li>

            @endforeach

        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: -5px;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>




</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive-sm"
            style="overflow-y:auto; max-height: 370px;  margin-top:-7px; margin-bottom: 10px;" id="content">
            <div style="float:right;">
                <input type="text" id="searchtable" class="form-control">
            </div>
            <table id="uploadtable" class="table table-sm table-hover table-bordered mt-5">
                <thead>
                    <tr>
                        <th></th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Designation</th>
                        <th class="d-none">Date Created</th>
                        <th class="d-none">Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('decodedTableData') as $row)
                    <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['firstname'] }}</td>
                        <td>{{ $row['middlename'] }}</td>
                        <td>{{ $row['lastname'] }}</td>
                        <td>{{ $row['email'] }}</td>
                        <td>{{ $row['contact'] }}</td>
                        <td>{{ $row['role'] }}</td>
                        <td>{{ $row['designation'] }}</td>
                        <td class="d-none">{{ $row['datecreated'] }}</td>
                        <td class="d-none">{{ $row['createdby'] }}</td>
                        <td><button class="btn btn-sm btn-outline-danger">Remove</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <center>
            <div class="mt-2">
                <button class="btn-sm btn btn-outline-primary mr-1" onclick="convertAndDisplayJson()"><i
                        class="fas fa-fw fa-save"></i>&nbsp;Save</button>
            </div>
        </center>
    </div>
</div>
@else
<div class="card shadow mb-4">
    <div class="card-body">

        <div class="table-responsive-sm"
            style="overflow-y:auto; max-height: 370px;; margin-top:-7px; margin-bottom: 10px;" id="content">
            <div style="float:right;">
                <input type="text" id="searchtable" class="form-control">
            </div>

            <table class="table table-sm table-hover table-bordered mt-5" style="" id="uploadtable" width="100%"
                cellspacing="0">
                <div class="row" style="margin-bottom: 7px;">
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Firstname</th>
                        <th class="text-center">Middlename</th>
                        <th class="text-center">Lastname</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Contact Number</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Designation</th>
                        <th class="d-none">Created By</th>
                        <th class="d-none">Date Created</th>
                        <th class="disableSort disableFilterBy text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td>NO DATA FOUND</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <center>
            <div class="mt-2">
                <button class="btn-sm btn btn-outline-primary mr-1" onclick="convertAndDisplayJson()"><i
                        class="fas fa-fw fa-save"></i>&nbsp;Save</button>
            </div>
        </center>
    </div>
</div>
@endif
<form id="uploadForm" action="{{route('UPLOADUSERSJSON')}}" method="POST">
    @csrf
    <input type="hidden" id="uploaduser" name="uploadusersjson">
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    $("#uploadBtn").on("click", function() {
        var fileInput = $("#customFile")[0];
        if (fileInput.files.length === 0) {
            alert("No file selected.");
            return;
        }

        var file = fileInput.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            var data = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, {
                type: 'array'
            });
            var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            var jsonSheet = XLSX.utils.sheet_to_json(firstSheet, {
                header: 1
            });

            if (jsonSheet[0].length !== 7) {
                alert("Invalid File. Please use the template provided");
                return;
            }

            var tableBody = $("#uploadtable tbody");
            tableBody.empty();

            jsonSheet.forEach((row, index) => {
                if (index === 0) return;

                var isEmptyRow = row.every(cell => cell === null || cell === "");

                if (!isEmptyRow) {
                    var newRow = `<tr><td class="text-center">${index}</td>`;
                    row.forEach(cell => {
                        newRow += `<td class="text-center">${cell || ""}</td>`;
                    });
                    newRow +=
                        `<td class="d-none">{{ date('m-d-Y') }}</td><td class="d-none">{{ session()->get('userid') }}</td><td class="text-center"><button class="btn btn-sm btn-outline-danger">Remove</button></td>`;
                    newRow += "</tr>";
                    tableBody.append(newRow);
                }
            });
        };
        reader.readAsArrayBuffer(file);
        $(".custom-file-label").html(file.name);
    });

    $(document).on("click", ".btn-outline-danger", function() {
        $(this).closest("tr").remove();
    });

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
});

$("#downloadTemplateBtn").on("click", function() {
    window.location.href = "/download-template";
});


document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById("searchtable");
    const table = document.getElementById("uploadtable");
    const rows = table.getElementsByTagName("tr");

    input.addEventListener("input", function() {
        const filter = input.value.toUpperCase();
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let shouldHide = true;
            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toUpperCase();
                if (cellText.includes(filter)) {
                    shouldHide = false;
                    break;
                }
            }
            rows[i].style.display = shouldHide ? "none" : "";
        }
    });
});
</script>



<script>
function extractTableData(html) {
    const dom = new DOMParser().parseFromString(html, 'text/html');
    const table = dom.querySelector('table');
    // const headers = Array.from(table.querySelectorAll('th'))
    //     .map(th => th.textContent.trim())
    //     .filter(header => header !== 'action');

    const headers = [
        'id',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'contact',
        'role',
        'designation',
        'datecreated',
        'createdby'
    ];
    const rows = Array.from(table.querySelectorAll('tr')).slice(1);
    const data = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('td'));
        const rowData = {};
        cells.forEach((cell, i) => {

            if (headers[i]) {
                rowData[headers[i]] = cell.textContent.trim();
            }
        });
        return rowData;
    });

    return data;
}

function convertTableToJson(html) {
    const tableData = extractTableData(html);
    return JSON.stringify(tableData, null, 2);
}

function convertAndDisplayJson() {
    const html = document.querySelector('table').outerHTML;
    const jsonOutput = convertTableToJson(html);

    document.getElementById('uploaduser').value = jsonOutput;

    document.getElementById('uploadForm').submit();
}
</script>


@endsection