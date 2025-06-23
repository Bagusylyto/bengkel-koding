<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_daftar_poli',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
    ];

    /**
     * Relasi ke User sebagai pasien
     */
    // public function pasien()
    // {
    //     return $this->belongsTo(User::class, 'id_pasien');
    // }

    /**
     * Relasi ke User sebagai dokter
     */
    // public function dokter()
    // {
    //     return $this->belongsTo(User::class, 'id_dokter');
    // }

     /**
     * Relasi One to Many dengan DetailPeriksa
     * Satu Periksa bisa memiliki banyak DetailPeriksa
     */

    public function daftarPoli() {
        return $this->belongsTo(DaftarPoli::class, 'id_daftar_poli');
    }

    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }
}