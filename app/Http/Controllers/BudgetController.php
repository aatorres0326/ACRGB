<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class BudgetController extends Controller
{
    public function viewFacilityBudget()
    {
        return view('BudgetManagement/hcfbudget');
    }


    public function GetFacilityBudget()
    {

        $datefrom = "MM-dd-yyy";
        $dateto = "MM-dd-yyyy";
        // $apiFacilityBudget = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthFacilityBadget/'.$datefrom.'/'.$dateto);
        $apiFacilityBudget = Http::withoutVerifying()->get('http://localhost:7001/ACRGB/ACRGBFETCH/GetHealthFacilityBadget/01-25-2007/02-25-2024');

        $decodedapiFacilityBudget = $apiFacilityBudget->json();

        $FacilityBudget = json_decode($decodedapiFacilityBudget['result'], true);

        return view('BudgetManagement/budget-management', compact('FacilityBudget'));
    }

}