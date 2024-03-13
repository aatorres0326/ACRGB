<?php

namespace App\Http\Controllers;



use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function AreaManagement()
    {
        return view('area-management');
    }
    public function GetArea()
    {

        $apiAreaType = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAreaType/ACTIVE');
        $apiArea = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetArea/ACTIVE');
        $apiUsers = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUser/ACTIVE');




        $decodedAreaType = $apiAreaType->json();
        $decodedArea = $apiArea->json();
        $decodedUsers = $apiUsers->json();


        $AreaType = json_decode($decodedAreaType['result'], true);
        $Area = json_decode($decodedArea['result'], true);
        $Users = json_decode($decodedUsers['result'], true);




        return view('AreaManagement/area-management', compact('AreaType', 'Area', 'Users'));
    }

    public function AddAreaType(Request $request)
    {

        $now = new DateTime();
        $ATresponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTAREATYPE', [
            'typename' => $request->input('typename'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),

        ]);

        if ($ATresponse->successful()) {
            return redirect('/area');

        }

    }

    public function AddArea(Request $request)
    {

        $now = new DateTime();
        $ATresponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTAREA', [
            'areaname' => $request->input('areaname'),
            'typeid' => $request->input('areatype'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),

        ]);

        if ($ATresponse->successful()) {
            return redirect('/area');

        }

    }


    // REGIONAL OFFICE CONTROLLER
    public function GetRegionalOffice()
    {

        $apiPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetPro/ACTIVE');

        $decodedPro = $apiPro->json();

        $RegionalOffices = json_decode($decodedPro['result'], true);

        return view('AreaManagement/pro-management', compact('RegionalOffices'));
    }

    public function addPro(Request $request)
    {

        $now = new DateTime();
        $AddProResponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTPRO', [
            'proname' => $request->input('proname'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),

        ]);

        if ($AddProResponse->successful()) {
            return redirect('/pro');

        }

    }

    // END OF REGIONAL OFFICE CONTROLLER

    // MANAGING BOARD CONTROLLER

    public function GetManagingBoard()
    {
        $SessionUserID = session()->get('userid');
        $ApiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndexWithID/' . $SessionUserID);
        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('AreaManagement/managing-board', compact('HCFUnderPro', 'ManagingBoard'));
    }
    public function INSERTManagingBoard(Request $request)
    {

        $now = new DateTime();
        $AddProResponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTManagingBoard', [
            'mbname' => $request->input('mbname'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),

        ]);

        if ($AddProResponse->successful()) {
            return redirect('/managingboard');

        }

    }
    public function GetMbAccess(Request $request)
    {

        $RoleIndexResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndex/0');
        $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthCareFacility/ACTIVE');

        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $decodedFacilityResponse = $facilityapiResponse->json();

        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $Facilities = json_decode($decodedFacilityResponse['result'], true);

        $RoleIndex = collect($RoleIndex);
        $Facilities = collect($Facilities);





        $SelectedMbID = $request->query('mbid', '');
        $SelectedMbName = $request->query('mbname', '');



        return view('AreaManagement/mb-access-assignment', compact('RoleIndex', 'Facilities', 'SelectedMbID', 'SelectedMbName'));
    }
    public function INSERTROLEINDEXMB(Request $request)
    {
        $now = new DateTime();
        $AddProResponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTROLEINDEX', [
            'userid' => $request->input('mbid'),
            'accessid' => $request->input('accessid'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),
        ]);

        $SelectedMbID = $request->input('mbid');
        $SelectedMbName = $request->input('mbname');

        if ($AddProResponse->successful()) {
            // Pass all necessary variables to the view
            return redirect('/mbaccess?mbid=' . $SelectedMbID . '&mbname=' . $SelectedMbName);
        }
    }


    public function GetProAccess(Request $request)
    {

        $RoleIndexResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndex/0');
        $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthCareFacility/ACTIVE');

        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $decodedFacilityResponse = $facilityapiResponse->json();

        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $Facilities = json_decode($decodedFacilityResponse['result'], true);

        $RoleIndex = collect($RoleIndex);
        $Facilities = collect($Facilities);


        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);


        $SelectedProID = $request->query('proid', '');
        $SelectedProName = $request->query('proname', '');

        $ApiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndexWithID/167');
        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


        return view('AreaManagement/pro-access-assignment', compact('RoleIndex', 'Facilities', 'SelectedProID', 'SelectedProName', 'ManagingBoard', 'HCFUnderPro'));
    }

    public function INSERTROLEINDEXPRO(Request $request)
    {
        $now = new DateTime();
        $AddProResponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTROLEINDEX', [
            'userid' => $request->input('proid'),
            'accessid' => $request->input('accessid'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),
        ]);

        $SelectedProID = $request->input('proid');
        $SelectedProName = $request->input('proname');

        if ($AddProResponse->successful()) {
            // Pass all necessary variables to the view
            return redirect('/proaccess?proid=' . $SelectedProID . '&proname=' . $SelectedProName);
        }
    }

}


