<?php
namespace App\Helpers;

class Sistem {

	public static function konversiTanggal($tanggal)
	{
		date_default_timezone_set('Asia/Jakarta');
		$format = array('Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember');
		$tanggal = date('d M Y', strtotime($tanggal));
		return strtr($tanggal, $format);
	}

	public static function formatRupiah($angka)
	{
		$rupiah="";
		$rp=strlen($angka);
			while ($rp>3)
			{
				$rupiah = ".". substr($angka,-3). $rupiah;
				$s=strlen($angka) - 3;
				$angka=substr($angka,0,$s);
				$rp=strlen($angka);
			}
		$rupiah = $angka . $rupiah . "";
		return $rupiah;
	}

}