<div
    class="min-h-screen p-6 bg-gradient-to-br from-[var(--color-zinc-100)] to-[var(--color-zinc-200)] dark:from-[var(--color-zinc-900)] dark:to-[var(--color-zinc-950)] text-[var(--color-zinc-900)] dark:text-[var(--color-zinc-100)]">

    {{-- 👋 Encabezado --}}
    <div class="mb-8 text-center">
        <h1
            class="text-3xl sm:text-4xl font-extrabold tracking-tight text-[var(--color-tamarillo-700)] dark:text-tamarillo-400">
            ¡Hola {{ auth()->user()->name ?? 'Donante' }}! 👋
        </h1>
        <p class="text-sm text-[var(--color-zinc-600)] dark:text-[var(--color-zinc-300)] mt-2">
            Gracias por salvar vidas. Aquí tienes un resumen de tu impacto 💖
        </p>
    </div>

    {{-- 💳 Tarjetas principales --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- 🩸 Tipo de sangre --}}
        <div
            class="backdrop-blur bg-white/30 dark:bg-white/10 border border-white/20 dark:border-white/10 shadow-xl rounded-2xl p-6 text-center">
            <div class="text-5xl mb-2">🩸</div>
            <h3 class="text-lg font-semibold">Tu tipo de sangre</h3>
            <p class="text-3xl font-bold mt-1 text-[var(--color-tamarillo-700)] dark:text-tamarillo-400">
                {{ $tipoSangre }}
            </p>
        </div>

        {{-- ⏳ Estado de donación --}}
        <div
            class="backdrop-blur bg-white/30 dark:bg-white/10 border border-white/20 dark:border-white/10 shadow-xl rounded-2xl p-6 text-center">
            <div class="text-5xl mb-2">⏳</div>
            <h3 class="text-lg font-semibold">Próxima donación</h3>
            @if ($puedeDonar)
                <p class="text-green-600 dark:text-green-400 font-bold text-xl mt-2">✅ ¡Puedes donar hoy mismo!</p>
            @else
                <p class="text-sm mt-2">
                    Disponible en <strong>{{ $diasRestantes }}</strong> días
                    <br>
                    <span class="text-xs text-[var(--color-zinc-600)] dark:text-[var(--color-zinc-400)]">
                        {{ \Carbon\Carbon::parse($proximaFecha)->format('d/m/Y') }}
                    </span>
                </p>
            @endif
        </div>

        {{-- 📊 Donaciones totales --}}
        <div
            class="backdrop-blur bg-white/30 dark:bg-white/10 border border-white/20 dark:border-white/10 shadow-xl rounded-2xl p-6 text-center">
            <div class="text-5xl mb-2">📊</div>
            <h3 class="text-lg font-semibold">Total donaciones</h3>
            <p class="text-3xl font-bold text-red-600 dark:text-tamarillo-400 mt-2">{{ $totalDonaciones }}</p>
            <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">Este año: {{ $donacionesEsteAnio }}</p>
        </div>

    </div>

    {{-- 📅 Próxima cita --}}
    @if($proximaCita)
        <div
            class="mt-8 backdrop-blur bg-white/30 dark:bg-white/10 border border-white/20 dark:border-white/10 shadow-xl rounded-2xl p-6">
            <h3 class="text-lg font-bold mb-2 text-purple-600 dark:text-purple-400">📅 Próxima cita</h3>
            <p class="text-md font-medium">
                {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y H:i') }}
            </p>
            <p class="text-sm mt-1">
                🏥 {{ $proximaCita->centro->user->name ?? 'Sin nombre' }} <br>
                📍 {{ $proximaCita->centro->direccion ?? '-' }}
            </p>
        </div>
    @endif

    {{-- 🔗 Accesos rápidos --}}
    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('donante.reservar') }}"
            class="transition hover:-translate-y-1 bg-gradient-to-tr from-red-100 to-red-200 dark:from-red-900 dark:to-red-800 p-5 rounded-2xl text-center shadow-lg">
            <div class="text-3xl mb-2">🗓️</div>
            <h4 class="font-semibold">Agendar Cita</h4>
            <p class="text-xs text-gray-700 dark:text-gray-300">Reserva tu próxima donación.</p>
        </a>
        <a href="{{ route('donante.historial') }}"
            class="transition hover:-translate-y-1 bg-gradient-to-tr from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 p-5 rounded-2xl text-center shadow-lg">
            <div class="text-3xl mb-2">📄</div>
            <h4 class="font-semibold">Historial</h4>
            <p class="text-xs text-gray-700 dark:text-gray-300">Revisa tus donaciones pasadas.</p>
        </a>
        <a href="{{ route('donante.gestionar') }}"
            class="transition hover:-translate-y-1 bg-gradient-to-tr from-indigo-100 to-indigo-200 dark:from-indigo-900 dark:to-indigo-800 p-5 rounded-2xl text-center shadow-lg">
            <div class="text-3xl mb-2">✏️</div>
            <h4 class="font-semibold">Mis Citas</h4>
            <p class="text-xs text-gray-700 dark:text-gray-300">Gestiona y modifica tus reservas.</p>
        </a>
    </div>
</div>