<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private function authenticate() {
        $user = Http::acceptJson()->withToken(session('token'))->post(env('USERS_URL') . '/auth/me');
        try {
            json_decode($user)->id;
        } catch (\Exception $exception) {
            return redirect(route('login.show'));
        }

        return $user;
    }

    public function listings() {
        $user = json_decode($this->authenticate());

        return view('dashboard.home', compact('user'));
    }
}
