<div class="p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-md text-zinc-900 dark:text-zinc-100">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Estadísticas donaciones') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Aquí podrás ver en formato tabla todas las donaciones que se han realizado por cada centro, el tipo de sangre y con la opción de filtrar por un periodo de fecha.') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Filtrar por fecha</h2>

    <form wire:submit.prevent="actualizarEstadisticas" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desde</label>
            <input type="date" wire:model.defer="fechaInicio"
                class="border border-gray-300 dark:border-zinc-600 rounded px-2 py-1 bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hasta</label>
            <input type="date" wire:model.defer="fechaFin"
                class="border border-gray-300 dark:border-zinc-600 rounded px-2 py-1 bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-100" />
        </div>
        <div>
            <button type="submit"
                class="bg-tamarillo-600 text-white px-4 py-2 rounded hover:bg-tamarillo-800 transition">
                Buscar
            </button>
        </div>
    </form>

    @if (count($estadisticas))
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-center border border-gray-300 dark:border-zinc-700">
                <thead class="bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-100">
                    <tr>
                        <th class="px-4 py-2 border dark:border-zinc-700">Centro</th>
                        @foreach (array_keys($estadisticas[0]['tipos']) as $tipo)
                            <th class="px-4 py-2 border dark:border-zinc-700">{{ $tipo }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estadisticas as $item)
                        <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800">
                            <td class="px-4 py-2 border font-semibold text-left dark:border-zinc-700">{{ $item['centro'] }}</td>
                            @foreach ($item['tipos'] as $cantidad)
                                <td class="px-4 py-2 border dark:border-zinc-700">{{ $cantidad }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400">No hay datos disponibles para mostrar.</p>
    @endif
</div>