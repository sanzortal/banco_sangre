<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CentrosCrud extends Component
{
    use WithPagination;
    public $user_id;

    #[On('recargarCentros')]
    public function recargarCentros(){
        $centros = User::where('role', 'centro')->with('centro')->paginate(10);
    }

    public function render()
    {
        $centros = User::where('role', 'centro')->with('centro')->paginate(10);
        return view('livewire.admin.centros-crud', compact('centros'));
    }

    public function edit($id)
    {
        $this->dispatch('editarCentro', $id);

    }

    public function delete($id)
    {
        $this->user_id = $id;
        $this->dispatch('borrarCentro', $id);
    }
}
