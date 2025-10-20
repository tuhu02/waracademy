<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;

use App\Http\Controllers\ProfileController;

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
//profile
Route::get('/profil/{id}', [ProfileController::class, 'show'])->name('profil.show');

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

Route::get('/guru/tournament',function(){
    if (!session()->has('pengguna_id')) {
        return redirect()->route('login');
    }
    return view('guru.tournament');
})->name('guru.tournament');

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

