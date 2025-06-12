<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;

class EditarCentro extends Component
{
    public $name, $email, $user_id, $telefono, $direccion, $latitud, $longitud;
    public $isEditing = false;
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => $this->isEditing
                ? 'required|email|unique:users,email,' . $this->user_id
                : 'required|email|unique:users,email',
            'telefono' => 'nullable|digits:9',
            'direccion' => 'nullable|string|max:255',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
        ];
    }

    public function render()
    {
        return view('livewire.admin.editar-centro');
    }

    #[On('editarCentro')]
    public function editarCentro($id)
    {
        $user = User::with('centro')->findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->telefono = $user->centro->telefono ?? '';
        $this->direccion = $user->centro->direccion ?? '';
        $this->latitud = $user->centro->latitud ?? '';
        $this->longitud = $user->centro->longitud ?? '';
        $this->isEditing = true;
        Flux::modal("editar-centro")->show();
    }

    public function update()
    {
        $this->validate($this->rules(), $this->messages());

        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user->centro()->updateOrCreate([], [
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
        ]);

        Flux::modal('editar-centro')->close();
        $this->dispatch('recargarCentros');
    }

    protected function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'telefono.digits' => 'El teléfono debe contener exactamente 9 dígitos.',
            'latitud.required' => 'La latitud es obligatoria.',
            'latitud.numeric' => 'La latitud debe ser un número.',
            'latitud.between' => 'La latitud debe estar entre -90 y 90.',
            'longitud.required' => 'La longitud es obligatoria.',
            'longitud.numeric' => 'La longitud debe ser un número.',
            'longitud.between' => 'La longitud debe estar entre -180 y 180.',
        ];
    }
}
