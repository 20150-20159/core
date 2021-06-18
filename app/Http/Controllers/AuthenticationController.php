<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    public function loginShow()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        try {
            $response = Http::post(env('USERS_URL') . '/auth/login', [
                'email' => $request->post('email'),
                'password' => $request->post('password')
            ]);
            if (!empty($response)) {
                if (!empty($response->body())) {
                    $token = json_decode($response->body(), true)['access_token'];
                    if (!empty($token)) {
                        session(['token' => $token]);
                        return redirect(route('dashboard.home'));
                    }
                }
            }
        } catch (\Exception $e) {}

        return redirect(route('login.show'));
    }

    public function logout()
    {
        try {
            Http::withToken(session('token'))->post(env('USERS_URL') . '/auth/logout');
        } catch (\Exception $e) {
        }

        session()->flush();

        return redirect(route('login.show'));
    }

}
