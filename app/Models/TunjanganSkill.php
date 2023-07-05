<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TunjanganSkill extends Model
{
    protected $primaryKey = 'kd_tunjangan_skill';
    protected $fillable = [
        'kd_tunjangan_skill',
        'nm_tunjangan_skill',
        'jumlah_tunjangan_skill',
        'keterangan',
    ];
    protected $table = 'tunjangan_skills';

    public function detailGajiTunjangan(){
        return $this->hasOne('App\Models\DetailGaji', 'kd_tunjangan_skill', 'kd_tunjangan_skill');
    }
}
