<div
    class="max-w-3xl mx-auto bg-white dark:bg-zinc-900 p-8 rounded-2xl shadow-xl space-y-8 text-zinc-800 dark:text-zinc-100 transition">

    <div class="space-y-1">
        <h2 class="text-3xl font-extrabold flex items-center gap-2 text-tamarillo-700 dark:text-tamarillo-400">
            🩺 Reserva tu próxima cita
        </h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">Elige el centro, la fecha y la hora que más te convenga.</p>
    </div>

    @if($tieneCitaPendiente)
        <div
            class="bg-yellow-100 dark:bg-yellow-800/30 border border-yellow-400 dark:border-yellow-600 text-yellow-800 dark:text-yellow-100 px-4 py-3 rounded-md">
            ⚠️ Ya tienes una cita pendiente. Espera a que sea confirmada o cancelada para agendar otra.
        </div>
    @endif

    @if (session('message'))
        <div
            class="bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-md">
            ✅ {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div
            class="bg-red-100 dark:bg-red-900 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-md">
            ❌ {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="reservar" class="space-y-6">

        {{-- Paso 1: Centro --}}
        <div>
            <label class="block text-sm font-semibold mb-1">
                🏥 Centro de donación
            </label>
            <select wire:model="centro_id"
                class="w-full bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 border border-zinc-300 dark:border-zinc-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-tamarillo-500">
                <option value="">— Selecciona un centro —</option>
                @foreach ($centros as $centro)
                    <option value="{{ $centro->id }}">{{ $centro->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Paso 2: Fecha --}}
        <div>
            <label class="block text-sm font-semibold mb-1">
                📅 Fecha disponible
            </label>
            <input type="date" wire:model="fecha" min="{{ $fechaProximaDonacion->format('Y-m-d') }}"
                class="w-full bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 border border-zinc-300 dark:border-zinc-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-tamarillo-500">
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                Puedes agendar a partir del <strong>{{ $fechaProximaDonacion->format('d/m/Y') }}</strong>.
            </p>
        </div>

        {{-- Paso 3: Hora --}}
        <div>
            <label class="block text-sm font-semibold mb-1">
                ⏰ Hora
            </label>
            @if (!empty($horasDisponibles))
                <select wire:model="hora"
                    class="w-full bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 border border-zinc-300 dark:border-zinc-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-tamarillo-500">
                    <option value="">— Selecciona una hora —</option>
                    @foreach ($horasDisponibles as $item)
                        <option value="{{ $item['hora'] }}" @if($item['disponibles'] === 0) disabled @endif>
                            {{ $item['hora'] }}
                            @if($item['disponibles'] === 0)
                                (Sin disponibilidad)
                            @else
                                ({{ $item['disponibles'] }} disponibles)
                            @endif
                        </option>
                    @endforeach
                </select>
            @elseif($fecha && $centro_id)
                <p class="text-sm text-red-600 dark:text-red-400">
                    ⚠️ No hay horarios disponibles para ese día o todos los bloques están ocupados.
                </p>
            @endif
        </div>

        {{-- Botón --}}
        <div class="pt-4 text-end">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2 bg-tamarillo-600 hover:bg-tamarillo-700 text-white font-semibold rounded-full shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed"
                @if($tieneCitaPendiente) disabled @endif>
                📤 Reservar cita
            </button>
        </div>
    </form>
</div>