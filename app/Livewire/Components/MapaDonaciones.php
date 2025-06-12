<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Collection;

class MapaDonaciones extends Component
{
    public Collection $puntos;

    public function mount($puntos = [])
    {
        // $puntos = colección de objetos con: latitud, longitud, nombre, dirección
        $this->puntos = collect($puntos)->filter(function ($p) {
            return isset($p['latitud'], $p['longitud']);
        });
    }

    public function render()
    {
        return view('livewire.components.mapa-donaciones');
    }
}
