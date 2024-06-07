<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;



class ReportsController extends Controller
{

    public function Ledger(Request $request)
    {
        $SessionUserID = session()->get('userid');
        // GET ALL HCPN
        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        if (session()->get('leveid') == 'PRO') {
            // GET ALL HCPN UNDER THE LOGGED IN PRO
            $GetHCPNwithPro = env('API_GET_HCPN_USING_PRO_USERID');
            $ApiMBUnderPro = Http::withoutVerifying()->get($GetHCPNwithPro . '/' . $SessionUserID . "/PRO");
            $decodedMBUnderPro = $ApiMBUnderPro->json();
            $MBUnderPro = json_decode($decodedMBUnderPro['result'], true);
            // GET ALL FACILITY UNDER THE LOGGED IN PRO
            $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
            $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

        } else {
            // GET HCPN
            $GetHCPN = env('API_GET_HCPN');
            $ApiMBUnderPro = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
            $decodedMBUnderPro = $ApiMBUnderPro->json();
            $MBUnderPro = json_decode($decodedMBUnderPro['result'], true);
            // GET ALL FACILITY
            $GetAllFacility = env('API_GET_ALL_FACILITIES');
            $apiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
            $decodedHCFUnderPro = $apiHCFUnderPro->json();
            $HCFUnderPro = json_decode($decodedHCFUnderPro['result'], true);

        }
        // GET ALL HCPN CONTRACTS
        $GetContract = env('API_GET_CONTRACT');
        $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
        $decodedapiContract = $apiContract->json();
        $HCPNContract = json_decode($decodedapiContract['result'], true);
        // GET ALL FACILITY
        $GetAllFacility = env('API_GET_ALL_FACILITIES');
        $apiHCFapex = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
        $decodedHCFapex = $apiHCFapex->json();
        $HCFapex = json_decode($decodedHCFapex['result'], true);

        return view('Reports/ledger-forms', compact('ManagingBoard', 'MBUnderPro', 'HCFUnderPro', 'HCFapex', 'HCPNContract'));
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
        $GetAssets = env('API_GET_ASSETS');
        $Assets = Http::withoutVerifying()->get($GetAssets . '/ACTIVE/' . $SelectedConID);
        $decodedResponse = $Assets->json();
        $Assets = json_decode($decodedResponse['result'], true);

        // GET HCPN
        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        return view('Reports/apex-ledger', compact('ManagingBoard', 'Assets', 'SelectedConID', 'SelectedHCFID', 'SelectedDateTo', 'SelectedDateFrom', 'SelectedAmount'));
    }

    public function GetHCPNLedger(Request $request)
    {
        $SelectedConID = $request->query('conid', '');
        $SelectedConNumber = $request->query('controlnumber', '');
        $SessionUserID = session()->get('userid');
        // GET FACILITIES ASSETS
        $GetLedger = env('API_GET_LEDGER_PER_CONTRACT');
        $gethcpncontract = Http::withoutVerifying()->get($GetLedger . '/' . $SelectedConNumber . '/' . $SelectedConID .
            '/HCPN');
        $decodedResponse = $gethcpncontract->json();
        $HCPNledger = json_decode($decodedResponse['result'], true);

        // GET ALL HCPN
        $GetHCPN = env('API_GET_HCPN');
        $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
        $decodedMB = $apiMB->json();
        $ManagingBoard = json_decode($decodedMB['result'], true);

        $GetContract = env('API_GET_CONTRACT');
        $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
        $decodedapiContract = $apiContract->json();
        $Contract = json_decode($decodedapiContract['result'], true);

        return view(
            'Reports/hcpn-ledger',
            compact(
                'ManagingBoard',
                'HCPNledger',
                'SelectedConID',
                'SelectedConNumber',
                'Contract'
            )
        );
    }

