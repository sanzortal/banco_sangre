<div>
    <flux:heading size="xl" level="1">
        {{ __('¡Bienvenido/a de vuelta, ' . (auth()->user()->name ?? 'Usuario') . '!') }}
    </flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __('Desde aquí puedes acceder y administrar donantes, centros, niveles de reserva y estadísticas.') }}
    </flux:subheading>
    <flux:separator variant="subtle" />
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
        <!-- Donantes -->
        <a href="{{ route('admin.donantes') }}"
            class="bg-white dark:bg-zinc-900 hover:shadow-lg transition-shadow rounded-xl p-6 shadow flex flex-col items-center justify-center text-center space-y-4">
            <div class="text-5xl text-red-600 dark:text-tamarillo-400">👥</div>
            <h3 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">Donantes</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Gestiona todos los donantes</p>
        </a>

        <!-- Centros -->
        <a href="{{ route('admin.centros') }}"
            class="bg-white dark:bg-zinc-900 hover:shadow-lg transition-shadow rounded-xl p-6 shadow flex flex-col items-center justify-center text-center space-y-4">
            <div class="text-5xl text-red-600 dark:text-tamarillo-400">🏥</div>
            <h3 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">Centros</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Administra los centros de donación</p>
        </a>

        <!-- Nivel de Reserva -->
        <a href="{{ route('admin.nivel-reserva') }}"
            class="bg-white dark:bg-zinc-900 hover:shadow-lg transition-shadow rounded-xl p-6 shadow flex flex-col items-center justify-center text-center space-y-4">
            <div class="text-5xl text-red-600 dark:text-tamarillo-400">🩸</div>
            <h3 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">Nivel de Reserva</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Visualiza y edita el stock actual</p>
        </a>

        <!-- Estadísticas -->
        <a href="{{ route('admin.estadisticas-donaciones') }}"
            class="bg-white dark:bg-zinc-900 hover:shadow-lg transition-shadow rounded-xl p-6 shadow flex flex-col items-center justify-center text-center space-y-4">
            <div class="text-5xl text-red-600 dark:text-tamarillo-400">📈</div>
            <h3 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">Estadísticas</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Consulta donaciones por centro</p>
        </a>
    </div>
</div>