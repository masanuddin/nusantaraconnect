<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'nama',
        'lokasi',
        'range_harga',
        'deskripsi',
        'mulai_kerja',
        'selesai_kerja',
        'thumbnail'
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
