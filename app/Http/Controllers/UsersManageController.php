<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class UsersManageController extends Controller
{
    public function users()
    {
        return view('users');
    }
    public function GetUsers()
    {
        // Assuming $apiResponse contains the JSON response from your API
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUser');
        $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHCIFacility');

        // Debug: Dump the HTTP response


        // Extract the JSON response body
        $decodedFacilityResponse = $facilityapiResponse->json();

        // Extract the result array
        $facilities = json_decode($decodedFacilityResponse['result'], true);
        // Debug: Dump the HTTP response


        // Extract the JSON response body
        $decodedResponse = $apiResponse->json();

        // Extract the result array
        $userList = json_decode($decodedResponse['result'], true);

        // Debug: Dump the user list


        return view('users', compact('userList', 'facilities'));
    }

    public function addUserAccount(Request $request)
    {

        $now = new DateTime();

        $response = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/InsertUser', [
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'datecreated' => $now->format('Y-m-d'),
            'hfid' => $request->input('hfid'),
        ]);

        if ($response->successful()) {
            return redirect('/users');

        }

    }
}


