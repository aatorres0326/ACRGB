<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class BudgetController extends Controller
{



    public function GetHealthFacilityBudget(Request $request)
    {
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');

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

        // GET HCPN CONTRACT
        if (session()->get('leveid') == 'PRO') {

            $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/' . $SessionUserID . '/PRO');
            $decodedapiContract = $apiContract->json();
            $Contract = json_decode($decodedapiContract['result'], true);
        } else {
            $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/0/PHICHCPN');
            $decodedapiContract = $apiContract->json();
            $Contract = json_decode($decodedapiContract['result'], true);

        }


        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $apiMB2 = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoardWithProID/' . $SessionUserID . '/PRO');
        $decodedMB2 = $apiMB2->json();
        $ManagingBoard2 = json_decode($decodedMB2['result'], true);

        return view('BudgetManagement/hcpn-contract', compact('Contract', 'ManagingBoard', 'ManagingBoard2'));
    }
    public function AddContract(Request $request)
    {
        $datefrom = $request->input('datefrom');
        $datef = date_create($datefrom);
        $datefromformat = date_format($datef, "m-d-Y");
        $dateto = $request->input('dateto');
        $datet = date_create($dateto);
        $datetoformat = date_format($datet, "m-d-Y");
        $amount = preg_replace('/[^0-9.]/', '', $request->input('amount'));
        $baseamount = preg_replace('/[^0-9.]/', '', $request->input('baseamount'));
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
            'baseamount' => $baseamount,
        ]);
        if ($response->successful()) {

            return back();

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
            return back();
        }

    }
    public function EditContractStatus(Request $request)
    {
        $enddate = $request->input('enddate');
        $datef = date_create($enddate);
        $enddateformat = date_format($datef, "m-d-Y");




        $response = Http::put('http://localhost:7001/ACRGB/ACRGBUPDATE/TAGGINGCONTRACT', [
            'conid' => $request->input('es_conid'),
            'stats' => $request->input('status'),
            'enddate' => $enddateformat,
            'remarks' => $request->input('                                                                                                                                 remarks'),

        ]);
        if ($response->successful()) {
            return back();
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
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
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


        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $apiTranch = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetTranch/ACTIVE');
        $decodedapiTranch = $apiTranch->json();
        $Tranch = json_decode($decodedapiTranch['result'], true);




        return view('BudgetManagement/apex-assets', compact('ManagingBoard', 'Assets', 'SelectedConID', 'SelectedHCFID', 'SelectedDateTo', 'SelectedDateFrom', 'SelectedAmount', 'Tranch'));
    }
    public function GetHCPNAssets(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedHCPN = $request->query('hcpn', '');
        $SelectedControlNumber = $request->query('controlnumber', '');
        $SelectedAmount = $request->query('amount', '');
        $SelectedContract = $request->query('transcode', '');
        $SessionUserID = session()->get('userid');
        // GET FACILITIES
        $getAssets = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAssets/ACTIVE/' . $SelectedConID);
        $decodedResponse = $getAssets->json();
        $Assets = json_decode($decodedResponse['result'], true);


        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $apiTranch = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetTranch/ACTIVE');
        $decodedapiTranch = $apiTranch->json();
        $Tranch = json_decode($decodedapiTranch['result'], true);




        return view('BudgetManagement/hcpn-assets', compact('ManagingBoard', 'Assets', 'SelectedConID', 'SelectedHCPN', 'SelectedAmount', 'Tranch', 'SelectedContract', 'SelectedControlNumber'));
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
            return back();
        }
    }
    public function GetFacilityContracts(Request $request)
    {

        $MBName = $request->query('mbname', '');
        $ConNumber = $request->query('controlnumber', '');
        $ContractAmount = $request->query('conamount', '');
        $TransCode = $request->query('transcode', '');
        $SessionUserID = session()->get('userid');



        // GET HCPN CONTRACTS
        $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/' . $ConNumber . '/HCPN');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);

        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);





        return view('BudgetManagement/facility-contracts', compact('Contract', 'ManagingBoard', 'MBName', 'ContractAmount', 'TransCode'));
    }
    public function GetFacilityAssets(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedHCFID = $request->query('hcfid', '');
        $SelectedDateTo = $request->query('dateto', '');
        $SelectedDateFrom = $request->query('datefrom', '');
        $SelectedAmount = $request->query('amount', '');
        $SessionUserID = session()->get('userid');
        // GET FACILITIES ASSETS
        $getAssets = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAssets/ACTIVE/' . $SelectedConID);
        $decodedResponse = $getAssets->json();
        $Assets = json_decode($decodedResponse['result'], true);


        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $apiTranch = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetTranch/ACTIVE');
        $decodedapiTranch = $apiTranch->json();
        $Tranch = json_decode($decodedapiTranch['result'], true);




        return view('BudgetManagement/facility-assets', compact('ManagingBoard', 'Assets', 'SelectedConID', 'SelectedHCFID', 'SelectedDateTo', 'SelectedDateFrom', 'SelectedAmount', 'Tranch'));
    }
    public function GetTerminatedContract()
    {
        $SessionUserID = session()->get('userid');

        // GET HCPN CONTRACT
        $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetBalanceTerminatedContract/' . $SessionUserID . '/PRO');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);

        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('BudgetManagement/terminated-contract', compact('Contract', 'ManagingBoard'));
    }

    // HCPN REPORTS *******************************************************************************************************************************************************************

    public function GetAPEXReports()
    {
        $SessionUserID = session()->get('userid');

        // GET HCPN CONTRACT
        $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/0/PHICAPEX');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);


        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $apiMB2 = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoardWithProID/' . $SessionUserID . '/PRO');
        $decodedMB2 = $apiMB2->json();
        $ManagingBoard2 = json_decode($decodedMB2['result'], true);

        return view('BudgetManagement/apex-reports', compact('Contract', 'ManagingBoard', 'ManagingBoard2'));
    }

    public function GetAPEXLedger(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedHCFID = $request->query('hcfid', '');
        $SelectedDateTo = $request->query('dateto', '');
        $SelectedDateFrom = $request->query('datefrom', '');
        $SelectedAmount = $request->query('amount', '');
        $SessionUserID = session()->get('userid');
        // GET FACILITIES ASSETS
        $getAssets = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetAssets/ACTIVE/' . $SelectedConID);
        $decodedResponse = $getAssets->json();
        $Assets = json_decode($decodedResponse['result'], true);


        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);






        return view('BudgetManagement/apex-ledger', compact('ManagingBoard', 'Assets', 'SelectedConID', 'SelectedHCFID', 'SelectedDateTo', 'SelectedDateFrom', 'SelectedAmount'));
    }

    public function Ledger(Request $request)
    {
        $SessionUserID = session()->get('userid');


        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        if (session()->get('leveid') == 'PRO') {
            $ApiMBUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoardWithProID/' . $SessionUserID . "/PRO");
            $decodedMBUnderPro = $ApiMBUnderPro->json();
            $MBUnderPro = json_decode($decodedMBUnderPro['result'], true);

            $apiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetFacilityUsingProAccountUserID/' . $SessionUserID);
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

        } else {

            $ApiMBUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
            $decodedMBUnderPro = $ApiMBUnderPro->json();
            $MBUnderPro = json_decode($decodedMBUnderPro['result'], true);

            $apiHCFUnderPro = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GETALLFACILITY');
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);
        }
        $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/0/PHICHCPN');
        $decodedapiContract = $apiContract->json();
        $HCPNContract = json_decode($decodedapiContract['result'], true);

        $apiHCFapex = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GETALLFACILITY');
        $decodedHCFapex = $apiHCFapex->json();
        $HCFapex = json_decode($decodedHCFapex['result'], true);

        return view('BudgetManagement/ledger-forms', compact('ManagingBoard', 'MBUnderPro', 'HCFUnderPro', 'HCFapex', 'HCPNContract'));
    }

    public function GetHCPNLedger(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedConNumber = $request->query('controlnumber', '');
        $SessionUserID = session()->get('userid');
        // GET FACILITIES ASSETS
        $gethcpncontract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/PerContractLedger/' . $SelectedConNumber . '/' . $SelectedConID . '/HCPN');
        $decodedResponse = $gethcpncontract->json();
        $HCPNledger = json_decode($decodedResponse['result'], true);


        // GET MANAGING BOARD FOR SIDEBAR
        $apiMB = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetManagingBoard');
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);


        $apiContract = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetContract/ACTIVE/0/PHICHCPN');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);



        return view('BudgetManagement/hcpn-ledger', compact('ManagingBoard', 'HCPNledger', 'SelectedConID', 'SelectedConNumber', 'Contract'));
    }

}




