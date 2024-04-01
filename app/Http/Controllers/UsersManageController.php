<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;



class UsersManageController extends Controller
{

    public function GetUsers()
    {
        // Assuming $apiResponse contains the JSON response from your API
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUser/ACTIVE');
        $apiUserLevel = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUserLevel/ACTIVE');


        // Extract the JSON response body
        $decodedResponse = $apiResponse->json();
        $decodedapiUserLevel = $apiUserLevel->json();

        // Extract the result array
        $userList = json_decode($decodedResponse['result'], true);
        $userLevel = json_decode($decodedapiUserLevel['result'], true);

        // Debug: Dump the user list
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('UserManagement/users-login', compact('userList', 'userLevel', 'ManagingBoard'));
    }

    public function GetUsersInfo()
    {
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

        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('UserManagement/users-info', compact('userInfoList', 'userlogin', 'userLevel', 'ManagingBoard'));
    }


    public function addUserInfo(Request $request)
    {

        $now = new DateTime();

        $response = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTUSERDETAILS', [
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => $request->input('createdby'),
        ]);

        if ($response->successful()) {
            return redirect('/userinfo');

        }

    }

    public function addUserLogin(Request $request)
    {

        $now = new DateTime();

        $response = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTUSER', [
            'did' => $request->input('did'),
            'username' => $request->input('username'),
            'userpassword' => $request->input('password'),
            'leveid' => $request->input('level'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => '1',

        ]);

        if ($response->successful()) {
            return redirect('/userinfo');

        }

    }

    public function editUserLogin(Request $request)
    {

        $response = Http::put('http://localhost:7001/ACRGB/ACRGBUPDATE/UPDATEUSERCREDENTIALS', [
            'userid' => $request->input('userid'),
            'username' => $request->input('editusername'),
            'userpassword' => $request->input('editpassword'),

        ]);

        if ($response->successful()) {
            return redirect('/userlogins');

        }

    }

    public function GetUserLevel()
    {

        $apiUserLevel = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUserLevel/ACTIVE');

        $decodedapiUserLevel = $apiUserLevel->json();

        $userLevel = json_decode($decodedapiUserLevel['result'], true);

        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('UserManagement/role-management', compact('userLevel', 'ManagingBoard'));
    }

    public function addUserLevel(Request $request)
    {

        $now = new DateTime();

        $response = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTUSERLEVEL', [
            'levname' => $request->input('levname'),
            'levdetails' => $request->input('levdetails'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => $request->input('createdby'),

        ]);

        if ($response->successful()) {
            return redirect('/userlevel');

        }

    }

    public function GetAccess(Request $request)
    {

        // GET MANAGING BOARD


        // GET PROS
        $apiPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetPro');
        $decodedPro = $apiPro->json();
        $RegionalOffices = json_decode($decodedPro['result'], true);

        $RoleIndexResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndex/0');

        // Extract the JSON response body
        $decodedRoleIndexResponse = $RoleIndexResponse->json();





        // Extract the result array

        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);


        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        $RoleIndex = collect($RoleIndex);

        $ManagingBoard = collect($ManagingBoard);




        $SelectedUserRole = $request->query('leveid', '');
        $SelectedUserID = $request->query('userid', '');



        return view('UserManagement/access-assignments', compact('RoleIndex', 'RegionalOffices', 'ManagingBoard', 'SelectedUserRole', 'SelectedUserID'));
    }
    public function INSERTROLEINDEX(Request $request)
    {
        $now = new DateTime();
        $AddProResponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTROLEINDEX', [
            'userid' => $request->input('userid'),
            'accessid' => $request->input('accessid'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),
        ]);

        $SelectedUserRole = $request->input('passleveid');
        $SelectedUserID = $request->input('userid');

        if ($AddProResponse->successful()) {
            // Pass all necessary variables to the view
            return redirect('/useraccess?leveid=' . $SelectedUserRole . '&userid=' . $SelectedUserID);
        }
    }



}


