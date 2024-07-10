<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;



class UsersManageController extends Controller
{

    public function GetUsers()
    {
        $token = session()->get('token');
        $UserID = session()->get('userid');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $GetHCPN = env('API_GET_HCPN');
                $GetUser = env('API_GET_USER');
                if (session()->get('leveid') == "ADMIN") {


                    $apiUser = Http::withHeaders(['token' => $token])->get($GetUser . '/ACTIVE/0');
                } else if (session()->get('leveid') == "PRO") {


                    $apiUser = Http::withHeaders(['token' => $token])->get($GetUser . '/ACTIVE/' . $UserID);

                }

                $GetUserLevel = env('API_GET_USER_LEVEL');
                $apiUserLevel = Http::withHeaders(['token' => $token])->get($GetUserLevel . '/ACTIVE');

                $decodedResponse = $apiUser->json();
                $decodedapiUserLevel = $apiUserLevel->json();
                $userList = json_decode($decodedResponse['result'], true);
                $userLevel = json_decode($decodedapiUserLevel['result'], true);



                return view('UserManagement/users-login', compact('userList', 'userLevel'));
            }
            //========================TOKEN
        } else {

            redirect('login');
        }
    }

    //===================END TOKEN

    public function GetUsersInfo()
    {
        $token = session()->get('token');

        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        $UserID = session()->get('userid');
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $GetUser = env('API_GET_USER');
                $GetUserInfo = env('API_GET_USER_INFO');
                $GetUserLevel = env('API_GET_USER_LEVEL');
                $GetHCPN = env('API_GET_HCPN');
                if (session()->get('leveid') == "ADMIN") {
                    $apiUserInfo = Http::withHeaders(['token' => $token])->get($GetUserInfo . '/ACTIVE/0');

                    $apiUser = Http::withHeaders(['token' => $token])->get($GetUser . '/ACTIVE/0');
                } else if (session()->get('leveid') == "PRO") {
                    $apiUserInfo = Http::withHeaders(['token' => $token])->get($GetUserInfo . '/ACTIVE/' . $UserID);

                    $apiUser = Http::withHeaders(['token' => $token])->get($GetUser . '/ACTIVE/' . $UserID);

                }
                $apiLevel = Http::withHeaders(['token' => $token])->get($GetUserLevel . '/ACTIVE');
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
            //========================TOKEN
        } else {

            redirect('login');
        }
    }

    //===================END TOKEN

    public function GetProfileInfo()
    {
        $token = session()->get('token');

        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN

                $GetUser = env('API_GET_USER');
                $GetUserInfo = env('API_GET_USER_INFO');
                $GetUserLevel = env('API_GET_USER_LEVEL');
                $GetHCPN = env('API_GET_HCPN');
                $apiUserInfo = Http::withHeaders(['token' => $token])->get($GetUserInfo . '/ACTIVE/0');

                $apiUser = Http::withHeaders(['token' => $token])->get($GetUser . '/ACTIVE/0');
                $apiLevel = Http::withHeaders(['token' => $token])->get($GetUserLevel . '/ACTIVE');
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
            //========================TOKEN
        } else {

            redirect('login');
        }
    }

    //===================END TOKEN


    public function addUserInfo(Request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $SessionUserID = session()->get('userid');
                $now = new DateTime();
                $InsertUserDetails = env('API_INSERT_USER_DETAILS');
                $response = Http::withHeaders(['token' => $token])->post($InsertUserDetails, [
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
            //========================TOKEN
        } else {

            redirect('login');
        }
    }

    //===================END TOKEN

    public function addUserLogin(Request $request)
    {
        $token = session()->get('token');

        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $now = new DateTime();
                $SessionUserID = session()->get('userid');
                $InsertUser = env('API_INSERT_USER');
                $response = Http::withHeaders(['token' => $token])->post($InsertUser, [
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
                //========================TOKEN
            } else {

                redirect('login');
            }
        }

        //===================END TOKEN
    }

    public function editUserLogin(Request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $UpdateUserCredentials = env('API_UPDATE_USER_CREDENTIALS');
                $response = Http::withHeaders(['token' => $token])->put($UpdateUserCredentials, [
                    'userid' => $request->input('userid'),
                    'username' => $request->input('editusername'),
                    'userpassword' => $request->input('editpassword'),

                ]);

                if ($response->successful()) {
                    return redirect('/userlogins');
                }
                //========================TOKEN
            } else {

                redirect('login');
            }
        }

        //===================END TOKEN
    }

    public function UPDATEUSERINFO(Request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $now = new DateTime();
                $SessionUserID = session()->get('userid');
                $UpdateUserDetails = env('API_UPDATE_USER_DETAILS');
                $response = Http::withHeaders(['token' => $token])->put($UpdateUserDetails, [
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
                //========================TOKEN
            } else {

                redirect('login');
            }
        }

        //===================END TOKEN

    }




    public function GetAccess(Request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN

                $GetRoleIndex = env('API_GET_ROLE_INDEX');
                $GetHCPN = env('API_GET_HCPN');

                $GetRegionalOffice = env('API_GET_REGIONAL_OFFICE');
                $apiPro = Http::withHeaders(['token' => $token])->get($GetRegionalOffice . '/ACTIVE');
                $decodedPro = $apiPro->json();
                $RegionalOffices = json_decode($decodedPro['result'], true);
                $RoleIndexResponse = Http::withHeaders(['token' => $token])->get($GetRoleIndex . '/0');
                $decodedRoleIndexResponse = $RoleIndexResponse->json();
                $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
                $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $ManagingBoard = json_decode($decodedMB['result'], true);
                $RoleIndex = collect($RoleIndex);
                $ManagingBoard = collect($ManagingBoard);
                $SelectedUserRole = $request->query('leveid', '');
                $SelectedUserID = $request->query('userid', '');
                return view('UserManagement/access-assignments', compact('RoleIndex', 'RegionalOffices', 'ManagingBoard', 'SelectedUserRole', 'SelectedUserID'));
                //========================TOKEN
            } else {

                redirect('login');
            }
        }

        //===================END TOKEN
    }
    public function INSERTROLEINDEX(Request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $InsertRoleIndex = env('API_INSERT_ROLE_INDEX');
                $now = new DateTime();
                $AddProResponse = Http::withHeaders(['token' => $token])->post($InsertRoleIndex, [
                    'userid' => $request->input('userid'),
                    'accessid' => $request->input('accessid'),
                    'createdby' => $request->input('createdby'),
                    'datecreated' => $now->format('m-d-Y'),
                ]);


                if ($AddProResponse->successful()) {

                    return back();
                }
                //========================TOKEN
            } else {

                redirect('login');
            }
        }

        //===================END TOKEN
    }
    public function UploadUsers()
    {
        return view('UserManagement/upload-users');
    }
    public function UPLOADUSERSJSON(Request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $tabledata = $request->input('uploadusersjson');
                $decodedTableData = json_decode($tabledata, true);

                $UpdateUserDetails = env('API_UPLOAD_USERS');
                $response = Http::withHeaders(['token' => $token])->post($UpdateUserDetails, $decodedTableData);

                if ($response->successful()) {
                    return back()->with([
                        'decodedTableData' => $decodedTableData,
                        'apimessage' => $response['result']
                    ]);
                }

                return response()->json(['message' => 'Failed to process data'], 500);
                //========================TOKEN
            } else {

                redirect('login');
            }
        }

        //===================END TOKEN
    }
}