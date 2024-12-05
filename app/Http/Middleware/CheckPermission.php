<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = User::with('activeRole.permissions')->find($request->user()->id);
        $userPermissions = $user->activeRole->permissions->pluck('name')->toArray();

        if (!in_array($permission, $userPermissions)) {
            return response()->json([
                'error' => 'You do not have permission to access this resource'
            ], 403);
        }

        return $next($request);
    }
}
