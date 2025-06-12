<?php

namespace App\Livewire\Donante;

use App\Models\Cita;
use App\Models\Donacion;
use App\Models\Donacione;
use Livewire\Component;
use Illuminate\Support\Carbon;

class DashboardDonante extends Component
{
    public $donante;
    public $tipoSangre;
    public $sexo;
    public $diasRestantes;
    public $proximaFecha;
    public $puedeDonar;
    public $totalDonaciones;
    public $donacionesEsteAnio;
    public $proximaCita;
    public $centrosConDonaciones = [];

    public function mount()
    {
        $this->donante = auth()->user()->donante;
        $user = auth()->user();
        $donante = $user->donante;

        $this->tipoSangre = $donante->tipo_sangre ?? 'N/A';
        $this->sexo = $donante->sexo ?? 'M'; // Por defecto masculino

        // Totales
        $this->totalDonaciones = Donacione::where('user_id', $user->id)->count();

        $this->donacionesEsteAnio = Donacione::where('user_id', $user->id)
            ->whereYear('created_at', now()->year)
            ->count();


        // Última donación registrada
        $ultimaDonacion = Donacione::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if ($ultimaDonacion) {
            $esperaDias = $this->sexo === 'F' ? 120 : 90; // Mujeres: 4 meses, Hombres: 3 meses
            $fechaUltima = Carbon::parse($ultimaDonacion->created_at);
            $this->proximaFecha = $fechaUltima->copy()->addDays($esperaDias);
            $this->diasRestantes = abs( (int) now()->diffInDays($this->proximaFecha, false));
            $this->puedeDonar = now()->greaterThanOrEqualTo($this->proximaFecha);
        } else {
            $this->diasRestantes = 0;
            $this->puedeDonar = true;
            $this->proximaFecha = now();
        }
        
        $this->proximaCita = Cita::with('centro.user')
            ->where('user_id', auth()->id())
            ->where('fecha', '>=', now())
            ->whereIn('estado', ['agendada', 'confirmada'])
            ->orderBy('fecha')
            ->first();
    
        $this->centrosConDonaciones = Donacione::with('centro.user')
            ->where('user_id', auth()->id())
            ->get()
            ->pluck('centro')
            ->filter(fn($c) => $c && $c->latitud && $c->longitud)
            ->unique('id')
            ->values();
    }

    public function render()
    {
        return view('livewire.donante.dashboard-donante', [
            'user' => auth()->user()
        ]);
    }
}
