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
            'nominal_jabatan' => '3000000',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'HRD',
            'nominal_jabatan' => '3000000',
        ]);
       
        Jabatan::create([
            'nm_jabatan' => 'SPV Line',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Adm Line',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Gudang',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'SPV QC',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'SPV Finishing',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Security',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Operator Sewing',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'SPV Cutting',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Bagian Administrasi',
            'nominal_jabatan' => '1940890',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Cutting',
            'nominal_jabatan' => '1940890',
        ]);
    }
}
