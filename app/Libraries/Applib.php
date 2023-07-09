<?php

namespace App\Libraries;

use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Kasbon;
use App\Models\Lembur;
use App\Models\TunjanganSkill;

class Applib 
{
    public static function dd_jabatan(){
		$query                          = Jabatan::get();
		$dd['']                         = '=== Pilih Jabatan ===';
		if ($query->count() > 0){
			foreach($query as $row){
				$dd[$row->kd_jabatan] = $row->nm_jabatan;
			}
		}
		return $dd;
	}

	public static function dd_pegawai(){
		$query                          = Pegawai::get();
		$dd['']                         = '=== Pilih Pegawai ===';
		if ($query->count() > 0){
			foreach($query as $row){
				$dd[$row->nip] = $row->nm_pegawai;
			}
		}
		return $dd;
	}

	public static function dd_tunjangan(){
		$query                       = TunjanganSkill::get();
		$dd['']                      = '=== Pilih Tunjangan Skill ===';
		if ($query->count() > 0){
			foreach($query as $row){
				$dd[$row->kd_tunjangan_skill] = $row->nm_tunjangan_skill;
			}
		}
		return $dd;
	}

	public static function dd_kasbon(){
		$query                       = Kasbon::get();
		$dd['']                      = '=== Pilih Kasbon ===';
		if ($query->count() > 0){
			foreach($query as $row){
				$dd[$row->kd_kasbon] = $row->nm_kasbon;
			}
		}
		return $dd;
	}

	public static function dd_lembur(){
		$query                       = Lembur::get();
		$dd['']                      = '=== Pilih Lembur ===';
		if ($query->count() > 0){
			foreach($query as $row){
				$dd[$row->kd_lembur] = $row->nm_lembur;
			}
		}
		return $dd;
	}

    public static function getJabatan($kd_jabatan){
		$query                          = Jabatan::where('kd_jabatan', $kd_jabatan)->get();
		if($query->count() > 0){
			foreach($query as $h){
				$hasil = $h->nm_jabatan;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}

	public static function getNama($nip){
		$query                          = Pegawai::where('nip', $nip)->get();
		if($query->count() > 0){
			foreach($query as $h){
				$hasil = $h->nm_pegawai;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}

}