<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class APIController extends Controller
{

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


    public function getData($API)
    {
        // Make a request to your API to get data based on the selected ID
        $response = Http::get('https://api.publicapis.org/entries' . $API);
        $data = $response->json(); // Assuming the response is JSON

        return response()->json($data);
    }
}


