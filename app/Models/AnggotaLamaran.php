<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaLamaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'lamaran_id',
        'nama_depan',
        'nama_belakang',
        'umur',
        'nomor_telpon',
        'email',
        'cv',
    ];

    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class);
    }
}
