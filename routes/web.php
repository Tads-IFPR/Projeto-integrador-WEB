<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\PlaylistAudioController;

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

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('audio', AudioController::class)->except('index');
    Route::get('audio/{audio}/cover', [AudioController::class, 'showImage'])->name('audio.show.image');
    Route::post('audio/{audio}/playlist', [AudioController::class, 'showPlaylist'])->name('audio.show.playlist');
    Route::resource('playlist', PlaylistController::class)->except('index');
    Route::get('playlist/{playlist}/cover', [PlaylistController::class, 'showImage'])->name('playlist.show.image');
    Route::get('playlist/{playlist}', [PlaylistController::class, 'play'])->name('playlist.show');
});



require __DIR__.'/auth.php';


