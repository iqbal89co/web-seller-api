<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::with('activeRole.permissions', 'roles')->find($request->user()->id);
        return response()->json([
            'message' => 'data successfully retrieved',
            'data' => $user
        ]);
    }

    public function switchRole(Request $request)
    {
        $user = $request->user();
        $roles = $user->roles->pluck('id')->toArray();
        if (!in_array($request->role_id, $roles)) {
            return response()->json([
                'error' => 'Role not found'
            ], 404);
        }
        $user->active_role_id = $request->role_id;
        $user->save();

        return response()->json([
            'message' => 'Role successfully switched',
            'data' => $user
        ]);
    }
}
