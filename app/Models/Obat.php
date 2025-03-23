<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // Nama tabel di database (opsional, jika tidak sama dengan plural model)
    protected $table = 'obats';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
    ];

    /**
     * Relasi One to Many dengan tabel detail_periksas
     * Satu obat bisa terdapat di banyak detail_periksas
     */
    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_obat');
    }
}