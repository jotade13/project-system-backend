<?php

namespace App\Http\Requests\Project;

use App\Models\Project;



use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $projectId = $this->route('project'); // e.g. 42
        $project = Project::findOrFail($projectId->id);
        $user = auth()->user();

        return $user->role == 'ADMIN' ||($user->role == 'SUPERVISOR' && $project->owner_id == $user->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'string|in:IN_PROGRESS,COMPLETED,CANCELLED',
            'users' => 'array',
            'users.*.value' => 'required|exists:users,id'
        ];
    }
}
