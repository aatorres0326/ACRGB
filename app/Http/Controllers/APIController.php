<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class APIController extends Controller
{

    public function GetUsers()
    {
        // Assuming $apiResponse contains the JSON response from your API
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUser');

        // Debug: Dump the HTTP response
        dd($apiResponse->status(), $apiResponse->json());

        // Extract the JSON response body
        $decodedResponse = $apiResponse->json();

        // Extract the result array
        $userList = $decodedResponse['result'];

        // Debug: Dump the user list
        dd($userList);

        return view('users', compact('userList'));
    }



    public function displayData()
    {

        // Make a GET request to the API
        $response = Http::withoutVerifying()->get('https://api.publicapis.org/entries');
        $response->json();
        $result = json_decode($response, true);
        // $newData = $result['entries'];

        return view('table', compact('result'));
    }
    public function displayBudget()
    {

        // Make a GET request to the API
        $response = Http::withoutVerifying()->get('https://api.publicapis.org/entries');
        $response->json();
        $result = json_decode($response, true);
        // $newData = $result['entries'];

        return view('budget-management', compact('result'));
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


