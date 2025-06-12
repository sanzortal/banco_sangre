<div class="p-6 space-y-10 bg-white dark:bg-zinc-900 rounded-2xl shadow-xl text-zinc-800 dark:text-zinc-100 transition">

    {{-- Encabezado --}}
    <div class="flex items-center gap-3">
        <div class="text-3xl">🏥</div>
        <h2 class="text-3xl font-extrabold text-tamarillo-700 dark:text-tamarillo-400 tracking-tight">
            Historial de Donaciones
        </h2>
    </div>
    <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-2xl">Consulta tus centros visitados, cuántas veces has
        donado en cada uno y accede al detalle de tus contribuciones.</p>

    @if ($agrupadas->count())
        {{-- Grid creativa con "Tarjetas interactivas animadas" --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($agrupadas as $centroId => $item)
                <div wire:click="verDetalle({{ $centroId }})"
                    class="relative bg-gradient-to-br from-zinc-50 dark:from-zinc-800 via-white dark:via-zinc-900 to-zinc-100 dark:to-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-xl p-6 cursor-pointer transition hover:-translate-y-1 hover:shadow-2xl group overflow-hidden">

                    {{-- Badge flotante --}}
                    <div class="absolute top-0 right-0 m-3 text-xs px-2 py-1 bg-tamarillo-600 text-white rounded-full shadow">🩸
                        {{ $item['total'] }} Donaciones
                    </div>

                    {{-- Centro Info --}}
                    <div class="space-y-1">
                        <h3 class="text-xl font-bold text-tamarillo-700 dark:text-tamarillo-400">
                            {{ $item['nombre'] }}
                        </h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            📍 {{ $item['direccion'] }}
                        </p>
                    </div>

                    {{-- Visual de barras --}}
                    <div class="mt-4">
                        <div class="h-2 rounded bg-zinc-200 dark:bg-zinc-700 overflow-hidden">
                            <div class="h-full bg-red-500 dark:bg-tamarillo-500 transition-all"
                                style="width: {{ min(100, $item['total'] * 10) }}%"></div>
                        </div>
                        <p class="text-xs text-zinc-400 mt-1">Nivel de compromiso en este centro</p>
                    </div>

                    {{-- Call to Action --}}
                    <div class="mt-4 text-right">
                        <button class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline transition">
                            Ver detalle →
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-zinc-500 dark:text-zinc-400 italic text-center">No se encontraron donaciones registradas.</p>
    @endif

    {{-- Modal de Detalle --}}
    @if($modalAbierto)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center px-4">
            <div
                class="bg-white dark:bg-zinc-900 w-full max-w-xl rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-700 p-6 space-y-5">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-red-600 dark:text-tamarillo-400">
                        📋 Donaciones en {{ $modalTitulo }}
                    </h3>
                    <button wire:click="$set('modalAbierto', false)"
                        class="text-2xl font-bold text-zinc-400 hover:text-red-600 transition">
                        &times;
                    </button>
                </div>

                {{-- Timeline --}}
                <ul class="divide-y divide-zinc-200 dark:divide-zinc-700 max-h-80 overflow-y-auto">
                    @foreach ($donacionesCentro as $d)
                        <li class="py-3 flex items-center gap-3">
                            <div class="w-3 h-3 bg-red-600 dark:bg-tamarillo-400 rounded-full flex-shrink-0"></div>
                            <div class="text-sm text-zinc-700 dark:text-zinc-100">
                                {{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i') }}
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Footer --}}
                <div class="text-end pt-3">
                    <button wire:click="$set('modalAbierto', false)"
                        class="px-5 py-2 bg-zinc-700 dark:bg-zinc-600 text-white rounded-md hover:bg-zinc-800">
                        ✖️ Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>