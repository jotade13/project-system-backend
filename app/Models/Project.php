<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'status'
    ];

    // Relación con el propietario
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relación con usuarios asignados (muchos a muchos)
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    // Relación con tareas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
