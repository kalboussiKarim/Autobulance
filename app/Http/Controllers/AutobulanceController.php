<?php

namespace App\Http\Controllers;

use App\Models\Autobulance;
use App\Http\Requests\StoreAutobulanceRequest;
use App\Http\Requests\UpdateAutobulanceRequest;
use App\Traits\HttpResponses;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailController;

class AutobulanceController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $admin = Auth::guard('staff')->user();
        $autobulances = Autobulance::join('transaction_reparateurs', 'transaction_reparateurs.autobulance_id', '=', 'autobulance.id')
            ->where('transaction_reparateurs.staff_id', $admin['id'])
            ->where('transaction_reparateurs.detached_at', '=', null)->get();
        if (!$autobulances) {
            return $this->error('', 'This admin is not responsable for any autobulance', 401);
        }
        return $this->success([
            'autobulances' => $autobulances,
        ], "Autobulance found successfully", 201);
        /************** old version *********************
        $autobulances = Autobulance::all();
        return $this->success([
            'autobulances' => $autobulances,
        ], 201);
         */
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAutobulanceRequest $request)
    {

        $request->validated($request->all());
        $state = State::where('status', $request->status)->first();
        if (!$state) {
            return $this->error('', 'the status you specified doesn\'t exist', 401);
        }
        $autubulance = Autobulance::create([
            'matricule' => $request->matricule,
            'phone' => $request->phone,
            'state_id' => $state->id,
        ]);

        return $this->success([
            'autobulance' => $autubulance,
        ], "Autobulance stored successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($autobulance_id)
    {
        $autobulance = Autobulance::find($autobulance_id);
        if (!$autobulance) {
            return $this->error('', 'The autobulance you specified doesn\'t exist', 401);
        }
        return $this->success([
            'autobulance' => $autobulance,
        ], "Autobulance found successfully", 201);
    }

    public function updateStatus($autobulance_id, $status_id)
    {
        $autobulance = Autobulance::find($autobulance_id);
        if (!$autobulance) {
            return $this->error('', 'Autobulance doesn\'t exist', 401);
        }
        $state = State::find($status_id);
        if (!$state) {
            return $this->error('', 'State doesn\'t exist', 401);
        }
        $autobulance->update([
            "state_id" => $state->id,
        ]);
        return $this->success([
            'autobulance' => $autobulance,
        ], "Autobulance state updated successfully", 201);
    }


    public function findByStatus($status_id)
    {
        $state = State::where('id', $status_id)->first();
        if (!$state) {
            return $this->error('', 'the status you specified doesn\'t exist', 401);
        }
        $autobulances = Autobulance::where('state_id', $state->id)->get();
        return $this->success([
            'autobulances' => $autobulances,
        ], "Autobulances found successfully", 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpdateAutobulanceRequest $request, $autobulance_id)
    {
        $autobulance = Autobulance::find($autobulance_id);
        if (!$autobulance) {
            return $this->error('', 'the autobulance you want to edit doesn\'t exist', 401);
        }
        $new_data = $request->validated();
        $autobulance->update($new_data);
        return $this->success([
            'autobulance' => $autobulance,
        ], "Autobulance updated successfully", 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($autobulance_id)
    {
        $autobulance = Autobulance::find($autobulance_id);
        if (!$autobulance) {
            return $this->error('', 'the autobulance you want to delete doesn\'t exist', 401);
        }
        $autobulance->delete();
        return $this->success([], "Autobulance deleted successfully", 201);
    }
}
