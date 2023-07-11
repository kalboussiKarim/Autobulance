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
        ], "All Roles");
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
    public function show($role_id)
    {
        $role = Role::find($role_id);
        if (!$role) {
            return $this->error('', 'Role not found or invlaid Role id', 401);
        }
        return $this->success([
            'role' => $role,
        ], "role found");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpdateRoleRequest $request, $role_id)
    {
        $role = Role::find($role_id);
        if (!$role) {
            return $this->error('', 'The role you want to update is not found', 401);
        }
        $new_data = $request->validated();
        $role->update($new_data);
        return $this->success([
            'role' => $role,
        ], "Role updated successfully");
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
