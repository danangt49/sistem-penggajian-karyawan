<?php

namespace Database\Seeders;

use Database\Factories\LemburFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(JabatanSeeder::class);
        $this->call(KasbonSeeder::class);
        $this->call(TunjanganSkillSeeder::class);
        $this->call(LemburSeeder::class);

    }
}
