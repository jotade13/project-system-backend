<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $project = Project::with('assignedUsers:id,first_name')->get();
        return response()->json([
            'success' => true,
            'message' => 'Project found successfully.',
            'data'    => $project,
        ], 200);
    }
    public function store(CreateProjectRequest $request)
    {
        $user = auth()->user();
        try {
            DB::beginTransaction();

            $project = $user->ownedProjects()->create($request->validated());

            $userIds = collect($request['users'])->pluck('value')->toArray();

            $project->assignedUsers()->sync($userIds);

            DB::commit();

            return response()->json([
                'message' => 'Proyecto creado exitosamente',
                'project' => $project,
                'users' => $project->users
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al crear el proyecto',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            DB::beginTransaction();

            $project->update($request->validated());

            $userIds = collect($request['assigned_users'])->pluck('value')->toArray();

            $project->assignedUsers()->sync($userIds);

            DB::commit();

            return response()->json([
                'message' => 'Proyecto creado exitosamente',
                'project' => $project,
                'users' => $project->users
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al crear el proyecto',
                'message' => $e->getMessage()
            ], 500);
        }
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
