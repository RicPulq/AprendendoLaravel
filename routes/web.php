<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Middleware\Autenticador;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/series');
})->middleware(Autenticador::class);

// Route::controller(SeriesController::class)->group(function(){
//     Route::get('/series', 'index')->name('series.index');
//     Route::get('/series/criar', 'create')->name('series.create');
//     Route::post('/series/salvar', 'store')->name('series.store');
// });
// Route::delete('/series/destroy/{id}',[SeriesController::class,'destroy'])->name('series.destroy');
// OU
// Route::resource('/series', SeriesController::class)->only(['index','store','create','destroy','edit','update']);

Route::resource('/series', SeriesController::class)->except(['show']);

// Route::resource('/series/{series}/seasons', SeasonsController::class)->only(['index']);
Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])->name('seasons.index');

Route::get('/seasons/{season}/episodes', [EpisodesController::class, 'index'])->name('episodes.index');
Route::post('/seasons/{season}/episodes', [EpisodesController::class, 'update'])->name('episodes.update');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('sign-in');