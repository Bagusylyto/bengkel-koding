<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeriksa extends Model
{
    use HasFactory;

    // Nama tabel di database (opsional jika tidak sesuai konvensi plural model)
    protected $table = 'detail_periksas';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'id_periksa',
        'id_obat',
    ];

    /**
     * Relasi Many to One ke model Periksa
     * Banyak detail_periksas bisa dimiliki satu periksa
     */
    public function periksa()
    {
        return $this->belongsTo(Periksa::class, 'id_periksa');
    }

    /**
     * Relasi Many to One ke model Obat
     * Banyak detail_periksas bisa memiliki satu obat
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}