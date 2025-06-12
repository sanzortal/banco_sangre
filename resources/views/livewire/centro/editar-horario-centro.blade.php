<div
    class="p-6 text-[var(--color-zinc-900)] dark:text-[var(--color-zinc-100)] bg-white dark:bg-[var(--color-zinc-900)] rounded-xl shadow-md space-y-6">

    <h2 class="text-3xl font-bold text-[var(--color-tamarillo-700)] dark:text-tamarillo-400">🕒 Horarios del Centro</h2>

    @if (session('message'))
        <div
            class="bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-2 rounded shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    @php
        $emojis = [
            'lunes' => '🌞',
            'martes' => '🌤️',
            'miércoles' => '☁️',
            'jueves' => '🌧️',
            'viernes' => '🌈',
            'sábado' => '🎉',
            'domingo' => '🛌',
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($diasSemana as $dia)
            <div x-data="{ open: false }" class="relative">
                {{-- 📅 Card --}}
                <div @click="open = true"
                    class="cursor-pointer bg-[var(--color-zinc-50)] dark:bg-[var(--color-zinc-800)] border border-[var(--color-zinc-200)] dark:border-[var(--color-zinc-700)] rounded-2xl shadow-md hover:shadow-lg transition p-6 space-y-2">
                    <div class="text-2xl font-extrabold">
                        {{ $emojis[$dia] ?? '📅' }} <span class="capitalize">{{ $dia }}</span>
                    </div>
                    <div class="text-[var(--color-zinc-600)] dark:text-[var(--color-zinc-300)]">
                        🕒 {{ $horarios[$dia]['hora_inicio'] ?? '--:--' }} - {{ $horarios[$dia]['hora_fin'] ?? '--:--' }}
                    </div>
                    <div class="text-sm text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-400)]">
                        👥 Aforo: {{ $horarios[$dia]['aforo'] ?? 0 }} <br>⏱️ Duración:
                        {{ $horarios[$dia]['duracion_bloque'] ?? 0 }} min
                    </div>
                </div>

                {{-- 🧩 Modal --}}
                <div x-show="open" x-transition @click.away="open = false"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
                    <div
                        class="bg-white dark:bg-[var(--color-zinc-800)] p-6 rounded-2xl shadow-xl w-full max-w-md space-y-4 border border-[var(--color-zinc-200)] dark:border-[var(--color-zinc-600)]">

                        <h3 class="text-xl font-bold text-red-600 dark:text-tamarillo-400 mb-4">
                            {{ $emojis[$dia] ?? '📅' }} {{ ucfirst($dia) }}
                        </h3>

                        <div class="grid gap-4">
                            <div>
                                <label class="text-sm font-semibold block mb-1">Inicio:</label>
                                <input type="time" wire:model.defer="horarios.{{ $dia }}.hora_inicio"
                                    class="w-full rounded px-3 py-2 border border-[var(--color-zinc-300)] dark:border-[var(--color-zinc-600)] bg-white dark:bg-[var(--color-zinc-900)] text-[var(--color-zinc-800)] dark:text-[var(--color-zinc-100)] shadow-sm" />
                            </div>

                            <div>
                                <label class="text-sm font-semibold block mb-1">Fin:</label>
                                <input type="time" wire:model.defer="horarios.{{ $dia }}.hora_fin"
                                    class="w-full rounded px-3 py-2 border border-[var(--color-zinc-300)] dark:border-[var(--color-zinc-600)] bg-white dark:bg-[var(--color-zinc-900)] text-[var(--color-zinc-800)] dark:text-[var(--color-zinc-100)] shadow-sm" />
                            </div>

                            <div>
                                <label class="text-sm font-semibold block mb-1">Duración (min):</label>
                                <input type="number" min="1" wire:model.defer="horarios.{{ $dia }}.duracion_bloque"
                                    class="w-full rounded px-3 py-2 border border-[var(--color-zinc-300)] dark:border-[var(--color-zinc-600)] bg-white dark:bg-[var(--color-zinc-900)] text-[var(--color-zinc-800)] dark:text-[var(--color-zinc-100)] shadow-sm" />
                            </div>

                            <div>
                                <label class="text-sm font-semibold block mb-1">Aforo:</label>
                                <input type="number" min="1" wire:model.defer="horarios.{{ $dia }}.aforo"
                                    class="w-full rounded px-3 py-2 border border-[var(--color-zinc-300)] dark:border-[var(--color-zinc-600)] bg-white dark:bg-[var(--color-zinc-900)] text-[var(--color-zinc-800)] dark:text-[var(--color-zinc-100)] shadow-sm" />
                            </div>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button @click="open = false"
                                class="px-4 py-2 bg-gray-200 dark:bg-[var(--color-zinc-700)] text-gray-800 dark:text-[var(--color-zinc-100)] rounded hover:bg-gray-300 dark:hover:bg-[var(--color-zinc-600)] transition">
                                Cancelar
                            </button>

                            <button wire:click="guardar" @click="open = false"
                                class="px-4 py-2 bg-[var(--color-tamarillo-600)] hover:bg-[var(--color-tamarillo-700)] text-white rounded shadow transition">
                                Guardar
                            </button>

                            <button wire:click="borrarDia('{{ $dia }}')" @click="open = false"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow transition">
                                Borrar Día
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>