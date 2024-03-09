<?php

namespace App\Http\Controllers;



use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function AreaManagement()
    {
        return view('area-management');
    }
    public function GetArea()
    {

        $apiAreaType = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAreaType/ACTIVE');
        $apiArea = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetArea/ACTIVE');
        $apiUsers = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetUser/ACTIVE');




        $decodedAreaType = $apiAreaType->json();
        $decodedArea = $apiArea->json();
        $decodedUsers = $apiUsers->json();


        $AreaType = json_decode($decodedAreaType['result'], true);
        $Area = json_decode($decodedArea['result'], true);
        $Users = json_decode($decodedUsers['result'], true);




        return view('AreaManagement/area-management', compact('AreaType', 'Area', 'Users'));
    }

    public function AddAreaType(Request $request)
    {

        $now = new DateTime();
        $ATresponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTAREATYPE', [
            'typename' => $request->input('typename'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),

        ]);

        if ($ATresponse->successful()) {
            return redirect('/area');

        }

    }

    public function AddArea(Request $request)
    {

        $now = new DateTime();
        $ATresponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTAREA', [
            'areaname' => $request->input('areaname'),
            'typeid' => $request->input('areatype'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),

        ]);

        if ($ATresponse->successful()) {
            return redirect('/area');

        }

    }


    // REGIONAL OFFICE CONTROLLER
    public function GetRegionalOffice()
    {

        $apiPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetPro/ACTIVE');

        $decodedPro = $apiPro->json();

        $RegionalOffices = json_decode($decodedPro['result'], true);

        return view('AreaManagement/pro-management', compact('RegionalOffices'));
    }

    public function addPro(Request $request)
    {

        $now = new DateTime();
        $AddProResponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTPRO', [
            'proname' => $request->input('proname'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),

        ]);

        if ($AddProResponse->successful()) {
            return redirect('/pro');

        }

    }

    // END OF REGIONAL OFFICE CONTROLLER

    // MANAGING BOARD CONTROLLER

    public function GetManagingBoard()
    {

        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('AreaManagement/managing-board', compact('ManagingBoard'));
    }
    public function INSERTManagingBoard(Request $request)
    {

        $now = new DateTime();
        $AddProResponse = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTManagingBoard', [
            'mbname' => $request->input('mbname'),
            'createdby' => $request->input('createdby'),
            'datecreated' => $now->format('m-d-Y'),

        ]);

        if ($AddProResponse->successful()) {
            return redirect('/managingboard');

        }

    }


}


