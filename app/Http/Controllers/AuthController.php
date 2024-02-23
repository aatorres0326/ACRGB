<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{


    public function login()
    {
        return view('auth/login');
    }





    public function loginAction(Request $request)
    {
        // Assuming you have login data to send in the request
        $loginData = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        // Make a POST request to the API endpoint for user login
        $apiUrl = 'http://localhost:7001/ACRGB/ACRGBINSERT/UserLogin';

        $response = Http::post($apiUrl, $loginData);

        // Check if the request was successful
        if ($response->successful()) {
            // Check if the API request was successful
            if ($response['success']) {

                $result = json_decode($response['result'], true);
                $level = $result['leveid'];

                $userlevel = 'http://localhost:7001/ACRGB/ACRGBFETCH/GetLevel/' . $level;

                $levelresult = json_decode($userlevel['result'], true);


                // Start a session or perform other actions
                $this->startUserSession($result);

                // Redirect to the dashboard
                return view('dashboard', compact('result'));


            } else {
                return response()->json(['error' => 'Login failed. API response indicates failure.' . $response]);
            }

        } else {
            // Handle the case where the API request was not successful
            return response()->json(['error' => 'Failed to perform login.'], $response->status());
        }
    }

    // Function to start user session
    private function startUserSession($userData)
    {
        // Example: Store user ID in the session
        session([
            'userid' => $userData['userid'],
            'username' => $userData['username'],
            'firstname' => $userData['firstname'],
            'lastname' => $userData['lastname'],
            // Add other relevant user data to the session as needed
        ]);
        // Add other relevant user data to the session as needed
        // ...
    }


    public function logout()
    {
        // Clear all session data
        Session::flush();

        // Generate a new session ID
        Session::regenerate();

        // Redirect the user to the login page or any other destination
        return redirect('/login');
    }

}
