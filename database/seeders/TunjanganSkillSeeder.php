<?php

namespace Database\Seeders;

use App\Models\TunjanganSkill;
use Illuminate\Database\Seeder;

class TunjanganSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TunjanganSkill::create([
            'nm_tunjangan_skill' => 'Tidak Ada',
            'jumlah_tunjangan_skill' => 0,
            'keterangan' => 'Tidak Ada',
        ]);

        TunjanganSkill::create([
            'nm_tunjangan_skill' => 'Tunjangan Marketing',
            'jumlah_tunjangan_skill' => 600000,
            'keterangan' => 'Marketing',
        ]);

        TunjanganSkill::create([
            'nm_tunjangan_skill' => 'Tunjangan Kedisiplinan',
            'jumlah_tunjangan_skill' => 500000,
            'keterangan' => 'Kedisiplinan',
        ]);

        TunjanganSkill::create([
            'nm_tunjangan_skill' => 'Tunjangan Transportasi',
            'jumlah_tunjangan_skill' => 50000,
            'keterangan' => 'Transportasi',
        ]);

        TunjanganSkill::create([
            'nm_tunjangan_skill' => 'Tunjangan Prestasi',
            'jumlah_tunjangan_skill' => 1000000,
            'keterangan' => 'Prestasi',
        ]);
    }
}
