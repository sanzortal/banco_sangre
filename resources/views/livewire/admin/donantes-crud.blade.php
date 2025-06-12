<div class="p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-md text-zinc-900 dark:text-zinc-100">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Donantes') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Maneja todos los datos de los donantes desde aquí:') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:modal.trigger name="nuevo-donante">
        <flux:button>+ Crear Nuevo</flux:button>
    </flux:modal.trigger>

    <livewire:admin.nuevo-donante />
    <livewire:admin.editar-donante />
    <livewire:admin.borrar-donante />

    @if (session()->has('message'))
        <div
            class="mb-4 p-2 bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 rounded text-zinc-800 dark:text-zinc-100">
            {{ session('message') }}
        </div>
    @endif

    {{-- Lista de donantes --}}
    <div class="overflow-x-auto mt-4">
        <table
            class="min-w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 shadow-sm rounded-lg text-sm text-zinc-900 dark:text-zinc-100">
            <thead class="bg-gray-100 dark:bg-zinc-700">
                <tr>
                    <th class="p-2 border dark:border-zinc-600">Nombre</th>
                    <th class="p-2 border dark:border-zinc-600">Email</th>
                    <th class="p-2 border dark:border-zinc-600">Tipo Sangre</th>
                    <th class="p-2 border dark:border-zinc-600">Nacimiento</th>
                    <th class="p-2 border dark:border-zinc-600">Teléfono</th>
                    <th class="p-2 border dark:border-zinc-600">Dirección</th>
                    <th class="p-2 border dark:border-zinc-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donantes as $donante)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700">
                        <td class="border p-2 dark:border-zinc-600">{{ $donante->name }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $donante->email }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $donante->donante->tipo_sangre ?? '-' }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $donante->donante->fecha_nacimiento ?? '-' }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $donante->donante->telefono ?? '-' }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $donante->donante->direccion ?? '-' }}</td>
                        <td class="border p-2 dark:border-zinc-600 text-center">
                            <flux:button variant="filled" size="sm" wire:click="edit({{ $donante->id }})">
                                Editar
                            </flux:button>
                            <flux:button variant="danger" size="sm" wire:click="delete({{ $donante->id }})">
                                Borrar
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $donantes->links() }}
        </div>
    </div>
</div>