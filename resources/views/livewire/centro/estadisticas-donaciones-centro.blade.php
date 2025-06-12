<div
    class="text-[var(--color-zinc-900)] dark:text-[var(--color-zinc-50)] bg-white dark:bg-[var(--color-zinc-900)] p-6 rounded-xl shadow-md space-y-6">

    <h2 class="text-2xl font-extrabold text-red-600 dark:text-tamarillo-400">📊 Estadísticas de Donaciones</h2>

    {{-- Filtro por año --}}
    <div class="w-full md:w-1/3">
        <label
            class="block text-sm font-medium text-[var(--color-zinc-700)] dark:text-[var(--color-zinc-200)] mb-1">Seleccionar
            año:</label>
        <div class="flex gap-2">
            <select wire:model.defer="anioSeleccionado"
                class="border border-[var(--color-zinc-300)] dark:border-[var(--color-zinc-600)] bg-zinc-50 dark:bg-[var(--color-zinc-800)] text-[var(--color-zinc-900)] dark:text-[var(--color-zinc-100)] rounded px-3 py-2 w-full">
                @foreach ($disponibles as $anio)
                    <option value="{{ $anio }}">{{ $anio }}</option>
                @endforeach
            </select>
            <button wire:click="buscar"
                class="px-4 py-2 bg-tamarillo-600 hover:bg-tamarillo-700 text-zinc-50 rounded transition">
                Buscar
            </button>
        </div>
    </div>

    {{-- Tarjetas de resumen mensual --}}
    @if ($mensuales && count($mensuales))
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach (range(1, 12) as $mes)
                <div wire:click="verMes({{ $mes }})"
                    class="cursor-pointer text-center bg-[var(--color-zinc-100)] dark:bg-[var(--color-zinc-800)] hover:bg-[var(--color-zinc-200)] dark:hover:bg-[var(--color-zinc-700)] rounded p-4 shadow-sm transition">
                    <div class="text-sm text-[var(--color-zinc-600)] dark:text-[var(--color-zinc-300)]">
                        {{ \Carbon\Carbon::create()->month($mes)->locale('es')->translatedFormat('F') }}
                    </div>
                    <div class="text-2xl font-bold text-red-600 dark:text-tamarillo-400">
                        {{ $mensuales[str_pad($mes, 2, '0', STR_PAD_LEFT)] ?? 0 }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-400)] mt-4">No hay datos de donaciones para este
            año seleccionado.</p>
    @endif

    {{-- Modal --}}
    @if ($mostrarModal)
        <div
            class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-60 flex items-center justify-center z-50 transition">
            <div
                class="bg-white dark:bg-[var(--color-zinc-800)] p-6 rounded-lg shadow-lg max-w-4xl w-full max-h-[80vh] overflow-y-auto">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-red-600 dark:text-tamarillo-400">
                        Donaciones en {{ $mesSeleccionado }}
                    </h3>
                    <button wire:click="cerrarModal"
                        class="text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-300)] hover:text-red-600 text-2xl">
                        &times;
                    </button>
                </div>

                @if ($detalles->count())
                    <table class="w-full border border-collapse text-sm rounded overflow-hidden">
                        <thead
                            class="bg-[var(--color-zinc-100)] dark:bg-[var(--color-zinc-700)] text-[var(--color-zinc-700)] dark:text-[var(--color-zinc-200)]">
                            <tr>
                                <th class="p-2 border">Nº Donante</th>
                                <th class="p-2 border">Nombre</th>
                                <th class="p-2 border">Fecha</th>
                                <th class="p-2 border">Tipo Sangre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detalles as $d)
                                <tr class="hover:bg-[var(--color-zinc-50)] dark:hover:bg-[var(--color-zinc-700)] transition">
                                    <td class="p-2 border text-center">{{ $d->user->id }}</td>
                                    <td class="p-2 border">{{ $d->user->name }}</td>
                                    <td class="p-2 border">
                                        {{ \Carbon\Carbon::parse($d->created_at)->locale('es')->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="p-2 border text-center">{{ $d->tipo_sangre }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-300)]">
                        No hay donaciones registradas para este mes.
                    </p>
                @endif
            </div>
        </div>
    @endif
</div>