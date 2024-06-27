<?php

namespace App\Http\Controllers;



use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class FacilityController extends Controller
{

    public function GetFacilities()
    {
        $GetAllFacility = env('API_GET_ALL_FACILITIES');
        $apiResponse = Http::withoutVerifying()->get($GetAllFacility . '/ALL/0');

        $decodedResponse = $apiResponse->json();

        $facilities = json_decode($decodedResponse['result'], true);
        $SessionUserID = session()->get('userid');
        $userLevel = session()->get('leveid');

        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        if ($userLevel == 'PRO') {
            $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
            $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/facilities', compact('facilities', 'HCFUnderPro', 'ManagingBoard'));
        } elseif ($userLevel == 'PHIC') {

            $apiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility . '/ALL/0');
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);



            return view('Facilities/facilities', compact('HCFUnderPro', 'ManagingBoard'));
        } else {
            $ApiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility . "/HCPN/" . $SessionUserID);
            $decodedHCFUnderPro = $ApiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/facilities', compact('HCFUnderPro', 'ManagingBoard'));
        }


    }

    public function GetApexFacilities()
    {
        $GetAllFacility = env('API_GET_ALL_FACILITIES');
        $apiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
        $decodedHCFUnderPro = $apiHCFUnderPro->json();
        $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);


        return view('Facilities/apex-facilities', compact('HCFUnderPro', 'ManagingBoard'));



    }

    public function EditHCFTagging(Request $request)
    {
        $SessionUserID = session()->get('userid');
        $InsertApellate = env('API_INSERT_APELLATE');
        $now = new DateTime;

        $response2 = Http::post($InsertApellate, [
            'accessid' => $request->input('t_hcfcode'),
            'userid' => $request->input('appellate'),
            'createdby' => $SessionUserID,
            'datecreated' => $now->format('m-d-Y'),
        ]);


        if ($response2->successful()) {
            return back();
        }

    }
    public function ApexAffiliates(Request $request)
    {

        $SelectedHCFCode = $request->query('hcfcode', '');
        $SelectedHCFName = $request->query('hcfname', '');

        $GetRoleIndex = env('API_GET_ROLE_INDEX');
        $RoleIndexResponse = Http::withoutVerifying()->get($GetRoleIndex . '/0');
        $decodedRoleIndexResponse = $RoleIndexResponse->json();
        $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
        $RoleIndex = collect($RoleIndex);



        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);


        return view('Facilities/apex-affiliates', compact('RoleIndex', 'SelectedHCFCode', 'SelectedHCFName', 'ManagingBoard'));
    }


}