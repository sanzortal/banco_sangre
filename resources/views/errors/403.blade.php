<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>403 No tienes permiso para acceder aquí</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18]">
    <header class="fixed top-0 left-0 z-50 w-full bg-zinc-50 px-4 sm:px-6 lg:px-8 py-4 shadow-sm">
        @if (Route::has('login'))
            <nav class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-4">
                <!-- Logo + texto -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img src="{{ asset('img/logocruzroja@2x1.png') }}" alt="Logo de cruz roja" class="h-9 w-auto">
                        <!-- Oculta el texto en pantallas pequeñas -->
                        <span class="font-light text-xl border-l border-zinc-900 pl-3 hidden sm:inline-block">
                            Donación de Sangre
                        </span>
                    </a>
                </div>

                <!-- Botones -->
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-[#1b1b18] rounded text-sm sm:text-base">
                            Mi Dashboard
                            <ion-icon name="person-circle-outline" class="text-xl"></ion-icon>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-[#1b1b18] rounded text-sm sm:text-base">
                            Iniciar Sesión
                            <ion-icon name="log-in-outline" class="text-xl"></ion-icon>
                        </a>
                    @endauth
                </div>
            </nav>
        @endif
    </header>
    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

    <!-- Contenido principal aquí -->
    <main class="min-h-screen bg-zinc-100 flex flex-col justify-center items-center text-center p-10">
        <img src="{{ asset('img/imagen-triste-gotin.png') }}" class="h-80 mb-6"
            alt="Imagen triste gotín mascota para donar sangre" />
        <h1 class="text-5xl font-extrabold text-tamarillo-600 mb-4">🚫 403 - Acceso Denegado</h1>
        <p class="text-gray-600 text-lg mb-6">Lo sentimos, no hemos podido encontrar lo que buscas.</p>
        <a href="{{ url('/') }}" class="bg-tamarillo-600 text-zinc-50 px-5 py-2 rounded hover:bg-red-700">
            Volver al inicio
        </a>
    </main>

    <!-- Footer -->
    <footer class="bg-zinc-700 text-zinc-50">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-10 text-sm sm:text-base">
            <!-- Logo y título -->
            <div class="text-center md:text-left">
                <img src="{{ asset('img/logocruzrojablanco@2x1.png') }}" alt="Logo" class="h-20 mx-auto md:mx-0 mb-2" />
                <span class="text-xl font-semibold block">Donación de sangre</span>
            </div>

            <!-- Enlaces columna 1 -->
            <ul class="space-y-2 text-center md:text-left">
                <li><a href="{{url('/puntos-moviles')}}" class="hover:underline">Próximos puntos móviles</a></li>
                <li><a href="{{url('/empresas')}}" class="hover:underline">Empresas</a></li>
                <li><a href="{{url('/hazte-voluntario')}}" class="hover:underline">Hazte voluntario</a></li>
                <li><a href="{{url('/centros-docentes')}}" class="hover:underline">Centros docentes</a></li>
            </ul>

            <!-- Enlaces columna 2 -->
            <ul class="space-y-2 text-center md:text-left">
                <li><a href="{{url('/organiza-tu-campania-donacion')}}" class="hover:underline">Organiza tu campaña</a>
                </li>
                <li><a href="{{url('/cual-es-tu-razon')}}" class="hover:underline">¿Cuál es tu razón?</a></li>
                <li><a href="{{url('/todo-sobre-donacion')}}" class="hover:underline">Sobre la donación</a></li>
            </ul>
        </div>

        <div
            class="bg-tamarillo-600 flex flex-col sm:flex-row justify-between items-center px-6 py-6 text-center sm:text-left text-xs sm:text-sm">
            <div class="mb-4 sm:mb-0 space-y-2">
                <ul class="flex flex-wrap justify-center sm:justify-start gap-3">
                    <li><a href="{{url('/contacto')}}" class="hover:underline">Contacto</a></li>
                    <li><a href="{{url('/aviso-legal')}}" class="hover:underline">Aviso legal</a></li>
                    <li><a href="{{url('/politica-privacidad')}}" class="hover:underline">Privacidad</a></li>
                    <li><a href="{{url('/politica-cookies')}}" class="hover:underline">Cookies</a></li>
                    <li><a href="{{url('/creditos')}}" class="hover:underline">Créditos</a></li>
                    <li><a href="{{url('/quienes-somos')}}" class="hover:underline">¿Quiénes somos?</a></li>
                    <li><a href="{{url('/canal-denuncias')}}" class="hover:underline">Denuncias</a></li>
                </ul>
                <span class="block font-bold mt-2">&copy; Cruz Roja Española {{ date('Y') }}. Todos los derechos
                    reservados.</span>
            </div>

            <div class="flex justify-center gap-4 text-2xl">
                <a href="https://facebook.com/CruzRoja.es"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="https://x.com/DonasangreCruzR"><ion-icon name="logo-twitter"></ion-icon></a>
                <a href="https://linkedin.com/company/cruz-roja-donación-de-sangre"><ion-icon
                        name="logo-linkedin"></ion-icon></a>
                <a href="https://instagram.com/cruzrojadonasangre"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="https://youtube.com/@donaciondesangrecruzroja9663/videos"><ion-icon
                        name="logo-youtube"></ion-icon></a>
            </div>
        </div>
    </footer>

    {{-- Script para iconos --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>