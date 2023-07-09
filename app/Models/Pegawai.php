<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $primaryKey = 'nip';
    protected $fillable = [
        'nip',
        'kd_jabatan',
        'gaji_pokok',
        'nm_pegawai',
        'tanggal_masuk',
        'tanggal_lahir',
        'no_telepon',
        'alamat',
    ];
    protected $table = 'pegawais';
    
    public function jabatan(){
        return $this->belongsTo('App\Models\Jabatan', 'kd_jabatan', 'kd_jabatan');
    }

    public function gajiPegawai(){
        return $this->hasMany('App\Models\Gaji', 'nip', 'nip');
    }
}
