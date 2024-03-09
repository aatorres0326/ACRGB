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


        return view('UserManagement/users-login', compact('userList', 'userLevel'));
    }

    public function GetUsersInfo()
    {
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
    }


    public function addUserInfo(Request $request)
    {

        $now = new DateTime();

        $response = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTUSERDETAILS', [
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            // 'areaid' => $request->input('area'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => $request->input('createdby'),
            'hcfid' => $request->input('hcfid'),
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

        return view('UserManagement/role-management', compact('userLevel'));
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
        $apiPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetPro/ACTIVE');
        $decodedPro = $apiPro->json();
        $RegionalOffices = json_decode($decodedPro['result'], true);

        $RoleIndexResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndex/0');
        $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthCareFacility/ACTIVE');

        // Extract the JSON response body
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $decodedFacilityResponse = $facilityapiResponse->json();




        // Extract the result array

        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $Facilities = json_decode($decodedFacilityResponse['result'], true);

        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        $RoleIndex = collect($RoleIndex);
        $Facilities = collect($Facilities);
        $ManagingBoard = collect($ManagingBoard);




        $SelectedUserRole = $request->query('leveid', '');



        return view('UserManagement/access-assignments', compact('RoleIndex', 'Facilities', 'RegionalOffices', 'ManagingBoard', 'SelectedUserRole'));
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

        if ($AddProResponse->successful()) {
            return redirect('/useraccess');

        }

    }


}


