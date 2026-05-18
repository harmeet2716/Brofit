<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'Demo User',
            'email' => 'demo@fitportal.com',
            'password' => Hash::make('Demo@1234'),
            'age' => 28,
            'height_cm' => 175,
            'weight_kg' => 78.5,
            'fitness_goal' => 'build_muscle',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
