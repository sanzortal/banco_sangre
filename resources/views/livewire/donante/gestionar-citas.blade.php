<div class="p-6 space-y-8 text-[var(--color-zinc-900)] dark:text-[var(--color-zinc-100)] rounded-xl min-h-screen">
    <h2
        class="text-3xl font-bold tracking-tight text-[var(--color-tamarillo-700)] dark:text-[var(--color-tamarillo-400)]">
        📅 Mis Citas
    </h2>

    {{-- Mensajes --}}
    @if (session('message'))
        <div
            class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-300 dark:border-green-700 px-4 py-3 rounded-md shadow-sm">
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div
            class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-300 dark:border-red-700 px-4 py-3 rounded-md shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-center gap-4">
        <label for="estadoFiltro" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Filtrar por
            estado:</label>
        <select wire:model="estadoFiltro" wire:change="cargarCitas"
            class="px-3 py-2 rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100">
            <option value="agendada">Agendadas</option>
            <option value="confirmada">Confirmadas</option>
            <option value="cancelada">Canceladas</option>
            <option value="">Todas</option>
        </select>
    </div>

    {{-- Grid de cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($citas as $cita)
            <div
                class="group bg-white dark:bg-zinc-900 rounded-2xl shadow-md hover:shadow-lg p-6 transition relative overflow-hidden border border-zinc-200 dark:border-zinc-700">

                {{-- Encabezado --}}
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3
                            class="text-lg font-bold text-[var(--color-tamarillo-700)] dark:text-[var(--color-tamarillo-400)]">
                            🏥 {{ $cita->centro->user->name ?? 'Centro sin nombre' }}
                        </h3>
                        <p class="text-sm text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-400)]">
                            {{ $cita->centro->direccion ?? '-' }}
                        </p>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full font-semibold capitalize @class([
                        'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' => $cita->estado === 'agendada',
                        'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' => $cita->estado === 'confirmada',
                        'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' => $cita->estado === 'cancelada',
                        'bg-gray-200 text-gray-600 dark:bg-gray-800 dark:text-gray-300' => !in_array($cita->estado, ['agendada', 'confirmada', 'cancelada']),
                    ])">
                        {{ $cita->estado }}
                    </span>
                </div>

                {{-- Fecha y hora --}}
                <div class="text-md font-medium mb-4">
                    🕒 {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y H:i') }}
                </div>

                {{-- Acciones --}}
                @if ($editandoId === $cita->id)
                    <div class="space-y-3 border-t border-zinc-200 dark:border-zinc-700 pt-4">
                        <input type="date" wire:model="fecha"
                            class="w-full p-2 rounded bg-white dark:bg-zinc-800 border dark:border-zinc-600 text-sm" />
                        <select wire:model="hora"
                            class="w-full p-2 rounded bg-white dark:bg-zinc-800 border dark:border-zinc-600 text-sm">
                            <option value="">Selecciona hora</option>
                            @foreach ($horasDisponibles as $horaItem)
                                <option value="{{ $horaItem }}">{{ $horaItem }}</option>
                            @endforeach
                        </select>
                        <div class="flex gap-2 justify-end">
                            <button wire:click="actualizar"
                                class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700">Guardar</button>
                            <button wire:click="$set('editandoId', null)"
                                class="text-sm text-tamarillo-600 hover:underline">Cancelar</button>
                        </div>
                    </div>
                @elseif ($cita->estado === 'agendada' && \Carbon\Carbon::parse($cita->fecha)->isFuture())
                    <div class="flex justify-between mt-4 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                        <button wire:click="editar({{ $cita->id }})"
                            class="inline-flex items-center gap-1 px-4 py-2 rounded-md bg-green-400 text-white hover:bg-green-700 transition shadow">
                            ✏️ Editar
                        </button>

                        <button wire:click="confirmarCancelacion({{ $cita->id }})"
                            class="inline-flex items-center gap-1 px-4 py-2 rounded-md bg-tamarillo-600 text-white hover:bg-tamarillo-700 transition shadow">
                            ❌ Cancelar
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-400)] italic">
                No tienes citas registradas por el momento.
            </div>
        @endforelse
    </div>

    {{-- Modal --}}
    @if ($mostrarModalConfirmacion)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div
                class="bg-white dark:bg-zinc-900 p-6 rounded-xl shadow-xl w-full max-w-md text-zinc-800 dark:text-zinc-100">
                <h3 class="text-lg font-bold text-red-600 dark:text-tamarillo-400 mb-2">¿Cancelar esta cita?</h3>
                <p class="text-sm text-[var(--color-zinc-600)] dark:text-[var(--color-zinc-400)]">
                    Esta acción no se puede deshacer. Confirma si deseas continuar.
                </p>
                <div class="flex justify-end gap-3 mt-4">
                    <button wire:click="cerrarModal"
                        class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-100 rounded hover:bg-zinc-300">Volver</button>
                    <button wire:click="cancelarConfirmado"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirmar</button>
                </div>
            </div>
        </div>
    @endif

</div>