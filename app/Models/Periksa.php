<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    use HasFactory;

    protected $table = 'periksa';

    protected $fillable = [
        'id_daftar_poli',
        'id_dokter',
        'id_pasien',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
    ];

    protected $casts = [
        'tgl_periksa' => 'datetime',
        'biaya_periksa' => 'decimal:2',
    ];

    /**
     * Relasi ke User sebagai pasien
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien')->where('role','pasien');
    }

    /**
     * Relasi ke User sebagai dokter
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter')->where('role','dokter');
    }

     /**
     * Relasi One to Many dengan DetailPeriksa
     * Satu Periksa bisa memiliki banyak DetailPeriksa
     */

    public function daftarPoli() 
    {
        return $this->belongsTo(DaftarPoli::class, 'id_daftar_poli');
    }

    public function detailPeriksa()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    public function obat()
    {
        return $this->belongsToMany(Obat::class, 'detail_periksa', 'id_periksa', 'id_obat')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }

    // // Calculate total biaya including obat
    public function getTotalBiayaAttribute()
    {
        $biayaObat = $this->detailPeriksa->sum(function ($detail) {
            return $detail->obat->harga * $detail->jumlah;
        });

        return $this->biaya_periksa + $biayaObat;
    }
}