<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Traits\HttpResponses;

class StateController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = State::all();
        return $this->success([
            'states' => $states,
        ], 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {
        $request->validated($request->all());
        $state = State::create([
            'status' => $request->status,
        ]);
        return $this->success([
            'state' => $state,
        ], "State stored successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($state_id)
    {
        $state = State::find($state_id);
        if (!$state) {
            return $this->error('', 'the state you specified doesn\'t exist', 401);
        }
        return $this->success([
            'state' => $state,
        ], "State found successfully", 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreStateRequest $request, $state_id)
    {
        $state = State::find($state_id);
        if (!$state) {
            return $this->error('', 'the state you want to edit doesn\'t exist', 401);
        }
        $new_data = $request->validated();
        $state->update($new_data);
        return $this->success([
            'state' => $state,
        ], "State updated successfully", 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($state_id)
    {
        $state = State::find($state_id);
        if (!$state) {
            return $this->error('', 'the state you want to remove doesn\'t exist', 401);
        }
        $state->delete();
        return $this->success([], "State deleted successfully", 201);
    }
}
