<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class FacilityController extends Controller
{
    public function facilities()
    {
        return view('facilities');
    }
    public function GetFacilities()
    {
        // Assuming $apiResponse contains the JSON response from your API
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthCareFacility/ACTIVE');

        // Debug: Dump the HTTP response
        // dd($apiResponse);

        // Extract the JSON response body
        $decodedResponse = $apiResponse->json();

        // Extract the result array
        $facilities = $decodedResponse['result'];
        $SessionUserID = session()->get('userid');
        $userLevel = session()->get('leveid');

        if ($userLevel == 'PRO') {
            $apiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetRoleIndexWithID/' . $SessionUserID);
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result']);


            return view('Facilities/facilities', compact('facilities', 'HCFUnderPro'));
        } else {
            $ApiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetMBUsingUserIDMBID/' . $SessionUserID);
            $decodedHCFUnderPro = $ApiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


            return view('Facilities/facilities', compact('facilities', 'HCFUnderPro'));
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

}


