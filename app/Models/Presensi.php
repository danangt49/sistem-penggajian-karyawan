<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $primaryKey = 'kd_presensi';
    protected $fillable = [
        'kd_presensi',
        'jumlah_presensi',
        'jumlah_hari_kerja_kalender',
        'total_gaji',
    ];
    protected $table = 'presensis';
    use HasFactory;
}
