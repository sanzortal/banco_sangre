<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Sanaa Zorrouk Talidi',
            'email' => 'sanaazorrouktalidi@gmail.com',
            'role' => UserRole::Admin,
            'password' => Hash::make('SanaaRoot1234?')
        ]);

        User::create([
            'name' => 'Antonio Ortiz Moreno',
            'email' => 'antonio@admin.com',
            'role' => UserRole::Admin,
            'password' => Hash::make('AntonioOM1234?')
        ]);
        
        User::create([
            'name' => 'Ramon Merchán Sanzano',
            'email' => 'ramon@admin.com',
            'role' => UserRole::Admin,
            'password' => Hash::make('RamonMS1234?')
        ]);

        User::create([
            'name' => 'Juan Carlos Redondo',
            'email' => 'juancarlos@admin.com',
            'role' => UserRole::Admin,
            'password' => Hash::make('JuanCR1234?')
        ]);
    }
}
