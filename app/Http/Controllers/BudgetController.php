<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;



class BudgetController extends Controller
{



    public function GetHealthFacilityBudget(Request $request)
    {
        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN);
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

            $GetBudget = env('API_GET_BUDGET');
            $GetHCFBudget = Http::get($GetBudget . '/MB/' . $mbid . '/' . $datefromformat . '/' . $datetoformat);
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

            $GetBudget = env('API_GET_BUDGET');
            $GetHCFBudget = Http::get($GetBudget . '/PHICPRO/' . $mbid . '/' . $datefromformat . '/' . $datetoformat);
            $decodedHCFBudget = $GetHCFBudget->json();
            $HCFBudget = json_decode($decodedHCFBudget['result'], true);

        }

        return view('BudgetManagement/hcfbudget', compact('HCFBudget', 'ManagingBoard', 'mbid', 'datetoformat', 'datefromformat'));
    }

    public function GetHCPNContract()
    {
        $SessionUserID = session()->get('userid');

        $GetContract = env('API_GET_CONTRACT');

        // GET HCPN CONTRACT
        if (session()->get('leveid') == 'PRO') {

            $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/' . $SessionUserID . '/PRO');
            $decodedapiContract = $apiContract->json();
            $Contract = json_decode($decodedapiContract['result'], true);

        } else {

            $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
            $decodedapiContract = $apiContract->json();
            $Contract = json_decode($decodedapiContract['result'], true);

        }

        $GetHCPNwithPro = env('API_GET_HCPN_USING_PRO_USERID');
        $apiMB2 = Http::withoutVerifying()->get($GetHCPNwithPro . '/' . $SessionUserID . '/PRO');
        $decodedMB2 = $apiMB2->json();
        $ManagingBoard2 = json_decode($decodedMB2['result'], true);

        $ConDate = env('API_GET_CONTRACT_DATE');
        $GetConDate = Http::withoutVerifying()->get($ConDate . '/ACTIVE');
        $decodedapi = $GetConDate->json();
        $ContractDate = json_decode($decodedapi['result'], true);

        return view('BudgetManagement/hcpn-contract', compact('Contract', 'ManagingBoard2', 'ContractDate'));
    }

    public function AddContract(Request $request)
    {
        $amount = preg_replace('/[^0-9.]/', '', $request->input('amount'));
        $baseamount = preg_replace('/[^0-9.]/', '', $request->input('baseamount'));
        $now = new DateTime();
        $sessionuserid = session()->get('userid');

        $InsertContract = env('API_INSERT_CONTRACT');
        $response = Http::post($InsertContract, [
            'hcfid' => $request->input('mb'),
            'createdby' => $sessionuserid,
            'datecreated' => $now->format('m-d-Y'),
            'contractdate' => $request->input('contractperiod'),
            'amount' => $amount,
            'transcode' => $request->input('transcode'),
            'baseamount' => $baseamount,
        ]);

        if ($response->successful()) {
            return back();
        }
    }

    public function EditHCPNContract(Request $request)
    {
        $amount = preg_replace('/[^0-9.]/', '', $request->input('e_amount'));
        $UpdateContract = env('API_UPDATE_CONTRACT');
        $response = Http::put($UpdateContract, [
            'conid' => $request->input('e_conid'),
            'hcfid' => $request->input('e_controlnumber'),
            'contractdate' => $request->input('contractperiod'),
            'amount' => $amount,
            'transcode' => $request->input('e_transcode'),

        ]);

        if ($response->successful()) {
            return back();
        }
    }
    public function EditContractStatus(Request $request)
    {
        $enddate = $request->input('endDate');
        $datef = date_create($enddate);
        $enddateformat = date_format($datef, "m-d-Y");

        $ContractTagging = env('API_CONTRACT_TAGGING');
        $response = Http::put($ContractTagging, [
            'conid' => $request->input('es_conid'),
            'stats' => $request->input('status'),
            'enddate' => $enddateformat,
            'remarks' => $request->input('remarks'),

        ]);

        if ($response->successful()) {
            return back();
        }

    }
    public function GetAPEXContract()
    {
        $SessionUserID = session()->get('userid');
        // GET FACILITIES
        $GetAllFacility = env('API_GET_ALL_FACILITIES');
        $apiResponse = Http::withoutVerifying()->get($GetAllFacility . '/ALL/0');
        $decodedResponse = $apiResponse->json();
        $Facilities = json_decode($decodedResponse['result'], true);

        // GET CONTRACT
        $GetContract = env('API_GET_CONTRACT');
        $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICAPEX');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);

        $ConDate = env('API_GET_CONTRACT_DATE');
        $GetConDate = Http::withoutVerifying()->get($ConDate . '/ACTIVE');
        $decodedapi = $GetConDate->json();
        $ContractDate = json_decode($decodedapi['result'], true);

        return view('BudgetManagement/apex-contract', compact('Contract', 'Facilities', 'ContractDate'));
    }

    public function GetAPEXAssets(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedHCF = $request->query('hcfname', '');
        $SelectedPercent = $request->query('percentage', '');
        $SelectedHCFCode = $request->query('hcfcode', '');
        $SelectedAmount = $request->query('amount', '');
        $SelectedContract = $request->query('transcode', '');
        $SessionUserID = session()->get('userid');
        // GET TRANCHES
        $GetAssets = env('API_GET_ASSETS');
        $Assets = Http::withoutVerifying()->get($GetAssets . '/ACTIVE/' . $SelectedConID);
        $decodedResponse = $Assets->json();
        $Assets = json_decode($decodedResponse['result'], true);


        // GET ALL HCPN
        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $GetTranch = env('API_GET_TRANCH');
        $apiTranch = Http::withoutVerifying()->get($GetTranch . '/ACTIVE');
        $decodedapiTranch = $apiTranch->json();
        $Tranch = json_decode($decodedapiTranch['result'], true);

        return view('BudgetManagement/apex-assets', compact('Assets', 'SelectedConID', 'SelectedHCF', 'SelectedAmount', 'Tranch', 'SelectedContract', 'SelectedHCFCode', 'SelectedPercent'));
    }
    public function GetHCPNAssets(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedHCPN = $request->query('hcpn', '');
        $SelectedPercent = $request->query('percentage', '');
        $SelectedControlNumber = $request->query('controlnumber', '');
        $SelectedAmount = $request->query('amount', '');
        $SelectedContract = $request->query('transcode', '');
        $SessionUserID = session()->get('userid');
        // GET FACILITIES
        $GetAssets = env('API_GET_ASSETS');
        $Assets = Http::withoutVerifying()->get($GetAssets . '/ACTIVE/' . $SelectedConID);
        $decodedResponse = $Assets->json();
        $Assets = json_decode($decodedResponse['result'], true);

        $GetPrevBal = env('API_GET_PREVIOUS_BAL');
        $PreviousBal = Http::withoutVerifying()->get($GetPrevBal . '/' . $SelectedControlNumber);
        $decodedPrevBal = $PreviousBal->json();
        $PreviousBalance = json_decode($decodedPrevBal['result'], true);

        $GetTranch = env('API_GET_TRANCH');
        $apiTranch = Http::withoutVerifying()->get($GetTranch . '/ACTIVE');
        $decodedapiTranch = $apiTranch->json();
        $Tranch = json_decode($decodedapiTranch['result'], true);

        return view('BudgetManagement/hcpn-assets', compact('PreviousBalance', 'Assets', 'SelectedConID', 'SelectedHCPN', 'SelectedAmount', 'Tranch', 'SelectedContract', 'SelectedControlNumber', 'SelectedPercent'));
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
        $InsertAssets = env('API_INSERT_ASSETS');
        $response = Http::post($InsertAssets, [
            'hcfid' => $request->input('hcfid'),
            'tranchid' => $request->input('tranch'),
            'receipt' => $request->input('receipt'),
            'amount' => $request->input('tranch_amount'),
            'releasedamount' => $request->input('released_amount'),
            'previousbalance' => $request->input('previous_balance'),
            'conid' => $request->input('conid'),
            'createdby' => $sessionuserid,
            'datereleased' => $released,
            'datecreated' => $now->format('m-d-Y'),
        ]);

        if ($response->successful()) {
            return back();
        }
    }
    public function GetFacilityContracts(Request $request)
    {

        if (session()->get('leveid') == 'PRO' || session()->get('leveid') == 'PHIC') {
            $MBName = $request->query('mbname', '');
            $ConNumber = $request->query('controlnumber', '');
            $ContractAmount = $request->query('conamount', '');
            $TransCode = $request->query('transcode', '');
            $SessionUserID = session()->get('userid');

            // GET HCPN CONTRACTS
            $GetContract = env('API_GET_CONTRACT');
            $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/' . $ConNumber . '/HCIHCPNCON');
            $decodedapiContract = $apiContract->json();
            $Contract = json_decode($decodedapiContract['result'], true);

            return view('BudgetManagement/facility-contracts', compact('Contract', 'MBName', 'ContractAmount', 'TransCode'));
        } else {

            $SessionUserID = session()->get('userid');

            // GET HCPN CONTRACTS
            $GetContract = env('API_GET_CONTRACT');
            $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/' . $SessionUserID . '/HCPN');
            $decodedapiContract = $apiContract->json();
            $Contract = json_decode($decodedapiContract['result'], true);

            $GetAllFacility = env('API_GET_ALL_FACILITIES');
            $ApiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility . "/HCPN/" . $SessionUserID);
            $decodedHCFUnderPro = $ApiHCFUnderPro->json();
            $Facilities = json_decode($decodedHCFUnderPro['result'], true);


            $ConDate = env('API_GET_CONTRACT_DATE');
            $GetConDate = Http::withoutVerifying()->get($ConDate . '/ACTIVE');
            $decodedapi = $GetConDate->json();
            $ContractDate = json_decode($decodedapi['result'], true);

            return view('BudgetManagement/facility-contracts', compact('Contract', 'Facilities', 'ContractDate'));
        }
    }
    public function GetFacilityAssets(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedHCF = $request->query('hcfname', '');
        $SelectedPercent = $request->query('percentage', '');
        $SelectedHCFCode = $request->query('hcfcode', '');
        $SelectedAmount = $request->query('amount', '');
        $SelectedContract = $request->query('transcode', '');
        $SessionUserID = session()->get('userid');
        // GET TRANCHES
        $GetAssets = env('API_GET_ASSETS');
        $Assets = Http::withoutVerifying()->get($GetAssets . '/ACTIVE/' . $SelectedConID);
        $decodedResponse = $Assets->json();
        $Assets = json_decode($decodedResponse['result'], true);

        // GET ALL HCPN
        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $GetTranch = env('API_GET_TRANCH');
        $apiTranch = Http::withoutVerifying()->get($GetTranch . '/ACTIVE');
        $decodedapiTranch = $apiTranch->json();
        $Tranch = json_decode($decodedapiTranch['result'], true);

        return view('BudgetManagement/facility-assets', compact('Assets', 'SelectedConID', 'SelectedHCF', 'SelectedAmount', 'Tranch', 'SelectedContract', 'SelectedHCFCode', 'SelectedPercent'));
    }
    // public function GetTerminatedContract()
    // {
    //     $SessionUserID = session()->get('userid');

    //     // GET HCPN CONTRACT
    //     $apiContract = Http::withoutVerifying()->get($SessionUserID . '/PRO');
    //     $decodedapiContract = $apiContract->json();
    //     $Contract = json_decode($decodedapiContract['result'], true);

    //     // GET MANAGING BOARD FOR SIDEBAR
    //     $GetHCPN = env('API_GET_HCPN');
    //     $apiMB = Http::withoutVerifying()->get($GetHCPN);
    //     $decodedMB = $apiMB->json();
    //     $ManagingBoard = json_decode($decodedMB['result'], true);

    //     return view('BudgetManagement/terminated-contract', compact('Contract', 'ManagingBoard'));
    // }


    public function GetAPEXReports()
    {
        $SessionUserID = session()->get('userid');

        // GET APEX CONTRACT
        $GetContract = env('API_GET_CONTRACT');
        $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICAPEX');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);

        // GET HCPN
        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN);
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $GetHCPNwihtPro = env('API_GET_HCPN_USING_PRO_USERID');
        $apiMB2 = Http::withoutVerifying()->get($GetHCPNwihtPro . '/' . $SessionUserID . '/PRO');
        $decodedMB2 = $apiMB2->json();
        $ManagingBoard2 = json_decode($decodedMB2['result'], true);

        return view('BudgetManagement/apex-reports', compact('Contract', 'ManagingBoard', 'ManagingBoard2'));
    }

    public function GETPROFUND()
    {
        $GetRegionalOffice = env('API_GET_REGIONAL_OFFICE');
        $apiPro = Http::withoutVerifying()->get($GetRegionalOffice);
        $decodedPro = $apiPro->json();
        $RegionalOffices = json_decode($decodedPro['result'], true);


        $ConDate = env('API_GET_CONTRACT_DATE');
        $GetConDate = Http::withoutVerifying()->get($ConDate . '/ACTIVE');
        $decodedapi = $GetConDate->json();
        $ContractDate = json_decode($decodedapi['result'], true);

        return view('BudgetManagement/pro-budget', compact('RegionalOffices', 'ContractDate'));
    }



}




