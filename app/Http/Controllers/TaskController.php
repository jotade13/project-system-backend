<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if($user->role=='USER')
        {
            $tasks = Task::where('Assigned_to_id', $user->id);
            return response()->json([
                'success' => true,
                'message' => 'Tasks found successfully.',
                'data'    => $tasks,
            ], 200);
        }else
        {
            $tasks = Task::all();
            return response()->json([
                'success' => true,
                'message' => 'tasks found successfully.',
                'data'    => $tasks,
            ], 200);
        }
    }
    public function store(CreateTaskRequest $request)
    {
        $user = auth()->user();

        if($user->role=='ADMIN'||$user->role=='SUPERVISOR'){
            $task = Task::create($request->validated());
            return response()->json([
                'res' => true,
                'msg' => 'Project created successfully',
                'data' => $task
            ],200);
        }

        return response()->json([
            'res' => false,
            'msg' => 'user cannot create the project '
        ], 403); 
        
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
           $task->update($request->all());
            return response()->json([
                'res' => true,
                'msg' => 'Task updated successfully',
            ],200);
    }

    public function destroy(Task $task)
    {
        $user = auth()->user();

        if($user->role=='ADMIN')
        {
            $task->delete();
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
    public function show($id)
    {
        $user = auth()->user();

        $task = Task::find($id);

        if (!$task||!$user) {
            return response()->json([
                'res' => false,
                'msg' => 'Task not found'
            ], 404); 
        }
        if($user)
        {
            return response()->json([
                'res' => true,
                'msg' => 'Task founded successfully',
                'data' => $task
            ],200);
        }
    }

    public function taskMetrics()
    {
       $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        $userId = $user->id;
        
        $metrics = Task::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'data' => $metrics,
            'message' => 'Métricas de tareas obtenidas exitosamente',
        ]);
    }
}
