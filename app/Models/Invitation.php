<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'user_id', 'status'];

    // Relasi ke project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi ke pengguna yang diundang
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk mengambil undangan dengan status 'pending'
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
