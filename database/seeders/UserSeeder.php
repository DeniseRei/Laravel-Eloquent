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
            'name' => 'Denise Rei',
            'email' => 'denise@mail.com',
            'password' => bcrypt('123'),
        ]);
    }
}
