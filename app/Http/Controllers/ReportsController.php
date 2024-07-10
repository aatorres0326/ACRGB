<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;



class ReportsController extends Controller
{

    public function SubsidiaryLedger(request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {

                //=========================================== END TOKEN

                $HCFHCPN = $request->query('hcfHCPN', '');
                $SelectedConID = $request->query('conID', '');
                $ConNumber = $request->query('controlNumber', '');
                $SessionUserID = session()->get('userid');
                $selectType = $request->query('selectType', '');

                $GetContract = env('API_GET_ALL_CONTRACT');
                $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/ACTIVE');
                $decodedapiContract = $apiContract->json();
                $Contract = json_decode($decodedapiContract['result'], true);
                if ($HCFHCPN == null) {

                    $SelectedHCFHCPN = "0";
                } else {

                    $SelectedHCFHCPN = $HCFHCPN;
                }

                if ($ConNumber != null && $SelectedConID != null) {


                    $GetLedger = env('API_GET_LEDGER_PER_CONTRACT');
                    if ($selectType == "HCPN") {
                        $gethcpncontract = Http::withHeaders(['token' => $token])->get($GetLedger . '/' . $ConNumber . '/' . $SelectedConID . '/HCPN/ACTIVE');
                    } else {
                        $gethcpncontract = Http::withHeaders(['token' => $token])->get($GetLedger . '/' . $ConNumber . '/' . $SelectedConID . '/FACILITY/ACTIVE');
                    }
                    $decodedResponse = $gethcpncontract->json();
                    $Ledger = json_decode($decodedResponse['result'], true);

                    if (session()->get('leveid') == "PHIC") {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);
                        $APEXFacilities = json_decode($decodedResponse['result'], true);



                        return view('Reports/subsidiary-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Ledger', 'SelectedHCFHCPN'));

                    } elseif (session()->get('leveid') == "PRO") {

                        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                        $HCPN = json_decode($decodedHCFUnderPro['result'], true);

                        $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                        $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                        $decodedHCFUnderPro = $apiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $APEXFacilities = json_decode($decodedResponse['result'], true);


                        return view('Reports/subsidiary-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Ledger', 'SelectedHCFHCPN'));

                    } else {



                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);



