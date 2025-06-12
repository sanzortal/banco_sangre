<?php

namespace App\Livewire\Donante;

use App\Models\Cita;
use App\Models\Centro;
use App\Models\HorariosCentro;
use Carbon\Carbon;
use Livewire\Component;

class GestionarCitas extends Component
{
    public $citas = [];
    public $editandoId = null;
    public $centro_id, $fecha, $hora;
    public $horasDisponibles = [];
    public $mostrarModalConfirmacion = false;
    public $citaIdParaCancelar = null;
    public string $estadoFiltro = 'agendada';

    public function mount()
    {
        $this->cargarCitas();
    }

    public function confirmarCancelacion($id)
    {
        $this->citaIdParaCancelar = $id;
        $this->mostrarModalConfirmacion = true;
    }

    public function cancelarConfirmado()
    {
        $this->cancelar($this->citaIdParaCancelar);
        $this->mostrarModalConfirmacion = false;
        $this->citaIdParaCancelar = null;
    }

    public function cerrarModal()
    {
        $this->mostrarModalConfirmacion = false;
        $this->citaIdParaCancelar = null;
    }

    public function cargarCitas()
    {
        $this->citas = Cita::with('centro.user')
            ->where('user_id', auth()->id())
            ->when($this->estadoFiltro, fn($q) => $q->where('estado', $this->estadoFiltro))
            ->orderBy('fecha', 'desc')
            ->get();
    }

    public function editar($id)
    {
        $cita = Cita::findOrFail($id);
        $this->editandoId = $id;
        $this->centro_id = $cita->centro_id;
        $this->fecha = Carbon::parse($cita->fecha)->format('Y-m-d');
        $this->hora = Carbon::parse($cita->fecha)->format('H:i');

        $this->calcularHorasDisponibles();
    }

    public function updatedFecha()
    {
        $this->calcularHorasDisponibles();
    }

    public function calcularHorasDisponibles()
    {
        $this->horasDisponibles = [];

        if (!$this->fecha || !$this->centro_id) return;

        $diaSemana = Carbon::parse($this->fecha)->locale('es')->isoFormat('dddd');
        $diaSemana = strtolower(trim($diaSemana));
        $diaSemana = str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $diaSemana);

        $horario = HorariosCentro::where('centro_id', $this->centro_id)
            ->where('dia_semana', $diaSemana)
            ->first();

        if (!$horario) return;

        $inicio = Carbon::parse($horario->hora_inicio);
        $fin = Carbon::parse($horario->hora_fin);

        while ($inicio < $fin) {
            $this->horasDisponibles[] = $inicio->format('H:i');
            $inicio->addMinutes(30);
        }
    }

    public function actualizar()
    {
        $this->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
        ]);

        try {
            $horaNormalizada = substr($this->hora, 0, 5);
            $fechaCompleta = Carbon::createFromFormat('Y-m-d H:i', "{$this->fecha} {$horaNormalizada}")
                ->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            session()->flash('error', 'Formato de fecha u hora inválido.');
            return;
        }

        $cita = Cita::findOrFail($this->editandoId);

        if ($cita->fecha < now()) {
            session()->flash('error', 'No puedes modificar una cita pasada.');
            return;
        }

        $existe = Cita::where('centro_id', $this->centro_id)
            ->where('fecha', $fechaCompleta)
            ->where('id', '!=', $this->editandoId)
            ->exists();

        if ($existe) {
            session()->flash('error', 'Ya hay una cita en ese horario.');
            return;
        }

        $cita->update([
            'fecha' => $fechaCompleta,
        ]);

        $this->editandoId = null;
        $this->reset(['fecha', 'hora', 'horasDisponibles']);
        $this->cargarCitas();
        session()->flash('message', 'Cita actualizada correctamente.');
    }

    public function cancelar($id)
    {
        $cita = Cita::findOrFail($id);

        if ($cita->user_id !== auth()->id()) return;

        $cita->update(['estado' => 'cancelada']);
        $this->cargarCitas();
        session()->flash('message', 'Cita cancelada.');
    }

    public function render()
    {
        return view('livewire.donante.gestionar-citas');
    }
}

