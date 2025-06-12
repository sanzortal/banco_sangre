<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonantesPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Ramón Merchán',
            'email' => 'ramon@donante.com',
            'role' => UserRole::Donante,
            'password' => Hash::make('ramon1234?'),
        ]);

        $user->donante()->create([
            'tipo_sangre' => 'AB+',
            'fecha_nacimiento' => '1990-05-22',
            'telefono' => '699999999',
            'direccion' => 'Plaza Carlos Vicente, 92',
            'sexo' => 'M',
        ]);

        $user2 = User::create([
            'name' => 'Antonio Ortiz',
            'email' => 'antonio@donante.com',
            'role' => UserRole::Donante,
            'password' => Hash::make('antonio1234?'),
        ]);

        $user2->donante()->create([
            'tipo_sangre' => 'B-',
            'fecha_nacimiento' => '1990-05-22',
            'telefono' => '699999999',
            'direccion' => 'Avenida Reina Sofía, 11',
            'sexo' => 'M',
        ]);

        $user3 = User::create([
            'name' => 'Juan Carlos',
            'email' => 'juancarlos@donante.com',
            'role' => UserRole::Donante,
            'password' => Hash::make('juancarlos1234?'),
        ]);

        $user3->donante()->create([
            'tipo_sangre' => '0-',
            'fecha_nacimiento' => '1990-05-22',
            'telefono' => '699999999',
            'direccion' => 'Avenida Cienpozuelos de la Villa, 38',
            'sexo' => 'M',
        ]);
    }
}
