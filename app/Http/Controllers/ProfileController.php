<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class ProfileController extends Controller
{

    public function UpdateProfileLogin(Request $request)
    {
        $token = session()->get('token');
           //================================== TOKEN
$TokenValidate = env('API_VALIDATE_TOKEN');
        $validate = http::withHeaders(['token' => $token])->get($TokenValidate);
        if ($validate->status() < 400) {
            $decodevalidate = $validate->json();
            if ($validate['success'] == 'true') {
//=========================================== END TOKEN

        $response = Http::withHeaders(['token' => $token])->put('http://localhost:7001/ACRGB/ACRGBUPDATE/UPDATEUSERCREDENTIALS', [
            'userid' => $request->input('userid'),
            'username' => $request->input('editusername'),
            'userpassword' => $request->input('editpassword'),


        ]);

        if ($response->successful()) {
            return redirect('/profile');

        }

    }

//========================TOKEN
  } else {

                redirect('login');
            }

        }

//===================END TOKEN



}