<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PromosController;
use App\Http\Controllers\MenuPageController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\TvController;


//ruta inicio
Route::get('/', function () {
    return view('welcome');
});


//ruta inicio
Route::get('/admin', function () {
    return view('administracion');
});

//ruta cuando de accede a el url del menu wifi del cliente
Route::prefix('menu_')->group(function () {
    Route::get('/{pageName}', [MenuPageController::class, 'show'])->where('pageName', '.*');
});


 //********************esto es seccion tv */********************************** */


 //ruta tv smart

// Sección TV
Route::get('/tv/{pageName}', [TvController::class, 'verPantalla'])->name('tv.verPantalla');


Route::middleware(['auth'])->group(function () {
    Route::get('/menu/seleccionar-diseno', [TvController::class, 'seleccionarVista'])->name('tv.seleccionar');
    Route::post('/tv/guardar-diseno', [TvController::class, 'guardarVista'])->name('tv.guardar');
    Route::post('/tv/cargar-vista', [TvController::class, 'cargarVista'])->name('tv.cargar.vista');
});

Route::prefix('tv')->group(function () {
    Route::get('/{pageName}/promo', [TvController::class, 'getPromo']);
    Route::get('/{pageName}/checksum', [TvController::class, 'imagenesChecksum']);
    Route::get('/{pageName}/page-checksum', [TvController::class, 'pageChecksum']);

});





//***************termina seccion tv******************************************* */

//ruta que guarda las metricas
Route::post('/guardar-metrica/{pageName}', [MenuPageController::class, 'guardarMetrica'])->name('guardar.metrica');


     Route::get('/dashboard', function () {
    return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
   //ruta connsulta de formulario usuarios business
    Route::get('/consulta', [ConsultaController::class, 'consultaMetricas'])->name('consulta.metricas');

    //rutas promos
    Route::post('/promos/crear', [PromosController::class, 'crear'])->name('promos.crear');
    Route::get('/promos/editar', [PromosController::class, 'editPromoForm'])->name('promos.editar');
    Route::post('/promos/actualizar/{id}', [PromosController::class, 'updatePromo'])->name('promos.actualizar');
    Route::delete('/promos/{id}', [PromosController::class, 'eliminar'])->name('promos.eliminar');
    Route::post('/promos/label', [PromosController::class, 'guardarLabel'])->name('promos.label');
    // Ruta para actualizar texto
    Route::put('/promos/actualizar-texto/{id}', [PromosController::class, 'actualizarTexto'])->name('promos.actualizar.texto');
    // Ruta para eliminar
    Route::delete('/promos/eliminar/{id}', [PromosController::class, 'eliminar'])->name('promos.eliminar');



    //rutas imagenes de menu
    Route::get('/menu/editar', [MenuController::class, 'editImageForm'])->name('menu.editar');
    Route::post('/menu/actualizar/{id}', [MenuController::class, 'updateImage'])->name('menu.actualizar');

    //ruta del link a canva
    Route::get('/dashboard', [MenuController::class, 'index'])->name('dashboard');
   

    //rutas perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});



Route::middleware('auth')->group(function () {
    Route::get('/control/inicio', [ControlController::class, 'inicio'])->name('control.inicio');
    Route::get('/control/editar', [ControlController::class, 'editar'])->name('control.editar');

    // CRUD Users
    Route::post('/control/users/crear', [ControlController::class, 'crearUser'])->name('control.users.crear');
    Route::put('/control/users/actualizar/{id}', [ControlController::class, 'actualizarUser'])->name('control.users.actualizar');
    Route::delete('/control/users/eliminar/{id}', [ControlController::class, 'eliminarUser'])->name('control.users.eliminar');

    // CRUD Menus
    Route::post('/control/menus/crear', [ControlController::class, 'crearMenu'])->name('control.menus.crear');
    Route::post('/control/menus/actualizar/{id}', [ControlController::class, 'actualizarMenu'])->name('control.menus.actualizar');
    Route::delete('/control/menus/eliminar/{id}', [ControlController::class, 'eliminarMenu'])->name('control.menus.eliminar');

    // CRUD Promos
    Route::post('/control/promos/crear', [ControlController::class, 'crearPromo'])->name('control.promos.crear');
    Route::post('/control/promos/actualizar/{id}', [ControlController::class, 'actualizarPromo'])->name('control.promos.actualizar');
    Route::delete('/control/promos/eliminar/{id}', [ControlController::class, 'eliminarPromo'])->name('control.promos.eliminar');

    // CRUD Clientes
    Route::post('/control/clientes/crear', [ControlController::class, 'crearCliente'])->name('control.clientes.crear');
    Route::put('/control/clientes/actualizar/{id}', [ControlController::class, 'actualizarCliente'])->name('control.clientes.actualizar');
    Route::delete('/control/clientes/eliminar/{id}', [ControlController::class, 'eliminarCliente'])->name('control.clientes.eliminar');
});


require __DIR__.'/auth.php';
