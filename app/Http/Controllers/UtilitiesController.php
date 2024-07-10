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
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                $ConDate = env('API_GET_CONTRACT_DATE');
                $GetConDate = http::withHeaders(['token' => $token])->get($ConDate . '/ACTIVE');
                $decodedapi = $GetConDate->json();
                $ContractDate = json_decode($decodedapi['result'], true);
                return view('Utilities/contract-period', compact('ContractDate'));
            } else {
                redirect('login');
            }
        }
    }


    public function INSERTCONTRACTPERIOD(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $InsertConDate = env('API_INSERT_CONTRACT_PERIOD');
                $now = new DateTime();
                $sessionuserid = session()->get('userid');
                $datefrom = $request->input('datefrom');
                $datef = date_create($datefrom);
                $datefromformat = date_format($datef, "m-d-Y");
                $dateto = $request->input('dateto');
                $datet = date_create($dateto);
                $datetoformat = date_format($datet, "m-d-Y");
                $response = http::withHeaders(['token' => $token])->post($InsertConDate, [
                    'datefrom' => $datefromformat,
                    'dateto' => $datetoformat,
                    'createdby' => $sessionuserid,
                    'datecreated' => $now->format('m-d-Y'),
                ]);

                if ($response->successful()) {
                    return back();
                }
            } else {

                redirect('login');
            }


        }
    }

    public function ActivityLogs()
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $ActLogs = env('API_GET_ACTIVITY_LOGS');
                $GetActLogs = http::withHeaders(['token' => $token])->get($ActLogs);
                $decodedapi = $GetActLogs->json();
                $ActivityLogs = json_decode($decodedapi['result'], true);
                return view('Utilities/activity-logs', compact('ActivityLogs'));
            } else {

                redirect('login');
            }
        }
    }

    public function ENDCONTRACTPERIOD(request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $condateid = $request->input('ec_condateid');
                $ApiEndConDate = env('API_END_CONTRACT_DATE');
                $EndConDate = http::withHeaders(['token' => $token])->get($ApiEndConDate . '/' . $condateid);
                $decodedapi = $EndConDate->json();
                $EndContractDate = json_decode($decodedapi['result'], true);
                return back();
            }
        } else {

            redirect('login');
        }


    }

}