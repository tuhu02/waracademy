<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Guru\TournamentController;

Route::get('/', function () {
    return view('landing'); // pastikan file resources/views/landing.blade.php ada
})->name('landing');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/home', function () {
    if (!session()->has('pengguna_id')) {
        return redirect()->route('login');
    }
    return view('siswa.home', ['username' => session('pengguna_username')]);
})->name('home');




// PROFIL
Route::get('/profil/{id}', [ProfileController::class, 'index'])->name('profil');
Route::put('/profil/update/{id}', [ProfileController::class, 'update'])->name('profil.update');




// Route::get('/level', function () {
//     if (!session()->has('pengguna_id')) {
//         return redirect()->route('login');
//     }
//     return view('siswa.level');
// })->name('level');

Route::get('/tournament', function () {
    if (!session()->has('pengguna_id')) {
        return redirect()->route('login');
    }
    return view('siswa.tournament');
})->name('tournament');

// Route Guru 
Route::get('/guru/home', function () {
    if (!session()->has('pengguna_id')) {
        return redirect()->route('login');
    }
    return view('guru.home', ['username' => session('pengguna_username')]);
})->name('guru.home');

Route::get('/guru/tournament', [TournamentController::class, 'index'])->name('guru.tournament.index');

// JSON endpoint used by client polling for near-real-time updates
Route::get('/guru/tournament/data', [TournamentController::class, 'data'])->name('guru.tournament.data');

Route::get('/guru/tournament/create', function () {
    if (!session()->has('pengguna_id')) {
        return redirect()->route('login');
    }
    return view('guru.tournament.create');
})->name('guru.tournament.create');

// POST: store tournament created by guru
Route::post('/guru/tournament', [TournamentController::class, 'store'])->name('guru.tournament.store');

// Show tournament detail (dynamic)
Route::get('/guru/tournament/{id}', [TournamentController::class, 'show'])->name('guru.tournament.show');

// Halaman kisi-kisi (preview)
Route::get('/level/{id}', function ($id) {
    return view('siswa.levels.preview', ['id' => $id]);
})->name('level.preview');

// Route::get('/level', function () {
//     if (!session()->has('pengguna_id')) {
//         return redirect()->route('login');
//     }
//     return view('siswa.level');
// })->name('siswa.level.map');

Route::get('/level', function () {
    if (!session()->has('pengguna_id')) {
        return redirect()->route('login');
    }
    return view('siswa.level');
})->name('level'); // 👈 jangan ubah ini

// 🗺 Route peta level (tanpa parameter, HARUS di atas)
Route::get('/level', [LevelController::class, 'map'])->name('level');

// 🎯 Route level detail & quiz (dengan parameter)
Route::get('/level/{id}', [LevelController::class, 'preview'])->name('level.preview');
Route::get('/level/{id}/start', [LevelController::class, 'start'])->name('level.start');
Route::post('/level/{id}/submit', [LevelController::class, 'submit'])->name('level.submit');



Route::get('/level/{id}/preview', [LevelController::class, 'preview'])->name('level.preview');
Route::get('/level/{id}/start', [LevelController::class, 'start'])->name('level.start');

// Halaman soal (ambil dari database)
Route::get('/level/{id}/start', [LevelController::class, 'start'])->name('level.start');

// mulai level → tampilkan soal
Route::get('/level/{id}/start', [LevelController::class, 'start'])->name('level.start');

// submit jawaban → proses hasil
Route::post('/level/{id}/submit', [LevelController::class, 'submit'])->name('level.submit');