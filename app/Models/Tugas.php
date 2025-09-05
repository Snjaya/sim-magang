<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tugas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi Many-to-Many ke User (sebagai Peserta).
     */
    public function pesertas(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tugas_user', 'tugas_id', 'user_id');
    }

    /**
     * Relasi One-to-Many (Inverse) ke User (sebagai Pembimbing).
     * SATU TUGAS DIMILIKI OLEH SATU PEMBIMBING.
     */
    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }
}
