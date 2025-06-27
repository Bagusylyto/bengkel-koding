<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // Nama tabel di database (opsional, jika tidak sama dengan plural model)
    protected $table = 'obat';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    /**
     * Relasi One to Many dengan tabel detail_periksas
     * Satu obat bisa terdapat di banyak detail_periksas
     */
    public function detailPeriksa()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_obat');
    }

    public function periksa()
    {
        return $this->belongsToMany(Periksa::class, 'detail_periksa', 'obat_id', 'periksa_id')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }
}