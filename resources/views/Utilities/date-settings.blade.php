@extends('layouts.app')
@section('contents')
<div id="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col col-md-6 mb-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="text-center">COMPUTATION DATE</h5><br>
                        <h6>Current Date Settings</h6>
                        <div class="form-row">
                            <div class="col col-md-3 mt-2">
                                <label>Date From</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" class="form-control"
                                    value="{{ DateTime::createFromFormat('m-d-Y', $DateSettings['datefrom'])->format('F j, Y') }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col col-md-3 mt-2">
                                <label>Date To</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" class="form-control"
                                    value="{{ DateTime::createFromFormat('m-d-Y', $DateSettings['dateto'])->format('F j, Y') }}"
                                    readonly>
                            </div>
                        </div><br>
                        <h6>Update Date Settings</h6>
                        <form acion="{{ route('UPDATEDATESETTINGS')}}">
                            <div class="form-row">
                                <div class="col col-md-3 mt-2">
                                    <label>Date From</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" class="form-control" id="formattedDate"
                                        style="position:absolute; width:85%; z-index:1;" required readonly>
                                    <input type="date" class="form-control" style="position:absolute; width:97%;"
                                        id="datePicker" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col col-md-3 mt-2">
                                    <label>Date To</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" class="form-control" id="formattedDate2"
                                        style="position:absolute; width:85%; z-index:1;" required readonly>
                                    <input type="date" class="form-control" style="position:absolute; width:97%;"
                                        id="datePicker2" required>
                                </div>
                            </div>
                        </form>
                        </br>
                        <div class="text-center">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#confirmdatesetting"
                                id="DateSettingConfirm">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-6 mb-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="text-center">SKIP YEAR SETTINGS</h5><br>
                        <h6>Current Skip Year</h6>
                        <div class="form-row">
                            <div class="col col-md-3 mt-2">
                                <label>Date From</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" class="form-control"
                                    value="{{ DateTime::createFromFormat('m-d-Y', $SkipYear['datefrom'])->format('F j, Y') }}"
                                    readonly required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col col-md-3 mt-2">
                                <label>Date To</label>
                            </div>
                            <div class="col col-md-9">
                                <input type="text" class="form-control"
                                    value="{{ DateTime::createFromFormat('m-d-Y', $SkipYear['dateto'])->format('F j, Y') }}"
                                    readonly required>
                            </div>
                        </div><br>
                        <h6>Update Skip Year</h6>
                        <form>
                            <div class="form-row">
                                <div class="col col-md-3 mt-2">
                                    <label>Date From</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" class="form-control" id="formattedDate3"
                                        style="position:absolute; width:85%; z-index:1;" readonly>
                                    <input type="date" class="form-control" style="position:absolute; width:97%;"
                                        id="datePicker3" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col col-md-3 mt-2">
                                    <label>Date To</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="text" class="form-control" id="formattedDate4"
                                        style="position:absolute; width:85%; z-index:1;" readonly>
                                    <input type="date" class="form-control" style="position:absolute; width:97%;"
                                        id="datePicker4" required>
                                </div>
                            </div>

                        </form>
                        </br>
                        <div class="text-center">
                            <button class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="confirmdatesetting">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header  bg-light">
                <h6 class="modal-title">CONFIRMATION</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('UPDATEDATESETTINGS') }}" method="POST">
                    @method('PUT') 
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="proname">DATE SETTINGS WILL BE CHANGED INTO :</label>
                            <div class="form-row">
                                <div class="col col-md-6">
                                    <label>Date From</label>
                                    <input type="text" class="form-control" id="cdatefrom" readonly>
                                </div>
                                <div class="col col-md-6">
                                    <label>Date To</label>
                                    <input type="text" class="form-control" id="cdateto" readonly>
                                    <input type="text" class="d-none" name="tags" value="DATEDIF" readonly>
                                    <input type="text" class="d-none" name="dd_datefrom" id="dd_datefrom" readonly>
                                    <input type="text" class="d-none" name="dd_dateto" id="dd_dateto" readonly>
                                </div>
                            </div>
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
    function setupDatePicker(datePickerId, formattedDateInputId) {
        const datePicker = document.getElementById(datePickerId);
        const formattedDateInput = document.getElementById(formattedDateInputId);
        datePicker.addEventListener('change', function () {
            const selectedDate = new Date(this.value);
            const month = selectedDate.toLocaleString('default', { month: 'long' });
            const day = selectedDate.getDate();
            const year = selectedDate.getFullYear();
            formattedDateInput.value = `${month} ${day}, ${year}`;
        });
    }


    setupDatePicker('datePicker', 'formattedDate');
    setupDatePicker('datePicker2', 'formattedDate2');
    setupDatePicker('datePicker3', 'formattedDate3');
    setupDatePicker('datePicker4', 'formattedDate4');

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("DateSettingConfirm").addEventListener("click", function () {
            var datefrom_t = document.getElementById("formattedDate").value;
            document.getElementById("cdatefrom").value = datefrom_t;
            var dateto_t = document.getElementById("formattedDate2").value;
            document.getElementById("cdateto").value = dateto_t;
            var datefrom = document.getElementById("datePicker").value;
            document.getElementById("dd_datefrom").value = datefrom;
            var dateto = document.getElementById("datePicker2").value;
            document.getElementById("dd_dateto").value = dateto;
        });
    });
</script>


@endsection