<?php

namespace App\Livewire\Centro;

use App\Models\HorariosCentro;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditarHorarioCentro extends Component
{
    public $horarios = [];

    public function mount()
    {
        $centroId = Auth::user()->centro->id ?? null;
        if ($centroId) {
            $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];

            foreach ($dias as $dia) {
                $horario = HorariosCentro::firstOrNew([
                    'centro_id' => $centroId,
                    'dia_semana' => $dia,
                ]);

                $this->horarios[$dia] = [
                    'hora_inicio' => $horario->hora_inicio ?? '08:00:00',
                    'hora_fin' => $horario->hora_fin ?? '20:00:00',
                    'aforo' => $horario->aforo ?? 1,
                    'duracion_bloque' => $horario->duracion_bloque ?? 60,
                ];
            }
        }
    }

    public function borrarDia($dia)
    {
        $centroId = auth()->user()->centro->id ?? null;

        if (!$centroId || !isset($this->horarios[$dia])) return;

        HorariosCentro::where('centro_id', $centroId)
            ->where('dia_semana', $dia)
            ->delete();
        
        unset($this->horarios[$dia]);

        session()->flash('message', "Horario del día {$dia} eliminado.");
    }

    public function guardar()
    {
        $centroId = Auth::user()->centro->id ?? null;
        if (!$centroId) return;

        foreach ($this->horarios as $dia => $data) {
            HorariosCentro::updateOrCreate(
                ['centro_id' => $centroId, 'dia_semana' => $dia],
                [
                    'hora_inicio' => $data['hora_inicio'],
                    'hora_fin' => $data['hora_fin'],
                    'aforo' => $data['aforo'],
                    'duracion_bloque' => $data['duracion_bloque'],
                ]
            );
        }

        session()->flash('message', 'Horario actualizado correctamente.');
    }

    public function render()
    {
        return view('livewire.centro.editar-horario-centro', [
            'diasSemana' => [
                'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'
            ],
        ]); 
    }
}
