<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PageController extends Controller
{

    public function dashboard()
    {
        return view('dashboard');
    }
    public function profile()
    {
        return view('profile');
    }

    public function table()
    {
        return view('table');
    }

    public function users()
    {
        return view('user-management');
    }
    public function assets()
    {
        return view('assets');
    }
    public function xmlupload()
    {
        return view('xml-upload');
    }
    public function budgetmanagement()
    {
        return view('budget-management');
    }


}

