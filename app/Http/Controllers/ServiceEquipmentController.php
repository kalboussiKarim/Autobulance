<?php

namespace App\Http\Controllers;

use App\Models\ServiceEquipment;
use App\Http\Requests\StoreServiceEquipmentRequest;
use App\Http\Requests\UpdateServiceEquipmentRequest;
use App\Models\Equipment;
use App\Models\Service;
use App\Models\Task;
use App\Traits\HttpResponses;

class ServiceEquipmentController extends Controller
{
    use HttpResponses;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceEquipmentRequest $request)
    {
        $request->validated($request->all());
        $task = Task::where('id', $request->task_id)->first();
        if (!$task) {
            return $this->error('', 'The task you specified doesn\'t exist', 401);
        }
        $service = Service::where('id', $request->service_id)->first();
        if (!$service) {
            return $this->error('', 'The service you specified doesn\'t exist', 401);
        }
        $equipment = Equipment::where('id', $request->equipment_id)->first();
        if (!$equipment) {
            return $this->error('', 'The equipment you specified doesn\'t exist', 401);
        }
        // $service_equipment = ServiceEquipment::where('task_id', $request->task_id)
        //     ->where('service_id', $request->service_id)
        //     ->where('equipment_id', $request->equipment_id)
        //     ->first();
        // if ($service_equipment) {
        //     return $this->error('', 'The equipment service already exists', 401);
        // }
        $new_service_equipment = ServiceEquipment::create([
            'task_id' => $request->task_id,
            'service_id' => $request->service_id,
            'equipment_id' => $request->equipment_id,
            'quantity' => $request->quantity,
        ]);
        return $this->success([
            'new_service_equipment' => $new_service_equipment,
        ], "new service_equipment added successfully", 201);
    }
}
