<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Client;
use App\Traits\HttpResponses;

class RequestController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = Request::all();
        return response()->json(['data' => $requests], 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestRequest $request)
    {
        $request->validated($request->all());
        $client = Client::where('id', $request->client_id)->first();
        if (!$client) {
            return $this->error('', 'Client not found', 401);
        }
        $request = Request::create([
            'client_id' => $request->client_id,
            'car_type' => $request->car_type,
            'matricule' => $request->matricule,
            'latitude' => $request->latitude,
            "longitude" => $request->longitude,
            "request_type" => $request->request_type,
            "date" => $request->date,
        ]);
        return $this->success([
            'request' => $request,
        ], "Request stored successfully");
    }


    /**
     * Display the specified resource.
     */
    public function show($request_id)
    {
        $request = Request::find($request_id);
        if (!$request) {
            return $this->error('', 'the request you want to see is not found', 401);
        }
        return $this->success([
            'request' => $request,
        ], "Request found successfully");
    }



    public function edit(StoreRequestRequest $request, $request_id)
    {
        $request_request = Request::find($request_id);
        if (!$request_request) {
            return $this->error('', 'the request you want to edit is not found', 401);
        }
        $client = Client::where('id', $request->client_id)->first();
        if (!$client) {
            return $this->error('', 'Client not found', 401);
        }
        $new_data = $request->validated(/*$request->all()*/);
        $request_request->update($new_data);
        return $this->success([
            'request' => $request_request,
        ], "Request modified successfully");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($request_id)
    {
        $request = Request::find($request_id);
        if (!$request) {
            return $this->error('', 'the request you want to delete is not found', 401);
        }
        $request->delete();
        return $this->success([], "Request deleted successfully");
    }
}
