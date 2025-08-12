<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Middleware\Autenticador;
use App\Mail\SeriesCreated;
use App\Models\Series;
use Illuminate\Http\Request;


// Route::controller(SeriesController::class)->group(function(){
    //     Route::get('/series', 'index')->name('series.index');
    //     Route::get('/series/criar', 'create')->name('series.create');
    //     Route::post('/series/salvar', 'store')->name('series.store');
    // });
    // Route::delete('/series/destroy/{id}',[SeriesController::class,'destroy'])->name('series.destroy');
    // OU
    // Route::resource('/series', SeriesController::class)->only(['index','store','create','destroy','edit','update']);

Route::resource('/series', SeriesController::class)->except(['show']);

Route::middleware([Autenticador::class])->group(function () {
    Route::get('/', function () {
        return redirect('/series');
    });
    // Route::resource('/series/{series}/seasons', SeasonsController::class)->only(['index']);
    Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])->name('seasons.index');

    Route::get('/seasons/{season}/episodes', [EpisodesController::class, 'index'])->name('episodes.index');
    Route::post('/seasons/{season}/episodes', [EpisodesController::class, 'update'])->name('episodes.update');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('signin');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [UsersController::class, 'create'])->name('users.create');
Route::post('/register', [UsersController::class, 'store'])->name('users.store');

Route::get('/email', function (Request $request) {
    return new SeriesCreated(
        'TEste', 1,5, 5
    );
})->name('email.test');

/* Route::get('/api/series', function () {
    return Series::all();
}); */