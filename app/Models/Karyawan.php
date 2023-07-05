<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
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
    protected $table = 'karyawans';
    
    public function jabatan(){
        return $this->belongsTo('App\Models\Jabatan', 'kd_jabatan', 'kd_jabatan');
    }

    public function gajiKaryawan(){
        return $this->hasMany('App\Models\Gaji', 'nip', 'nip');
    }
}
