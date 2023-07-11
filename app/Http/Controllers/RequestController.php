<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\AdminStoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Http\Requests\AdminUpdateRequestRequest;
use App\Models\Client;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not found', 401);
        }
        $requests = Request::where('client_id', $client['id'])->get();
        return $this->success([
            'requests' => $requests,
        ], "Request found successfully");
    }

    public function adminIndex()
    {
        /* to modify */
        $requests = Request::all();
        return $this->success([
            'requests' => $requests,
        ], "Requests found successfully");
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestRequest $request)
    {
        $request->validated($request->all());
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not found', 401);
        }
        $request = Request::create([
            'client_id' => $client['id'],
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


    public function adminStore(AdminStoreRequestRequest $request)
    {
        $request->validated($request->all());
        $client = Client::find($request->client_id);
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
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not found', 401);
        }
        $request = Request::where('id', $request_id)->where('client_id', $client['id'])->first();
        if (!$request) {
            return $this->error('', 'the request you want to see is not found', 401);
        }
        return $this->success([
            'request' => $request,
        ], "Request found successfully");
    }

    public function adminShow($request_id)
    {
        $request = Request::find($request_id);
        if (!$request) {
            return $this->error('', 'the request you want to see is not found', 401);
        }
        return $this->success([
            'request' => $request,
        ], "Request found successfully");
    }


    public function edit(UpdateRequestRequest $request, $request_id)
    {
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not found', 401);
        }
        $request_request = Request::where('id', $request_id)->where('client_id', $client['id'])->first();
        if (!$request_request) {
            return $this->error('', 'the request you want to edit is not found', 401);
        }
        $new_data = $request->validated();
        $request_request->update($new_data);
        return $this->success([
            'request' => $request_request,
        ], "Request modified successfully");
    }

    public function adminEdit(AdminUpdateRequestRequest $request, $request_id)
    {
        $request_request = Request::find($request_id);
        if (!$request_request) {
            return $this->error('', 'The request you want to edit is not found', 401);
        }
        $new_data = $request->validated();
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
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not found', 401);
        }
        $request = Request::where('id', $request_id)->where('client_id', $client['id'])->first();
        if (!$request) {
            return $this->error('', 'the request you want to delete is not found', 401);
        }
        $request->delete();
        return $this->success([], "Request deleted successfully");
    }

    public function adminDestroy($request_id)
    {
        $request = Request::find($request_id);
        if (!$request) {
            return $this->error('', 'Request not found', 401);
        }
        $request->delete();
        return $this->success([], "Request deleted successfully");
    }
}
