<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peserta extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim_nisn',
        'jurusan',
        'institusi_asal',
        'status', // Pastikan ini ada
        'no_hp',
        'personal_email',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];
    /**
     * Mendefinisikan bahwa satu profil Peserta dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
