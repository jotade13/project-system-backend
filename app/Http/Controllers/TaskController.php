<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(CreateTaskRequest $request)
    {
        $user = auth()->user();
        $task = Task::create($request->validated());
        return response()->json([
            'res' => true,
            'msg' => 'Task created successfully',
            'data' => $task
        ],200);
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
