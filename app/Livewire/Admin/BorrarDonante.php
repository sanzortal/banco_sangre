<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;

class BorrarDonante extends Component
{
    public $user_id;

    #[On('borrarDonante')]
    public function borrarDonante($id)
    {
        $this->user_id = $id;
        Flux::modal('borrar-donante')->show();
    }

    public function destroy()
    {
        if ($this->user_id) {
            User::findOrFail($this->user_id)->delete();
            Flux::modal('borrar-donante')->close();
            $this->dispatch('recargarDoanantes');
            session()->flash('message', 'Donante eliminado con éxito.');
        }
    }
    public function render()
    {
        return view('livewire.admin.borrar-donante');
    }
}
