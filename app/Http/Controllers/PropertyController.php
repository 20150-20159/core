<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * @var User $user
     */
    private $user;

    public function __construct(Request $request)
    {
        $jwt = $request->bearerToken();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $jwt
        ])->post(env('USERS_URL').'/auth/me');

        $this->user = !empty($response->json()['id']) ? new User($response->json()) : null;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        if (empty($this->user)) {
            return response('Unauthorized', 401);
        }

        return Property::where('user_id', $this->user->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //Validate request
        $request->validate([
            'address' => 'required|max:255',
            'size' => 'required|numeric|max:255',
            'deed_file' => 'required|mimes:pdf',
        ]);

        $file = $request->file('deed_file')->store('');
        if (empty($file)) {
            session()->flash('error', 'Error in file upload');
            return redirect(route('dashboard.home'));
        }

        $property = new Property();
        $property->address = $request->post('address');
        $property->size = $request->post('size');
        $property->user_id = $request->post('user_id');
        $property->deed = $file;
        $property->save();
        return redirect(route('dashboard.home'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Property|Response
     */
    public function show(int $id)
    {
        if (empty($this->user)) {
            return response('Unauthorized', 401);
        }

        $property = Property::find($id);
        if (empty($property)) {
            return response('Property not found', 404);
        }

        if ($property->user_id !== $this->user->id) {
            return response('Unauthorized property', 401);
        }

        return $property;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        if (empty($this->user)) {
            return response('Unauthorized', 401);
        }

        $property = Property::find($id);
        if (empty($property)) {
            return response('Property not found', 404);
        }

        if ($property->user_id !== $this->user->id) {
            return response('Unauthorized property', 401);
        }

        $property->update($request->all());
        return response('Property updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $property = Property::find($id);
        if (empty($property)) {
            return response('Property not found', 404);
        }

        $property->delete();
        return redirect(route('admin.properties'));
    }

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

    public function approveTransfer(Property $property) {
        $user = $this->authenticate();

        //Check if user is the transfer beneficiary
        if ($property->transfer_user_id != $user->id) {
            //TODO Add error
            return redirect(route('dashboard.home'));
        }

        $property->user_id = $property->transfer_user_id;
        $property->transfer_user_id = null;
        $property-> update();

        try {
            Http::post(env('NOTIFICATIONS_URL').'/requestSuccess', [
                'name' => $user->name . ' ' . $user->surname,
                'to' => $user->email,
            ]);
        } catch (\Exception $e) {}

        return redirect(route('dashboard.home'));
    }

    public function rejectTransfer(Property $property) {
        $user = $this->authenticate();

        //Check if user is the transfer beneficiary
        if ($property->transfer_user_id != $user->id) {
            //TODO Add error
            return redirect(route('dashboard.home'));
        }

        $property->transfer_user_id = null;
        $property->update();

        try {
            Http::post(env('NOTIFICATIONS_URL').'/requestReject', [
                'name' => $user->name . ' ' . $user->surname,
                'to' => $user->email,
            ]);
        } catch (\Exception $e) {}

        return redirect(route('dashboard.home'));
    }

    public function initiateTransfer(Property $property, Request $request) {
        $user = $this->authenticate();

        if ($property->user_id != $user->id) {
            //TODO Add error
            return redirect(route('dashboard.home'));
        }

        $response = Http::acceptJson()->get(env('USERS_URL'). "/getUserIdByVat", [
            'vat' => $request->post('vat')
        ]);

        if ($response->status() !== 200) {
            //TODO show error
            return redirect(route('dashboard.home'));
        }

        $property->transfer_user_id = $response->body();
        $property->update();

        try {
            Http::post(env('NOTIFICATIONS_URL').'/submissionRequest', [
                'name' => $user->name . ' ' . $user->surname,
                'to' => $user->email,
            ]);
        } catch (\Exception $e) {}

        return redirect(route('dashboard.home'));
    }

    public function cancelTransfer(Property $property) {
        $property->transfer_user_id = null;
        $property->update();

        return redirect(route('admin.properties'));
    }

    public function deed(Property $property) {
        return Storage::download($property->deed, $property->address. 'deed.pdf');
    }
}
