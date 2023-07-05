<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailGaji extends Model
{
    protected $fillable = [
        'id_detail_gaji',
        'no_slip_gaji',
        'kd_tunjangan_skill',
        'kd_kasbon',
        'kd_lembur',
        'kd_presensi',
        'jumlah_potongan',
        'potongan_perhari',
        'sub_total_tunjangan_skill',
        'sub_total_lembur',
        'sub_total_kasbon',
        'sub_total_Presensi',
        'sub_jumlah_tunjangan',
        'sub_jumlah_lembur',
        'sub_jumlah_kasbon',
        'sub_jumlah_Presensi',
    ];

    protected $table = 'detail_gajis';

    public function gaji(){
        return $this->belongsTo('App\Models\Gaji', 'no_slip_gaji', 'no_slip_gaji');
    }

    public function tunjangan(){
        return $this->belongsTo('App\Models\TunjanganSkill', 'kd_tunjangan_skill', 'kd_tunjangan_skill');
    }

    public function kasbon(){
        return $this->belongsTo('App\Models\Kasbon', 'kd_kasbon', 'kd_kasbon');
    }

    public function lembur(){
        return $this->belongsTo('App\Models\Lembur', 'kd_lembur', 'kd_lembur');
    }
    
    public function presensi(){
        return $this->belongsTo('App\Models\Presensi', 'kd_presensi', 'kd_presensi');
    }
}
