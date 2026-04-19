<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/anime/{mal_id}', [FavoriteController::class, 'toggleAnime'])->name('favorites.toggleAnime');
    Route::post('/favorites/manga/{mal_id}', [FavoriteController::class, 'toggleManga'])->name('favorites.toggleManga');
});

Route::get('/anime', [AnimeController::class, 'index'])->name('anime.index');
Route::get('/anime/{mal_id}', [AnimeController::class, 'show'])->name('anime.show');

Route::get('/manga', [MangaController::class, 'index'])->name('manga.index');
Route::get('/manga/{mal_id}', [MangaController::class, 'show'])->name('manga.show');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');


require __DIR__.'/auth.php';
