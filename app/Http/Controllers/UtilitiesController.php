<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;



class UtilitiesController extends Controller
{
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

    public function ENDCONTRACTPERIOD(request $request)
    {
        $condateid = $request->input('ec_condateid');
        $ApiEndConDate = env('API_END_CONTRACT_DATE');
        $EndConDate = Http::withoutVerifying()->get($ApiEndConDate . '/' . $condateid);
        $decodedapi = $EndConDate->json();
        $EndContractDate = json_decode($decodedapi['result'], true);
        return back();
    }


}