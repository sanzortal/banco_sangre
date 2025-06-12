<?php

use App\Livewire\Admin\CentrosCrud;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\DonantesCrud;
use App\Livewire\Admin\EstadisticasDonaciones;
use App\Livewire\Admin\VerNivelReserva;
use App\Livewire\Centro\CentroCitasCrud;
use App\Livewire\Centro\DashboardCentro;
use App\Livewire\Centro\EditarHorarioCentro;
use App\Livewire\Centro\EstadisticasDonacionesCentro;
use App\Livewire\Donante\DashboardDonante;
use App\Livewire\Donante\GestionarCitas;
use App\Livewire\Donante\HistorialDonaciones;
use App\Livewire\Donante\ReservarCita;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\NivelReserva;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $niveles = NivelReserva::orderByRaw("FIELD(nivel, 'bajo', 'medio', 'alto')")->get();
    return view('welcome', compact('niveles'));
})->name('home');

Route::view('/haz-test', 'haz-test')->name('haz-test');
Route::view('/puntos-moviles', 'under-construction')->name('under-construction');
Route::view('/puntos-fijos', 'under-construction')->name('under-construction');
Route::view('/empresas', 'under-construction')->name('under-construction');
Route::view('/hazte-voluntario', 'under-construction')->name('under-construction');
Route::view('/centros-docentes', 'under-construction')->name('under-construction');
Route::view('/organiza-tu-campania-donacion', 'under-construction')->name('under-construction');
Route::view('/cual-es-tu-razon', 'under-construction')->name('under-construction');
Route::view('/todo-sobre-donacion', 'under-construction')->name('under-construction');
Route::view('/contacto', view: 'under-construction')->name('under-construction');
Route::view('/aviso-legal', 'under-construction')->name('under-construction');
Route::view('/politica-privacidad', 'under-construction')->name('under-construction');
Route::view('/politica-cookies', 'under-construction')->name('under-construction');
Route::view('/creditos', 'under-construction')->name('under-construction');
Route::view('/quienes-somos', 'under-construction')->name('under-construction');
Route::view('/canal-denuncias', 'under-construction')->name('under-construction');

/* Redirifir al dashboard correcto según el rol */
Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)
     ->middleware('auth')
     ->name('dashboard');

/* Ruta para el usuario Admin */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/donantes', DonantesCrud::class)->name('admin.donantes');
    Route::get('/admin/centros', CentrosCrud::class)->name('admin.centros');
    Route::get('/admin/dashboard', DashboardAdmin::class)->name('admin.dashboard');
    Route::get('/admin/nivel-de-reserva', VerNivelReserva::class)->name('admin.nivel-reserva');
    Route::get('/admin/estadisticas-donaciones', EstadisticasDonaciones::class)->name('admin.estadisticas-donaciones');
});

/* Ruta para el usuario Donante */
Route::middleware(['auth', 'donante'])->group(function () {
    Route::get('/donante/reservar', ReservarCita::class)->name('donante.reservar');
    Route::get('/donante/gestionar', GestionarCitas::class)->name('donante.gestionar');
    Route::get('/donante/dashboard', DashboardDonante::class)->name('donante.dashboard');
    Route::get('/donante/historial', HistorialDonaciones::class)->name('donante.historial');
});

/* Ruta para el usuario Centro */
Route::middleware(['auth', 'centro'])->group(function () {
    Route::get('/centro/citas', CentroCitasCrud::class)->name('centro.citas');
    Route::get('/centro/dashboard', DashboardCentro::class)->name('centro.dashboard');
    Route::get('/centro/estadistica-donaciones', EstadisticasDonacionesCentro::class)->name('centro.estadisticas');
    Route::get('/centro/editar-horario', EditarHorarioCentro::class)->name('centro.editar-horario');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
