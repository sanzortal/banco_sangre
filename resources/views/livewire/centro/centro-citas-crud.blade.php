<div
    class="space-y-8 p-6 rounded-xl shadow-inner transition-colors
           bg-[var(--color-zinc-50)] text-[var(--color-zinc-900)] dark:bg-[var(--color-zinc-900)] dark:text-[var(--color-zinc-50)]">

    <h2 class="text-3xl font-extrabold text-[var(--color-tamarillo-700)] dark:text-[var(--color-tamarillo-400)] border-b border-[var(--color-zinc-200)] dark:border-[var(--color-zinc-700)] pb-3">
        📅 Citas del Centro
    </h2>

    {{-- Mensajes --}}
    @if (session('message'))
        <div
            class="bg-[var(--color-tamarillo-100)] text-[var(--color-tamarillo-800)] border border-[var(--color-tamarillo-300)] px-4 py-3 rounded-md shadow-sm dark:bg-[var(--color-tamarillo-600)] dark:text-[var(--color-zinc-50)]">
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div
            class="bg-[var(--color-tamarillo-50)] text-[var(--color-tamarillo-900)] border border-[var(--color-tamarillo-400)] px-4 py-3 rounded-md shadow-sm dark:bg-[var(--color-tamarillo-700)] dark:text-[var(--color-zinc-50)]">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filtros --}}
    <div class="flex flex-wrap gap-4 items-center">
        <div class="flex items-end gap-2">
            <label class="text-sm font-medium text-[var(--color-zinc-700)] dark:text-[var(--color-zinc-300)]">Buscar por fecha:</label>
            <input type="date" wire:model="filtroFecha" wire:change="cambiarVista('fecha')"
                class="border border-[var(--color-zinc-300)] dark:border-[var(--color-zinc-600)] bg-white dark:bg-[var(--color-zinc-800)] text-[var(--color-zinc-800)] dark:text-[var(--color-zinc-100)] rounded-md px-3 py-1.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-tamarillo-500)]">
        </div>
        <button wire:click="cambiarVista('hoy')"
            class="px-5 py-2 rounded-md font-medium text-white bg-[var(--color-tamarillo-600)] hover:bg-[var(--color-tamarillo-700)] transition">
            Hoy
        </button>
    </div>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
        @foreach ([
            ['label' => 'Total', 'color' => '--color-zinc-300', 'valor' => $estadisticas['total']],
            ['label' => 'Agendadas', 'color' => '--color-zinc-400', 'valor' => $estadisticas['agendada']],
            ['label' => 'Confirmadas', 'color' => '--color-zinc-500', 'valor' => $estadisticas['confirmada']],
            ['label' => 'Canceladas', 'color' => '--color-zinc-600', 'valor' => $estadisticas['cancelada']],
        ] as $card)
            <div
                class="bg-[var({{ $card['color'] }})] dark:bg-[var(--color-zinc-800)] text-[var(--color-zinc-950)] dark:text-[var(--color-zinc-100)] text-center p-4 rounded-lg shadow">
                <h3 class="text-sm font-semibold uppercase tracking-wide">{{ $card['label'] }}</h3>
                <p class="text-2xl font-bold">{{ $card['valor'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Tabla de Citas --}}
    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full border border-[var(--color-zinc-300)] dark:border-[var(--color-zinc-700)] bg-white dark:bg-[var(--color-zinc-900)] rounded-lg shadow-sm">
            <thead class="bg-[var(--color-zinc-100)] dark:bg-[var(--color-zinc-800)]">
                <tr class="text-left text-sm text-[var(--color-zinc-700)] dark:text-[var(--color-zinc-300)]">
                    <th class="px-4 py-2 border-b">Donante</th>
                    <th class="px-4 py-2 border-b">Fecha</th>
                    <th class="px-4 py-2 border-b">Estado</th>
                    <th class="px-4 py-2 border-b text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse ($citas as $cita)
                    <tr class="hover:bg-[var(--color-zinc-100)] dark:hover:bg-[var(--color-zinc-800)] transition">
                        <td class="px-4 py-2 border-b">{{ $cita->user->name ?? 'Sin nombre' }}</td>
                        <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 border-b">
                            @php
                                $color = match ($cita->estado) {
                                    'agendada' => 'text-[var(--color-zinc-700)] dark:text-[var(--color-zinc-200)]',
                                    'confirmada' => 'text-[var(--color-tamarillo-600)] dark:text-[var(--color-tamarillo-300)]',
                                    'cancelada' => 'text-[var(--color-tamarillo-800)] dark:text-[var(--color-tamarillo-100)]',
                                    default => 'text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-300)]',
                                };
                            @endphp
                            <span class="font-semibold {{ $color }}">{{ ucfirst($cita->estado) }}</span>
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            @if ($cita->estado === 'agendada')
                                <button wire:click="cambiarEstado({{ $cita->id }}, 'confirmada')"
                                    class="px-3 py-1.5 text-white text-xs rounded bg-[var(--color-tamarillo-600)] hover:bg-[var(--color-tamarillo-700)] transition">
                                    Confirmar
                                </button>
                                <button wire:click="cambiarEstado({{ $cita->id }}, 'cancelada')"
                                    class="px-3 py-1.5 text-white text-xs rounded bg-[var(--color-tamarillo-800)] hover:bg-[var(--color-tamarillo-900)] transition">
                                    Cancelar
                                </button>
                            @else
                                <span class="text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-300)]">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="text-center text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-400)] py-8 italic">
                            No hay citas para mostrar en este modo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $citas->links() }}
    </div>
</div>
