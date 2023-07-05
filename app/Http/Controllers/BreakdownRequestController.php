<?php

namespace App\Http\Controllers;

use App\Models\BreakdownRequest;
use App\Http\Requests\StoreBreakdownRequestRequest;
use App\Http\Requests\UpdateBreakdownRequestRequest;
use App\Models\Breakdown;
use App\Models\Request;
use App\Traits\HttpResponses;

class BreakdownRequestController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breakdown_requests = BreakdownRequest::all();
        return $this->success([
            'Breakdown Requests' => $breakdown_requests,
        ],);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBreakdownRequestRequest $request)
    {
        $request->validated($request->all());
        $request_request = Request::find($request->request_id);
        if (!$request_request) {
            return $this->error('', 'Request not found', 401);
        }
        $breakdown = Breakdown::find($request->breakdown_id);
        if (!$breakdown) {
            return $this->error('', 'Breakdown not found', 401);
        }
        $exist = BreakdownRequest::where('request_id', $request->request_id)->where('breakdown_id', $request->breakdown_id)->count();
        if ($exist >= 1) {
            return $this->error('', 'Breakdown Request already exists', 401);
        }
        $breakdown_request = BreakdownRequest::create([
            'request_id' => $request->request_id,
            'breakdown_id' => $request->breakdown_id,
        ]);
        return $this->success([
            'Breakdown Request' => $breakdown_request,
        ], "Breakdown Request stored successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($request_id, $breakdown_id)   //najmou nekhdmouha bel request also
    {

        $breakdoqn_request = BreakdownRequest::where('request_id', $request_id)
            ->where('breakdown_id', $breakdown_id)->first();
        if (!$breakdoqn_request) {
            return $this->error('', 'Breakdown Request doesn\'t exists', 401);
        }
        return $this->success([
            'breakdown request ' => $breakdoqn_request,
        ], "Breakdown Request found successfully");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BreakdownRequest $breakdownRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBreakdownRequestRequest $request, BreakdownRequest $breakdownRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($request_id, $breakdown_id)
    {
        $breakdoqn_request = BreakdownRequest::where('request_id', $request_id)
            ->where('breakdown_id', $breakdown_id)->first();
        if (!$breakdoqn_request) {
            return $this->error('', 'the Breakdown Request you want to delete doesn\'t exists', 401);
        }
        $breakdoqn_request->delete();
        return $this->success([], "Breakdown Request deleted successfully");
    }
}
