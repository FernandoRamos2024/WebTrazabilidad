<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\EstanteController;
use App\Http\Controllers\OperadorController;
use App\Http\Controllers\ReportesEstanteController;
use App\Http\Controllers\ReportesMaquinadoController;
use App\Http\Controllers\LoginController;
use App\Models\User;
use App\Http\Controllers\HomeController;

// componentes
Route::get('/preguntas-frecuentes', function () {
    return view('information.frequent-questions');
})->name('frequent-questions');

Route::get('/buscar-mas-reciente', [ReportesMaquinadoController::class, 'buscarRegistroMasReciente'])->name('buscar.reciente');

Route::get('/', [ProyectoController::class, 'mostrarTablaProyectos'])->name('pagina-principal');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register', function () {
    if (config('app.REGISTER_ENABLED', false)) {
        return redirect('/login');
    } else {
        return view('auth.register');
    }
});

// necesita autorizacion
Route::middleware('can:acceder-operador')->group(function () {
    Route::get('/operador', [UserController::class, 'operador'])->name('operador.index');
});

Route::middleware('can:acceder-ventas')->group(function () {
    Route::get('/ventas', [UserController::class, 'ventas'])->name('ventas.index');
});

Route::middleware('can:acceder-admin')->group(function () {
    Route::get('/admin', [UserController::class, 'admin'])->name('admin.index');
    Route::middleware('users')->resource('users', UserController::class);
    // Route::middleware('users')->resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']); //solamente para
    // Route::middleware('users')->resource('users', UserController::class)->except(['show']); //excluir metodos
});

Route::middleware('check.admin.ventas')->group(function () {
    Route::resource('operadores', OperadorController::class);
    Route::get('/revisar-registros-maquinado', [ReportesMaquinadoController::class, 'registrosPorRevisar'])->name('reportesMaquinados.revisarRegistros');
    Route::get('/revisar-registros-estante', [ReportesEstanteController::class, 'registrosPorRevisar'])->name('reportesEstantes.revisarRegistros');
});

// filtros
Route::post('/reportes-maquinados/filtrar', [ReportesMaquinadoController::class, 'filtrar'])->name('reportes-maquinados.filtrar');
Route::post('/reportes-estantes/filtrar', [ReportesEstanteController::class, 'filtrar'])->name('reportes-estantes.filtrar');
Route::post('/proyectos/filtrar', [ProyectoController::class, 'filtrar'])->name('proyectos.filtrar');
Route::get('/panel', [UserController::class, 'returnViewByRole'])->name('panel.vista');

// clases
Route::resource('maquinas', MaquinaController::class);
Route::resource('areas', AreaController::class);
Route::resource('estantes', EstanteController::class);
Route::resource('reportes-estantes', ReportesEstanteController::class);
Route::resource('reportes-maquinados', ReportesMaquinadoController::class);
Route::resource('proyectos', ProyectoController::class);
Route::get('/proyectos/{codigo_proyecto}/seguimiento', [ProyectoController::class, 'seguimiento'])->name('proyectos.seguimiento');

// solicitud por modal
Route::get('/revisionM', [ReportesMaquinadoController::class, 'addRevision'])->name('solicitar.revision.m');
Route::get('/revisionE', [ReportesEstanteController::class, 'addRevision'])->name('solicitar.revision.e');

// apis
Route::get('/obtener-estantes', [ApiController::class, 'obtenerEstantes']);
Route::get('/obtener-areas', [ApiController::class, 'obtenerAreas']);
Route::get('/manejar-registros-maquinado', [ApiController::class, 'manejarRegistrosMaquinado']);
Route::get('/insertar-registros-faltantes-maquinado', [ApiController::class, 'insertarRegistrosFaltantesMaquinado']);
Route::get('/manejar-registros-estante', [ApiController::class, 'manejarRegistrosEstante']);

require __DIR__.'/auth.php';