<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'deadline', 'created_by'];

    // Relasi ke pengguna sebagai Project Manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'project_user')->withPivot('role');
    }



    // Relasi ke tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relasi ke milestones
    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
