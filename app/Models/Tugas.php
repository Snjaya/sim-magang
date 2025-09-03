<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    // Menentukan bahwa tidak ada kolom yang dijaga (semua bisa diisi)
    // Alternatif dari $fillable
    protected $guarded = ['id'];
}
