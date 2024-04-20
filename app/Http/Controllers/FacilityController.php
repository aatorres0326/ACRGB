<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class FacilityController extends Controller
{

    public function GetFacilities()
    {
        // Assuming $apiResponse contains the JSON response from your API
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GETALLFACILITY');


        $decodedResponse = $apiResponse->json();

        // Extract the result array
        $facilities = json_decode($decodedResponse['result'], true);
        $SessionUserID = session()->get('userid');
        $userLevel = session()->get('leveid');


        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        if ($userLevel == 'PRO') {
            $apiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetFacilityUsingProAccountUserID/' . $SessionUserID);
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/facilities', compact('facilities', 'HCFUnderPro', 'ManagingBoard'));
        } elseif ($userLevel == 'PHIC') {
            $apiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GETALLFACILITY');
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/facilities', compact('HCFUnderPro', 'ManagingBoard'));
        } else {
            $ApiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetMBUsingUserIDMBID/' . $SessionUserID);
            $decodedHCFUnderPro = $ApiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/facilities', compact('facilities', 'HCFUnderPro', 'ManagingBoard'));
        }


    }

    public function addFacility(Request $request)
    {


        $response = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/InsertHCIFacility', [
            'hciname' => $request->input('hciname'),
            'address' => $request->input('address'),
            'accreditation' => $request->input('accreditation'),

        ]);

        if ($response->successful()) {
            return redirect('/facilities');

        }

    }

    public function EditHCFTagging(Request $request)
    {
        if ($request->input('t_type') == "APEX") {
            $response = Http::put('http://localhost:7001/ACRGB/ACRGBUPDATE/TAGGINGFACILITY', [
                'hcfcode' => $request->input('t_hcfcode'),
                'type' => $request->input('t_type')
            ]);

            $response2 = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTAPPELLATE', [
                'accessid' => $request->input('t_hcfcode'),
                'userid' => $request->input('appellate')
            ]);

            if ($response->successful() && $response2->successful()) {
                return back();
            }
        } else {
            $response = Http::put('http://localhost:7001/ACRGB/ACRGBUPDATE/TAGGINGFACILITY', [
                'hcfcode' => $request->input('t_hcfcode'),
                'type' => $request->input('t_type')
            ]);

            if ($response->successful()) {
                return back();
            }
        }
    }



}