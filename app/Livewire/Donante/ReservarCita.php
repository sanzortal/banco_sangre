<?php

namespace App\Livewire\Donante;

use App\Models\Centro;
use App\Models\Cita;
use App\Models\Donacione;
use App\Models\HorariosCentro;
use Carbon\Carbon;
use Livewire\Component;

class ReservarCita extends Component
{
    public $centro_id, $fecha, $hora;
    public $centros = [];
    public $horasDisponibles = [];
    public $fechaProximaDonacion;
    public $tieneCitaPendiente = false;

    public function mount()
    {
        $this->centros = Centro::with('user:id,name')->get()->map(function ($centro) {
            $centro->nombre = $centro->user->name ?? 'Sin nombre';
            return $centro;
        });

        $donante = auth()->user()->donante;
        $sexo = $donante->sexo ?? 'M';

        $ultima = Donacione::where('user_id', auth()->id())
            ->latest('created_at')
            ->first();

        $this->fechaProximaDonacion = $ultima
            ? Carbon::parse($ultima->created_at)->addDays($sexo === 'F' ? 120 : 90)
            : now();

        $this->tieneCitaPendiente = Cita::where('user_id', auth()->id())
            ->whereIn('estado', ['agendada', 'confirmada'])
            ->where('fecha', '>', now())
            ->exists();
    }

    public function updatedFecha() { $this->calcularHorasDisponibles(); }
    public function updatedCentroId() { $this->calcularHorasDisponibles(); }

    public function calcularHorasDisponibles()
    {
        $this->horasDisponibles = [];

        if (!$this->fecha || !$this->centro_id) return;

        $diaSemana = Carbon::parse($this->fecha)->locale('es')->isoFormat('dddd');
        $diaSemana = strtolower(str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $diaSemana));

        $horario = HorariosCentro::where('centro_id', $this->centro_id)
            ->where('dia_semana', $diaSemana)
            ->first();

        if (!$horario) return;

        $bloque = $horario->duracion_bloque ?? 60;
        $aforo = $horario->aforo ?? 1;

        $inicio = Carbon::parse($horario->hora_inicio);
        $fin = Carbon::parse($horario->hora_fin);

        while ($inicio < $fin) {
            $horaStr = $inicio->format('H:i');

            $fechaHora = Carbon::createFromFormat('Y-m-d H:i', "{$this->fecha} {$horaStr}");
            $ocupadas = Cita::where('centro_id', $this->centro_id)
                ->where('fecha', $fechaHora)
                ->whereIn('estado', ['agendada', 'confirmada'])
                ->count();

            if ($ocupadas < $aforo) {
                $this->horasDisponibles[] = [
                    'hora' => $horaStr,
                    'disponibles' => $aforo - $ocupadas,
                ];
            }

            $inicio->addMinutes($bloque);
        }
    }

    public function reservar()
    {
        if ($this->tieneCitaPendiente) {
            session()->flash('error', 'Ya tienes una cita pendiente.');
            return;
        }

        $this->validate([
            'centro_id' => 'required|exists:centros,id',
            'fecha' => 'required|date',
            'hora' => 'required|string',
        ]);

        if (Carbon::parse($this->fecha)->lt($this->fechaProximaDonacion)) {
            session()->flash('error', 'No puedes reservar antes del ' . $this->fechaProximaDonacion->format('d/m/Y'));
            return;
        }

        $fechaCompleta = Carbon::createFromFormat('Y-m-d H:i', "{$this->fecha} {$this->hora}");

        $ocupadas = Cita::where('centro_id', $this->centro_id)
            ->where('fecha', $fechaCompleta)
            ->whereIn('estado', ['agendada', 'confirmada'])
            ->count();

        $diaSemana = strtolower(Carbon::parse($this->fecha)->locale('es')->isoFormat('dddd'));
        $horario = HorariosCentro::where('centro_id', $this->centro_id)
            ->where('dia_semana', $diaSemana)
            ->first();

        if ($ocupadas >= ($horario->aforo ?? 1)) {
            session()->flash('error', 'Ese bloque horario ya está completo.');
            return;
        }

        Cita::create([
            'user_id' => auth()->id(),
            'centro_id' => $this->centro_id,
            'fecha' => $fechaCompleta,
            'estado' => 'agendada',
        ]);

        session()->flash('message', 'Cita reservada con éxito.');
        $this->reset(['fecha', 'hora', 'centro_id', 'horasDisponibles']);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.donante.reservar-cita');
    }
}

