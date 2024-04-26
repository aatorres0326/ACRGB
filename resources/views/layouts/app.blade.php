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
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('admin_assets/css/global.min.css') }}" rel="stylesheet">

<script src="{{ asset('admin_assets/js/slimselect.min.js') }}"></script>
<link href="{{ asset('admin_assets/css/slimselect.min.css') }}" rel="stylesheet">

<script>
document.addEventListener("DOMContentLoaded", function() {
  const input = document.getElementById("searchInput");
  const table = document.getElementById("tablemanager");
  const rows = table.getElementsByTagName("tr");
  let noMatchRow = null; // Declare a variable to hold the reference to the "No matching records" row
  
  input.addEventListener("input", function() {
    const filter = input.value.toUpperCase();
    let visibleRowCount = 0;
    for (let i = 1; i < rows.length; i++) {
      if (rows[i].classList.contains("exclude-row")) {
        continue; // Skip filtering rows with the "exclude-row" class
      }
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
      if (!shouldHide) {
        visibleRowCount++;
      }
    }

  });
});
</script>





<style>
  #searchInput {
    position:absolute;

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
            font-size: 13px; /* Adjust the font size as needed */
        }
        #max-width-column {
        max-width: 130px; /* Adjust the value as needed */
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    #for_numrows
   {
    display:none;
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
    <div id="content-wrapper" class="d-flex flex-column bg-gradient-light" style="min-width:1000px;">

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



  
  
  <!-- MODIFY USER DETAILS -->
  <script>
    function EditUserLogin(userid, username, status) {
      document.getElementById("titlemodal").innerHTML = "Modify Login Credentials";
      document.getElementsByName("userid")[0].setAttribute("value", userid);
      document.getElementsByName("editusername")[0].setAttribute("placeholder", username);
      document.getElementsByName("editpassword")[0].setAttribute("placeholder", "●●●●●●●●●●●●");
      document.getElementsByName("status")[0].setAttribute("value", status);
    }
  </script>
  <!-- END OF MODIFY USER DETAILS -->

  <!-- GET USER DETAILS FOR ACCESS MANAGEMENT -->
  <script>
function DisplayUserDetails(userid, username, leveid) {
    // Storing user details in localStorage
    localStorage.setItem('getUserId', userid);
    localStorage.setItem('getUsername', username);
    localStorage.setItem('getLevel', leveid);
    
    // Redirecting to the new page
      window.location.href = "/useraccess?userid=" + userid + "&leveid=" + leveid;
}
  </script>

  <!--RESET PASSWORD -->
  <script>
    function generateRandomPassword() {

      var numbers = "0123456789";
      var lowercaseLetters = "abcdefghijklmnopqrstuvwxyz";
      var uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

      var password = "";

      // Ensure at least one of each type of character

      password += numbers.charAt(Math.floor(Math.random() * numbers.length));
      password += lowercaseLetters.charAt(Math.floor(Math.random() * lowercaseLetters.length));
      password += uppercaseLetters.charAt(Math.floor(Math.random() * uppercaseLetters.length));

      // Generate remaining characters
      var remainingLength = 6; // Max length - 4 (already added characters)
      var charset = symbols + numbers + lowercaseLetters + uppercaseLetters;
      for (var i = 0; i < remainingLength; i++) {
        var randomIndex = Math.floor(Math.random() * charset.length);
        password += charset.charAt(randomIndex);
      }

      // Shuffle the password to make sure the added characters are not always at the beginning
      password = shuffleString(password);

      return password;
    }

    function shuffleString(str) {
      var array = str.split('');
      var currentIndex = array.length;
      var temporaryValue, randomIndex;

      // While there remain elements to shuffle...
      while (0 !== currentIndex) {
        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
      }

      return array.join('');
    }

    function resetPassword() {
      var passwordInput = document.getElementsByName("editpassword")[0];
      var newPassword = '@' + generateRandomPassword();
      passwordInput.value = newPassword;
    }
    function reset() {
      var passwordInput = document.getElementsByName("editpassword")[0];
      passwordInput.placeholder = "●●●●●●●●●";
      passwordInput.value = "";
    }
  </script>
  <!-- END OF RESET PASSWORD -->

  <!-- GET SELECTED USER DETAILS -->
  <script type="text/javascript">
    function addLogin(did, lastname) {
      document.getElementById("titlemodal").innerHTML = "Add Login Credentials";
      document.getElementsByName("did")[0].setAttribute("value", did);
      document.getElementsByName("userlastname")[0].setAttribute("value", lastname);
      var currentDate = new Date();
      var philippinesTime = new Date(currentDate.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));

      var month = (philippinesTime.getMonth() + 1).toString().padStart(2, '0');
      var day = philippinesTime.getDate().toString().padStart(2, '0');
      var year = philippinesTime.getFullYear();
      var hours = philippinesTime.getHours().toString().padStart(2, '0');
      var minutes = philippinesTime.getMinutes().toString().padStart(2, '0');
      var seconds = philippinesTime.getSeconds().toString().padStart(2, '0');
      // Generate username
      var username = lastname + year + month + day + hours + minutes + seconds;
      // Update username field
      document.getElementsByName("username")[0].setAttribute("value", username);
      var password = '@' + generateRandomPassword();
      // Update password field
      document.getElementsByName("password")[0].setAttribute("value", password);
    }

    function generateRandomPassword() {
      var length = 8;
      var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      var password = "";
      while (!containsUppercase(password) || !containsLowercase(password) || !containsNumber(password)) {
        password = "";
        // Generate password with random characters
        for (var i = 0; i < length; i++) {
          var randomIndex = Math.floor(Math.random() * charset.length);
          password += charset[randomIndex];
        }
      }
      return password;
    }
    function containsUppercase(str) {
      return /[A-Z]/.test(str);
    }
    function containsLowercase(str) {
      return /[a-z]/.test(str);
    }
    function containsNumber(str) {
      return /\d/.test(str);
    }
  </script>
  <!-- END OF GET SELECTED USER DETAILS -->


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
    $(document).ready(function () {
      $('.create-login').click(function () {
        var userID = $(this).data('userid');
        console.log("User ID:", userID);
      });
    });
  </script>

  <!-- TOOLTIP -->
  <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
<script>
    new SlimSelect({
        select: "#select"
    });

    new SlimSelect({
        select: "#select2"
    });

    new SlimSelect({
        select: "#select3"
    });
    new SlimSelect({
        select: "#hcpn"
    });
    new SlimSelect({
        select: "#selectedhcf"
    });
</script>

</body>

</html>