<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Traits\HttpResponses;

class ServiceController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return $this->success([
            'services' => $services,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $request->validated($request->all());
        $service = Service::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        return $this->success([
            'service' => $service,
        ], "Service stored successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($service_id)
    {
        $service = Service::find($service_id);
        if (!$service) {
            return $this->error('', 'the service you specified doesn\'t exist', 401);
        }
        return $this->success([
            'service' => $service,
        ], "Service found successfully", 201);
    }



    /**
     * Update the specified resource in storage.
     */
    public function edit(UpdateServiceRequest $request, $service_id)
    {
        $service = Service::find($service_id);
        if (!$service) {
            return $this->error('', 'the service you want to modify doesn\'t exist', 401);
        }
        $new_data = $request->validated();
        $service->update($new_data);
        return $this->success([
            'service' => $service,
        ], "Service updated successfully", 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($service_id)
    {
        $service = Service::find($service_id);
        if (!$service) {
            return $this->error('', 'the service you want to delete doesn\'t exist', 401);
        }
        $service->delete();
        return $this->success([], "Service deleted successfully", 201);
    }
}
