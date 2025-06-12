<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Donante;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;

class DonantesCrud extends Component
{
    use WithPagination;
    public $user_id;

    public function render()
    {
        $donantes = User::where('role', 'donante')->with('donante')->paginate(10);
        return view('livewire.admin.donantes-crud', compact('donantes'));
    }

    #[On('recargarDoanantes')]
    public function recargarDoanantes(){
        $donantes = User::where('role', 'donante')->with('donante')->paginate(10);
    }

    public function edit($id)
    {
        $this->dispatch('editarDonante', $id);

    }

    public function delete($id)
    {
        $this->user_id = $id;
        $this->dispatch('borrarDonante', $id);
    }
}
