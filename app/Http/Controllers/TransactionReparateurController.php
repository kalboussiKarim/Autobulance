<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\TransactionReparateur;
use App\Http\Requests\StoreTransactionReparateurRequest;
use App\Http\Requests\UpdateTransactionReparateurRequest;
use App\Models\Autobulance;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionReparateurController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function technicianAffect($staff_id, $autobulance_id)
    {
        $staff = Staff::find($staff_id);
        if (!$staff) {
            return $this->error('', 'the staff memeber you specified doesn\'t exist', 401);
        }
        $role = $staff->role;
        if ($role['name'] !== "technician") {
            return $this->error('', 'the technician you specified doesn\'t exist', 401);
        }
        $admin = Auth::guard('staff')->user();
        /** to see if the admin is responsible for that autobulance */
        $transaction_admin = TransactionReparateur::where('staff_id', $admin['id'])
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if (!$transaction_admin) {
            return $this->error('', 'the autobulance you specified doesn\'t exist', 401);
        }
        $transaction_staff_already = TransactionReparateur::where('staff_id', $staff_id)
            //->where('autobulance_id', $autobulance_id)    cuz only at one autobulance
            ->where('detached_at', null)
            ->first();
        if ($transaction_staff_already) {
            return $this->error('', 'This member is already affected to an autobulance', 401);
        }
        $transaction_staff = TransactionReparateur::create([
            'autobulance_id' => $autobulance_id,
            'staff_id' => $staff_id,
            'affected_at' => Carbon::now(),
        ]);
        return $this->success([
            'transaction_staff_affect' => $transaction_staff,
        ], "staff affected successfully", 201);
    }

    /***************************************************************************************************************************/

    public function managerAffect($staff_id, $autobulance_id)
    {
        $staff = Staff::find($staff_id);
        if (!$staff) {
            return $this->error('', 'the staff memeber you specified doesn\'t exist', 401);
        }
        $role = $staff->role;
        if ($role['name'] !== "manager") {
            return $this->error('', 'the manager you specified doesn\'t exist', 401);
        }
        $admin = Auth::guard('staff')->user();
        /** to see if the admin is responsible for that autobulance */
        $transaction_admin = TransactionReparateur::where('staff_id', $admin['id'])
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if (!$transaction_admin) {
            return $this->error('', 'the autobulance you specified doesn\'t exist', 401);
        }
        $transaction_manager_already = TransactionReparateur::where('staff_id', $staff_id)
            //->where('autobulance_id', $autobulance_id)  //  cuz only at one autobulance
            ->where('detached_at', null)
            ->first();
        if ($transaction_manager_already) {
            return $this->error('', 'This member is already affected to an autobulance', 401);
        }
        $managers_count = TransactionReparateur::join('staff', 'transaction_reparateurs.staff_id', '=', 'staff.id')
            ->join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'manager')
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if ($managers_count) {
            return $this->error('', 'This autobulance has already a manager', 401);
        }
        $transaction_staff = TransactionReparateur::create([
            'autobulance_id' => $autobulance_id,
            'staff_id' => $staff_id,
            'affected_at' => Carbon::now(),
        ]);
        return $this->success([
            'transaction_staff_affect' => $transaction_staff,
        ], "staff affected successfully", 201);
    }

    /***************************************************************************************************************************/



    public function technicianDetach($staff_id, $autobulance_id)
    {
        $staff = Staff::find($staff_id);
        if (!$staff) {
            return $this->error('', 'the staff memeber you specified doesn\'t exist', 401);
        }
        $role = $staff->role;
        if ($role['name'] !== "technician") {
            return $this->error('', 'the technician you specified doesn\'t exist', 401);
        }
        $admin = Auth::guard('staff')->user();
        /** to see if the admin is responsible for that autobulance */
        $transaction_admin = TransactionReparateur::where('staff_id', $admin['id'])
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if (!$transaction_admin) {
            return $this->error('', 'the autobulance you specified doesn\'t exist', 401);
        }
        $transaction_staff_exists = TransactionReparateur::where('staff_id', $staff_id)
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if (!$transaction_staff_exists) {
            return $this->error('', 'This technician is not affected to that autobulance, you can\'t detach it', 401);
        }
        $transaction_staff_exists->update([
            'detached_at' => Carbon::now(),
        ]);
        return $this->success([
            'transaction_staff-detach' => $transaction_staff_exists,
        ], "staff detached successfully", 201);
    }

    /***************************************************************************************************************************/

    public function managerDetach($staff_id, $autobulance_id)
    {
        $staff = Staff::find($staff_id);
        if (!$staff) {
            return $this->error('', 'The staff memeber you specified doesn\'t exist', 401);
        }
        $role = $staff->role;
        if ($role['name'] !== "manager") {
            return $this->error('', 'The manager you specified doesn\'t exist', 401);
        }
        $admin = Auth::guard('staff')->user();
        /** to see if the admin is responsible for that autobulance */
        $transaction_admin = TransactionReparateur::where('staff_id', $admin['id'])
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if (!$transaction_admin) {
            return $this->error('', 'The autobulance you specified doesn\'t exist', 401);
        }
        $transaction_staff_exists = TransactionReparateur::where('staff_id', $staff_id)
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if (!$transaction_staff_exists) {
            return $this->error('', 'This manager is not affected to that autobulance, you can\'t detach it', 401);
        }
        $transaction_staff_exists->update([
            'detached_at' => Carbon::now(),
        ]);
        return $this->success([
            'transaction_staff-detach' => $transaction_staff_exists,
        ], "staff detached successfully", 201);
    }

    /***************************************************************************************************************************/

    public function adminAffect($autobulance_id)
    {
        $autobulance = Autobulance::find($autobulance_id);
        if (!$autobulance) {
            return $this->error('', 'The autobulance you specified deoesn\'t exist', 401);
        }
        $admin = Auth::guard('staff')->user();
        $transaction_already = TransactionReparateur::where('staff_id', $admin['id'])
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if ($transaction_already) {
            return $this->error('', 'This autobulance is already affected to this admin', 401);
        }
        $already_administrated = TransactionReparateur::join('staff', 'transaction_reparateurs.staff_id', '=', 'staff.id')
            ->join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'admin')
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if ($already_administrated) {
            return $this->error('', 'The autobulance you specified is already administrated by another admin', 401);
        }
        $transaction = TransactionReparateur::create([
            'staff_id' => $admin['id'],
            'autobulance_id' => $autobulance_id,
            'affected_at' => Carbon::now(),
        ]);
        return $this->success([
            'transaction_admin_affect' => $transaction,
        ], "admin affected successfully", 201);
    }

    /***************************************************************************************************************************/
    /***************************************************************************************************************************/

    public function adminDetach($autobulance_id)
    {
        $autobulance = Autobulance::find($autobulance_id);
        if (!$autobulance) {
            return $this->error('', 'The autobulance you specified deoesn\'t exist', 401);
        }
        $admin = Auth::guard('staff')->user();
        $transaction_already = TransactionReparateur::where('staff_id', $admin->id)
            ->where('autobulance_id', $autobulance_id)
            ->where('detached_at', null)
            ->first();
        if (!$transaction_already) {
            return $this->error('', 'This autobulance is not affected to t  his admin, you can\'t detach it', 401);
        }
        $transaction_already->update([
            'detached_at' => Carbon::now(),
        ]);
        return $this->success([
            'transaction_staff-detach' => $transaction_already,
        ], "staff detached successfully", 201);
    }
}
