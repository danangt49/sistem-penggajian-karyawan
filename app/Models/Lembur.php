<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $primaryKey = 'kd_lembur';
    protected $fillable = [
        'kd_lembur',
        'nm_lembur',
        'jumlah_jam_lembur',
        'biaya_lembur_perjam',
        'total_pendapatan_lembur'
    ];
    protected $table = 'lemburs';
    
    public function detailGajiLembur(){
        return $this->hasOne('App\Models\DetailGaji', 'kd_lembur', 'kd_lembur');
    }
}
