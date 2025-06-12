<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;

class BorrarCentro extends Component
{
    public $user_id;

    #[On('borrarCentro')]
    public function borrarCentro($id)
    {
        $this->user_id = $id;
        Flux::modal('borrar-centro')->show();
    }

    public function destroy()
    {
        if ($this->user_id) {
            User::findOrFail($this->user_id)->delete();
            Flux::modal('borrar-centro')->close();
            $this->dispatch('recargarCentros');
        }
    }

    public function render()
    {
        return view('livewire.admin.borrar-centro');
    }
}
