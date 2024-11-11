<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'due_date', 'status', 'project_id', 'assigned_to'];

    // Relasi ke project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi ke pengguna yang ditugaskan
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
