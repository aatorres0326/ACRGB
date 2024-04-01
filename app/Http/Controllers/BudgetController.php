<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class BudgetController extends Controller
{



    public function GetHealthFacilityBudget(Request $request)
    {
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');

        $decodedMB = $apiMB->json();

        $ManagingBoard = json_decode($decodedMB['result'], true);
        if (session()->get('leveid') == 'MB') {
            $datefrom = $request->input('datefrom');
            $datef = date_create($datefrom);
            $datefromformat = date_format($datef, "m-d-Y");
            $dateto = $request->input('dateto');
            $datet = date_create($dateto);
            $datetoformat = date_format($datet, "m-d-Y");
            $mbid = session()->get('userid');

            $GetHCFBudget = Http::get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthFacilityBadget/MB/' . $mbid . '/' . $datefromformat . '/' . $datetoformat);
            $decodedHCFBudget = $GetHCFBudget->json();
            $HCFBudget = json_decode($decodedHCFBudget['result'], true);

        } else {

            $datefrom = $request->input('datefrom');
            $datef = date_create($datefrom);
            $datefromformat = date_format($datef, "m-d-Y");
            $dateto = $request->input('dateto');
            $datet = date_create($dateto);
            $datetoformat = date_format($datet, "m-d-Y");
            $mbid = $request->input('mb');

            $GetHCFBudget = Http::get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthFacilityBadget/PHICPRO/' . $mbid . '/' . $datefromformat . '/' . $datetoformat);
            $decodedHCFBudget = $GetHCFBudget->json();
            $HCFBudget = json_decode($decodedHCFBudget['result'], true);
        }

        return view('BudgetManagement/hcfbudget', compact('HCFBudget', 'ManagingBoard', 'mbid', 'datetoformat', 'datefromformat'));

    }
    public function GetHCPNContract()
    {
        $SessionUserID = session()->get('userid');
        // GET FACILITIES
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetMBUsingUserIDMBID/' . $SessionUserID);
        $decodedResponse = $apiResponse->json();
        $Facilities = json_decode($decodedResponse['result'], true);

        // GET HCPN CONTRACT
        $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/' . $SessionUserID . '/PRO');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);

        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('BudgetManagement/hcpn-contract', compact('Contract', 'ManagingBoard', 'Facilities'));
    }
    public function AddHCPNContract(Request $request)
    {
        $datefrom = $request->input('datefrom');
        $datef = date_create($datefrom);
        $datefromformat = date_format($datef, "m-d-Y");
        $dateto = $request->input('dateto');
        $datet = date_create($dateto);
        $datetoformat = date_format($datet, "m-d-Y");
        $amount = preg_replace('/[^0-9.]/', '', $request->input('amount'));
        $now = new DateTime();
        $sessionuserid = session()->get('userid');

        $response = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTCONTRACT', [
            'hcfid' => $request->input('mb'),
            'createdby' => $sessionuserid,
            'datecreated' => $now->format('m-d-Y'),
            'datefrom' => $datefromformat,
            'dateto' => $datetoformat,
            'amount' => $amount,
            'transcode' => $request->input('transcode'),
        ]);

        if ($response->successful()) {
            return redirect('/hcpncontract');

        }

    }

    public function EditHCPNContract(Request $request)
    {
        $datefrom = $request->input('e_datefrom');
        $datef = date_create($datefrom);
        $datefromformat = date_format($datef, "m-d-Y");
        $dateto = $request->input('e_dateto');
        $datet = date_create($dateto);
        $datetoformat = date_format($datet, "m-d-Y");
        $amount = preg_replace('/[^0-9.]/', '', $request->input('e_amount'));



        $response = Http::put('http://localhost:7001/ACRGB/ACRGBUPDATE/UPDATECONTRACT', [
            'conid' => $request->input('e_conid'),
            'hcfid' => $request->input('hcpn'),
            'datefrom' => $datefromformat,
            'dateto' => $datetoformat,
            'amount' => $amount,
            'transcode' => $request->input('e_transcode'),

        ]);

        if ($response->successful()) {

            if (request()->is('userinfo') == 'hcpncontract') {
                return redirect('/hcpncontract');
            } else {
                return redirect('/apexcontract');
            }

        }

    }
    public function GetAPEXContract()
    {
        $SessionUserID = session()->get('userid');
        // GET FACILITIES
        $apiResponse = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GETALLFACILITY');
        $decodedResponse = $apiResponse->json();
        $Facilities = json_decode($decodedResponse['result'], true);

        // GET CONTRACT
        $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/0/PHICAPEX');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);

        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);



        return view('BudgetManagement/apex-contract', compact('Contract', 'ManagingBoard', 'Facilities'));
    }

    public function GetAPEXAssets(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedHCFID = $request->query('hcfid', '');
        $SelectedDateTo = $request->query('dateto', '');
        $SelectedDateFrom = $request->query('datefrom', '');
        $SelectedAmount = $request->query('amount', '');
        $SessionUserID = session()->get('userid');
        // GET FACILITIES
        $getAssets = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAssets/ACTIVE/' . $SelectedConID);
        $decodedResponse = $getAssets->json();
        $Assets = json_decode($decodedResponse['result'], true);

        // GET CONTRACT
        $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/0/PHICAPEX');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);

        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $apiTranch = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetTranch/ACTIVE');
        $decodedapiTranch = $apiTranch->json();
        $Tranch = json_decode($decodedapiTranch['result'], true);




        return view('BudgetManagement/apex-assets', compact('Contract', 'ManagingBoard', 'Assets', 'SelectedConID', 'SelectedHCFID', 'SelectedDateTo', 'SelectedDateFrom', 'SelectedAmount', 'Tranch'));
    }
    public function INSERTASSETS(Request $request)
    {
        $released = $request->input('datereleased');
        if ($released) {
            $released = new DateTime($released);
            $released = $released->format('m-d-Y');
        }
        $now = new DateTime();
        $sessionuserid = session()->get('userid');

        $response = Http::post('http://localhost:7001/ACRGB/ACRGBINSERT/INSERTASSETS', [
            'hcfid' => $request->input('hcfid'),
            'tranchid' => $request->input('tranch'),
            'receipt' => $request->input('receipt'),
            'conid' => $request->input('conid'),
            'createdby' => $sessionuserid,
            'datereleased' => $released,
            'datecreated' => $now->format('m-d-Y'),
        ]);

        if ($response->successful()) {
            $SelectedConID = $request->input('conid');
            $SelectedHCFID = $request->input('selectedhcfid');
            $SelectedAmount = $request->input('contract_amount');
            $SelectedDateTo = $request->input('dateto');
            $SelectedDateFrom = $request->input('datefrom');

            // GET FACILITIES
            $getAssets = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAssets/ACTIVE/' . $SelectedConID);
            $decodedResponse = $getAssets->json();
            $Assets = json_decode($decodedResponse['result'], true);

            // GET CONTRACT
            $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/0/PHICAPEX');
            $decodedapiContract = $apiContract->json();
            $Contract = json_decode($decodedapiContract['result'], true);

            // GET MANAGING BOARD FOR SIDEBAR
            $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard/ACTIVE');
            $decodedMB = $apiMB->json();
            $ManagingBoard = json_decode($decodedMB['result'], true);

            $apiTranch = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetTranch/ACTIVE');
            $decodedapiTranch = $apiTranch->json();
            $Tranch = json_decode($decodedapiTranch['result'], true);

            return view('BudgetManagement/apex-assets', compact('Contract', 'ManagingBoard', 'Assets', 'SelectedConID', 'SelectedHCFID', 'SelectedDateTo', 'SelectedDateFrom', 'SelectedAmount', 'Tranch'));
        }
    }


}




