<div class="p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-md text-zinc-900 dark:text-zinc-100">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Nivel de reserva') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Aquí podrás ver el nivel de stock de sangre actualmente, además de actualizarlo.') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Mensaje flash --}}
    @if (session('message'))
        <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded shadow">
            {{ session('message') }}
        </div>
    @endif
    {{-- Tarjetas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($niveles as $nivel)
            <div
                class="bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-600 rounded-xl p-5 space-y-3 shadow-sm">

                <h3 class="text-lg font-bold text-red-700 dark:text-tamarillo-400">🧬 {{ $nivel->tipo_sangre }}</h3>

                <p class="text-sm text-zinc-600 dark:text-zinc-300">Cantidad: <strong>{{ $nivel->cantidad }}</strong> bolsas
                    (0.45L)</p>

                <span class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full
                                            {{
            match ($nivel->nivel) {
                'bajo' => 'bg-red-600',
                'medio' => 'bg-yellow-400 text-black',
                'alto' => 'bg-green-600',
                default => 'bg-gray-500'
            }
                                            }}">
                    Nivel: {{ ucfirst($nivel->nivel) }}
                </span>

                <div class="text-right">
                    <button wire:click="editar({{ $nivel->id }})"
                        class="text-sm bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition shadow">
                        ✏️ Editar
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal de edición --}}
    @if ($editando && $nivelEditando)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center px-4">
            <div
                class="bg-white dark:bg-zinc-900 border dark:border-zinc-700 rounded-xl p-6 w-full max-w-md shadow-lg space-y-4">

                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-red-600 dark:text-tamarillo-400">
                        🖊️ Editar cantidad: {{ $nivelEditando->tipo_sangre }}
                    </h3>
                    <button wire:click="cerrarModal"
                        class="text-2xl font-bold text-zinc-400 hover:text-red-500">&times;</button>
                </div>

                <div class="space-y-2">
                    <label class="text-sm text-zinc-700 dark:text-zinc-300">Cantidad en bolsas</label>
                    <input type="number" min="0" wire:model.defer="cantidadEditada"
                        class="w-full rounded-md px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 text-sm" />
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <button wire:click="cerrarModal"
                        class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-800 dark:text-white rounded hover:bg-zinc-300 dark:hover:bg-zinc-600">
                        Cancelar
                    </button>
                    <button wire:click="actualizarCantidad"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 shadow">
                        💾 Guardar cambios
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>