<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $primaryKey = 'kd_jabatan';
    protected $fillable = [
        'kd_jabatan',
        'nm_jabatan',
        'total_gaji'
    ];
    protected $table = 'jabatans';

    public function pegawai(){
        return $this->hasOne('App\Models\Pegawai', 'kd_jabatan', 'kd_jabatan');
    }
}
