<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado',
                ], 401);
            }
    
            if($user)
            {
                $tasks = User::all();
                return response()->json([
                    'success' => true,
                    'message' => 'Users found successfully.',
                    'data'    => $tasks,
                ], 200);
            }
    }
    public function update(Request $request, User $user)
    {
        $user = auth()->user();
            if($user->update($request->all())||$user->role=='ADMIN')
            {
                $user->update($request->all());
                return response()->json([
                    'res' => true,
                    'msg' => 'user updated successfully',
                ],200);
            }
    }

    public function destroy(User $user)
    {
        $user = auth()->user();

        if($user->role=='ADMIN')
        {
            $user->delete();
            return response()->json([
                'res' => true,
                'msg' => 'Task deleted successfully'
            ],200);
        }
        return response()->json([
            'res' => false,
            'msg' => 'User cannot delete the task '
        ], 403);  
    }

    public function userMetrics()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        if($user)
        {
            return response()->json([
                'total_users' => User::count(),
            //   'new_users_today' => User::whereDate('created_at', today())->count(),
            ]);
        }
    }
}
