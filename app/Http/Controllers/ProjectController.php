<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\odels\User;

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
        if($user->role=='ADMIN'||$user->role=='SUPERVISOR'){
            $project = $user->ownedProjects()->create($request->validated());
            return response()->json([
                'res' => true,
                'msg' => 'Project created successfully',
                'data' => $project
            ],200);
        }

        return response()->json([
            'res' => false,
            'msg' => 'user cannot create the project '
        ], 403); 
        
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        if($user->role=='ADMIN'||$user->role=='SUPERVISOR')
        {
            $project_update = $project->update($request->all());
            return response()->json([
                'res' => true,
                'msg' => 'Project updated successfully',
                'data' => $project_update
            ],200);
        }
        return response()->json([
            'res' => false,
            'msg' => 'user cannot updated the project '
        ], 403);  
        
    }

    public function destroy(Project $project)
    {
        $user = auth()->user();

        if($user->role=='ADMIN')
        {
            $project->delete();
            return response()->json([
                'res' => true,
                'msg' => 'Project deleted successfully'
            ],200);
        }
        return response()->json([
            'res' => false,
            'msg' => 'user cannot delete the project '
        ], 403);  
    }

}
