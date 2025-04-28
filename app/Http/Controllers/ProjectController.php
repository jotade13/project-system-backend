<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
    public function index()
    {
        $project = Project::all();
        return response()->json([
            'success' => true,
            'message' => 'Project found successfully.',
            'data'    => $project,
        ], 200);
    }
    public function store(CreateProjectRequest $request)
    {
        $user = auth()->user();

        $project = $user->ownedProjects()->create($request->validated());
        return response()->json([
            'res' => true,
            'msg' => 'Project created successfully',
            'data' => $project
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
    public function show($id)
    {
        $user = auth()->user();

        $project = Project::find($id);

        if (!$project||!$user) {
            return response()->json([
                'res' => false,
                'msg' => 'Project not found'
            ], 404); 
        }
        if($user)
        {
            return response()->json([
                'res' => true,
                'msg' => 'Project founded successfully',
                'data' => $project
            ],200);
        }
    }


    public function projectMetrics()
    {
        $user =auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        
        $metrics = Project::count();

        return response()->json([
            'success' => true,
            'data' => $metrics,
            'message' => 'Métricas de tareas obtenidas exitosamente',
        ]);
    }

}
