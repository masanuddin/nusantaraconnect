<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pekerjaan_id',
        'customer_id',
        'nama_depan',
        'nama_belakang',
        'umur',
        'nomor_telpon',
        'email',
        'cv',
        'pengalaman_kerja',
        'keterangan_tambahan',
        'video',
        'status',
        'cancel_reason',
    ];

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function anggota()
    {
        return $this->hasMany(AnggotaLamaran::class);
    }
}
