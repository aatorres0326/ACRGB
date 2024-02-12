<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class APIController extends Controller
{

    public function displayData()
    {

        // Assuming $apiResponse contains the JSON response from your API
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAccountPayable');
        $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHCIFacility');

        // Debug: Dump the HTTP response


        // Extract the JSON response body
        $decodedFacilityResponse = $facilityapiResponse->json();

        // Extract the result array
        $facilities = json_decode($decodedFacilityResponse['result'], true);
        // Debug: Dump the HTTP response


        // Extract the JSON response body
        $decoded = $apiResponse->json();

        // Extract the result array
        $result = json_decode($decoded['result'], true);

        return view('table', compact('result', 'facilities'));
    }




    public function apiData()
    {

        // Make a GET request to the API
        $response = Http::withoutVerifying()->get('https://api.publicapis.org/entries');
        $response->json();
        $apiresult = json_decode($response, true);



        return view('facilities', compact('apiresult'));
    }



    // end of testing



}


