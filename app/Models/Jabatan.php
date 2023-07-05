<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $primaryKey = 'kd_jabatan';
    protected $fillable = [
        'kd_jabatan',
        'nm_jabatan'
    ];
    protected $table = 'jabatans';

    public function jabatan(){
        return $this->hasOne('App\Models\Karyawan', 'kd_jabatan', 'kd_jabatan');
    }
}
