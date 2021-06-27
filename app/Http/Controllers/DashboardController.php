<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private function authenticate() {
        if (empty(session('token'))) {
            return redirect(route('login.show'));
        }

        $user = Http::acceptJson()->withToken(session('token'))->post(env('USERS_URL') . '/auth/me');
        try {
            json_decode($user)->id;
        } catch (\Exception $exception) {
            return redirect(route('login.show'));
        }

        return json_decode($user);
    }

    public function home() {
        $user = $this->authenticate();

        return redirect(route('dashboard.home', compact('user')));
    }

    public function properties() {
        $user = $this->authenticate();

        $properties = Property::where('user_id', $user->id)->whereNull('transfer_user_id')->get();
        $transferRequests = Property::where('transfer_user_id', $user->id)->get();

        return view('dashboard.home', compact('user', 'properties', 'transferRequests'));
    }
}
