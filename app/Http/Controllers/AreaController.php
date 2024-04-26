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


    // REGIONAL OFFICE CONTROLLER
    public function GetRegionalOffice()
    {

        $apiPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetPro');

        $decodedPro = $apiPro->json();

        $RegionalOffices = json_decode($decodedPro['result'], true);

        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('AreaManagement/pro-management', compact('RegionalOffices', 'ManagingBoard'));
    }

    // END OF REGIONAL OFFICE CONTROLLER

    // MANAGING BOARD CONTROLLER

    public function GetManagingBoard()
    {
        $SessionUserID = session()->get('userid');
        $ApiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoardWithProID/' . $SessionUserID . "/PRO");
        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('AreaManagement/managing-board', compact('HCFUnderPro', 'ManagingBoard'));
    }
    public function INSERTManagingBoard(Request $request)
    {
        // Dump the incoming request data for debugging



        $now = new DateTime();
        $AddProResponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTHCPN', [
            'mbname' => $request->input('mbname'),
            'datecreated' => $now->format('m-d-Y'),
            'createdby' => $request->input('createdby'),
            'controlnumber' => $request->input('accreditation'),
            'licensedatefrom' => $request->input('licensedatefrom'),
            'licensedateto' => $request->input('licensedateto'),
        ]);

        // Dump the response for debugging


        if ($AddProResponse->successful()) {
            return redirect('/managingboard');
        }
    }


    public function GetMbAccess(Request $request)
    {

        $RoleIndexResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndex/0');
        $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GETALLFACILITY');

        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $decodedFacilityResponse = $facilityapiResponse->json();

        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $Facilities = json_decode($decodedFacilityResponse['result'], true);

        $RoleIndex = collect($RoleIndex);
        $Facilities = collect($Facilities);





        $SelectedMbID = $request->query('mbid', '');
        $SelectedMbName = $request->query('mbname', '');

        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('AreaManagement/mb-access-assignment', compact('RoleIndex', 'Facilities', 'SelectedMbID', 'SelectedMbName', 'ManagingBoard'));
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
        $SelectedProCode = $request->query('proid', '');
        $SessionUserID = session()->get('userid');
        $RoleIndexResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndex/0');


        $decodedRoleIndexResponse = $RoleIndexResponse->json();


        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);


        $RoleIndex = collect($RoleIndex);



        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);


        $SelectedProID = $request->query('proid', '');
        $SelectedProName = $request->query('proname', '');

        $ApiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoardWithProID/' . $SelectedProCode . '/PHIC');
        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

        $apiPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetPro');

        $decodedPro = $apiPro->json();

        $RegionalOffices = json_decode($decodedPro['result'], true);


        return view('AreaManagement/pro-access-assignment', compact('RoleIndex', 'SelectedProID', 'SelectedProName', 'ManagingBoard', 'HCFUnderPro', 'RegionalOffices'));
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
    public function REMOVEROLEINDEXPRO(Request $request)
    {
        $now = new DateTime();
        $RemoveProResponse = Http::put('http://localhost:7001/ACRGB/ACRGBUPDATE/RemoveAccessRole', [
            'userid' => $request->input('proid'),
            'accessid' => $request->input('accessid'),
        ]);

        $SelectedProID = $request->input('proid');
        $SelectedProName = $request->input('proname');

        if ($RemoveProResponse->successful()) {
            // Pass all necessary variables to the view
            return redirect('/proaccess?proid=' . $SelectedProID . '&proname=' . $SelectedProName);
        }
    }



}


