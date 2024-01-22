@extends('layouts.app')


@section('contents')
<!-- Begin Page Content -->
<div class="container-fluid">



    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">XML UPLOAD</h6>
        </div>
        <div class="card-body">
            <div class="modal-body">
                <form>
                    <div class="d-grid">
                        <div class="row justify-content-center">
                            <div class="mr-2 col-5 custom-file">
                                <label for="drgxml">DRG XML FILE</label>
                            </div>
                            <div class="col-5 custom-file">
                                <label for="eclaimsxml">ECLAIMS XML FILE</label>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="mr-2 col-5 custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="drgxml">Choose file</label>
                            </div>
                            <div class="col-5 custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="eclaimsxml">Choose file</label>
                            </div>
                        </div>
                        <div class="p-2"></div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-sm btn-primary form-control"
                                style="width:100px;">UPLOAD <span class="fas fa-upload"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection