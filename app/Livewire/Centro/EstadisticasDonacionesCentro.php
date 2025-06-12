<?php

namespace App\Livewire\Centro;

use App\Models\Donacione;
use Livewire\Component;
use Carbon\Carbon;

class EstadisticasDonacionesCentro extends Component
{
    public $anioSeleccionado;
    public $disponibles = [];
    public $mensuales = [];
    public $detalles = [];
    public $mesSeleccionado = null;
    public $mostrarModal = false;

    public function mount()
    {
        $this->anioSeleccionado = now()->year;
        $this->disponibles = range(now()->year - 5, now()->year);
        $this->actualizarDatos();
    }

    public function buscar()
    {
        $this->actualizarDatos();
    }

    public function actualizarDatos()
    {
        $centroId = auth()->user()->centro?->id;

        $this->mensuales = Donacione::where('centro_id', $centroId)
            ->whereYear('created_at', $this->anioSeleccionado)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('m');
            })
            ->map(function ($items) {
                return $items->count();
            })
            ->toArray();
    }

    public function verMes($mes)
    {
        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES.UTF-8'); // para compatibilidad con servidores Unix

        $this->mesSeleccionado = Carbon::create()->locale('es')->month($mes)->translatedFormat('F');


        $centroId = auth()->user()->centro?->id;

        $this->detalles = Donacione::with('user', 'user.donante')
            ->where('centro_id', $centroId)
            ->whereYear('created_at', $this->anioSeleccionado)
            ->whereMonth('created_at', $mes)
            ->get();

        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->detalles = [];
    }


    public function render()
    {
        return view('livewire.centro.estadisticas-donaciones-centro');
    }
}

