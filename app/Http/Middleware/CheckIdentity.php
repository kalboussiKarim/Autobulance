<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HttpResponses;
use App\Models\Role;

class CheckIdentity
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff) {
            return $this->error('', 'Unauthorized user to do the action', 400);
        }
        $role = Role::where('id', $staff->role_id)->first();
        if (($role) && (in_array($role['name'], $roles))) {
            return $next($request);
        } else {
            return $this->error('', 'Unauthorized user to do the action', 401);
        }
    }
}
