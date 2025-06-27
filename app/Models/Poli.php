<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'poli';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama_poli',
        'keterangan',
    ];

    public function dokter()
    {
        return $this->hasMany(User::class, 'id_poli')->where('role','dokter');
    }
}
