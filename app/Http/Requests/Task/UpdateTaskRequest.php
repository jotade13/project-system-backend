<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task_route = $this->route('project'); // e.g. 42
        $task = Task::findOrFail($task_route->id);
        $user = auth()->user();

        return $user->role == 'ADMIN' ||$user->role == 'SUPERVISOR'||($task->assigned_to == $user->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'title' => 'string',
           'description' => 'string',
           'project_id' => 'exists:projects,id',
           'assigned_to_id' => 'exists:users,id',
           'status' => 'string|in:PENDING,IN_PROGRESS,COMPLETED',
           'priority' => 'string|in:LOW,MEDIUM,HIGH'
        ];
    }
}
