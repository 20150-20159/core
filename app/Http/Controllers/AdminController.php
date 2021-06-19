<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
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

    public function properties() {
        $user = $this->authenticate();
        $properties = Property::all();
        return view('admin.properties', compact('user','properties'));
    }
}
