<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission as PermissionModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (auth()->check() && !auth()->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized.');
        }

        $permission = PermissionModel::where('name', $permission)->first();
        if ($permission && $permission->status === 0) {
            abort(403, 'Unauthorized.');
        }
        
        return $next($request);
    }
}
