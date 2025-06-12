<?php

namespace App\Livewire\Admin;

use App\Models\Donacione;
use Livewire\Component;

class EstadisticasDonaciones extends Component
{
    public $estadisticas = [];
    public $fechaInicio;
    public $fechaFin;

    public function mount()
    {
        // Inicialmente no mostrar estadísticas
        $this->fechaInicio = null;
        $this->fechaFin = null;
        $this->estadisticas = [];
    }

    public function actualizarEstadisticas()
    {
        if (!$this->fechaInicio || !$this->fechaFin) {
            $this->estadisticas = [];
            return;
        }

        $tiposSangre = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        $this->estadisticas = Donacione::with('centro')
            ->whereBetween('created_at', [$this->fechaInicio, $this->fechaFin])
            ->get()
            ->groupBy('centro_id')
            ->map(function ($donaciones) use ($tiposSangre) {
                $centroNombre = optional($donaciones->first()->centro->user)->name ?? 'Centro desconocido';

                $tipos = collect($tiposSangre)->mapWithKeys(function ($tipo) use ($donaciones) {
                    return [$tipo => $donaciones->where('tipo_sangre', $tipo)->count()];
                });

                return [
                    'centro' => $centroNombre,
                    'tipos' => $tipos->toArray(),
                ];
            })->values()->toArray();
    }

    public function render()
    {
        return view('livewire.admin.estadisticas-donaciones');
    }
}
