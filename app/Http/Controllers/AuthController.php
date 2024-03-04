<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{


    public function login()
    {
        return view('auth/login');
    }


    public function loginAction(Request $request)
    {
        $loginData = [
            'username' => $request->input('username'),
            'userpassword' => $request->input('password'),
        ];

        $apiUrl = 'http://localhost:7001/ACRGB/ACRGBINSERT/UserLogin';

        $response = Http::post($apiUrl, $loginData);


        if ($response->successful()) {

            if ($response['success']) {

                $result = json_decode($response['result'], true);


                $this->startUserSession($result);


                return view('dashboard', compact('result'));


            } else {
                return response()->json(['error' => 'Login failed. API response indicates failure.' . $response]);
            }

        } else {

            return response()->json(['error' => 'Failed to perform login.'], $response->status());
        }
    }


    private function startUserSession($userData)
    {
        $userDetails = json_decode($userData['did'], true);


        session([
            'userid' => $userData['userid'],
            'username' => $userData['username'],
            'leveid' => $userData['leveid'],
            'firstname' => $userDetails['firstname'],
            'middlename' => $userDetails['middlename'],
            'lastname' => $userDetails['lastname'],
            'did' => $userDetails['did'],
            'areaid' => $userDetails['areaid'],
            'hcfid' => $userDetails['hcfid'],
        ]);

    }


    public function logout()
    {
        Session::flush();
        Session::regenerate();
        return redirect('/login');
    }

}
