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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
            'client' => $staff,
            'token' => $staff->createToken('staff-token')->plainTextToken,
        ], "Client logged in successfully");
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
        /*$staff = Staff::where('email',$request->email)->first();
        if($staff){
            return $this->error('', 'Staff already exists', 401);
        }*/
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
        $mailer =  new MailController();
        $mailer->index($request);
        return $this->success([
            'staff_member' => $staff_member,
            'token' => $staff_member->createToken('staff-token')->plainTextToken,
        ], "Staff registration was successful", 201);
    }


    public function logout()
    {
        //return response()->json('Logout function');
        $staff = Auth::guard('staff')->user();
        if ($staff) {
            $staff->tokens()->where('name', 'staff-token')->delete();
            return $this->success([
                'message' => 'You have succesfully been logged out as a staff and your token(s) has been removed'
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
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
