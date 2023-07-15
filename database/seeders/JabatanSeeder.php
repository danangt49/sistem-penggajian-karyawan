<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jabatan::create([
            'nm_jabatan' => 'Chief Sewing',
            'total_gaji' => '3000000',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'HRD',
            'total_gaji' => '3000000',
        ]);
       
        Jabatan::create([
            'nm_jabatan' => 'SPV Line',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Adm Line',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Gudang',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'SPV QC',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'SPV Finishing',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Security',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Operator Sewing',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'SPV Cutting',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Bagian Administrasi',
            'total_gaji' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Cutting',
            'total_gaji' => '1940890',
        ]);
    }
}
