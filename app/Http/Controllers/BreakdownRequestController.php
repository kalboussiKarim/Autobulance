<?php

namespace App\Http\Controllers;

use App\Models\BreakdownRequest;
use App\Http\Requests\StoreBreakdownRequestRequest;
use App\Http\Requests\UpdateBreakdownRequestRequest;
use App\Models\Breakdown;
use App\Models\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class BreakdownRequestController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */





    public function adminIndex()
    {
        $breakdown_requests = BreakdownRequest::all();
        return $this->success([
            'Breakdown Requests' => $breakdown_requests,
        ],);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBreakdownRequestRequest $request)
    {
        $request->validated($request->all());
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not connected', 401);
        }
        $request_request = Request::where('id', $request->request_id)->where('client_id', $client['id'])->first();
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
            'Breakdown_Request' => $breakdown_request,
        ], "Breakdown_Request stored successfully");
    }

    public function adminStore(StoreBreakdownRequestRequest $request)
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
    public function show($request_id, $breakdown_id)
    {
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not connected', 401);
        }
        $request = Request::where('id', $request_id)->where('client_id', $client['id'])->first();
        if (!$request) {
            return $this->error('', 'Request not found', 401);
        }
        $breakdown = Breakdown::find($breakdown_id);
        if (!$breakdown) {
            return $this->error('', 'Breakdown not found', 401);
        }
        $breakdown_request = BreakdownRequest::where('request_id', $request_id)
            ->where('breakdown_id', $breakdown_id)->first();
        if (!$breakdown_request) {
            return $this->error('', 'Breakdown Request doesn\'t exists', 401);
        }
        return $this->success([
            'breakdown request ' => $breakdown_request,
        ], "Breakdown Request found successfully");
    }

    public function showBreakdowns($request_id)
    {
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not connected', 401);
        }
        $request = Request::where('id', $request_id)->where('client_id', $client['id'])->first();
        if (!$request) {
            return $this->error('', 'Request not found', 401);
        }

        $breakdown_requests = BreakdownRequest::where('request_id', $request_id)
            ->join('breakdowns', 'breakdowns.id', '=', 'breakdown_requests.breakdown_id')
            ->get();
        if ($breakdown_requests->count() == 0) {
            return $this->error('', 'Breakdown Requests doesn\'t exists', 401);
        }
        return $this->success([
            'breakdown request ' => $breakdown_requests,
        ], "Breakdown Request found successfully");
    }


    public function adminShow($request_id, $breakdown_id)
    {
        $request = Request::find($request_id);
        if (!$request) {
            return $this->error('', 'Request not found', 401);
        }
        $breakdown = Breakdown::find($breakdown_id);
        if (!$breakdown) {
            return $this->error('', 'Breakdown not found', 401);
        }
        $breakdown_request = BreakdownRequest::where('request_id', $request_id)
            ->where('breakdown_id', $breakdown_id)->first();
        if (!$breakdown_request) {
            return $this->error('', 'Breakdown Request doesn\'t exists', 401);
        }
        return $this->success([
            'breakdown request ' => $breakdown_request,
        ], "Breakdown Request found successfully");
    }


    public function adminShowBreakdowns($request_id)   //najmou nekhdmouha bel request also
    {
        $request = Request::find($request_id);
        if (!$request) {
            return $this->error('', 'Request not found', 401);
        }

        $breakdown_requests = BreakdownRequest::where('request_id', $request_id)
            ->join('breakdowns', 'breakdowns.id', '=', 'breakdown_requests.breakdown_id')
            ->get();
        if ($breakdown_requests->count() == 0) {
            return $this->error('', 'Breakdown Request doesn\'t exists', 401);
        }
        return $this->success([
            'breakdown request ' => $breakdown_requests,
        ], "Breakdown Request found successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($request_id, $breakdown_id)
    {
        $client = Auth::guard('client')->user();
        if (!$client) {
            return $this->error('', 'Client not connected', 401);
        }
        $request = Request::where('id', $request_id)->where('client_id', $client['id'])->first();
        if (!$request) {
            return $this->error('', 'Request not found', 401);
        }
        $breakdown = Breakdown::find($breakdown_id);
        if (!$breakdown) {
            return $this->error('', 'Breakdown not found', 401);
        }
        $breakdown_request = BreakdownRequest::where('request_id', $request_id)
            ->where('breakdown_id', $breakdown_id)->first();
        if (!$breakdown_request) {
            return $this->error('', 'the Breakdown Request you want to delete doesn\'t exists', 401);
        }
        $breakdown_request->delete();
        return $this->success([], "Breakdown Request deleted successfully");
    }


    public function adminDestroy($request_id, $breakdown_id)
    {
        $request = Request::find($request_id);
        if (!$request) {
            return $this->error('', 'Request not found', 401);
        }
        $breakdown = Breakdown::find($breakdown_id);
        if (!$breakdown) {
            return $this->error('', 'Breakdown not found', 401);
        }
        $breakdown_request = BreakdownRequest::where('request_id', $request_id)
            ->where('breakdown_id', $breakdown_id)->first();
        if (!$breakdown_request) {
            return $this->error('', 'the Breakdown Request you want to delete doesn\'t exists', 401);
        }
        $breakdown_request->delete();
        return $this->success([], "Breakdown Request deleted successfully");
    }
}
