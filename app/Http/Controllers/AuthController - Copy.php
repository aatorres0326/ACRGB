<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class LoginController extends Controller
{
    // ...

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed, reset login attempts
            $this->clearLoginAttempts($request);

            return redirect()->intended('/dashboard');
        }

        // Authentication failed, increment login attempts
        $this->incrementLoginAttempts($request);

        // Check if the user exceeded the maximum attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->lockAccount($request);
            return $this->sendLockoutResponse($request);
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    protected function lockAccount(Request $request)
    {
        $user = $this->getUser($request);
        $user->update([
            'locked' => true, // Add a 'locked' field in your users table
        ]);
    }

    protected function clearLoginAttempts(Request $request)
    {
        $this->limiter()->clear($this->throttleKey($request));
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit($this->throttleKey($request));
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts($this->throttleKey($request), 3, 1); // Lock after 3 attempts
    }

    protected function throttleKey(Request $request)
    {
        return mb_strtolower($request->input('email')) . '|' . $request->ip();
    }

    protected function getUser(Request $request)
    {
        return User::where('email', $request->input('email'))->firstOrFail();
    }

    // ...



    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }


}
