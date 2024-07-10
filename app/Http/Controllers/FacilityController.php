<?php

namespace App\Http\Controllers;



use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class FacilityController extends Controller
{

    public function GetFacilities()
    {
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $token = session()->get('token');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . '/ALL/0');

                $decodedResponse = $apiResponse->json();

                $facilities = json_decode($decodedResponse['result'], true);
                $SessionUserID = session()->get('userid');
                $userLevel = session()->get('leveid');

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $ManagingBoard = json_decode($decodedMB['result'], true);

                if ($userLevel == 'PRO') {
                    $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                    $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                    $decodedHCFUnderPro = $apiHCFUnderPro->json();
                    $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


                    return view('Facilities/facilities', compact('facilities', 'HCFUnderPro', 'ManagingBoard'));
                } elseif ($userLevel == 'PHIC') {

                    $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . '/ALL/0');
                    $decodedHCFUnderPro = $apiHCFUnderPro->json();
                    $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);



                    return view('Facilities/facilities', compact('HCFUnderPro', 'ManagingBoard'));
                } else {
                    $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                    $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                    $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


                    return view('Facilities/facilities', compact('HCFUnderPro', 'ManagingBoard'));
                }
            } else {

                redirect('login');
            }
        }

    }

    public function GetApexFacilities()
    {
        $token = session()->get('token');

        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                // $token = session()->get('token');
                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                $decodedHCFUnderPro = $apiHCFUnderPro->json();
                $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);


                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $ManagingBoard = json_decode($decodedMB['result'], true);


                return view('Facilities/apex-facilities', compact('HCFUnderPro', 'ManagingBoard'));

            } else {

                redirect('login');
            }

        }
    }

    public function EditHCFTagging(Request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN



                $SessionUserID = session()->get('userid');
                $InsertApellate = env('API_INSERT_APELLATE');
                $now = new DateTime;

                $response2 = Http::withHeaders(['token' => $token])->post($InsertApellate, [
                    'accessid' => $request->input('t_hcfcode'),
                    'userid' => $request->input('appellate'),
                    'createdby' => $SessionUserID,
                    'datecreated' => $now->format('m-d-Y'),
                ]);


                if ($response2->successful()) {
                    return back();
                }

                //========================TOKEN
            } else {

                redirect('login');
            }

        }

        //===================END TOKEN





    }
    public function ApexAffiliates(Request $request)
    {

        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                $SelectedHCFCode = $request->query('hcfcode', '');
                $SelectedHCFName = $request->query('hcfname', '');
                $GetRoleIndex = env('API_GET_ROLE_INDEX');
                $RoleIndexResponse = Http::withHeaders(['token' => $token])->get($GetRoleIndex . '/0');
                $decodedRoleIndexResponse = $RoleIndexResponse->json();
                $RoleIndex = json_decode($decodedRoleIndexResponse['result'], true);
                $RoleIndex = collect($RoleIndex);
                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $ManagingBoard = json_decode($decodedMB['result'], true);
                return view('Facilities/apex-affiliates', compact('RoleIndex', 'SelectedHCFCode', 'SelectedHCFName', 'ManagingBoard'));
            } else {

                redirect('login');
            }


        }





    }


}