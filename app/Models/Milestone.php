<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'deadline', 'progress', 'project_id'];

    // Relasi ke project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
