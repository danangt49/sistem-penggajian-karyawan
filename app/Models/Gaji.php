<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $primaryKey = 'no_slip_gaji';
    protected $fillable = [
       'no_slip_gaji',
       'nip',
       'tanggal_gaji',
       'total_gaji_pokok',
       'total_tunjangan_skill',
       'total_biaya_lembur',
       'total_kasbon',
       'gaji_kotor',
       'gaji_bersih',
       'keterangan',
       'status_pengajuan',
    ];
    protected $table = 'gajis';
    
    public function karyawan(){
        return $this->belongsTo('App\Models\Karyawan', 'nip', 'nip');
    }

    public function detailGaji(){
        return $this->belongsTo('App\Models\DetailGaji', 'no_slip_gaji', 'no_slip_gaji');
    }

}
