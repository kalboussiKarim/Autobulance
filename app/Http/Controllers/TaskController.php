<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Autobulance;
use App\Models\Request;
use App\Models\Service;
use App\Models\ServiceEquipment;
use App\Models\TransactionReparateur;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::guard('staff')->user();
        $autobulances = TransactionReparateur::where('staff_id', $admin['id'])
            ->where('detached_at', null)
            ->get();
        if ($autobulances->count() == 0) {
            return $this->error('', 'this admin is not responisble for any autobulance', 401);
        }
        $tasks = collect();
        foreach ($autobulances as $auto) {
            $auto_task = Task::where('autobulance_id', $auto->id)->get();
            $tasks = $tasks->merge($auto_task);
        }
        if ($tasks->count() == 0) {
            return $this->error('', 'there are no tasks for your autobulances', 401);
        }
        return $this->success([
            'tasks' => $tasks,
        ], "tasks found successfully", 201);
    }


    public function totalPrice($task_id)
    {


        $task = Task::where('id', $task_id);
        if (!$task) {
            return $this->error('', 'task not found', 401);
        }
        $admin = Auth::guard('staff')->user();
        $admin_responsible_or_not = TransactionReparateur::where('staff_id', $admin['id'])
            ->where('autobulance_id', $task->autobulance_id)
            ->where('detached_at', null)
            ->first();
        if (!$admin_responsible_or_not) {
            return $this->error('', 'task not found', 401);
        }
        $services = ServiceEquipment::where('task_id', $task_id)
            ->get();
        $total = 0;
        foreach ($services as $serv) {
            $price = Service::where('id', $serv->id)->get('price');
            $total += $price;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());
        $admin = Auth::guard('staff')->user();
        
        // $transaction_admin = TransactionReparateur::where('staff_id', $admin['id'])
        //     ->where('autobulance_id', $request->autobulance_id)
        //     ->where('detached_at', null)
        //     ->first();
        // if (!$transaction_admin) {
        //     return $this->error('', 'the autobulance you specified doesn\'t exist', 401);
        // }
        $client_request = Request::where('id', $request->request_id)->first();
        if (!$client_request) {
            return $this->error('', "client request not found", 401);
        }
        $autobulance = Autobulance::where('id', $request->autobulance_id)->first();
        if (!$autobulance) {
            return $this->error('', "autobulance not found", 401);
        }
        $task_already = Task::where('autobulance_id', $request->autobulance_id)
            ->where('request_id', $request->request_id)
            ->first();
        if ($task_already) {
            return $this->error('', "task already exists", 401);
        }
        $task = Task::create([
            'autobulance_id' => $request->autobulance_id,
            'request_id' => $request->request_id,
            'state' => $request->state,
        ]);
        return $this->success([
            'task' => $task,
        ], "task created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
