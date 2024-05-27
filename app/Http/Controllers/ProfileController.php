<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class ProfileController extends Controller
{

    public function UpdateProfileLogin(Request $request)
    {

        $response = Http::put('http://localhost:7001/ACRGB/ACRGBUPDATE/UPDATEUSERCREDENTIALS', [
            'userid' => $request->input('userid'),
            'username' => $request->input('editusername'),
            'userpassword' => $request->input('editpassword'),


        ]);

        if ($response->successful()) {
            return redirect('/profile');

        }

    }





}


