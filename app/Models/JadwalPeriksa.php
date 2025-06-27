<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPeriksa extends Model
{
    use HasFactory;

    protected $table = 'jadwal_periksa';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // protected $casts = [
    //     'jam_mulai' => 'datetime:H:i',
    //     'jam_selesai' => 'datetime:H:i',
    //     'status' => 'boolean',
    // ];

    public function dokter() {
        return $this->belongsTo(User::class, 'id_dokter')->where('role','dokter');
    }

    public function daftarPoli() {
        return $this->hasMany(DaftarPoli::class, 'id_jadwal');
    }

    // public function getJamAttribute()
    // {
    //     return $this->jam_mulai->format('H:i') . ' - ' . $this->jam_selesai->format('H:i');
    // }
}
