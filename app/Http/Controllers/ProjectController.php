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

        $task = $user->ownedProjects()->create($request->validated());
        return response()->json([
            'res' => true,
            'msg' => 'Project created successfully',
            'data' => $task
        ],200);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
           $project->update($request->all());
            return response()->json([
                'res' => true,
                'msg' => 'Project updated successfully',
            ],200);
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
