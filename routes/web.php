<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\StatusPendaftaran;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

// Route::get('/', [StatusPendaftaran::class, 'cektahap']);

Route::get('/tn', function () {
    return view('hometn');
});

Route::view('/', 'home')->name('home');

Route::get('/daftar', function () {
    return view('livewire.daftar-baru');
});

Route::get('/daftarnaikqism', function () {
    return view('livewire.daftar-naik-qism');
});

Route::get('/tn/daftar', function () {
    return view('livewire.daftartn');
});

// Route::get('/daftar', function () {
//     return view('filament.pages.pendaftaran-santri-baru');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
