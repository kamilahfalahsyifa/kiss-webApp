<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Ahmad Mekanik', 'email' => 'mekanik@kiss.com', 'password' => Hash::make('password'), 'role' => 'mekanik'],
            ['name' => 'Budi GL', 'email' => 'gl@kiss.com', 'password' => Hash::make('password'), 'role' => 'gl'],
            ['name' => 'Citra Tere', 'email' => 'tere@kiss.com', 'password' => Hash::make('password'), 'role' => 'tere'],
            ['name' => 'Dian Planner', 'email' => 'planner@kiss.com', 'password' => Hash::make('password'), 'role' => 'planner'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}