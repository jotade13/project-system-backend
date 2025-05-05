<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user->role=='ADMIN'||$user->role=='SUPERVISOR';
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
            'owner_id' => 'exists:users,id',
            'status' => 'string|in:IN_PROGRESS,COMPLETED,CANCELLED',
            'users' => 'required|array',
            'users.*.value' => 'required|exists:users,id'
        ];
    }
}
