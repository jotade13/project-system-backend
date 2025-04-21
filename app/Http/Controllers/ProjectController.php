<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\CreateProjectRequest;
use App\Models\User;

class ProjectController extends Controller
{
    public function store(CreateProjectRequest $request)
    {
        $user = auth()->user();

        if (!$user) 
        {
            return response()->json([
                'res' => false,
                'msg' => 'Unauthenticated user'
            ], 401); 
        }

        $project = $user->ownedProjects()->create($request->validated());
        return response()->json([
            'res' => true,
            'msg' => 'Project created successfully',
            'data' => $project
        ],200);
    }
}
