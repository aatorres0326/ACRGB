<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;



class UtilitiesController extends Controller
{
    public function DATESETTINGS()
    {
        // GET HCPN FOR SIDEBAR
        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        // GET DATE SETTINGS
        $GetDateSettings = env('API_GET_DATE_SETTINGS');
        $api = Http::withoutVerifying()->get($GetDateSettings . '/YEARCOMPUTE');
        $decodedapi = $api->json();
        $DateSettings = json_decode($decodedapi['result'], true);
        $apiSkipYear = Http::withoutVerifying()->get($GetDateSettings . '/SKIPYEAR');
        $decodedapiSkipYear = $apiSkipYear->json();
        $SkipYear = json_decode($decodedapiSkipYear['result'], true);
        return view('Utilities/date-settings', compact('ManagingBoard', 'DateSettings', 'SkipYear'));
    }

    public function CONTRACTPERIOD()
    {
        $ConDate = env('API_GET_CONTRACT_DATE');
        $GetConDate = Http::withoutVerifying()->get($ConDate . '/ACTIVE');
        $decodedapi = $GetConDate->json();
        $ContractDate = json_decode($decodedapi['result'], true);
        return view('Utilities/contract-period', compact('ContractDate'));
    }


    public function INSERTCONTRACTPERIOD(Request $request)
    {
        $InsertConDate = env('API_INSERT_CONTRACT_PERIOD');
        $now = new DateTime();
        $sessionuserid = session()->get('userid');
        $datefrom = $request->input('datefrom');
        $datef = date_create($datefrom);
        $datefromformat = date_format($datef, "m-d-Y");
        $dateto = $request->input('dateto');
        $datet = date_create($dateto);
        $datetoformat = date_format($datet, "m-d-Y");
        $response = Http::post($InsertConDate, [
            'datefrom' => $datefromformat,
            'dateto' => $datetoformat,
            'createdby' => $sessionuserid,
            'datecreated' => $now->format('m-d-Y'),
        ]);

        if ($response->successful()) {
            return back();
        }
    }

    public function ActivityLogs()
    {
        $ActLogs = env('API_GET_ACTIVITY_LOGS');
        $GetActLogs = Http::withoutVerifying()->get($ActLogs);
        $decodedapi = $GetActLogs->json();
        $ActivityLogs = json_decode($decodedapi['result'], true);
        return view('Utilities/activity-logs', compact('ActivityLogs'));
    }
}


