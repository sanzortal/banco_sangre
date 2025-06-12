<?php

namespace App\Livewire\Centro;

use App\Models\Cita;
use App\Models\Donacione;
use App\Models\NivelReserva;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CentroCitasCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $modoVista = 'hoy';
    public $filtroFecha;
    public $totalCitasCentro = 0;

    public $estadisticas = [
        'total' => 0,
        'agendada' => 0,
        'confirmada' => 0,
        'cancelada' => 0,
    ];

    public function mount()
    {
        $this->filtroFecha = now()->format('Y-m-d');
    }

    public function updatingFiltroFecha()
    {
        $this->resetPage();
    }

    public function cambiarVista($modo)
    {
        $this->modoVista = $modo;
        if ($modo === 'hoy') {
            $this->filtroFecha = now()->format('Y-m-d');
        }
        $this->resetPage();
    }

    public function getCitasProperty()
    {
        $centro = auth()->user()->centro;
        if (!$centro) return collect();

        $query = Cita::with('user')
            ->where('centro_id', $centro->id);

        if ($this->modoVista === 'hoy') {
            $query->whereDate('fecha', now());
        } elseif ($this->modoVista === 'fecha' && $this->filtroFecha) {
            $query->whereDate('fecha', $this->filtroFecha);
        } elseif ($this->modoVista === 'todas') {
            $query->whereDate('fecha', '>=', now());
        }

        $this->totalCitasCentro = Cita::where('centro_id', $centro->id)->count();

        $citas = $query->orderBy('fecha')->paginate(10);

        $this->estadisticas['total'] = $citas->total();
        $this->estadisticas['agendada'] = $citas->where('estado', 'agendada')->count();
        $this->estadisticas['confirmada'] = $citas->where('estado', 'confirmada')->count();
        $this->estadisticas['cancelada'] = $citas->where('estado', 'cancelada')->count();

        return $citas;
    }

    public function cambiarEstado($id, $estado)
    {
        $cita = Cita::with('user.donante')->findOrFail($id);

        if ($cita->centro_id !== auth()->user()->centro->id) {
            session()->flash('error', 'No autorizado.');
            return;
        }

        if ($estado === 'confirmada') {
            $tipo = $cita->user->donante->tipo_sangre ?? null;

            if ($tipo) {
                Donacione::create([
                    'user_id' => $cita->user_id,
                    'centro_id' => $cita->centro_id,
                    'cita_id' => $cita->id,
                    'tipo_sangre' => $tipo,
                ]);

                $reserva = NivelReserva::firstOrNew(['tipo_sangre' => $tipo]);
                $reserva->cantidad = ($reserva->cantidad ?? 0) + 1;
                $reserva->nivel = match (true) {
                    $reserva->cantidad < 5 => 'bajo',
                    $reserva->cantidad < 10 => 'medio',
                    default => 'alto',
                };
                $reserva->save();
            }
        }

        $cita->estado = $estado;
        $cita->save();

        session()->flash('message', "Cita marcada como $estado.");
    }

    public function render()
    {
        return view('livewire.centro.centro-citas-crud', [
            'citas' => $this->citas
        ]);
    }
}