<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Mulya',
            'email' => 'mulyawardhana@gmail.com',
            'email_verified_at' => now(),
            'password' => 'mulya',
            'role' => 0
        ]);
        User::create([
            'name' => 'visitor',
            'email' => 'visitor@gmail.com',
            'email_verified_at' => now(),
            'password' => 'visitor',
            'role' => 0
        ]);
    }
}
