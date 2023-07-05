<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Traits\HttpResponses;

class EquipmentController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eqiupments = Equipment::all();
        return $this->success([
            'eqiupments' => $eqiupments,
        ],);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request)
    {
        $request->validated($request->all());
        $equipment = Equipment::create([
            "name" => $request->name,
            "stock" => $request->stock,
        ]);
        return $this->success([
            'equipment' => $equipment,
        ], "Equipmnet stored successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($equipment_id)
    {
        $equipment = Equipment::find($equipment_id);
        if (!$equipment) {
            return $this->error('', 'the equipment you want to see is not found', 401);
        }
        return $this->success([
            'equipment' => $equipment,
        ], "Equipment found successfully");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpdateEquipmentRequest $request, $equipment_id)
    {
        $equipment = Equipment::find($equipment_id);
        if (!$equipment) {
            return $this->error('', 'the equipment you want to edit is not found', 401);
        }
        $new_data = $request->validated(/*$request->all()*/);
        $equipment->update($new_data);
        return $this->success([
            'equipment' => $equipment,
        ], "Equipment modified successfully");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($equipment_id)
    {
        $equipment = Equipment::find($equipment_id);
        if (!$equipment) {
            return $this->error('', 'the equipment you want to delete is not found', 401);
        }
        $equipment->delete();
        return $this->success([], "Equipment deleted successfully");
    }
}
