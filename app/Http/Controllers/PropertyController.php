<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        if (empty($this->user)) {
            return response('Unauthorized', 401);
        }
        Property::create($request->all());
        return response('Property created', 201);
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
     * @return Response
     */
    public function destroy(int $id): Response
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

        $property->delete();
        return response('Property deleted');
    }
}
