<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;



class BudgetController extends Controller
{




    public function GetHCPNContract()
    {

        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                $SessionUserID = session()->get('userid');
                $GetContract = env('API_GET_CONTRACT');
                // GET HCPN CONTRACT
                if (session()->get('leveid') == 'PRO') {

                    $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/' . $SessionUserID . '/PRO');
                    $decodedapiContract = $apiContract->json();
                    $Contract = json_decode($decodedapiContract['result'], true);

                    $ownContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/' . $SessionUserID . '/PROCONOWN');
                    $decodedownContract = $ownContract->json();
                    $PROContract = json_decode($decodedownContract['result'], true);

                } else {
                    $PROContract = null;
                    $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/0/PHICHCPN');
                    $decodedapiContract = $apiContract->json();
                    $Contract = json_decode($decodedapiContract['result'], true);

                }

                $GetHCPNwithPro = env('API_GET_HCPN_USING_PRO_USERID');
                $apiMB2 = Http::withHeaders(['token' => $token])->get($GetHCPNwithPro . '/' . $SessionUserID . '/PRO');
                $decodedMB2 = $apiMB2->json();
                $ManagingBoard2 = json_decode($decodedMB2['result'], true);

                $ConDate = env('API_GET_CONTRACT_DATE');
                $GetConDate = Http::withHeaders(['token' => $token])->get($ConDate . '/ACTIVE');
                if ($GetConDate->status() == 404) {

                    return redirect('NotFound');
                } else {

                    $decodedapi = $GetConDate->json();
                    $ContractDate = json_decode($decodedapi['result'], true);

                    return view('BudgetManagement/hcpn-contract', compact('Contract', 'ManagingBoard2', 'ContractDate', 'PROContract'));
                }
            } else {

                redirect('login');
            }


        }
    }

    public function AddContract(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {



                $now = new DateTime();
                $sessionuserid = session()->get('userid');
                $quarter = $request->input('quarter') ?? "N/A";
                $totalClaimsAmount = $request->input('total_claims_amount') ?? '0';
                $committedclaimsVol = $request->input('committed_claims_volume') ?? '0';
                $claimsVol = $request->input('claims_volume') ?? '0';
                $sb = $request->input('sb') ?? '0';
                $thirty = $request->input('thirty') ?? '0';

                $InsertContract = env('API_INSERT_CONTRACT');
                $response = Http::withHeaders(['token' => $token])->post($InsertContract, [
                    'hcfid' => $request->input('connumber'),
                    'createdby' => $sessionuserid,
                    'datecreated' => $now->format('m-d-Y'),
                    'contractdate' => $request->input('condateid'),
                    'amount' => $request->input('contract_amount'),
                    'transcode' => $request->input('transcode'),
                    'baseamount' => $totalClaimsAmount,
                    'comittedClaimsVol' => $committedclaimsVol,
                    'computedClaimsVol' => $claimsVol,
                    'sb' => $sb,
                    'addamount' => $thirty,
                    'quarter' => $quarter,
                ]);

                if ($response->successful()) {
                    if (session()->get('leveid') == "PRO") {
                        return redirect('/hcpncontract');
                    } else if (session()->get('leveid') == "HCPN") {
                        return redirect('/facilitycontracts');
                    }
                }
            } else {

                redirect('login');
            }


        }

    }
    public function AddAPEXContract(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {


                $now = new DateTime();
                $sessionuserid = session()->get('userid');
                $quarter = $request->input('quarter') ?? "N/A";
                $totalClaimsAmount = $request->input('total_claims_amount') ?? '0';
                $committedclaimsVol = $request->input('committed_claims_volume') ?? '0';
                $claimsVol = $request->input('claims_volume') ?? '0';
                $sb = $request->input('sb') ?? '0';
                $thirty = $request->input('thirty') ?? '0';

                $InsertContract = env('API_INSERT_CONTRACT');
                $response = Http::withHeaders(['token' => $token])->post($InsertContract, [
                    'hcfid' => $request->input('connumber'),
                    'createdby' => $sessionuserid,
                    'datecreated' => $now->format('m-d-Y'),
                    'contractdate' => $request->input('condateid'),
                    'amount' => $request->input('contract_amount'),
                    'transcode' => $request->input('transcode'),
                    'baseamount' => $totalClaimsAmount,
                    'comittedClaimsVol' => $committedclaimsVol,
                    'computedClaimsVol' => $claimsVol,
                    'sb' => $sb,
                    'addamount' => $thirty,
                    'quarter' => $quarter,
                ]);

                if ($response->successful()) {

                    return redirect('/apexcontract');
                }
            } else {

                redirect('login');
            }


        }


    }


    public function AddPROBudget(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $now = new DateTime();
                $sessionuserid = session()->get('userid');

                $InsertContract = env('API_INSERT_CONTRACT');
                $response = Http::withHeaders(['token' => $token])->post($InsertContract, [
                    'hcfid' => $request->input('pro'),
                    'createdby' => $sessionuserid,
                    'datecreated' => $now->format('m-d-Y'),
                    'contractdate' => $request->input('contractperiod'),
                    'amount' => $request->input('amount'),
                    'transcode' => $request->input('transcode'),
                    'baseamount' => "0",
                    'comittedClaimsVol' => "0",
                    'computedClaimsVol' => "0",
                    'sb' => "0",
                    'addamount' => "0",
                    'quarter' => $request->input('quarter'),
                ]);
                if ($response->successful()) {

                    return back();


                }
            } else {

                redirect('login');
            }


        }
    }

    public function EditHCPNContract(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $amount = preg_replace('/[^0-9.]/', '', $request->input('e_amount'));
                $UpdateContract = env('API_UPDATE_CONTRACT');
                $response = Http::withHeaders(['token' => $token])->put($UpdateContract, [
                    'conid' => $request->input('e_conid'),
                    'hcfid' => $request->input('e_controlnumber'),
                    'contractdate' => $request->input('contractperiod'),
                    'amount' => $amount,
                    'transcode' => $request->input('e_transcode'),

                ]);

                if ($response->successful()) {
                    return back();
                }
            } else {

                redirect('login');
            }


        }
    }
    public function EditContractStatus(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $enddate = $request->input('endDate');
                $datef = date_create($enddate);
                $enddateformat = date_format($datef, "m-d-Y");

                $ContractTagging = env('API_CONTRACT_TAGGING');
                $response = Http::withHeaders(['token' => $token])->put($ContractTagging, [
                    'conid' => $request->input('es_conid'),
                    'stats' => $request->input('status'),
                    'enddate' => $enddateformat,
                    'remarks' => $request->input('remarks'),

                ]);

                if ($response->successful()) {
                    return back();
                }
            } else {

                redirect('login');
            }


        }

    }
    public function GetAPEXContract()
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $SessionUserID = session()->get('userid');
                // GET FACILITIES
                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . '/ALL/0');
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                // GET CONTRACT
                $GetContract = env('API_GET_CONTRACT');
                $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/0/PHICAPEX');
                $decodedapiContract = $apiContract->json();
                $Contract = json_decode($decodedapiContract['result'], true);

                $ConDate = env('API_GET_CONTRACT_DATE');
                $GetConDate = Http::withHeaders(['token' => $token])->get($ConDate . '/ACTIVE');
                $decodedapi = $GetConDate->json();
                $ContractDate = json_decode($decodedapi['result'], true);

                return view('BudgetManagement/apex-contract', compact('Contract', 'Facilities', 'ContractDate'));
            } else {

                redirect('login');
            }


        }
    }

    public function GetAPEXAssets(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $SelectedConID = $request->query('conid', '');
                $SelectedHCF = $request->query('hcfname', '');
                $SelectedPercent = $request->query('percentage', '');
                $SelectedHCFCode = $request->query('hcfcode', '');
                $SelectedAmount = $request->query('amount', '');
                $SelectedContract = $request->query('transcode', '');
                $SessionUserID = session()->get('userid');
                $ClaimsAmount = $request->query('claimsamount', '');
                // GET TRANCHES
                $GetAssets = env('API_GET_ASSETS');
                $Assets = Http::withHeaders(['token' => $token])->get($GetAssets . '/ACTIVE/' . $SelectedConID);
                $decodedResponse = $Assets->json();
                $Assets = json_decode($decodedResponse['result'], true);

                $GetPrevBal = env('API_GET_PREVIOUS_BAL');
                $PreviousBal = Http::withHeaders(['token' => $token])->get($GetPrevBal . '/' . $SelectedHCFCode);
                if ($PreviousBal->successful()) {
                    $decodedPrevBal = $PreviousBal->json();
                    $PreviousBalance = json_decode($decodedPrevBal['result'], true);
                } else {
                    $PreviousBalance = null;
                }
                // GET ALL HCPN
                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $ManagingBoard = json_decode($decodedMB['result'], true);

                $GetTranch = env('API_GET_TRANCH');
                $apiTranch = Http::withHeaders(['token' => $token])->get($GetTranch . '/ACTIVE');
                $decodedapiTranch = $apiTranch->json();
                $Tranch = json_decode($decodedapiTranch['result'], true);

                return view('BudgetManagement/apex-assets', compact('Assets', 'SelectedConID', 'SelectedHCF', 'SelectedAmount', 'Tranch', 'SelectedContract', 'SelectedHCFCode', 'SelectedPercent', 'ClaimsAmount', 'PreviousBalance'));
            } else {

                redirect('login');
            }


        }
    }
    public function GetHCPNAssets(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $token = session()->get('token');
                $SelectedConID = $request->query('conid', '');
                $SelectedHCPN = $request->query('hcpn', '');
                $SelectedPercent = $request->query('percentage', '');
                $SelectedControlNumber = $request->query('controlnumber', '');
                $SelectedAmount = $request->query('amount', '');
                $SelectedContract = $request->query('transcode', '');
                $SelectedClaimsAmount = $request->query('claimsamount', '');
                $SessionUserID = session()->get('userid');
                // GET FACILITIES
                $GetAssets = env('API_GET_ASSETS');
                $Assets = Http::withHeaders(['token' => $token])->get($GetAssets . '/ACTIVE/' . $SelectedConID);
                $decodedResponse = $Assets->json();
                $Assets = json_decode($decodedResponse['result'], true);

                $GetPrevBal = env('API_GET_PREVIOUS_BAL');
                $PreviousBal = Http::withHeaders(['token' => $token])->get($GetPrevBal . '/' . $SelectedControlNumber);
                if ($PreviousBal->successful()) {
                    $decodedPrevBal = $PreviousBal->json();
                    $PreviousBalance = json_decode($decodedPrevBal['result'], true);
                } else {
                    $PreviousBalance = null;
                }

                $GetTranch = env('API_GET_TRANCH');
                $apiTranch = Http::withHeaders(['token' => $token])->get($GetTranch . '/ACTIVE');
                $decodedapiTranch = $apiTranch->json();
                $Tranch = json_decode($decodedapiTranch['result'], true);

                return view('BudgetManagement/hcpn-assets', compact('PreviousBalance', 'Assets', 'SelectedConID', 'SelectedHCPN', 'SelectedAmount', 'Tranch', 'SelectedContract', 'SelectedControlNumber', 'SelectedPercent', 'SelectedClaimsAmount'));
            } else {

                redirect('login');
            }


        }
    }

    public function INSERTASSETS(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $release = $request->input('datereleased');

                if ($release) {

                    $released = new DateTime($release);
                    $releaseddate = $released->format('m-d-Y');
                }

                $now = new DateTime();
                $sessionuserid = session()->get('userid');
                $InsertAssets = env('API_INSERT_ASSETS');
                $response = Http::withHeaders(['token' => $token])->post($InsertAssets, [
                    'hcfid' => $request->input('hcfid'),
                    'tranchid' => $request->input('tranch'),
                    'receipt' => $request->input('receipt'),
                    'amount' => $request->input('tranch_amount'),
                    'releasedamount' => $request->input('released_amount'),
                    'previousbalance' => $request->input('previous_balance'),
                    'conid' => $request->input('conid'),
                    'createdby' => $sessionuserid,
                    'datereleased' => $releaseddate,
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
    public function GetFacilityContracts(Request $request)
    {

        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                if (session()->get('leveid') == 'PRO' || session()->get('leveid') == 'PHIC') {
                    $MBName = $request->query('mbname', '');
                    $ConNumber = $request->query('controlnumber', '');
                    $ContractAmount = $request->query('conamount', '');
                    $TransCode = $request->query('transcode', '');
                    $SessionUserID = session()->get('userid');

                    // GET HCPN CONTRACTS
                    $GetContract = env('API_GET_CONTRACT');
                    $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/' . $ConNumber . '/HCIHCPNCON');
                    $decodedapiContract = $apiContract->json();
                    $Contract = json_decode($decodedapiContract['result'], true);

                    return view('BudgetManagement/facility-contracts', compact('Contract', 'MBName', 'ContractAmount', 'TransCode'));
                } else {

                    $SessionUserID = session()->get('userid');

                    // GET HCPN CONTRACTS
                    $GetContract = env('API_GET_CONTRACT');
                    $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/' . $SessionUserID . '/HCPN');
                    $decodedapiContract = $apiContract->json();
                    $Contract = json_decode($decodedapiContract['result'], true);

                    $GetAllFacility = env('API_GET_ALL_FACILITIES');
                    $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                    $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                    $Facilities = json_decode($decodedHCFUnderPro['result'], true);


                    $ConDate = env('API_GET_CONTRACT_DATE');
                    $GetConDate = Http::withHeaders(['token' => $token])->get($ConDate . '/ACTIVE');
                    $decodedapi = $GetConDate->json();
                    $ContractDate = json_decode($decodedapi['result'], true);
                    $ownContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/' . $SessionUserID . '/HCPNCONOWN');
                    $decodedownContract = $ownContract->json();
                    $HCPNContract = json_decode($decodedownContract['result'], true);
                    return view('BudgetManagement/facility-contracts', compact('Contract', 'Facilities', 'ContractDate', 'HCPNContract'));
                }
            } else {

                redirect('login');
            }


        }
    }
    public function GetFacilityAssets(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $SelectedConID = $request->query('conid', '');
                $SelectedHCF = $request->query('hcfname', '');
                $SelectedPercent = $request->query('percentage', '');
                $SelectedHCFCode = $request->query('hcfcode', '');
                $SelectedAmount = $request->query('amount', '');
                $SelectedContract = $request->query('transcode', '');
                $ClaimsAmount = $request->query('claimsamount', '');
                $SessionUserID = session()->get('userid');
                // GET TRANCHES
                $GetAssets = env('API_GET_ASSETS');
                $Assets = Http::withHeaders(['token' => $token])->get($GetAssets . '/ACTIVE/' . $SelectedConID);
                $decodedResponse = $Assets->json();
                $Assets = json_decode($decodedResponse['result'], true);
                $GetPrevBal = env('API_GET_PREVIOUS_BAL');

                $PreviousBal = Http::withHeaders(['token' => $token])->get($GetPrevBal . '/' . $SelectedHCFCode);
                if ($PreviousBal->successful()) {
                    $decodedPrevBal = $PreviousBal->json();
                    $PreviousBalance = json_decode($decodedPrevBal['result'], true);
                } else {
                    $PreviousBalance = null;
                }
                // GET ALL HCPN
                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $ManagingBoard = json_decode($decodedMB['result'], true);

                $GetTranch = env('API_GET_TRANCH');
                $apiTranch = Http::withHeaders(['token' => $token])->get($GetTranch . '/ACTIVE');
                $decodedapiTranch = $apiTranch->json();
                $Tranch = json_decode($decodedapiTranch['result'], true);

                return view('BudgetManagement/facility-assets', compact('Assets', 'SelectedConID', 'SelectedHCF', 'SelectedAmount', 'Tranch', 'SelectedContract', 'SelectedHCFCode', 'SelectedPercent', 'PreviousBalance', 'ClaimsAmount'));
            } else {

                redirect('login');
            }


        }
    }


    public function GETPROFUND()
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $GetRegionalOffice = env('API_GET_REGIONAL_OFFICE');
                $apiPro = Http::withHeaders(['token' => $token])->get($GetRegionalOffice . "/ACTIVE");
                $decodedPro = $apiPro->json();
                $RegionalOffices = json_decode($decodedPro['result'], true);

                return view('BudgetManagement/pro-budget', compact('RegionalOffices'));
            } else {

                redirect('login');
            }


        }
    }

    public function NewContract(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $userLevel = session()->get('leveid');
                $SessionUserID = session()->get('userid');
                $ConDate = env('API_GET_CONTRACT_DATE');
                $GetConDate = Http::withHeaders(['token' => $token])->get($ConDate . '/ACTIVE');
                $decodedapi = $GetConDate->json();
                $ContractDate = json_decode($decodedapi['result'], true);

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . '/ACTIVE');
                $decodedMB = $apiMB->json();
                $ManagingBoard = json_decode($decodedMB['result'], true);
                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $ConNumber = $request->query('controlNumber', '');
                $DateFrom = $request->query('DateFrom');

                $DateTo = $request->query('DateTo');

                $transcode = $request->query('TransCode', '');
                $SelectedHCFHCPN = $request->query('HCFHCPN');
                $SelectedConDate = $request->query('ConDate');
                $ownCondateid = $request->query('condateid');



                if ($ConNumber != null) {
                    $GetBudget = env('API_GET_SUMMARY');
                    $apiBudget = Http::withHeaders(['token' => $token])->get($GetBudget . '/HCPN/' . $ConNumber . '/' . $DateFrom . '/' . $DateTo . '/CONTRACT/OLD');
                    $decodedBudget = $apiBudget->json();

                    if ($decodedBudget['success'] === false) {

                        $apiBudget = Http::withHeaders(['token' => $token])->get($GetBudget . '/FACILITY/' . $ConNumber . '/' . $DateFrom . '/' . $DateTo . '/CONTRACT/OLD');
                        $decodedBudget = $apiBudget->json();
                    }
                    if ($decodedBudget != null) {
                        $Budget = json_decode($decodedBudget['result'], true);
                    } else {
                        $Budget = null;
                    }
                } else {
                    $Budget = null;

                }


                return view('BudgetManagement/new-contract', compact('ContractDate', 'ManagingBoard', 'transcode', 'SelectedHCFHCPN', 'SelectedConDate', 'DateFrom', 'DateTo', 'ConNumber', 'Budget', 'Facilities'));
            } else {

                redirect('login');
            }


        }
    }

    public function NewAPEXContract(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $ConDate = env('API_GET_CONTRACT_DATE');
                $GetConDate = Http::withHeaders(['token' => $token])->get($ConDate . '/ACTIVE');
                $decodedapi = $GetConDate->json();
                $ContractDate = json_decode($decodedapi['result'], true);


                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . '/ALL/0');
                $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $ConNumber = $request->query('controlNumber', '');
                $DateFrom = $request->query('DateFrom', '');

                $DateTo = $request->query('DateTo', '');

                $transcode = $request->query('TransCode', '');
                $SelectedHCFHCPN = $request->query('HCFHCPN');
                $SelectedConDate = $request->query('ConDate');


                if ($ConNumber != null && $DateFrom != null && $DateTo != null) {
                    $GetBudget = env('API_GET_SUMMARY');
                    $apiBudget = Http::withHeaders(['token' => $token])->get($GetBudget . '/FACILITY/' . $ConNumber . '/' . $DateFrom . '/' . $DateTo . '/CONTRACT/OLD');
                    $decodedBudget = $apiBudget->json();
                    if ($decodedBudget != null) {
                        $Budget = json_decode($decodedBudget['result'], true);
                    } else {
                        $Budget = null;
                    }
                } else {
                    $Budget = null;

                }


                return view('BudgetManagement/new-apex-contract', compact('ContractDate', 'transcode', 'SelectedHCFHCPN', 'SelectedConDate', 'DateFrom', 'DateTo', 'ConNumber', 'Budget', 'Facilities'));
            } else {

                redirect('login');
            }


        }
    }


    public function dashboard()
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $SessionUserID = session()->get('userid');

                if ($token == null) {

                    return redirect('login');
                } else {
                    if (session()->get('leveid') == "PRO") {

                        $GetContract = env('API_GET_CONTRACT');
                        $ownContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE/' . $SessionUserID . '/PROCONOWN');
                        $decodeownContract = $ownContract->json();
                        $Contract = json_decode($ownContract, true);
                        $PROContract = json_decode($Contract['result'], true);

                        return view('dashboard', compact('PROContract'));
                    } else {

                        return view('dashboard');
                    }

                }
            }
        } else {

            redirect('login');
        }


    }

    public function GetPROBudget(Request $request)
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $PROCode = $request->query('procode', '');
                $PROName = $request->query('proname', '');
                $ReleasedTranche = $request->query('totaltranhceamount', '');
                $ReleasedPercent = $request->query('percentage', '');
                $ClaimsAmount = $request->query('claimsamount', '');
                $ClaimsPercentage = $request->query('claimspercentage', '');
                $Unutilized = $request->query('unutilized', '');

                $SessionUserID = session()->get('userid');
                // GET FACILITIES
                $GetBudget = env('API_GET_PRO_BUDGET');
                $Budget = Http::withHeaders(['token' => $token])->get($GetBudget . '/ACTIVE/' . $PROCode);
                $decodedResponse = $Budget->json();
                $PROBudget = json_decode($decodedResponse['result'], true);

                return view('BudgetManagement/release-pro-budget', compact('PROName', 'PROCode', 'PROBudget', 'ReleasedTranche', 'ReleasedPercent', 'ClaimsAmount', 'ClaimsPercentage', 'Unutilized'));
            } else {

                redirect('login');
            }


        }
    }

    public function ContractHistory()
    {
        $token = session()->get('token');
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                $GetContractHistory = env('API_GET_CONTRACT_HISTORY');
                $Contract = Http::withHeaders(['token' => $token])->get($GetContractHistory . '/0/ALLHCPN');

                $decodeContract = $Contract->json();
                $EndedContract = json_decode($decodeContract['result'], true);


                return view('BudgetManagement/contract-history', compact('EndedContract'));
            } else {

                redirect('login');
            }


        }
    }
}