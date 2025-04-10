<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'assigned_to_id',
        'status',
        'priority'
    ];

    // Relación con el proyecto
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relación con el usuario asignado
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
