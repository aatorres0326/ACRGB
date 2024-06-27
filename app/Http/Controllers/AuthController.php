<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{


    public function login()
    {
        return view('auth/login');
    }
    public function ForgotPassword()
    {
        return view('auth/forgot-password');
    }

    public function ResetPassword(request $request)
    {
        $Forgotpass = env('API_FORGOT_PASSWORD');
        $response = Http::post($Forgotpass, [
            'emailto' => $request->input('email'),
        ]);

        if ($response['success'] == true) {

            return view('errors/success-reset-password');

        } elseif ($response['success'] == false) {

            return view('errors/invalid-email');
        }
    }

    public function ChangeLogin()
    {
        return view('auth/changelogin');
    }

    public function loginAction(Request $request)
    {
        $loginData = [
            'username' => $request->input('username'),
            'userpassword' => $request->input('password'),
        ];
        $UserLogin = env('API_USER_LOGIN');
        $apiUrl = $UserLogin;

        $response = Http::post($apiUrl, $loginData);


        if ($response->successful()) {

            if ($response['success']) {


                $result = json_decode($response['result'], true);

                $this->startUserSession($response);

                if ($result['leveid'] === 'PRO') {

                    return redirect('dashboard');
                } elseif ($result['leveid'] === 'MB') {

                    return redirect('dashboard');
                } elseif ($result['leveid'] === 'ADMIN') {

                    return redirect('dashboard');
                } elseif ($result['leveid'] === 'PHIC') {
                    return redirect('dashboard');

                } else {

                    return redirect('dashboard');
                }



            } else {
                return redirect()->back()->with('error', $response['message']);
            }
        } else {
            return redirect()->back()->with('error', 'Invalid username or password.');
        }
    }

    private function startUserSession($response)
    {
        $userData = json_decode($response['result'], true);
        $userDetails = json_decode($userData['did'], true);
        $message = $response['message'];

        session([
            'userid' => $userData['userid'],
            'username' => $userData['username'],
            'leveid' => $userData['leveid'],
            'firstname' => $userDetails['firstname'],
            'middlename' => $userDetails['middlename'],
            'lastname' => $userDetails['lastname'],
            'did' => $userDetails['did'],
            'status' => $userData['status'],
            'token' => $message,
        ]);

    }


    public function logout()
    {
        Session::flush();
        Session::regenerate();
        return redirect('/login');
    }

}