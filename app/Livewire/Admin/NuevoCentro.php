<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Flux\Flux;
use Hash;
use Livewire\Component;

class NuevoCentro extends Component
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
    
        public function store(){
        $this->validate($this->rules(), $this->messages());

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('root1234'),
            'role' => 'centro',
        ]);

        $user->centro()->create([
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
        ]);
        
        Flux::modal('nuevo-centro')->close();
        $this->resetForm();
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
            'longitud.numeric' => 'La longitud debe ser un número.',
            'longitud.between' => 'La longitud debe estar entre -180 y 180.',
        ];
    }

    public function resetForm(){
        $this->reset(['name', 'email', 'telefono', 'direccion', 'latitud', 'longitud', 'user_id']);
    }

    public function render()
    {
        return view('livewire.admin.nuevo-centro');
    }
}
