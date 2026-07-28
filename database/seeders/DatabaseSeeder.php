<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Default Admin & Regular User Accounts
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator System',
                'role' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Analis Rantai Pasok',
                'role' => 'User',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            CountrySeeder::class,
            PortSeeder::class,
            SentimentWordsSeeder::class,
        ]);
    }
}