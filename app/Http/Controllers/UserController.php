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
                'new_users_today' => User::whereDate('created_at', today())->count(),
                'active_users' => User::where('last_login_at', '>=', now()->subDays(30))->count()
            ]);
        }
    }
}
