<div class="p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-md text-zinc-900 dark:text-zinc-100">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Centros') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Maneja todos los datos de los centros desde aquí:') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:modal.trigger name="nuevo-centro">
        <flux:button>+ Crear Nuevo</flux:button>
    </flux:modal.trigger>

    <livewire:admin.nuevo-centro />
    <livewire:admin.editar-centro />
    <livewire:admin.borrar-centro />

    <div class="overflow-x-auto mt-4">
        <table
            class="min-w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 shadow-sm rounded-lg text-sm text-zinc-900 dark:text-zinc-100">
            <thead class="bg-gray-100 dark:bg-zinc-700">
                <tr>
                    <th class="p-2 border dark:border-zinc-600">Nombre</th>
                    <th class="p-2 border dark:border-zinc-600">Email</th>
                    <th class="p-2 border dark:border-zinc-600">Latitud</th>
                    <th class="p-2 border dark:border-zinc-600">Longitud</th>
                    <th class="p-2 border dark:border-zinc-600">Teléfono</th>
                    <th class="p-2 border dark:border-zinc-600">Dirección</th>
                    <th class="p-2 border dark:border-zinc-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($centros as $centro)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700">
                        <td class="border p-2 dark:border-zinc-600">{{ $centro->name }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $centro->email }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $centro->centro->latitud ?? '-' }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $centro->centro->longitud ?? '-' }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $centro->centro->telefono ?? '-' }}</td>
                        <td class="border p-2 dark:border-zinc-600">{{ $centro->centro->direccion ?? '-' }}</td>
                        <td class="border p-2 dark:border-zinc-600 text-center">
                            <flux:button variant="filled" size="sm" wire:click="edit({{ $centro->id }})">Editar
                            </flux:button>
                            <flux:button variant="danger" size="sm" wire:click="delete({{ $centro->id }})">Borrar
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $centros->links() }}
        </div>
    </div>
</div>