                        return view('Reports/subsidiary-ledger', compact('Facilities', 'Ledger', 'SelectedHCFHCPN', 'Contract'));

                    }


                } else {

                    $SessionUserID = session()->get('userid');
                    $Ledger = null;

                    if (session()->get('leveid') == "PHIC") {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);
                        $APEXFacilities = json_decode($decodedResponse['result'], true);




                        return view('Reports/subsidiary-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'Ledger', 'Contract', 'SelectedHCFHCPN'));

                    } elseif (session()->get('leveid') == "PRO") {

                        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                        $ApiHCPNUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                        $decodedHCPNUnderPro = $ApiHCPNUnderPro->json();
                        $HCPN = json_decode($decodedHCPNUnderPro['result'], true);

                        $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                        $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                        $decodedHCFUnderPro = $apiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . '/ALL/0');
                        $decodedResponse = $apiResponse->json();
                        $APEXFacilities = json_decode($decodedResponse['result'], true);



                        return view('Reports/subsidiary-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Ledger', 'SelectedHCFHCPN'));

                    } else {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);



                        return view('Reports/subsidiary-ledger', compact('HCPN', 'Facilities', 'Ledger', 'SelectedHCFHCPN', 'Contract'));

                    }
                }

                //========================TOKEN
            } else {

                redirect('login');
            }

        }


        //===================END TOKEN
    }


    public function VIEWBUDGET(request $request)
    {

        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $ConNumber = $request->query('controlNumber', '');
                $Facilities = $request->query('Facilities', '');
                $HCFCodes = trim($Facilities);
                $datefrom = $request->query('DateFrom', '');
                $datef = date_create($datefrom);
                $datefromformat = date_format($datef, "m-d-Y");
                $dateto = $request->query('DateTo', '');
                $datet = date_create($dateto);
                $datetoformat = date_format($datet, "m-d-Y");

                if ($ConNumber != null && $datefrom != null && $dateto != null) {
                    $GetBudget = env('API_GET_SUMMARY');
                    if ($HCFCodes === "") {
                        $apiBudget = Http::withHeaders(['token' => $token])->get($GetBudget . '/FACILITY/' . $ConNumber . '/' . $datefromformat . '/' . $datetoformat . '/SUMMARY/OLD');
                        $decodedBudget = $apiBudget->json();

                    } else {
                        $apiBudget = Http::withHeaders(['token' => $token])->get($GetBudget . '/HCPN/' . $ConNumber . '/' . $datefromformat . '/' . $datetoformat . '/SUMMARY/' . $HCFCodes);
                        $decodedBudget = $apiBudget->json();

                    }

                    if ($decodedBudget != null) {
                        $Budget = json_decode($decodedBudget['result'], true);
                    } else {
                        $Budget = null;
                    }

                    $SessionUserID = session()->get('userid');

                    if (session()->get('leveid') == "PHIC") {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/basebudget', compact('Budget', 'HCPN', 'Facilities', 'HCFCodes'));

                    } elseif (session()->get('leveid') == "PRO") {

                        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                        $HCPN = json_decode($decodedHCFUnderPro['result'], true);

                        $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                        $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                        $decodedHCFUnderPro = $apiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $APEXFacilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/basebudget', compact('HCPN', 'Facilities', 'Budget', 'APEXFacilities', 'HCFCodes'));

                    } else {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);
                        return view('Reports/basebudget', compact('Budget', 'HCPN', 'Facilities'));

                    }


                } else {

                    $SessionUserID = session()->get('userid');
                    $Budget = null;

                    if (session()->get('leveid') == "PHIC") {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/basebudget', compact('HCPN', 'Facilities', 'Budget'));

                    } elseif (session()->get('leveid') == "PRO") {

                        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                        $ApiHCPNUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                        $decodedHCPNUnderPro = $ApiHCPNUnderPro->json();
                        $HCPN = json_decode($decodedHCPNUnderPro['result'], true);

                        $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                        $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                        $decodedHCFUnderPro = $apiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $APEXFacilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/basebudget', compact('HCPN', 'Facilities', 'Budget', 'APEXFacilities'));

                    } else {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/basebudget', compact('HCPN', 'Facilities', 'Budget'));

                    }


                }


                //========================TOKEN
            } else {

                redirect('login');
            }

        }

        //===================END TOKEN



    }

    public function GeneralLedger(request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $HCFHCPN = $request->query('hcfHCPN', '');
                $SelectedConID = $request->query('conID', '');
                $ConNumber = $request->query('controlNumber', '');
                $SessionUserID = session()->get('userid');
                $selectType = $request->query('selectType', '');

                $GetContract = env('API_GET_ALL_CONTRACT');
                $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/INACTIVE');
                $decodedapiContract = $apiContract->json();
                $Contract = json_decode($decodedapiContract['result'], true);

                if ($HCFHCPN == null) {

                    $SelectedHCFHCPN = "0";
                } else {

                    $SelectedHCFHCPN = $HCFHCPN;
                }

                if ($ConNumber != null && $SelectedConID != null) {

                    $GetLedger = env('API_GET_LEDGER_PER_CONTRACT');
                    if ($selectType == "HCPN") {
                        $gethcpncontract = Http::withHeaders(['token' => $token])->get($GetLedger . '/' . $ConNumber . '/' . $SelectedConID . '/HCPN/INACTIVE');
                    } else if ($selectType == "APEX") {
                        $gethcpncontract = Http::withHeaders(['token' => $token])->get($GetLedger . '/' . $ConNumber . '/' . $SelectedConID . '/FACILITY/INACTIVE');
                    }
                    $decodedResponse = $gethcpncontract->json();
                    $Ledger = json_decode($decodedResponse['result'], true);

                    if (session()->get('leveid') == "PHIC") {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);
                        $APEXFacilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Ledger', 'SelectedHCFHCPN'));

                    } elseif (session()->get('leveid') == "PRO") {

                        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                        $HCPN = json_decode($decodedHCFUnderPro['result'], true);

                        $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                        $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                        $decodedHCFUnderPro = $apiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $APEXFacilities = json_decode($decodedResponse['result'], true);


                        return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Ledger', 'SelectedHCFHCPN'));

                    } else {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'Ledger', 'SelectedHCFHCPN', 'Contract'));

                    }


                } else {

                    $SessionUserID = session()->get('userid');
                    $Ledger = null;

                    if (session()->get('leveid') == "PHIC") {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);
                        $APEXFacilities = json_decode($decodedResponse['result'], true);


                        return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'Ledger', 'Contract', 'SelectedHCFHCPN'));

                    } elseif (session()->get('leveid') == "PRO") {

                        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                        $ApiHCPNUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                        $decodedHCPNUnderPro = $ApiHCPNUnderPro->json();
                        $HCPN = json_decode($decodedHCPNUnderPro['result'], true);

                        $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                        $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                        $decodedHCFUnderPro = $apiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . '/ALL/0');
                        $decodedResponse = $apiResponse->json();
                        $APEXFacilities = json_decode($decodedResponse['result'], true);



                        return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Ledger', 'SelectedHCFHCPN'));

                    } else {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/HCPN/" . $SessionUserID);
                        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);



                        return view('Reports/general-ledger', compact('HCPN', 'Facilities', 'Ledger', 'SelectedHCFHCPN', 'Contract'));

                    }


                }

                //========================TOKEN
            } else {

                redirect('login');
            }

        }

        //===================END TOKEN




    }
    public function Booking(request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $transCode = $request->query('transCode', '');
                $HCFHCPN = $request->query('hcfHCPN', '');
                $SelectedConID = $request->query('conID', '');
                $ConNumber = $request->query('controlNumber', '');
                $SessionUserID = session()->get('userid');
                $SessionUserID = session()->get('userid');

                $GetContract = env('API_GET_ALL_CONTRACT');
                $apiContract = Http::withHeaders(['token' => $token])->get($GetContract . '/INACTIVE');
                $decodedapiContract = $apiContract->json();
                $Contract = json_decode($decodedapiContract['result'], true);
                if ($HCFHCPN == null) {
                    $SelectedHCFHCPN = "0";
                } else {

                    $SelectedHCFHCPN = $HCFHCPN;
                }
                if ($ConNumber != null && $SelectedConID != null) {

                    $GetClaims = env('API_GET_CLAIMS');
                    $gethcpncontract = Http::withHeaders(['token' => $token])->get($GetClaims . '/' . $ConNumber . '/' . $SelectedConID .
                        '/HCPN');
                    $decodedResponse = $gethcpncontract->json();
                    $Claims = json_decode($decodedResponse['result'], true);


                    if (session()->get('leveid') == "PHIC") {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);
                        $APEXFacilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/booking', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Claims', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

                    } elseif (session()->get('leveid') == "PRO") {

                        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                        $ApiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                        $decodedHCFUnderPro = $ApiHCFUnderPro->json();
                        $HCPN = json_decode($decodedHCFUnderPro['result'], true);

                        $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                        $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                        $decodedHCFUnderPro = $apiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $APEXFacilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/booking', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Claims', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

                    }


                } else {

                    $SessionUserID = session()->get('userid');
                    $Claims = null;
                    $SelectedConID = "0";
                    $ConNumber = "0";
                    $transCode = "0";

                    if (session()->get('leveid') == "PHIC") {

                        $GetHCPN = env('API_GET_HCPN');
                        $apiMB = Http::withHeaders(['token' => $token])->get($GetHCPN . "/ACTIVE");
                        $decodedMB = $apiMB->json();
                        $HCPN = json_decode($decodedMB['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . "/ALL/0");
                        $decodedResponse = $apiResponse->json();
                        $Facilities = json_decode($decodedResponse['result'], true);
                        $APEXFacilities = json_decode($decodedResponse['result'], true);

                        return view('Reports/booking', compact('HCPN', 'Facilities', 'APEXFacilities', 'Claims', 'Contract', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

                    } elseif (session()->get('leveid') == "PRO") {

                        $GetHCPNwithProUser = env('API_GET_HCPN_USING_PRO_USERID');
                        $ApiHCPNUnderPro = Http::withHeaders(['token' => $token])->get($GetHCPNwithProUser . '/' . $SessionUserID . "/PRO");
                        $decodedHCPNUnderPro = $ApiHCPNUnderPro->json();
                        $HCPN = json_decode($decodedHCPNUnderPro['result'], true);

                        $GetFacilitywithPro = env('API_GET_FACILITY_WITH_PRO');
                        $apiHCFUnderPro = Http::withHeaders(['token' => $token])->get($GetFacilitywithPro . '/' . $SessionUserID);
                        $decodedHCFUnderPro = $apiHCFUnderPro->json();
                        $Facilities = json_decode($decodedHCFUnderPro['result'], true);

                        $GetAllFacility = env('API_GET_ALL_FACILITIES');
                        $apiResponse = Http::withHeaders(['token' => $token])->get($GetAllFacility . '/ALL/0');
                        $decodedResponse = $apiResponse->json();
                        $APEXFacilities = json_decode($decodedResponse['result'], true);


                        return view('Reports/booking', compact('HCPN', 'Facilities', 'APEXFacilities', 'Contract', 'Claims', 'SelectedHCFHCPN', 'ConNumber', 'SelectedConID', 'transCode'));

                    }
                }
                //========================TOKEN
            } else {

                redirect('login');
            }

        }

        //===================END TOKEN



    }

    public function BookData(Request $request)
    {
        $token = session()->get('token');
        //================================== TOKEN
        $TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
                //=========================================== END TOKEN
                $now = new DateTime();
                $sessionuserid = session()->get('userid');
                $InsertAssets = env('API_BOOK_DATA');
                $response = Http::withHeaders(['token' => $token])->post($InsertAssets, [
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

                //========================TOKEN
            } else {

                redirect('login');
            }

        }
        //===================END TOKEN


    }




}