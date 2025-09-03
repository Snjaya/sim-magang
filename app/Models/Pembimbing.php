<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembimbing extends Model
{
    use HasFactory;

    // Menentukan bahwa tidak ada kolom yang dijaga (semua bisa diisi)
    // Alternatif dari $fillable
    protected $guarded = ['id'];

    /**
     * Mendefinisikan bahwa satu profil Pembimbing dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
