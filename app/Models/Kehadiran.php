<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $primaryKey = 'kd_kehadiran';
    protected $fillable = [
        'kd_kehadiran',
        'jumlah_kehadiran',
        'jumlah_hari_kerja_kalender',
    ];
    protected $table = 'kehadirans';
    use HasFactory;

    public function detailGajiKehadiran(){
        return $this->hasOne('App\Models\Kehadiran', 'kd_kehadiran', 'kd_kehadiran');
    }

}
