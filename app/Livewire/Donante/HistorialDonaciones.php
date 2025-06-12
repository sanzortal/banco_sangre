<?php

namespace App\Livewire\Donante;

use App\Models\Donacione;
use Livewire\Component;
use Log;

class HistorialDonaciones extends Component
{
    public $donaciones = [];
    public $agrupadas = [];
    public $donacionesCentro = [];
    public $modalAbierto = false;
    public $modalTitulo = '';

    public function mount()
    {
        $donaciones = Donacione::with('centro.user')
            ->where('user_id', auth()->id())
            ->get();

        $this->agrupadas = collect(
            $donaciones
                ->groupBy('centro_id')
                ->map(function ($items) {
                    $centro = $items->first()->centro;
                    return [
                        'nombre' => $centro->user->name ?? 'Centro desconocido',
                        'direccion' => $centro->direccion ?? '-',
                        'total' => $items->count(),
                    ];
                })
                ->all()
        );
    }

    public function verDetalle($centroId)
    {
        $donaciones = Donacione::with('centro')
            ->where('user_id', auth()->id())
            ->where('centro_id', $centroId)
            ->orderByDesc('created_at')
            ->get();

        $centro = $donaciones->first()?->centro;

        $this->donacionesCentro = $donaciones;
        $this->modalTitulo = $centro?->user->name ?? 'Centro';
        $this->modalAbierto = true;
    }

    public function render()
    {
        return view('livewire.donante.historial-donaciones');
    }
}
