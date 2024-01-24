<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class UsersManageController extends Controller
{
    public function users()
    {
        return view('users');
    }
    public function GetUsers()
    {
        // Assuming $apiResponse contains the JSON response from your API
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHCIFacility');

        // Debug: Dump the HTTP response


        // Extract the JSON response body
        $decodedResponse = $apiResponse->json();

        // Extract the result array
        $facilities = json_decode($decodedResponse['result'], true);

        // Debug: Dump the user list


        return view('users', compact('facilities'));
    }


}


