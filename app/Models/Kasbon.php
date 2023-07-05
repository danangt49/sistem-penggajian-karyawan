<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    protected $primaryKey = 'kd_kasbon';
    protected $fillable = [
        'kd_kasbon',
        'nm_kasbon',
        'jumlah_kasbon',
        'keterangan',
    ];
    protected $table = 'kasbons';
    
    public function detailGajiKasbon(){
        return $this->hasOne('App\Models\DetailGaji', 'kd_kasbon', 'kd_kasbon');
    }

}
