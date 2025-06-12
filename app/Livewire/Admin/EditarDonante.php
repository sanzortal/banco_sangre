<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;

class EditarDonante extends Component
{
    private $tiposSangreValidos = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    public $name, $email, $tipo_sangre, $fecha_nacimiento, $user_id, $telefono, $direccion;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => $this->isEditing
                ? 'required|email|unique:users,email,' . $this->user_id
                : 'required|email|unique:users,email',
            'tipo_sangre' => 'required|in:' . implode(',', $this->tiposSangreValidos),
            'fecha_nacimiento' => ['required', 'date', function ($attribute, $value, $fail) {
                $fecha = Carbon::parse($value);
                if ($fecha->diffInYears(now()) < 18) {
                    $fail('El donante debe tener al menos 18 años.');
                }
            }],
            'telefono' => 'nullable|digits:9',
            'direccion' => 'required|string|max:255',
        ];
    }

    protected function messages()
    {
        return [
            'email.unique' => 'Este correo ya está registrado. Por favor, usa uno diferente.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo válido.',

            'tipo_sangre.required' => 'El tipo de sangre es obligatorio.',
            'tipo_sangre.in' => 'El tipo de sangre debe ser uno de los siguientes: A+, A-, B+, B-, AB+, AB-, O+, O-.',

            'telefono.digits' => 'El teléfono debe contener exactamente 9 dígitos.',

            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida.',
        ];
    }

    public function render()
    {
        return view('livewire.admin.editar-donante');
    }

    #[On('editarDonante')]
    public function editarDonante($id)
    {
        $user = User::with('donante')->findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->tipo_sangre = $user->donante->tipo_sangre ?? '';
        $this->fecha_nacimiento = $user->donante->fecha_nacimiento ?? '';
        $this->telefono = $user->donante->telefono ?? '';
        $this->direccion = $user->donante->direccion ?? '';
        $this->isEditing = true;
        Flux::modal("editar-donante")->show();
    }

    public function update()
    {
        $this->validate($this->rules(), $this->messages());

        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user->donante()->updateOrCreate([], [
            'tipo_sangre' => $this->tipo_sangre,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
        ]);
        
        Flux::modal('editar-donante')->close();
        $this->dispatch('recargarDoanantes');
    }
}
