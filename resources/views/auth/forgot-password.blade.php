<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ACR-GB</title>
    <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('admin_assets/css/global.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-0">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="row">
                            <div class="col-lg-6">
                                <center><img class="mb-2 p-5" src="{{ asset('admin_assets/img/ACR_GBlogo.png') }}"
                                        alt="" width="350">
                                </center>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <form action="{{ route('ResetPassword') }}" method="POST" class="user"
                                        style="min-height: 220px;">
                                        @csrf

                                        <div class="form-group">
                                            <label class="ml-2 text-secondary"><small>Enter Your Registered Email
                                                    Address</small></label>
                                            <input autocomplete="off" name="email" type="email"
                                                class="form-control form-control-user" placeholder="example@gmail.com"
                                                required>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block btn-user">Submit</button>
                                        <div class="text-center mt-2">
                                            <a class="btn-sm btn-link" style="cursor: pointer; text-decoration: none;"
                                                href="/login"><i class="fa fa-fw fa-arrow-left mr-1"></i>Back to Login
                                                Page</a>
                                        </div>

                                    </form>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/global.min.js') }}"></script>

</body>

</html>