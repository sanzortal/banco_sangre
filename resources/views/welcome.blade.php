<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cruz Roja - Donación de sangre en la Comunidad de Madrid</title>

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
    <main class="bg-zinc-100">
        <!-- Hero -->
        <section
            class="hero-section min-h-screen flex flex-col-reverse md:flex-row items-center container mx-auto px-4 py-10">
            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-extrabold text-zinc-900 mb-4 leading-tight">
                    LA SOLIDARIDAD CORRE POR TUS VENAS, COMPÁRTELA.
                </h1>
                <p class="text-gray-600 text-lg md:text-2xl py-6">
                    <strong>Cada gota cuenta.</strong> Cuando decides donar sangre, no solo ayudas a quien lo necesita,
                    también te
                    conviertes en parte de una red silenciosa de personas solidarias que creen en un mundo más justo,
                    más humano y más unido. <strong>Hoy, tu gesto puede marcar la diferencia.</strong>
                </p>
            </div>
            <div class="md:w-1/2 flex justify-center items-center mb-6 md:mb-0">
                <img src="{{ asset('img/imagen-donar-sangre-gotin.png') }}" alt="Donación" class="max-w-full h-auto" />
            </div>
        </section>

        <!-- Semáforo de necesidades -->
        <section class="container mx-auto px-4 py-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-zinc-700 mb-6 text-center md:text-left">SEMÁFORO DE
                NECESIDADES</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <ul class="space-y-4 text-xl md:text-2xl text-gray-700">
                        <li><ion-icon class="text-[#E20514]" name="ellipse"></ion-icon> Dona hoy</li>
                        <li><ion-icon class="text-[#F5A623]" name="ellipse"></ion-icon> Dona en los próximos días</li>
                        <li><ion-icon class="text-[#63B73D]" name="ellipse"></ion-icon> Dona en las próximas semanas
                        </li>
                    </ul>
                </div>
                <div class="semaforo flex flex-wrap gap-1 justify-center md:justify-start">
                    @foreach ($niveles as $reserva)
                        @php
                            $color = match ($reserva->nivel) {
                                'alto' => '#63B73D',
                                'medio' => '#F5A623',
                                'bajo' => '#E20514',
                                default => '#999'
                            };
                        @endphp

                        <div class="semaforo_card text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="53" height="64" viewBox="0 0 73 84" fill="none">
                                <g filter="url(#filter0_i_54_68)">
                                    <path
                                        d="M73 49.7143C73 68.6498 56.6584 84 36.5 84C16.3416 84 0 68.6498 0 49.7143C0 30.7788 16.3416 0 36.5 0C56.6584 0 73 30.7788 73 49.7143Z"
                                        fill="{{ $color }}" />
                                </g>
                            </svg>
                            <div class="nivel_reserva text-lg md:text-2xl">
                                {{ $reserva->tipo_sangre }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Información -->
        <section class="py-16 container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-md space-y-4">
                    <div class="text-tamarillo-600 text-5xl"><ion-icon name="bus"></ion-icon></div>
                    <p class="font-extrabold text-xl">Hoy puedes donar en:</p>
                    <p>Madrid...</p>
                    <a href="{{url('/puntos-moviles')}}"
                        class="block text-center font-bold bg-zinc-700 text-white px-4 py-2 rounded-xl hover:bg-zinc-600">
                        Próximos puntos móviles
                    </a>
                </div>
                <div class="bg-tamarillo-600 text-white p-6 rounded-2xl shadow-md space-y-4">
                    <div class="text-zinc-700 text-5xl"><ion-icon name="help-circle"></ion-icon></div>
                    <p class="font-extrabold text-xl">¿Puedo donar?</p>
                    <p>Sácate de dudas y...</p>
                    <a href="{{ url('haz-test') }}"
                        class="block text-center font-bold bg-white text-tamarillo-600 px-4 py-2 rounded-xl hover:bg-tamarillo-100">
                        Haz el test
                    </a>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md space-y-4">
                    <div class="text-tamarillo-600 text-5xl"><ion-icon name="location"></ion-icon></div>
                    <p class="font-extrabold text-xl">Siempre puedes venir a uno de nuestros puntos fijos de donación
                    </p>
                    <a href="{{url('/puntos-fijos')}}"
                        class="block text-center font-bold bg-zinc-700 text-white px-4 py-2 rounded-xl hover:bg-zinc-600">
                        Más información
                    </a>
                </div>
            </div>
        </section>

        <!-- About -->
        <section
            class="px-4 md:px-10 py-16 rounded-xl bg-gradient-to-br from-tamarillo-600 via-tamarillo-600 to-tamarillo-600 text-gray-800 container mx-auto shadow-inner">
            <div class="max-w-4xl mx-auto text-center space-y-6">
                <h2 class="text-4xl font-bold text-zinc-50">¿Quiénes somos?</h2>
                <p class="text-lg leading-relaxed text-zinc-50">Promovemos la donación de sangre en toda la Comunidad de
                    Madrid. Un
                    acto solidario que puede salvar vidas.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left mt-6">
                    <div class="bg-zinc-700 p-6 rounded-xl shadow">
                        <h3 class="text-xl font-semibold text-zinc-50 mb-2">🎯 Misión</h3>
                        <p class="text-zinc-50">Salvar vidas mediante la solidaridad, promoviendo la donación
                            voluntaria, altruista y
                            responsable de sangre.</p>
                    </div>
                    <div class="bg-zinc-700 p-6 rounded-xl shadow">
                        <h3 class="text-xl font-semibold text-zinc-50 mb-2">🌍 Visión</h3>
                        <p class="text-zinc-50">Construir una sociedad donde donar sangre sea un hábito natural, creando
                            una red de donantes
                            comprometidos y empáticos.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección: Atención y Frecuencia -->
        <section class="py-12 px-4 md:px-16">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-10">
                <!-- Bloque de atención -->
                <div class="flex items-center gap-6 w-full md:w-1/2">
                    <img src="{{ asset('img/imagen-explicando-gotin.png') }}" alt="Gotín" class="w-32 h-auto">
                    <div>
                        <p class="text-xl font-medium text-gray-800">Teléfono de Atención<br>al Donante:</p>
                        <p class="text-2xl md:text-3xl font-extrabold underline mt-2 text-black">900 506 819</p>
                    </div>
                </div>

                <!-- Bloque de botones con info emergente -->
                <div class="flex flex-col gap-4 w-full md:w-1/2">
                    <div x-data="{ mostrarMujer: false }">
                        <button @click="mostrarMujer = true"
                            class="flex items-center gap-3 bg-tamarillo-600 hover:bg-tamarillo-700 text-zinc-50 font-bold py-2 px-4 rounded w-full justify-center">
                            <ion-icon name="female-outline" class="text-2xl"></ion-icon>
                            Información para Mujeres
                        </button>

                        <!-- Modal mujer -->
                        <div x-show="mostrarMujer" x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                            <div @click.away="mostrarMujer = false"
                                class="bg-white p-6 rounded-xl shadow-lg w-80 text-center space-y-4">
                                <h3 class="text-xl font-bold text-tamarillo-600">👩 Como mujer</h3>
                                <p>Puedes donar <strong>hasta 3 veces al año</strong>.</p>
                                <button @click="mostrarMujer = false"
                                    class="bg-tamarillo-600 text-white px-4 py-1 rounded hover:bg-tamarillo-700">Cerrar</button>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ mostrarHombre: false }">
                        <button @click="mostrarHombre = true"
                            class="flex items-center gap-3 bg-tamarillo-600 hover:bg-tamarillo-700 text-zinc-50 font-bold py-2 px-4 rounded w-full justify-center">
                            <ion-icon name="male-outline" class="text-2xl"></ion-icon>
                            Información para Hombres
                        </button>

                        <!-- Modal hombre -->
                        <div x-show="mostrarHombre" x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                            <div @click.away="mostrarHombre = false"
                                class="bg-white p-6 rounded-xl shadow-lg w-80 text-center space-y-4">
                                <h3 class="text-xl font-bold text-tamarillo-600">👨 Como hombre</h3>
                                <p>Puedes donar <strong>hasta 4 veces al año</strong>.</p>
                                <button @click="mostrarHombre = false"
                                    class="bg-tamarillo-600 text-white px-4 py-1 rounded hover:bg-tamarillo-700">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                <li><a href="{{url('/organiza-tu-campania-donacion')}}" class="hover:underline">Organiza tu
                        campaña</a>
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

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- Script para iconos --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>