@extends('layouts.app')


@section('contents')

<div id="content">
    <div class="container-fluid">

        <!-- FACILITIES TABLE -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <div style="overflow-y:auto; max-height: 520px; margin-top:25px; margin-bottom: 10px;">

                    <select class="btn btn-secondary" name="selected" id="mySelect" required>
                        <option></option>
                        @foreach ($apiresult['entries'] as $data)
                        <option value="{{ $data['API'] }}">{{ $data['API'] }}</option>
                        @endforeach

                    </select>

                    <!-- Bootstrap modal -->
                    <button data-toggle="modal" data-target="#detail" onclick="myFunctionEdit(
                                                                    '<?=$data['API']?>',
                                                                    '<?=$data['Description']?>'
                                                 )" class="btn-sm btn-warning">Edit</button>

                    <div class="modal" id="detail" name="detail">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <div class="modal-content">

                                <!-- Modal Header -->


                                <div class="modal-header">
                                    <h5 class="modal-title" id="titlemodal">Claim Details</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body" id="modal-body-content">


                                    <input type="text" name="API" id="API" /><br>

                                    <input type="text" name="Description" id="Description" />

                                </div>



                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" name="submitAdd" class="btn btn-primary">Save</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <script>
        document.getElementById('showModalBtn').addEventListener('click', function () {
            var selectedApi = document.getElementById('mySelect').value;
            console.log('Selected API:', selectedApi);

            fetch('/apiData?API=' + selectedApi)
                .then(response => response.json())
                .then(data => {
                    console.log('Received Data:', data);

                    var modalBody = document.getElementById('modalBodyapi');
                    modalBody.innerHTML = '<p>API: ' + selectedApi + '</p><p>Description: ' + data.Description + '</p>';
                    $('#myModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

    </script>
    @endsection