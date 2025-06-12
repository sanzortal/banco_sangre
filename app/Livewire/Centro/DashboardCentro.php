<?php

namespace App\Livewire\Centro;

use App\Models\Cita;
use App\Models\Donacione;
use Livewire\Component;

class DashboardCentro extends Component
{
    public $totalDonaciones = 0;

    public function mount()
    {
        $centroId = auth()->user()->centro?->id;

        $this->totalDonaciones = Donacione::where('centro_id', $centroId)->count();
    }

    public function render()
    {
        return view('livewire.centro.dashboard-centro', [
            'user' => auth()->user()
        ]);
    }
}
