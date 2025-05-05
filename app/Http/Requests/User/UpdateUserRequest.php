<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
           'email' => 'required|string:',
           'first_name' => 'required|string',
           'last_name' => 'required|string',
           'role' => 'required|string',
           'password' => '',
        ];
    }
    // Eliminar el campo "password" si está vacío antes de validar
    protected function prepareForValidation()
    {
        if ($this->filled('password')) {
            // Si tiene valor, lo trimea para eliminar espacios innecesarios
            $this->merge(['password' => trim($this->password)]);
        } else {
            // Si está vacío (null, "" o solo espacios), lo elimina completamente
            $this->offsetUnset('password');
        }
    }
}
