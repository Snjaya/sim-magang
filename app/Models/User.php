<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Tugas;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mendefinisikan bahwa satu User bisa memiliki satu profil Pembimbing.
     */
    public function pembimbing(): HasOne
    {
        return $this->hasOne(Pembimbing::class, 'user_id');
    }

    /**
     * Mendefinisikan bahwa satu User bisa memiliki satu profil Peserta.
     */
    public function peserta(): HasOne
    {
        return $this->hasOne(Peserta::class, 'user_id');
    }

    public function tugas(): BelongsToMany
    {
        return $this->belongsToMany(Tugas::class, 'tugas_user', 'user_id', 'tugas_id');
    }
}
