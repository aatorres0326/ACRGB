<?php

namespace App\Http\Controllers;



use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    // REGIONAL OFFICE CONTROLLER
    public function GetRegionalOffice()
    {
        $token = session()->get('token');
        $GetRegionalOffice = env('API_GET_REGIONAL_OFFICE');
        $apiPro = Http::withHeaders(['token' => $token])->get($GetRegionalOffice . '/ACTIVE');
        $decodedPro = $apiPro->json();
        $RegionalOffices = json_decode($decodedPro['result'], true);

        return view('AreaManagement/pro-management', compact('RegionalOffices'));
    }

    // END OF REGIONAL OFFICE CONTROLLER

    // MANAGING BOARD CONTROLLER

    public function GetManagingBoard()
    {
        $token = session()->get('token');
        $SessionUserID = session()->get('userid');

        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);
        $HCFUnderPro = collect($HCFUnderPro);

        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);
        $ManagingBoard = collect($ManagingBoard);

        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $RoleIndexResponse = Http::withHeaders(['token' => $token])->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $RoleIndex = collect($RoleIndex);

        $GetContract = env('API_GET_CONTRACT');
        $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/0/PHICHCPN');
        $decodedapiContract = $apiContract->json();
        $Contracts = json_decode($decodedapiContract['result'], true);

        return view('AreaManagement/managing-board', compact('HCFUnderPro', 'ManagingBoard', 'RoleIndex', 'Contracts'));
    }
    public function INSERTManagingBoard(Request $request)
    {
        $token = session()->get('token');
        $SessionUserID = session()->get('userid');
        $enddate = $request->input('licensedateto');
        $datef = date_create($enddate);
        $enddateformat = date_format($datef, "m-d-Y");
        $startdate = $request->input('licensedatefrom');
        $dates = date_create($startdate);
        $startdateformat = date_format($dates, "m-d-Y");
        $now = new DateTime();

        $InsertHCPN = env('API_INSERT_HCPN');
        $AddProResponse = Http::withHeaders(['token' => $token])->post($InsertHCPN, [
            'mbname' => $request->input('mbname'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => $SessionUserID,
            'controlnumber' => $request->input('accreditation'),
            'address' => $request->input('address'),
            'bankaccount' => $request->input('bankaccount'),
            'bankname' => $request->input('bankname'),
            'licensedatefrom' => $startdateformat,
            'licensedateto' => $enddateformat,
        ]);

        if ($AddProResponse->successful()) {
            return back()->with('success', 'Managing board added successfully!');
        } else {
            return back()->with('error', 'Failed to add managing board.');
        }
    }



    public function GetMbAccess(Request $request)
    {
        $token = session()->get('token');
        $SelectedMbID = $request->query('mbid', '');
        $SelectedMbName = $request->query('mbname', '');

        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $RoleIndexResponse = Http::withHeaders(['token' => $token])->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $RoleIndex = collect($RoleIndex);

        $GetAllFacilities = env('API_GET_ALL_FACILITIES');
        $facilityapiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacilities . "/ALL/0");
        $decodedFacilityResponse = $facilityapiResponse->json();
        $Facilities = json_decode($decodedFacilityResponse['result'], true);
        $Facilities = collect($Facilities);

        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);


        return view('AreaManagement/mb-access-assignment', compact('RoleIndex', 'Facilities', 'SelectedMbID', 'SelectedMbName', 'ManagingBoard'));
    }
    public function INSERTROLEINDEXMB(Request $request)
    {
        $token = session()->get('token');
        $now = new DateTime();
        $InsertRoleIndex = env('API_INSERT_ROLE_INDEX');
        $AddProResponse = Http::withHeaders(['token' => $token])->post($InsertRoleIndex, [
            'userid' => $request->input('mbid'),
            'accessid' => $request->input('accessid'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),
        ]);

        if ($AddProResponse->successful()) {

            return back();
        }
    }


    public function GetProAccess(Request $request)
    {
        $token = session()->get('token');
        $SelectedProCode = $request->query('proid', '');
        $SessionUserID = session()->get('userid');
        $SelectedProID = $request->query('proid', '');
        $SelectedProName = $request->query('proname', '');

        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $RoleIndexResponse = Http::withHeaders(['token' => $token])->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $RoleIndex = collect($RoleIndex);

        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $GetHCPNwithPro = env('API_GET_HCPN_USING_PRO_USERID');
        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithPro . '/' . $SelectedProCode . '/PHIC');
        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

        $GetRegionalOffice = env('API_GET_REGIONAL_OFFICE');
        $apiPro = Http::withHeaders(['token' => $token])->get($GetRegionalOffice . '/ACTIVE');
        $decodedPro = $apiPro->json();
        $RegionalOffices = json_decode($decodedPro['result'], true);

        return view('AreaManagement/pro-access-assignment', compact('RoleIndex', 'SelectedProID', 'SelectedProName', 'ManagingBoard', 'HCFUnderPro', 'RegionalOffices'));
    }

    public function INSERTROLEINDEXPRO(Request $request)
    {
        $token = session()->get('token');
        $now = new DateTime();
        $InsertRoleIndex = env('API_INSERT_ROLE_INDEX');
        $AddProResponse = Http::withHeaders(['token' => $token])->post($InsertRoleIndex, [
            'userid' => $request->input('proid'),
            'accessid' => $request->input('accessid'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),
        ]);


        if ($AddProResponse->successful()) {

            return back();
        }
    }

    public function REMOVEROLEINDEXPRO(Request $request)
    {
        $token = session()->get('token');
        $now = new DateTime();
        $RemoveRoleIndex = env('API_REMOVE_ROLE_INDEX');
        $RemoveProResponse = Http::withHeaders(['token' => $token])->put($RemoveRoleIndex, [
            'userid' => $request->input('proid'),
            'accessid' => $request->input('accessid'),
        ]);

        if ($RemoveProResponse->successful()) {

            return back();
        }
    }

    public function REMOVEROLEINDEXHCPN(Request $request)
    {
        $token = session()->get('token');
        $userid = session()->get('userid');
        $hcpn = $request->input('remove-hcpn');
        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $RoleIndexResponse = Http::withHeaders(['token' => $token])->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();

        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $roleIndexData = null;

        foreach ($RoleIndex as $role) {
            if ($role['userid'] == $userid) {
                $roleIndexData = $role;
                break;
            }
        }

        if ($roleIndexData) {
            $procode = $roleIndexData['accessid'];
        } else {
            return back()->withErrors(['error' => 'Role index data not found for user.']);
        }

        $RemoveRoleIndex = env('API_REMOVE_ROLE_INDEX');
        $RemoveProResponse = Http::withHeaders(['token' => $token])->put($RemoveRoleIndex, [
            'userid' => $procode,
            'accessid' => $request->input('remove-controlnumber'),
        ]);

        if ($RemoveProResponse->successful()) {
            return back()->with('success', 'Access to ' . $hcpn . ' were removed successfully.');
        } else {
            return back()->withErrors(['error' => 'Failed to remove Network.']);
        }
    }


    public function UpdateHCPN(Request $request)
    {
        $token = session()->get('token');
        $Userid = session()->get('userid');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                $now = new DateTime();

                $UpdateHCPN = env('API_UPDATE_HCPN');
                $response = Http::withHeaders(['token' => $token])->put($UpdateHCPN, [
                    'mbid' => $request->input('hcpn-id'),
                    'mbname' => $request->input('edit-hcpn'),
                    'datecreated' => $now->format('m-d-Y'),
                    'createdby' => $Userid,
                    'controlnumber' => $request->input('edit-controlnumber'),
                    'address' => $request->input('edit-address'),
                    'bankaccount' => $request->input('edit-bank-account'),
                    'bankname' => $request->input('edit-bank-name'),
                ]);

                if ($response->successful()) {
                    return back()->with('alert', 'Update Successful');
                }
            } else {

                redirect('login');
            }


        }

    }


}