<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'	    => 1,
            'name'	    => 'Admin',
            'email'	    => 'admin@gmail.com',
            'password'	=> bcrypt('secret'),
            'level'     => 'admin'
        ]);

        User::create([
            'id'	    => 2,
            'name'	    => 'Direktur',
            'email'	    => 'direktur@gmail.com',
            'password'	=> bcrypt('secret'),
            'level'     => 'user'
        ]);
    }
}
