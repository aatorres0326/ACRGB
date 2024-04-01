<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AssetsController extends Controller
{


    public function GetAssets()
    {

        $assetsapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAssets/ACTIVE');
        $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthCareFacility/ACTIVE');
        $tranchapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetTranch/ACTIVE');
        // Extract the JSON response body
        $decodedAssetsResponse = $assetsapiResponse->json();
        $decodedFacilityResponse = $facilityapiResponse->json();
        $decodedTranchResponse = $tranchapiResponse->json();




        // Extract the result array

        $Assets = json_decode($decodedAssetsResponse['result'], true);
        $Facilities = json_decode($decodedFacilityResponse['result'], true);
        $Tranch = json_decode($decodedTranchResponse['result'], true);

        $Assets = collect($Assets);
        $Facilities = collect($Facilities);
        $Tranch = collect($Tranch);
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('BudgetManagement/assets', compact('Assets', 'Facilities', 'Tranch', 'ManagingBoard'));
    }


}


