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
                    $SessionUserID = session()->get('userid');
                    $ManagingBoard = json_decode($decodedMB['result'], true);
                    $ApiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoardWithProID/' . $SessionUserID);
                    $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                    $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

                    return view('AreaManagement/managing-board', compact('ManagingBoard', 'HCFUnderPro'));
                } elseif ($result['leveid'] === 'MB') {
                    // Assuming $apiResponse contains the JSON response from your API
                    $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthCareFacility/ACTIVE');

                    // Debug: Dump the HTTP response


                    // Extract the JSON response body
                    $decodedResponse = $apiResponse->json();

                    // Extract the result array
                    $facilities = json_decode($decodedResponse['result'], true);
                    $SessionUserID = session()->get('userid');
                    $ApiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetMBUsingUserIDMBID/' . $SessionUserID);
                    $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                    $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

                    // GET MANAGING BOARD FOR SIDEBAR
                    $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');
                    $decodedMB = $apiMB->json();
                    $ManagingBoard = json_decode($decodedMB['result'], true);


                    return view('Facilities/facilities', compact('facilities', 'HCFUnderPro', 'ManagingBoard'));
                } elseif ($result['leveid'] === 'ADMIN') {
                    $apiUserInfo = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUserInfo/ACTIVE');


                    $apiUser = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUser/ACTIVE');
                    $apiLevel = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUserLevel/ACTIVE');

                    // Extract the JSON response body

                    $decodedUserInfo = $apiUserInfo->json();

                    $decodedapiUser = $apiUser->json();
                    $decodedapiLevel = $apiLevel->json();



                    // Extract the result array
                    $userInfoList = json_decode($decodedUserInfo['result'], true);


                    $userlogin = json_decode($decodedapiUser['result'], true);
                    $userLevel = json_decode($decodedapiLevel['result'], true);

                    $userInfoList = collect($userInfoList);


                    $userlogin = collect($userlogin);
                    $userLevel = collect($userLevel);
                    $userInfoList = $userInfoList->sortByDesc('datecreated');

                    // GET MANAGING BOARD FOR SIDEBAR
                    $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');
                    $decodedMB = $apiMB->json();
                    $ManagingBoard = json_decode($decodedMB['result'], true);

                    return view('UserManagement/users-info', compact('userInfoList', 'userlogin', 'userLevel', 'ManagingBoard'));
                } elseif ($result['leveid'] === 'PHIC') {
                    // API FOR PRO
                    $apiPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetPro');

                    // Check if the request was successful
                    if ($apiPro->successful()) {
                        $decodedPro = $apiPro->json();
                        // Check if 'result' key exists in the decoded JSON
                        if (isset ($decodedPro['result'])) {
                            $RegionalOffices = json_decode($decodedPro['result'], true);
                            // Pass data to the view and return it

                            // GET MANAGING BOARD FOR SIDEBAR
                            $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');
                            $decodedMB = $apiMB->json();
                            $ManagingBoard = json_decode($decodedMB['result'], true);
                            return view('AreaManagement/pro-management', compact('RegionalOffices', 'ManagingBoard'));
                        } else {
                            // Handle case where 'result' key is missing
                            return response()->json(['error' => 'Unexpected response format from API'], 500);
                        }
                    } else {
                        // Handle unsuccessful API request
                        return response()->json(['error' => 'Failed to fetch data from API'], $apiPro->status());
                    }
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
