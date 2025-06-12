<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NivelReserva;

class NivelReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposSangre = ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];

        foreach ($tiposSangre as $tipo) {
            NivelReserva::create([
                'tipo_sangre' => $tipo,
                'cantidad' => 1,
                'nivel' => 'bajo'
            ]);
        }
    }
}