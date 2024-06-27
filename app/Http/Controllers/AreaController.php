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
        $SessionUserID = session()->get('userid');

        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
        $ApiHCFUnderPro = Http::withoutVerifying()->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);
        $HCFUnderPro = collect($HCFUnderPro);

        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);
        $ManagingBoard = collect($ManagingBoard);

        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $RoleIndexResponse = Http::withoutVerifying()->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $RoleIndex = collect($RoleIndex);

        return view('AreaManagement/managing-board', compact('HCFUnderPro', 'ManagingBoard', 'RoleIndex'));
    }
    public function INSERTManagingBoard(Request $request)
    {

        $SessionUserID = session()->get('userid');
        $enddate = $request->input('licensedateto');
        $datef = date_create($enddate);
        $enddateformat = date_format($datef, "m-d-Y");
        $startdate = $request->input('licensedatefrom');
        $dates = date_create($startdate);
        $startdateformat = date_format($dates, "m-d-Y");
        $now = new DateTime();

        $InsertHCPN = env('API_INSERT_HCPN');
        $AddProResponse = Http::post($InsertHCPN, [
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

            return back();
        }

    }


    public function GetMbAccess(Request $request)
    {

        $SelectedMbID = $request->query('mbid', '');
        $SelectedMbName = $request->query('mbname', '');

        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $RoleIndexResponse = Http::withoutVerifying()->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $RoleIndex = collect($RoleIndex);

        $GetAllFacilities = env('API_GET_ALL_FACILITIES');
        $facilityapiResponse = Http::withoutVerifying()->get($GetAllFacilities . "/ALL/0");
        $decodedFacilityResponse = $facilityapiResponse->json();
        $Facilities = json_decode($decodedFacilityResponse['result'], true);
        $Facilities = collect($Facilities);

        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);


        return view('AreaManagement/mb-access-assignment', compact('RoleIndex', 'Facilities', 'SelectedMbID', 'SelectedMbName', 'ManagingBoard'));
    }
    public function INSERTROLEINDEXMB(Request $request)
    {
        $now = new DateTime();
        $InsertRoleIndex = env('API_INSERT_ROLE_INDEX');
        $AddProResponse = Http::post($InsertRoleIndex, [
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
        $SelectedProCode = $request->query('proid', '');
        $SessionUserID = session()->get('userid');
        $SelectedProID = $request->query('proid', '');
        $SelectedProName = $request->query('proname', '');

        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $RoleIndexResponse = Http::withoutVerifying()->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $RoleIndex = collect($RoleIndex);

        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $GetHCPNwithPro = env('API_GET_HCPN_USING_PRO_USERID');
        $ApiHCFUnderPro = Http::withoutVerifying()->get($GetHCPNwithPro . '/' . $SelectedProCode . '/PHIC');
        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

        $GetRegionalOffice = env('API_GET_REGIONAL_OFFICE');
        $apiPro = Http::withoutVerifying()->get($GetRegionalOffice . '/ACTIVE');
        $decodedPro = $apiPro->json();
        $RegionalOffices = json_decode($decodedPro['result'], true);

        return view('AreaManagement/pro-access-assignment', compact('RoleIndex', 'SelectedProID', 'SelectedProName', 'ManagingBoard', 'HCFUnderPro', 'RegionalOffices'));
    }

    public function INSERTROLEINDEXPRO(Request $request)
    {
        $now = new DateTime();
        $InsertRoleIndex = env('API_INSERT_ROLE_INDEX');
        $AddProResponse = Http::post($InsertRoleIndex, [
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
        $now = new DateTime();
        $RemoveRoleIndex = env('API_REMOVE_ROLE_INDEX');
        $RemoveProResponse = Http::put($RemoveRoleIndex, [
            'userid' => $request->input('proid'),
            'accessid' => $request->input('accessid'),
        ]);

        if ($RemoveProResponse->successful()) {

            return back();
        }
    }



}