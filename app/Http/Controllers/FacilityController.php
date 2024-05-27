<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class FacilityController extends Controller
{

    public function GetFacilities()
    {
        $GetAllFacility = env('API_GET_ALL_FACILITIES');
        $apiResponse = Http::withoutVerifying()->get($GetAllFacility);

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

            $apiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility);
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/facilities', compact('HCFUnderPro', 'ManagingBoard'));
        } else {
            $ApiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility);
            $decodedHCFUnderPro = $ApiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/facilities', compact('facilities', 'HCFUnderPro', 'ManagingBoard'));
        }


    }

    public function GetApexFacilities()
    {
        $GetAllFacility = env('API_GET_ALL_FACILITIES');
        $apiResponse = Http::withoutVerifying()->get($GetAllFacility);

        $decodedResponse = $apiResponse->json();

        $facilities = json_decode($decodedResponse['result'], true);
        $SessionUserID = session()->get('userid');
        $userLevel = session()->get('leveid');

        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        if ($userLevel == 'PRO') {
            $GetFacilitywithPro = env('API_GET_ALL_FACILITIES');
            $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/apex-facilities', compact('facilities', 'HCFUnderPro', 'ManagingBoard'));
        } elseif ($userLevel == 'PHIC') {

            $apiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility);
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/apex-facilities', compact('HCFUnderPro', 'ManagingBoard'));
        } else {
            $ApiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility);
            $decodedHCFUnderPro = $ApiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/apex-facilities', compact('facilities', 'HCFUnderPro', 'ManagingBoard'));
        }


    }

    public function EditHCFTagging(Request $request)
    {
        $FacilityTagging = env('API_FACILITY_TAGGING');
        $InsertApellate = env('API_INSERT_APELLATE');
        if ($request->input('t_type') == "APEX") {
            $response = Http::put($FacilityTagging, [
                'hcfcode' => $request->input('t_hcfcode'),
                'type' => $request->input('t_type')
            ]);

            $response2 = Http::post($InsertApellate, [
                'accessid' => $request->input('t_hcfcode'),
                'userid' => $request->input('appellate')
            ]);

            if ($response->successful() && $response2->successful()) {
                return back();
            }
        } else {
            $response = Http::put($FacilityTagging, [
                'hcfcode' => $request->input('t_hcfcode'),
                'type' => $request->input('t_type')
            ]);

            if ($response->successful()) {
                return back();
            }
        }
    }



}