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
}
