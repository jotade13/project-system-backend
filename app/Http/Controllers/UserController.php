<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
            $tasks = User::all();
            return response()->json([
                'success' => true,
                'message' => 'Users found successfully.',
                'data'    => $tasks,
            ], 200);

    }
}
