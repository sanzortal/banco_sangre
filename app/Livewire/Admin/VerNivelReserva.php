<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NivelReserva;

class VerNivelReserva extends Component
{
    public $niveles = [];
    public $editando = false;
    public $nivelEditando = null;
    public $cantidadEditada = null;

    public function mount()
    {
        $this->cargarNiveles();
    }

    public function cargarNiveles()
    {
        $this->niveles = NivelReserva::orderBy('tipo_sangre')->get();
    }

    public function render()
    {
        return view('livewire.admin.ver-nivel-reserva');
    }

    public function editar($id)
    {
        $nivel = NivelReserva::findOrFail($id);
        $this->nivelEditando = $nivel;
        $this->cantidadEditada = $nivel->cantidad;
        $this->editando = true;
    }

    public function actualizarCantidad()
    {
        if (!$this->nivelEditando) return;

        $nivel = NivelReserva::findOrFail($this->nivelEditando->id);
        $cantidad = max(0, (int) $this->cantidadEditada);
        $nivel->cantidad = $cantidad;

        // Establecer nivel automáticamente según la cantidad
        $nivel->nivel = match (true) {
            $cantidad < 5 => 'bajo',
            $cantidad < 10 => 'medio',
            default => 'alto',
        };

        $nivel->save();

        $this->editando = false;
        $this->nivelEditando = null;
        $this->cantidadEditada = null;

        $this->cargarNiveles();
        session()->flash('message', 'Cantidad y nivel actualizados correctamente.');
    }

    public function cerrarModal()
    {
        $this->editando = false;
        $this->nivelEditando = null;
        $this->cantidadEditada = null;
    }
}