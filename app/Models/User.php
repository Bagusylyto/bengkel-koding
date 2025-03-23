<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi One to Many dengan tabel periksas sebagai pasien.
     */
    public function periksasSebagaiPasien()
    {
        return $this->hasMany(Periksa::class, 'id_pasien');
    }

    /**
     * Relasi One to Many dengan tabel periksas sebagai dokter.
     */
    public function periksasSebagaiDokter()
    {
        return $this->hasMany(Periksa::class, 'id_dokter');
    }
}