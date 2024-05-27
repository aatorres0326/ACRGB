<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>ACR-GB</title>
  <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
  <link href="{{ asset('admin_assets/css/global.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin_assets/css/slimselect.min.css') }}" rel="stylesheet">

  <style>
    #searchInput {
      position: absolute;

      padding: 5px;
      width: 440px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 13px;
    }

    #searchInput:focus {
      outline: none;
      border-color: dodgerblue;
    }

    .table-sm {
      font-size: 8px;
    }

    .btn-link:hover {
      text-decoration: none;
    }

    th {
      position: sticky;
      position: -webkit-sticky;
      top: 0px;
      z-index: 2;
      background-color: #3C3D46;
      color: white;
      font-size: 14px;
    }

    td {
      font-size: 14px;
      color: black;
    }

    ::-webkit-scrollbar {
      width: 10px;
    }


    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }


    ::-webkit-scrollbar-thumb {
      background: #888;
    }


    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    .tablemanager th.sorterHeader {
      cursor: pointer;
    }

    .tablemanager th.sorterHeader:after {
      content: " \f0dc";
      font-family: "FontAwesome";
    }


    .tablemanager th.sortingDesc:after {
      content: " \f0dd";
      font-family: "FontAwesome";
    }


    .tablemanager th.sortingAsc:after {
      content: " \f0de";
      font-family: "FontAwesome";
    }


    .tablemanager th.disableSort {}

    #for_numrows {
      padding: 10px;
      float: left;
    }

    #for_filter_by {

      padding: 10px;
      float: right;
    }

    #pagesControllers {
      display: block;
      text-align: center;
      align-content: center;
    }

    .loading-overlay {
      display: flex;
      align-items: center;
      justify-content: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(240, 240, 240, 0.7);
      z-index: 9999;
    }

    .text-darker-warning {
      color: #cc6600;
    }

    .text-darker-warning:hover {
      color: #994d00;
    }

    #tablemanager th,
    #tablemanager td {
      font-size: 13px;

    }

    #max-width-column {
      max-width: 140px;

      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    #for_numrows {
      display: none;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">

    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column" style="min-width:1000px;">
      <div id="content">

        @include('layouts.navbar')

        <div class="container-fluid">

          @yield('contents')

        </div>
      </div>

      @include('layouts.footer')

    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <div id="loading" class="loading-overlay">
    <div class="d-flex justify-content-center">
      <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
      </div>
    </div>
  </div>

  <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('admin_assets/js/global.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{ asset('js/tableManager.js')}}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('admin_assets/js/slimselect.min.js') }}"></script>
</body>

</html>