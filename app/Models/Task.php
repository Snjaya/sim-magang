<?php

namespace App\Models;

use Illuminate-Database-Eloquent-Factories-HasFactory;
use Illuminate-Database-Eloquent-Model;
use Illuminate-Database-Eloquent-Relations-BelongsTo;
use Illuminate-Database-Eloquent-Relations-BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi ke User (sebagai Peserta).
     * Pastikan nama method ini adalah 'users'.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    /**
     * Relasi ke User (sebagai Pembimbing).
     */
    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }
}