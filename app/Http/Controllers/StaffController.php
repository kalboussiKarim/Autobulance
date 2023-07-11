<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Http\Requests\LoginStaffRequest;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Role;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;
use App\Http\Controllers\MailController;

class StaffController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function login(LoginStaffRequest $request)
    {
        //return response()->json('Login function');
        $request->validated($request->only(['email', 'password']));
        $staff = Staff::where('email', $request->email)->first();
        if (!$staff || !Hash::check($request->password, $staff->password)) {
            return $this->error('', 'Credentials do not match', 401);
        }
        return $this->success([
            'staff' => $staff,
            'token' => $staff->createToken('staff-token')->plainTextToken,
        ], "Staff memeber logged in successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(StoreStaffRequest $request)
    {
        // return response()->json('Register functiton');
        $request->validated($request->all());
        $role = Role::where('name', $request->role)->first();
        if (!$role) {
            return $this->error('', 'the role you specified doesn\'t exist', 401);
        }
        $staff_member = Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'salary' => $request->salary,
            'role_id' => $role['id'],
            'position' => $request->position,
            'password' => Hash::make($request->password),
        ]);
        //$mailer =  new MailController();
        //$mailer->index($request);
        return $this->success([
            'staff_member' => $staff_member,
            'token' => $staff_member->createToken('staff-token')->plainTextToken,
        ], "Staff registration was successful", 201);
    }


    public function logout()
    {
        $staff = Auth::guard('staff')->user();
        if ($staff) {
            $staff->tokens()->where('name', 'staff-token')->delete();
            return $this->success([
                'message' => 'You have succesfully been logged out as a staff and your token(s) has been removed'
            ]);
        } else {
            return $this->error('', 'The staff member is not logged in', 401);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($staff_id)
    {
        $staff = Staff::find($staff_id);
        if (!$staff) {
            return $this->error('', 'Staff not found or invlaid staff id', 401);
        }
        return $this->success([
            'staff' => $staff,
        ], "Staff found");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpdateStaffRequest $request, $staff_id)
    {
        $staff = Staff::find($staff_id);
        if (!$staff) {
            return $this->error('', 'The staff you want to edit is not found', 401);
        }
        $role = Role::where('name', $request->role)->first();
        if (!$role) {
            return $this->error('', 'the role you specified doesn\'t exist', 401);
        }
        $staff->role_id = $role['id'];
        $staff->save();
        $new_data = $request->validated();
        $staff->update($new_data);
        return $this->success([
            'staff' => $staff,
        ], "Staff updated successfully");
    }



    public function showProfile($staff_id)
    {
        if (Auth::guard('staff')->user()->id !== (int)$staff_id) {
            return $this->error('', 'You are unauthorized to make this request', 401);
        }
        $staff = Auth::guard('staff')->user();
        if (!$staff) {
            return $this->error('', 'staff not found', 401);
        }
        return $this->success([
            'staff' => $staff,
        ], "Staff profile found");
    }

    public function getAutobulances()
    {
        $staff = Auth::guard('staff')->user();
        return $staff->autobulances;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
