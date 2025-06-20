<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                @if (auth()->user()->role === App\Enums\UserRole::Admin)
                    {{-- Rutas para usuario Admin --}}
                    <flux:navlist.item icon="users" :href="route('admin.donantes')" wire:navigate>{{ __('Donantes') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="building-office-2" :href="route('admin.centros')" wire:navigate>
                        {{ __('Centros') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="eye-dropper" :href="route('admin.nivel-reserva')" wire:navigate>
                        {{ __('Nivel Reserva') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="chart-bar" :href="route('admin.estadisticas-donaciones')" wire:navigate>
                        {{ __('Estadísticas donaciones') }}
                    </flux:navlist.item>
                @endif

                @if (auth()->user()->role === App\Enums\UserRole::Donante)
                    {{-- Rutas para usuario Donantes --}}
                    <flux:navlist.item icon="calendar-days" :href="route('donante.reservar')" wire:navigate>
                        {{ __('Reservar') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('donante.historial')" wire:navigate>
                        {{ __('Historial') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="calendar-days" :href="route('donante.gestionar')" wire:navigate>
                        {{ __('Mis citas') }}
                    </flux:navlist.item>
                @endif

                @if (auth()->user()->role === App\Enums\UserRole::Centro)
                    {{-- Rutas para usuario Centros --}}
                    <flux:navlist.item icon="calendar-days" :href="route('centro.citas')" wire:navigate>
                        {{ __('Mis Citas') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="chart-bar" :href="route('centro.estadisticas')" wire:navigate>
                        {{ __('Estadísticas') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="table-cells" :href="route('centro.editar-horario')" wire:navigate>
                        {{ __('Editar Horario') }}
                    </flux:navlist.item>
                @endif

            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Ajustes') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Cerrar sesión') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Ajustes') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Cerrar sesión') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
    {{-- Livewire styles --}}
    @livewireStyles
    @stack('scripts')

</body>

</html>