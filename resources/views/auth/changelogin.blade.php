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
  <style>
    /* Style all input fields */


/* Style the submit button */
input[type=submit] {
  background-color: #04AA6D;
  color: white;
}

/* Style the container for inputs */
.container {
  background-color: #f1f1f1;
  padding: 20px;
}

/* The message box is shown when the user clicks on the password field */
#message {

  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
}

#message p {
  padding: 10px 35px;
  font-size: 18px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "√";
}

/* Add a red text color and an "x" icon when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "x";
}
    </style>
</head>

<body class="bg-gradient-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-0">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            
            <div class="row">
              
              <div class="col-lg">
                <div class="p-5">
                    <h5 class=" text-center"> Change Login Details</h5>
                    <hr>
                  <form action="{{ route('login.action') }}" method="POST" class="user">
                    @csrf
                    
                    <div class="form-group">
                        <input autocomplete="off" placeholder="{{ session()->get('userid')}}"type="text" class="d-none" disabled/>
                      <input autocomplete="off" placeholder="{{ session()->get('username')}}"type="text" class="form-control form-control-user" disabled/>
                    </div>



                    <div class="form-group">
                      <input autocomplete="off" name="password" id="password" type="password" class="form-control form-control-user" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                         placeholder="Set a New Password" required/>
                    </div>



                    <div class="form-group">
                      
                      <input autocomplete="off" id="confirmpassword" type="password" class="form-control form-control-user" placeholder="Confirm Password" onkeyup="checkPass()" required/>
                    </div>
                   
                    <div id="message" class="block">
  <h5>Password must contain the following:</h5>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div>
                    <button type="submit" id="br" class="btn btn-primary btn-block btn-user">Save</button>
   
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

<script>
	function checkPass()
	{
		var x = document.getElementById('password').value;
		var y = document.getElementById('confirmpassword').value;
		if(y != '')
		{
			if(x != y)
			{
				document.getElementById('newRes').innerHTML = "<h6>Password Do Not Match</h6>";
				document.getElementById('newRes').style.color = "red";
				document.getElementById('br').disabled = true;
			}
			else if(x == y)
			{
				document.getElementById('newRes').innerHTML = "<h6>Password Match</h6>";
				document.getElementById('newRes').style.color = "green";
				document.getElementById('br').disabled = false;
			}
		}
		else if(y=='')
		{
			document.getElementById('newRes').innerHTML = "";
			document.getElementById('br').disabled = false;
		}
	}



   var x = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box


// When the user starts to type something inside the password field
x.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;  
  if(x.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
}

  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(x.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(x.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  // Validate length
  if(x.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
    
</script>





</body>

</html>