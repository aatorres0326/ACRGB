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


                $this->startUserSession($result);


                if ($result['status'] === '1') {
                    return view('auth/changelogin', compact('result'));
                } elseif ($result['leveid'] === 'PRO') {
                    $SessionUserID = session()->get('userid');

                    $GetHCPNwithPRO = env('API_GET_HCPN_USING_PRO_USERID');
                    $ApiHCFUnderPro = Http::withoutVerifying()->get($GetHCPNwithPRO . '/' . $SessionUserID . "/PRO");
                    $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                    $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

                    return view('dashboard', compact('HCFUnderPro'));
                } elseif ($result['leveid'] === 'MB') {

                    $GetFacility = env('API_GET_ALL_FACILITIES');
                    $apiResponse = Http::withoutVerifying()->get($GetFacility);
                    $decodedResponse = $apiResponse->json();
                    $facilities = json_decode($decodedResponse['result'], true);

                    $GetHCPN = env('API_GET_HCPN');
                    $apiMB = Http::withoutVerifying()->get($GetHCPN);
                    $decodedMB = $apiMB->json();
                    $ManagingBoard = json_decode($decodedMB['result'], true);


                    return view('Facilities/facilities', compact('facilities', 'ManagingBoard'));
                } elseif ($result['leveid'] === 'ADMIN') {

                    $GetUser = env('API_GET_USER');
                    $apiUser = Http::withoutVerifying()->get($GetUser . '/ACTIVE');
                    $decodedapiUser = $apiUser->json();
                    $userlogin = json_decode($decodedapiUser['result'], true);
                    $userlogin = collect($userlogin);

                    $GetUserInfo = env('API_GET_USER_INFO');
                    $apiUserInfo = Http::withoutVerifying()->get($GetUserInfo . '/ACTIVE');
                    $decodedUserInfo = $apiUserInfo->json();
                    $userInfoList = json_decode($decodedUserInfo['result'], true);
                    $userInfoList = collect($userInfoList);
                    $userInfoList = $userInfoList->sortByDesc('datecreated');

                    $GetUserLevel = env('API_GET_USER_LEVEL');
                    $apiUserLevel = Http::withoutVerifying()->get($GetUserLevel . '/ACTIVE');
                    $decodedapiLevel = $apiUserLevel->json();
                    $userLevel = json_decode($decodedapiLevel['result'], true);
                    $userLevel = collect($userLevel);

                    return view('dashboard', compact('userInfoList', 'userlogin', 'userLevel'));
                } elseif ($result['leveid'] === 'PHIC') {
                    // API FOR PRO
                    $GetRegionalOffice = env('API_GET_REGIONAL_OFFICE');
                    $apiPro = Http::withoutVerifying()->get($GetRegionalOffice);


                    if ($apiPro->successful()) {
                        $decodedPro = $apiPro->json();

                        if (isset($decodedPro['result'])) {
                            $RegionalOffices = json_decode($decodedPro['result'], true);

                            return view('dashboard', compact('RegionalOffices'));
                        } else {

                            return response()->json(['error' => 'Unexpected response format from API'], 500);
                        }
                    } else {

                        return response()->json(['error' => 'Failed to fetch data from API'], $apiPro->status());
                    }
                } else {
                    $GetHCPN = env('API_GET_HCPN');
                    $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                    $decodedMB = $apiMB->json();
                    $ManagingBoard = json_decode($decodedMB['result'], true);

                    return redirect('dashboard');
                }
            } else {
                return redirect()->back()->with('error', $response['message']);
            }
        } else {
            return redirect()->back()->with('error', 'Invalid username or password.');
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
            'status' => $userData['status'],
        ]);

    }


    public function logout()
    {
        Session::flush();
        Session::regenerate();
        return redirect('/login');
    }

}
