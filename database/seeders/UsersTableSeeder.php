<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // admin
        User::updateOrCreate(
            [
                'email' => "admin@start-tech.ae"
            ],
            [
                'name' => 'admin',
                'email' => "admin@start-tech.ae",
                'email_verified_at' => now(),
                'password' => Hash::make('v4Y5AehKd'), // password
                'role_id' => '1'
            ]
        );
    }
}
