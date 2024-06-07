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


        $GetHCPN = env('API_GET_HCPN');
        $GetUser = env('API_GET_USER');
        $apiResponse = Http::withoutVerifying()->get($GetUser . '/ACTIVE');
        $GetUserLevel = env('API_GET_USER_LEVEL');
        $apiUserLevel = Http::withoutVerifying()->get($GetUserLevel . '/ACTIVE');


        // Extract the JSON response body
        $decodedResponse = $apiResponse->json();
        $decodedapiUserLevel = $apiUserLevel->json();

        // Extract the result array
        $userList = json_decode($decodedResponse['result'], true);
        $userLevel = json_decode($decodedapiUserLevel['result'], true);



        return view('UserManagement/users-login', compact('userList', 'userLevel'));
    }

    public function GetUsersInfo()
    {
        $GetUser = env('API_GET_USER');
        $GetUserInfo = env('API_GET_USER_INFO');
        $GetUserLevel = env('API_GET_USER_LEVEL');
        $GetHCPN = env('API_GET_HCPN');
        $apiUserInfo = Http::withoutVerifying()->get($GetUserInfo . '/ACTIVE');

        $apiUser = Http::withoutVerifying()->get($GetUser . '/ACTIVE');
        $apiLevel = Http::withoutVerifying()->get($GetUserLevel . '/ACTIVE');
        $decodedUserInfo = $apiUserInfo->json();

        $decodedapiUser = $apiUser->json();
        $decodedapiLevel = $apiLevel->json();
        $userInfoList = json_decode($decodedUserInfo['result'], true);

        $userlogin = json_decode($decodedapiUser['result'], true);
        $userLevel = json_decode($decodedapiLevel['result'], true);

        $userInfoList = collect($userInfoList);


        $userlogin = collect($userlogin);
        $userLevel = collect($userLevel);
        $userInfoList = $userInfoList->sortByDesc('datecreated');



        return view('UserManagement/users-info', compact('userInfoList', 'userlogin', 'userLevel'));
    }

    public function GetProfileInfo()
    {
        $GetUser = env('API_GET_USER');
        $GetUserInfo = env('API_GET_USER_INFO');
        $GetUserLevel = env('API_GET_USER_LEVEL');
        $GetHCPN = env('API_GET_HCPN');
        $apiUserInfo = Http::withoutVerifying()->get($GetUserInfo . '/ACTIVE');

        $apiUser = Http::withoutVerifying()->get($GetUser . '/ACTIVE');
        $apiLevel = Http::withoutVerifying()->get($GetUserLevel . '/ACTIVE');
        $decodedUserInfo = $apiUserInfo->json();

        $decodedapiUser = $apiUser->json();
        $decodedapiLevel = $apiLevel->json();
        $userInfoList = json_decode($decodedUserInfo['result'], true);

        $userlogin = json_decode($decodedapiUser['result'], true);
        $userLevel = json_decode($decodedapiLevel['result'], true);

        $userInfoList = collect($userInfoList);


        $userlogin = collect($userlogin);
        $userLevel = collect($userLevel);
        $userInfoList = $userInfoList->sortByDesc('datecreated');



        return view('UserManagement/account-settings', compact('userInfoList', 'userlogin', 'userLevel'));
    }


    public function addUserInfo(Request $request)
    {
        $SessionUserID = session()->get('userid');
        $now = new DateTime();
        $InsertUserDetails = env('API_INSERT_USER_DETAILS');
        $response = Http::post($InsertUserDetails, [
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => $SessionUserID,
        ]);

        if ($response['success'] == true) {

            return redirect('/userinfo');

        } elseif ($response['success'] == false) {

            return view('errors/duplicate-email');
        }

    }

    public function addUserLogin(Request $request)
    {

        $now = new DateTime();
        $SessionUserID = session()->get('userid');
        $InsertUser = env('API_INSERT_USER');
        $response = Http::post($InsertUser, [
            'did' => $request->input('did'),
            'username' => $request->input('emailc'),
            'userpassword' => $request->input('password'),
            'leveid' => $request->input('level'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => $SessionUserID,

        ]);

        if ($response->successful()) {
            return redirect('/userinfo');

        }

    }

    public function editUserLogin(Request $request)
    {
        $UpdateUserCredentials = env('API_UPDATE_USER_CREDENTIALS');
        $response = Http::put($UpdateUserCredentials, [
            'userid' => $request->input('userid'),
            'username' => $request->input('editusername'),
            'userpassword' => $request->input('editpassword'),

        ]);

        if ($response->successful()) {
            return redirect('/userlogins');

        }

    }
    public function UPDATEUSERINFO(Request $request)
    {

        $now = new DateTime();
        $SessionUserID = session()->get('userid');
        $UpdateUserDetails = env('API_UPDATE_USER_DETAILS');
        $response = Http::put($UpdateUserDetails, [
            'did' => $request->input('edid'),
            'firstname' => $request->input('editfirstname'),
            'middlename' => $request->input('editmiddlename'),
            'lastname' => $request->input('editlastname'),
            'email' => $request->input('editemail'),
            'contact' => $request->input('editcontact'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => $SessionUserID,


        ]);

        if ($response->successful()) {
            return back();
        }

    }


    public function GetAccess(Request $request)
    {

        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $GetHCPN = env('API_GET_HCPN');

        $GetRegionalOffice = env('API_GET_REGIONAL_OFFICE');
        $apiPro = Http::withoutVerifying()->get($GetRegionalOffice);
        $decodedPro = $apiPro->json();
        $RegionalOffices = json_decode($decodedPro['result'], true);
        $RoleIndexResponse = Http::withoutVerifying()->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
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
        $InsertRoleIndex = env('API_INSERT_ROLE_INDEX');
        $now = new DateTime();
        $AddProResponse = Http::post($InsertRoleIndex, [
            'userid' => $request->input('userid'),
            'accessid' => $request->input('accessid'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),
        ]);


        if ($AddProResponse->successful()) {

            return back();
        }
    }

}


