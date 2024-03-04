<?php

namespace App\Http\Controllers;



class PageController extends Controller
{

    public function dashboard()
    {
        return view('dashboard');
    }

    public function assets()
    {
        return view('BudgetManagement/assets');
    }

    public function budgetmanagement()
    {
        return view('BudgetManagement/budget-management');
    }


}

