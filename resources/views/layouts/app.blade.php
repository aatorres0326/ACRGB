<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>ACR-GB</title>
  <!-- Custom fonts for this template-->
  <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('admin_assets/css/global.min.css') }}" rel="stylesheet">
  <style>
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
  </style>
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        @include('layouts.navbar')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">


          @yield('contents')

        </div>
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      @include('layouts.footer')
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div id="loading" class="loading-overlay">
    <div class="d-flex justify-content-center">
      <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
      </div>
    </div>
  </div>





  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('admin_assets/js/global.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Page level plugins -->
  <script src="{{ asset('js/tableManager.js')}}"></script>
  <script src="{{ asset('js/app.js') }}"></script>


  <script>
    $(document).ready(function () {
      $('.edit-user').click(function () {
        var modal = $('#edit-user');
        var button = $(this);
        modal.find('.modal-body').html(`
                <p><strong>User ID:</strong> ${button.data('userid')}</p>
                <p><strong>Name:</strong> ${button.data('name')}</p>
                <p><strong>Username:</strong> ${button.data('username')}</p>
                <p><strong>Facility Assignment:</strong> ${button.data('hfid')}</p>
                <p><strong>Creation Date:</strong> ${button.data('datecreated')}</p>
            `);
        modal.modal('show');
      });
    });
  </script>

  <!-- TABLE SCRIPT -->
  <script type="text/javascript">
    $('#tablemanager').tablemanager({
      firstSort: [[3, 0], [2, 0], [1, 'asc']],
      disable: ["last"],
      appendFilterby: true,
      dateFormat: [[4, "mm-dd-yyyy"]],
      debug: true,
      vocabulary: {
        voc_filter_by: 'Filter By ',
        voc_type_here_filter: ' ',
        voc_show_rows: 'Show '
      },
      pagination: true,
      showrows: [10, 15, 50, 100],
      disableFilterBy: [1]
    })  </script>

  <!-- FILE INPUT SCRIPT -->
  <script>
    $(".custom-file-input").on("change", function () {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    })  
  </script>


  <!-- SCRIPT FOR LOADER -->
  <script>
    // Hide content initially
    document.getElementById('content').style.display = 'none';

    // Function to show content and hide loading
    function showContent() {
      document.getElementById('content').style.display = 'block';
      document.getElementById('loading').style.display = 'none';
    }

    // Event listener for window load
    window.addEventListener('load', showContent)  </script>
  <!-- SCRIPT FOR EDITING TABLE CELLS -->
  <script>
    function makeEditable(button) {
      var row = button.parentNode.parentNode;
      var cells = row.getElementsByClassName('editable');

      for (var i = 0; i < cells.length; i++) {
        cells[i].contentEditable = true;
      }

      button.innerHTML = 'Save';
      button.onclick = function () {
        saveChanges(this);
      };
    }

    function saveChanges(button) {
      var row = button.parentNode.parentNode;
      var cells = row.getElementsByClassName('editable');

      for (var i = 0; i < cells.length; i++) {
        cells[i].contentEditable = false;
      }

      button.innerHTML = 'Change Status';
      button.onclick = function () {
        makeEditable(this);
      };
    }
  </script>
</body>

</html>