<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Donación de sangre en la Comunidad de Madrid</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-100 text-[#1b1b18]">
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
    <main class="flex flex-col justify-center p-10 h-screen">
        <h1 class="text-5xl font-bold text-center text-zinc-600 mb-6">¿Puedo donar?</h1>
        <h2 class="text-3xl text-center text-zinc-600 mb-6">Compruébalo haciendo este test</h2>
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md">
            <form x-data="{
            paso: 1,
            haDonado: '',
            haceDosMeses: '',
            salud: '',
            edad: '',
            peso: '',
            embarazada: '',
            actividad: '',
            puedeDonar() {
                return this.haDonado === 'no'
                    || (this.haceDosMeses === 'si'
                        && this.salud === 'si'
                        && this.edad === 'si'
                        && this.peso === 'si'
                        && this.embarazada === 'no'
                        && this.actividad === 'no');
            },
            resultado() {
                return this.puedeDonar() ? 'Puedes donar sangre. ¡Gracias por tu solidaridad!' : 'No puedes donar sangre en este momento.';
            }
        }" class="space-y-4">

                <template x-if="paso === 1">
                    <div class="flex flex-col items-center">
                        <p class="text-2xl font-semibold mb-2">¿Has donado alguna vez?</p>
                        <div>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="haDonado = 'si'; paso = 2">Sí</button>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="haDonado = 'no'; paso = 3">No</button>
                        </div>
                    </div>
                </template>

                <template x-if="paso === 2">
                    <div class="flex flex-col items-center">
                        <p class="text-2xl font-semibold mb-2">¿Hace más de 2 meses desde la última
                            vez?
                        </p>
                        <div>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="haceDosMeses = 'si'; paso = 3">Sí</button>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="haceDosMeses = 'no'; paso = 99">No</button>
                        </div>
                    </div>
                </template>

                <template x-if="paso === 3">
                    <div class="flex flex-col items-center">
                        <p class="text-2xl font-semibold mb-2">¿Estás bien de salud?</p>
                        <div>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="salud = 'si'; paso = 4">Sí</button>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="salud = 'no'; paso = 99">No</button>
                        </div>
                    </div>
                </template>

                <template x-if="paso === 4">
                    <div class="flex flex-col items-center">
                        <p class="text-2xl font-semibold mb-2">¿Tienes más de 18 años?</p>
                        <div>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="edad = 'si'; paso = 5">Sí</button>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="edad = 'no'; paso = 99">No</button>
                        </div>
                    </div>
                </template>

                <template x-if="paso === 5">
                    <div class="flex flex-col items-center">
                        <p class="text-2xl font-semibold mb-2">¿Pesas más de 50kg?</p>
                        <div>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="peso = 'si'; paso = 6">Sí</button>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="peso = 'no'; paso = 99">No</button>
                        </div>
                    </div>
                </template>

                <template x-if="paso === 6">
                    <div class="flex flex-col items-center">
                        <p class="text-2xl font-semibold mb-2">¿Estás embarazada?</p>
                        <div>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="embarazada = 'no'; paso = 7">No</button>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="embarazada = 'si'; paso = 99">Sí</button>
                        </div>
                    </div>
                </template>

                <template x-if="paso === 7">
                    <div class="flex flex-col items-center">
                        <p class="text-2xl font-semibold mb-2">¿Realizas alguna actividad peligrosa?</p>
                        <div>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="actividad = 'no'; paso = 100">No</button>
                            <button type="button" class="btn px-10 py-2 text-zinc-50 bg-tamarillo-600 rounded-2xl"
                                @click="actividad = 'si'; paso = 99">Sí</button>
                        </div>
                    </div>
                </template>

                <template x-if="paso === 99">
                    <div class="text-center text-zinc-600 font-semibold flex flex-col gap-6">
                        <p class="text-3xl">🥹</p>
                        <p class="text-3xl">Lo sentimos.</p>
                        <p class=" text-center text-zinc-400 font-semibold text-2xl">
                            En esta ocasión no puedes donar.
                            Si quieres saber más, llámanos al <strong class="text-tamarillo-400 font-extrabold">900 506
                                819</strong> o
                            acércate a un punto de
                            donación y el
                            personal sanitario valorará tu situación.
                            También tienes otras formas de ayudar <strong
                                class="text-tamarillo-400 font-extrabold">Hazte Voluntari@</strong>
                        </p>
                    </div>
                </template>

                <template x-if="paso === 100">
                    <div class="text-center text-zinc-600 font-semibold text-2xl grid grid-rows-3">
                        <p>❤️</p>
                        <p>Felicidades, hoy puedes donar sangre</p>
                        <p class=" text-center text-zinc-600 font-semibold text-sm">
                            * Antes de donar sangre tendrá que rellenar un formulario y pasar una entrevista médica en
                            la
                            que se valorará su salud y se determinará si puede donar sangre.

                        </p>
                    </div>
                </template>
            </form>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- Script para iconos --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>