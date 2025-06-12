<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Centro;
use Illuminate\Database\Seeder;

class CentrosPruebaSeeder extends Seeder
{
    public function run(): void
    {
        // Crea 3 usuarios tipo centro y sus centros asociados
        $centros = [
            [
                'name' => 'Sala de donación permanente',
                'email' => 'salapermanente@centros.com',
                'direccion' => 'Calle Juan Montalvo, 3 - Cerca de Cuatro Caminos - Madrid',
                'telefono' => '914562470',
                'latitud' => 40.447778,
                'longitud' => -3.709778,
            ],
            [
                'name' => 'Punto dijo diario Gran Vía',
                'email' => 'puntofijo@centros.com',
                'direccion' => 'C. Gran Vía esquina C. Montera – Red de San Luis   - C. Gran Vía - Madrid',
                'telefono' => '914562470',
                'latitud' => 40.419861,
                'longitud' => -3.701611,
            ],
            [
                'name' => 'Punto de fin de semana',
                'email' => 'puntofinde@centros.com',
                'direccion' => 'C/ Fuencarral, 121 - C. Fuencarral - Madrid',
                'telefono' => '914562470',
                'latitud' => 40.430222,
                'longitud' => -3.702639,
            ],
        ];

        foreach ($centros as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('centro1234?'),
                'role' => 'centro',
            ]);

            Centro::create([
                'user_id' => $user->id,
                'direccion' => $data['direccion'],
                'telefono' => $data['telefono'],
                'latitud' => $data['latitud'],
                'longitud' => $data['longitud'],
            ]);
        }
    }
}

