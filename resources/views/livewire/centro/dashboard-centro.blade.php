<div class="p-6">
    <flux:heading size="xl" level="1">
        {{ __('¡Bienvenido/a de vuelta, ' . (auth()->user()->name ?? 'Usuario') . '!') }}
    </flux:heading>

    <flux:subheading size="lg" class="mb-6">
        {{ __('Gestiona tu centro de donación: revisa tus datos, maneja tus citas y estadísticas.') }}
    </flux:subheading>

    <flux:separator variant="subtle" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- 🏥 Información del Centro -->
        <div
            class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-lg border border-zinc-200 dark:border-zinc-700 transition-transform hover:scale-[1.02]">
            <div class="absolute top-0 right-0 opacity-10 text-9xl pointer-events-none">🏥</div>
            <h3 class="text-xl font-bold text-red-600 dark:text-tamarillo-400 mb-4">Centro de Donación</h3>
            <div class="space-y-2 text-sm text-zinc-700 dark:text-zinc-200">
                <p><strong class="text-zinc-500">📛 Nombre:</strong> {{ auth()->user()->name }}</p>
                <p><strong class="text-zinc-500">📍 Dirección:</strong> {{ auth()->user()->centro->direccion ?? '-' }}
                </p>
                <p><strong class="text-zinc-500">📞 Teléfono:</strong> {{ auth()->user()->centro->telefono ?? '-' }}</p>
                <p><strong class="text-zinc-500">✉️ Email:</strong> {{ auth()->user()->email }}</p>
            </div>
        </div>

        <!-- 🩸 Total Donaciones -->
        <div
            class="bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900 dark:to-green-800 text-zinc-800 dark:text-green-100 p-6 rounded-2xl shadow-lg flex items-center justify-between hover:scale-[1.02] transition-transform">
            <div>
                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">Donaciones registradas</h3>
                <p class="text-5xl font-extrabold mt-2">{{ $totalDonaciones }}</p>
            </div>
            <div class="text-5xl opacity-40">🩸</div>
        </div>

        <!-- 🔗 Accesos rápidos -->
        <div
            class="bg-gradient-to-tr from-blue-100 to-blue-200 dark:from-zinc-800 dark:to-zinc-700 p-6 rounded-2xl shadow-lg hover:scale-[1.02] transition-transform">
            <h3 class="text-lg font-bold text-blue-800 dark:text-blue-300 mb-4">Accesos rápidos</h3>
            <ul class="space-y-3 text-zinc-800 dark:text-zinc-100 text-sm">
                <li>
                    <a href="{{ route('centro.editar-horario') }}"
                        class="flex items-center gap-2 hover:underline hover:text-blue-600 transition">
                        🕒 Ver / editar horario
                    </a>
                </li>
                <li>
                    <a href="{{ route('centro.citas') }}"
                        class="flex items-center gap-2 hover:underline hover:text-blue-600 transition">
                        📅 Ver agenda de citas
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>