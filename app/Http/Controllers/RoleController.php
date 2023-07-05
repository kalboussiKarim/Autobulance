<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Traits\HttpResponses;

class RoleController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return $this->success([
            'Roles' => $roles,
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
    public function store(StoreRoleRequest $request)
    {
        $request->validated($request->all());
        $role = Role::create([
            'name' => $request->name,
        ]);
        return $this->success([
            'Role' => $role,
        ], "Role stored successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($role_name)
    {
        $role = Role::where('name', $role_name)->first();
        if (!$role) {
            return $this->error('', 'The role you want to delete doesn\'t exists', 401);
        }
        $role->delete();
        return $this->success([], "Role deleted successfully");
    }
}
