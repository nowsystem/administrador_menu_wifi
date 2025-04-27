<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PromosController;
use App\Http\Controllers\MenuPageController;

Route::post('/guardar-metrica', [MenuPageController::class, 'guardarMetrica'])->name('guardar.metrica');

Route::get('/{pageName}', [MenuPageController::class, 'show'])->where('pageName', '.*');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::post('/promos/crear', [PromosController::class, 'crear'])->name('promos.crear');
    Route::get('/promos/editar', [PromosController::class, 'editPromoForm'])->name('promos.editar');
    Route::post('/promos/actualizar/{id}', [PromosController::class, 'updatePromo'])->name('promos.actualizar');
    
    Route::get('/menu/editar', [MenuController::class, 'editImageForm'])->name('menu.editar');
    Route::post('/menu/actualizar/{id}', [MenuController::class, 'updateImage'])->name('menu.actualizar');
   
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';