    public function VIEWBUDGET(request $request)
    {
        $ConNumber = $request->query('controlNumber', '');

        if ($ConNumber != null) {
            $GetBudget = env('API_GET_SUMMARY');
            $apiBudget = Http::withoutVerifying()->get($GetBudget . '/HCPN/' . $ConNumber);
            $decodedBudget = $apiBudget->json();

            if ($decodedBudget['success'] === false) {

                $apiBudget = Http::withoutVerifying()->get($GetBudget . '/FACILITY/' . $ConNumber);
                $decodedBudget = $apiBudget->json();
            }

            $Budget = json_decode($decodedBudget['result'], true);
            $SessionUserID = session()->get('userid');

            if (session()->get('leveid') == "PHIC") {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                return view('Reports/basebudget', compact('Budget', 'HCPN', 'Facilities'));

            } elseif (session()->get('leveid') == "PRO") {

                $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                $ApiHCFUnderPro = Http::withoutVerifying()->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                $HCPN = json_decode($decodedHCFUnderPro['result'], true);

                $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
                $decodedHCFUnderPro = $apiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $APEXFacilities = json_decode($decodedResponse['result'], true);

                return view('Reports/basebudget', compact('HCPN', 'Facilities', 'Budget', 'APEXFacilities'));

            } else {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);
                return view('Reports/basebudget', compact('Budget', 'HCPN', 'Facilities'));

            }


        } else {

            $SessionUserID = session()->get('userid');
            $Budget = null;

            if (session()->get('leveid') == "PHIC") {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                return view('Reports/basebudget', compact('HCPN', 'Facilities', 'Budget'));

            } elseif (session()->get('leveid') == "PRO") {

                $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                $ApiHCPNUnderPro = Http::withoutVerifying()->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                $decodedHCPNUnderPro = $ApiHCPNUnderPro->json();
                $HCPN = json_decode($decodedHCPNUnderPro['result'], true);

                $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
                $decodedHCFUnderPro = $apiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $APEXFacilities = json_decode($decodedResponse['result'], true);

                return view('Reports/basebudget', compact('HCPN', 'Facilities', 'Budget', 'APEXFacilities'));

            } else {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                return view('Reports/basebudget', compact('HCPN', 'Facilities', 'Budget'));

            }


        }
    }

    public function GeneralLedger(request $request)
    {
        $HCFHCPN = $request->query('hcfHCPN', '');
        $SelectedConID = $request->query('conID', '');
        $ConNumber = $request->query('controlNumber', '');
        $SessionUserID = session()->get('userid');
        if ($HCFHCPN == null) {

            $SelectedHCFHCPN = "0";
        } else {

            $SelectedHCFHCPN = $HCFHCPN;
        }

        if ($ConNumber != null && $SelectedConID != null) {

            $GetLedger = env('API_GET_LEDGER_PER_CONTRACT');
            $gethcpncontract = Http::withoutVerifying()->get($GetLedger . '/' . $ConNumber . '/' . $SelectedConID . '/HCPN');
            $decodedResponse = $gethcpncontract->json();
            $Ledger = json_decode($decodedResponse['result'], true);


            if (session()->get('leveid') == "PHIC") {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                $GetContract = env('API_GET_CONTRACT');
                $apiHCPNContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
                $decodedapiHCPNContract = $apiHCPNContract->json();
                $HCPNContract = json_decode($decodedapiHCPNContract['result'], true);

                return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'HCPNContract', 'Ledger', 'SelectedHCFHCPN'));

            } elseif (session()->get('leveid') == "PRO") {

                $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                $ApiHCFUnderPro = Http::withoutVerifying()->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                $HCPN = json_decode($decodedHCFUnderPro['result'], true);

                $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
                $decodedHCFUnderPro = $apiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $APEXFacilities = json_decode($decodedResponse['result'], true);
                $GetContract = env('API_GET_CONTRACT');
                $apiHCPNContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
                $decodedapiHCPNContract = $apiHCPNContract->json();
                $HCPNContract = json_decode($decodedapiHCPNContract['result'], true);

                return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'HCPNContract', 'Ledger', 'SelectedHCFHCPN'));

            } else {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $ApiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $GetContract = env('API_GET_CONTRACT');
                $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/' . $SessionUserID . '/HCPN');
                $decodedapiContract = $apiContract->json();
                $HCPNContract = json_decode($decodedapiContract['result'], true);

                return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'Ledger', 'SelectedHCFHCPN', 'HCPNContract'));

            }


        } else {

            $SessionUserID = session()->get('userid');
            $Ledger = null;

            if (session()->get('leveid') == "PHIC") {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                $GetContract = env('API_GET_CONTRACT');
                $apiHCPNContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
                $decodedapiHCPNContract = $apiHCPNContract->json();
                $HCPNContract = json_decode($decodedapiHCPNContract['result'], true);

                return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'Ledger', 'HCPNContract', 'SelectedHCFHCPN'));

            } elseif (session()->get('leveid') == "PRO") {

                $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                $ApiHCPNUnderPro = Http::withoutVerifying()->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                $decodedHCPNUnderPro = $ApiHCPNUnderPro->json();
                $HCPN = json_decode($decodedHCPNUnderPro['result'], true);

                $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
                $decodedHCFUnderPro = $apiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . '/ALL/0');
                $decodedResponse = $apiResponse->json();
                $APEXFacilities = json_decode($decodedResponse['result'], true);

                $GetContract = env('API_GET_CONTRACT');
                $apiHCPNContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
                $decodedapiHCPNContract = $apiHCPNContract->json();
                $HCPNContract = json_decode($decodedapiHCPNContract['result'], true);

                return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'HCPNContract', 'Ledger', 'SelectedHCFHCPN'));

            } else {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $ApiHCFUnderPro = Http::withoutVerifying()->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $GetContract = env('API_GET_CONTRACT');
                $apiContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/' . $SessionUserID . '/HCPN');
                $decodedapiContract = $apiContract->json();
                $HCPNContract = json_decode($decodedapiContract['result'], true);

                return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'Ledger', 'SelectedHCFHCPN', 'HCPNContract'));

            }


        }
    }
    public function Booking(request $request)
    {
        $transCode = $request->query('transCode', '');
        $HCFHCPN = $request->query('hcfHCPN', '');
        $SelectedConID = $request->query('conID', '');
        $ConNumber = $request->query('controlNumber', '');
        $SessionUserID = session()->get('userid');
        $SessionUserID = session()->get('userid');
        if ($HCFHCPN == null) {

            $SelectedHCFHCPN = "0";
        } else {

            $SelectedHCFHCPN = $HCFHCPN;
        }
        if ($ConNumber != null && $SelectedConID != null) {

            $GetClaims = env('API_GET_CLAIMS');
            $gethcpncontract = Http::withoutVerifying()->get($GetClaims . '/' . $ConNumber . '/' . $SelectedConID .
                '/HCPN');
            $decodedResponse = $gethcpncontract->json();
            $Claims = json_decode($decodedResponse['result'], true);


            if (session()->get('leveid') == "PHIC") {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                $GetContract = env('API_GET_CONTRACT');
                $apiHCPNContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
                $decodedapiHCPNContract = $apiHCPNContract->json();
                $HCPNContract = json_decode($decodedapiHCPNContract['result'], true);

                return view('Reports/booking', compact('HCPN', 'Facilities', 'HCPNContract', 'Claims', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

            } elseif (session()->get('leveid') == "PRO") {

                $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                $ApiHCFUnderPro = Http::withoutVerifying()->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                $HCPN = json_decode($decodedHCFUnderPro['result'], true);

                $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
                $decodedHCFUnderPro = $apiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $APEXFacilities = json_decode($decodedResponse['result'], true);
                $GetContract = env('API_GET_CONTRACT');
                $apiHCPNContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
                $decodedapiHCPNContract = $apiHCPNContract->json();
                $HCPNContract = json_decode($decodedapiHCPNContract['result'], true);

                return view('Reports/booking', compact('HCPN', 'Facilities', 'APEXFacilities', 'HCPNContract', 'Claims', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

            } else {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);
                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                return view('Reports/booking', compact('HCPN', 'Facilities', 'Claims', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

            }


        } else {

            $SessionUserID = session()->get('userid');
            $Claims = null;
            $SelectedConID = "0";
            $ConNumber = "0";
            $transCode = "0";

            if (session()->get('leveid') == "PHIC") {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                $GetContract = env('API_GET_CONTRACT');
                $apiHCPNContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
                $decodedapiHCPNContract = $apiHCPNContract->json();
                $HCPNContract = json_decode($decodedapiHCPNContract['result'], true);

                return view('Reports/booking', compact('HCPN', 'Facilities', 'Claims', 'HCPNContract', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

            } elseif (session()->get('leveid') == "PRO") {

                $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                $ApiHCPNUnderPro = Http::withoutVerifying()->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                $decodedHCPNUnderPro = $ApiHCPNUnderPro->json();
                $HCPN = json_decode($decodedHCPNUnderPro['result'], true);

                $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                $apiHCFUnderPro = Http::withoutVerifying()->get($GetFacilitywithPro . '/' . $SessionUserID);
                $decodedHCFUnderPro = $apiHCFUnderPro->json();
                $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . '/ALL/0');
                $decodedResponse = $apiResponse->json();
                $APEXFacilities = json_decode($decodedResponse['result'], true);

                $GetContract = env('API_GET_CONTRACT');
                $apiHCPNContract = Http::withoutVerifying()->get($GetContract . '/ACTIVE/0/PHICHCPN');
                $decodedapiHCPNContract = $apiHCPNContract->json();
                $HCPNContract = json_decode($decodedapiHCPNContract['result'], true);

                return view('Reports/booking', compact('HCPN', 'Facilities', 'APEXFacilities', 'HCPNContract', 'Claims', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

            } else {

                $GetHCPN = env('API_GET_HCPN');
                $apiMB = Http::withoutVerifying()->get($GetHCPN . "/ACTIVE");
                $decodedMB = $apiMB->json();
                $HCPN = json_decode($decodedMB['result'], true);

                $GetAllFacility = env('API_GET_ALL_FACILITIES');
                $apiResponse = Http::withoutVerifying()->get($GetAllFacility . "/ALL/0");
                $decodedResponse = $apiResponse->json();
                $Facilities = json_decode($decodedResponse['result'], true);

                return view('Reports/booking', compact('HCPN', 'Facilities', 'Claims', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

            }


        }
    }

    public function BookData(Request $request)
    {


        $now = new DateTime();
        $sessionuserid = session()->get('userid');
        $InsertAssets = env('API_BOOK_DATA');
        $response = Http::post($InsertAssets, [
            'booknum' => $request->input('booknum'),
            'conid' => $request->input('conid'),
            'hcpncode' => $request->input('code'),
            'tags' => 'HCPN',


            'createdby' => $sessionuserid,

            'datecreated' => $now->format('m-d-Y'),
        ]);

        if ($response->successful()) {
            return back();
        }
    }

}