<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class ProfileController extends Controller
{


    public function GetProfileInfo()
    {

        $facilityapiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthCareFacility/ACTIVE');
        $apiArea = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetArea/ACTIVE');
        $apiUserInfo = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUser/ACTIVE');

        // Extract the JSON response body
        $decodedFacilityResponse = $facilityapiResponse->json();
        $decodedArea = $apiArea->json();
        $decodedUserInfo = $apiUserInfo->json();

        $facilities = json_decode($decodedFacilityResponse['result'], true);
        $area = json_decode($decodedArea['result'], true);
        $userInfoList = json_decode($decodedUserInfo['result'], true);

        $facilities = collect($facilities);
        $area = collect($area);
        $userInfoList = collect($userInfoList);

        return view('profile', compact('facilities', 'area', 'userInfoList'));
    }


    public function UpdateProfileLogin(Request $request)
    {

        $response = Http::put('http://localhost:7001/ACRGB/ACRGBUPDATE/UPDATEUSERCREDENTIALS', [
            'userid' => $request->input('userid'),
            'username' => $request->input('editusername'),
            'userpassword' => $request->input('editpassword'),


        ]);

        if ($response->successful()) {
            return redirect('/profile');

        }

    }





}


