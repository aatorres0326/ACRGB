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

    public function changelogin()
    {
        return view('auth/changelogin');
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


                if ($result['status'] === '1') {
                    return view('auth/changelogin', compact('result'));
                } elseif ($result['leveid'] === 'PRO') {
                    $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

                    $decodedMB = $apiMB->json();

                    $ManagingBoard = json_decode($decodedMB['result'], true);

                    return view('AreaManagement/managing-board', compact('ManagingBoard'));
                } elseif ($result['leveid'] === 'ADMIN') {
                    $apiUserInfo = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUserInfo/ACTIVE');
                    $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthCareFacility/ACTIVE');
                    $apiArea = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetArea/ACTIVE');
                    $apiUser = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUser/ACTIVE');
                    $apiLevel = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUserLevel/ACTIVE');

                    // Extract the JSON response body
                    $decodedFacilityResponse = $facilityapiResponse->json();
                    $decodedUserInfo = $apiUserInfo->json();
                    $decodedArea = $apiArea->json();
                    $decodedapiUser = $apiUser->json();
                    $decodedapiLevel = $apiLevel->json();



                    // Extract the result array
                    $userInfoList = json_decode($decodedUserInfo['result'], true);
                    $facilities = json_decode($decodedFacilityResponse['result'], true);
                    $area = json_decode($decodedArea['result'], true);
                    $userlogin = json_decode($decodedapiUser['result'], true);
                    $userLevel = json_decode($decodedapiLevel['result'], true);

                    $userInfoList = collect($userInfoList);
                    $facilities = collect($facilities);
                    $area = collect($area);
                    $userlogin = collect($userlogin);
                    $userLevel = collect($userLevel);
                    $userInfoList = $userInfoList->sortByDesc('datecreated');

                    return view('UserManagement/users-info', compact('userInfoList', 'facilities', 'area', 'userlogin', 'userLevel'));
                } else {
                    return view('dashboard', compact('result'));
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
            'hcfid' => $userDetails['hcfid'],
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
