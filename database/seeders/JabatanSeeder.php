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
            'nm_jabatan' => 'ADMINISTRATOR',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'HRD',
        ]);
       
        Jabatan::create([
            'nm_jabatan' => 'STAFF',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'OPERATOR',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'TEKNISI',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'BAG. GUDANG',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'QUALITY CONTROL',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'SUPERVISOR',
        ]);
    }
}
