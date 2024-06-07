@extends('layouts.app')
@section('contents')
<style>
    #message {


        color: #000;
        position: relative;
        padding: 2px;
        margin-top: 5px;
    }

    #message p {
        padding: 0px 35px;
        font-size: 15px;
    }


    .valid {
        color: green;
    }

    .valid:before {
        position: relative;
        left: -35px;
        content: "√";
    }

    .invalid {
        color: red;
    }

    .invalid:before {
        position: relative;
        left: -35px;
        content: "x";
    }
</style>
<div id="content">
    <div class="container-fluid">


        <div class="col-md-12 container">
            <div class="card shadow mb-4">
                <div class="card-body">

                    <h4 class="font-weight-bold text-primary">
                        {{ session()->get('firstname') . " " . session()->get('middlename') . " " . session()->get('lastname') . " "}}
                    </h4>
                    <div class="form-row">
                        <div class="col col-md-2 mt-2">
                            <h6 class="font-weight-bold">CONTACT DETAILS</h6>
                        </div>
                        <div class="col col-md-3 mt-1"></div>
                        <div class="col col-md-1 mt-1"></div>
                        <div class="col col-md-2 mt-2">
                            <h6 class="font-weight-bold">LOGIN DETAILS</h6>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col col-md-2 mt-2">
                            <label>Contact Number</label>
                        </div>
                        <div class="col col-md-3 mt-1">
                            @php
                                $currentUserId = session()->get('userid');
                                $currentUserLogin = $userlogin->firstWhere('userid', $currentUserId);
                                $currentUserDid = $currentUserLogin['did'] ?? null;
                                $currentUserInfo = $userInfoList->firstWhere('did', $currentUserDid);
                            @endphp

                            @if ($currentUserInfo)
                                <input type="text" class="form-control" value="{{ $currentUserInfo['contact'] }}">
                            @endif

                        </div>
                        <div class="col col-md-1 mt-1">

                        </div>
                        <div class="col col-md-2 mt-2">
                            <label>Username</label>
                        </div>
                        <div class="col col-md-3 mt-1">
                            @foreach ($userlogin as $logindetails)
                                @if ($logindetails['userid'] == session()->get('userid'))
                                    <input type="text" class="form-control" value="{{ session()->get('username') }}">
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col col-md-2 mt-2">
                            <label>Email</label>
                        </div>
                        <div class="col col-md-3 mt-1">
                            @php
                                $currentUserId = session()->get('userid');
                                $currentUserLogin = $userlogin->firstWhere('userid', $currentUserId);
                                $currentUserDid = $currentUserLogin['did'] ?? null;
                                $currentUserInfo = $userInfoList->firstWhere('did', $currentUserDid);
                            @endphp

                            @if ($currentUserInfo)
                                <input type="text" class="form-control" value="{{ $currentUserInfo['email'] }}">
                            @endif
                        </div>
                        <div class="col col-md-1 mt-1">

                        </div>
                        <div class="col col-md-2 mt-2">
                            <button class="btn btn-outline-info btn-sm" data-toggle="modal"
                                data-target="#changepassword">Change Password</but>
                        </div>
                        <div class="col col-md-3 mt-1">
                            <input type="text" class="form-control" value="" placeholder="●●●●●●●●●">
                        </div>
                    </div><br>
                </div>
            </div>
        </div>

    </div>

    <div class="modal" id="changepassword">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="titlemodal">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="modal-body-content">
                    <form action="{{ route('editUserLogin') }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input class="form-control d-none" type="text" name="userid" id="userid" />
                        <div class="form-row">
                            <div class="form-group col">

                                <input autocomplete="off" type="text" class="form-control" name="oldpassword"
                                    placeholder="Enter Old Password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">

                                <input autocomplete="off" name="password" id="password" type="password"
                                    class="form-control form-control-user" placeholder="Set a New Password" required />
                            </div>
                        </div>
                        <div id="newRes"></div>
                        <div class="form-row">
                            <div class="form-group col">

                                <input id="confirmpassword" type="password" class="form-control form-control-user"
                                    placeholder="Confirm Password" onkeyup="checkPass()" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="container">

                                <div id="message" class="block">
                                    <h6 class="font-weight-bold">Password must contain the following:</h6>
                                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                    <p id="number" class="invalid">A <b>number</b></p>
                                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                    <p id="special" class="invalid">A <b>special character</b></p>
                                </div>

                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button id="br" class="btn btn-sm btn-outline-primary" disabled>Submit</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"
                        onclick="reset()">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function checkPass() {
            var x = document.getElementById('password').value;
            var y = document.getElementById('confirmpassword').value;
            if (y != '') {
                if (x != y) {
                    document.getElementById('newRes').innerHTML = "<h6>Password Do Not Match</h6>";
                    document.getElementById('newRes').style.color = "red";
                    document.getElementById('br').disabled = true;
                }
                else if (x == y) {
                    document.getElementById('newRes').innerHTML = "<h6>Password Match</h6>";
                    document.getElementById('newRes').style.color = "green";
                    document.getElementById('br').disabled = false;
                }
            }
            else if (y == '') {
                document.getElementById('newRes').innerHTML = "";
                document.getElementById('br').disabled = false;
            }
        }

        var x = document.getElementById("password");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");
        var special = document.getElementById("special");

        x.onkeyup = function () {

            var lowerCaseLetters = /[a-z]/g;
            if (x.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }

            var upperCaseLetters = /[A-Z]/g;
            if (x.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }

            var numbers = /[0-9]/g;
            if (x.value.match(numbers)) {
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
            }

            if (x.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
            }

            var specialCharacters = /[!@#$%^&*(),.?":{}|<>]/g;
            if (x.value.match(specialCharacters)) {
                special.classList.remove("invalid");
                special.classList.add("valid");
            } else {
                special.classList.remove("valid");
                special.classList.add("invalid");
            }
        }
    </script>

    @endsection