<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use MongoDB\Driver\Session;

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
                    $response = json_decode($response->body(), true);

                    if (empty($response['access_token'])) {
                        session()->flash('error', 'Bad credentials');
                        return redirect(route('login.show'));
                    }

                    $token = $response['access_token'];
                    session(['token' => $token]);
                    return redirect(route('dashboard.home'));
                    }
                }
                session()->flash('error', 'Error in communication');
            }
            catch (\Exception $e) {
                if(!empty($e)) {
                    session()->flash('error', 'Error in communication');
                }
            }

        return redirect(route('login.show'));
    }

    public function registerShow() {
        return view('login.register');
    }

    public function register(Request $request) {
        $response = Http::acceptJson()->post(env('USERS_URL'). "/register", [
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'email' => $request->post('email'),
            'password' => $request->post('password'),
            'vat' => $request->post('vat'),
        ]);

        if ($response->status() !== 201) {
            //TODO show error
            return redirect(route('login'));
        }

        session()->flash('success', true);
        return redirect(route('login'));
    }

    public function logout()
    {
        try {
            Http::acceptJson()->withToken(session('token'))->post(env('USERS_URL') . '/auth/logout');
        } catch (\Exception $e) {
        }

        session()->flush();

        return redirect(route('login.show'));
    }

}
