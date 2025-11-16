<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Guru\TournamentController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\SiswaTournamentController;
use App\Http\Controllers\TopController; 
use App\Models\Pengguna;

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


use Illuminate\Support\Facades\DB;

Route::get('/home', function () {
    if (!session()->has('pengguna_id')) {
        return redirect()->route('login');
    }

    $user = Pengguna::find(session('pengguna_id'));

    // === TOP 5 PLAYER ===
    $topPlayers = DB::table('pengguna')
        ->leftJoin('progreslevelpengguna', 'pengguna.id_pengguna', '=', 'progreslevelpengguna.id_pengguna')
        ->leftJoin('riwayatpertandingan', 'pengguna.id_pengguna', '=', 'riwayatpertandingan.id_pengguna')
        ->select(
            'pengguna.id_pengguna',
            'pengguna.username',
            'pengguna.avatar_url',
            DB::raw('
                COALESCE(pengguna.total_exp, 0) +
                COALESCE(SUM(progreslevelpengguna.exp), 0) +
                COALESCE(SUM(riwayatpertandingan.exp_didapat), 0)
            AS total_exp')
        )
        ->groupBy('pengguna.id_pengguna', 'pengguna.username', 'pengguna.avatar_url')
        ->orderByDesc('total_exp')
        ->limit(5)
        ->get();

    return view('siswa.home', [
        'username' => session('pengguna_username'),
        'user' => $user,
        'topPlayers' => $topPlayers  // <-- kirim ke Blade
    ]);
})->name('home');



Route::match(['get', 'post'], '/tournament/join', [SiswaTournamentController::class, 'join'])
    ->name('tournament.join');
Route::get('/tournament/lobby/{code}', [SiswaTournamentController::class, 'lobby'])->name('tournament.lobby');
Route::get('/tournament/lobby/{kode}/status', [SiswaTournamentController::class, 'lobbyStatus'])->name('tournament.lobby.status');

// PROFIL
Route::get('/profil/{id}', [ProfileController::class, 'index'])->name('profil');
Route::put('/profil/update/{id}', [ProfileController::class, 'update'])->name('profil.update');




// Route::get('/level', function () {
//     if (!session()->has('pengguna_id')) {
//         return redirect()->route('login');
//     }
//     return view('siswa.level');
// })->name('level');

// --- RUTE TURNAMEN SISWA (DIPERBARUI) ---
Route::get('/tournament', function () {
    if (!session()->has('pengguna_id')) {
        return redirect()->route('login');
    }
    $user = Pengguna::find(session('pengguna_id'));
    return view('siswa.tournament', [
        'username' => session('pengguna_username'),
        'user' => $user
    ]);
})->name('tournament');

Route::post('/tournament/join', [SiswaTournamentController::class, 'join'])->name('tournament.join');

// [PERBAIKAN] Samakan semua parameter menjadi '{kode}'
Route::get('/tournament/lobby/{kode}', [SiswaTournamentController::class, 'lobby'])->name('tournament.lobby');
Route::get('/tournament/lobby/{kode}/status', [SiswaTournamentController::class, 'lobbyStatus'])->name('tournament.lobby.status');
Route::post('/tournament/lobby/{kode}/move', [SiswaTournamentController::class, 'moveTeam'])->name('tournament.move');

// [RUTE BARU]
// Rute ini akan menampilkan halaman kuis/permainan untuk turnamen
Route::get('/tournament/start/{id}', [SiswaTournamentController::class, 'startTournamentGame'])->name('tournament.start');
// Endpoint untuk menerima submit jawaban turnamen dari siswa
Route::post('/tournament/submit/{id}', [SiswaTournamentController::class, 'submitAnswers'])->name('tournament.submit');
// Halaman leaderboard turnamen untuk siswa
Route::get('/tournament/leaderboard/{id}', [SiswaTournamentController::class, 'leaderboard'])->name('tournament.leaderboard');
// API endpoint untuk polling leaderboard (real-time update)
Route::get('/tournament/leaderboard/{id}/status', [SiswaTournamentController::class, 'leaderboardStatus'])->name('tournament.leaderboard.status');


// Route Guru
Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');



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

// Start tournament (POST)
Route::post('/guru/tournament/{id}/start', [TournamentController::class, 'startTournament'])->name('guru.tournament.start');

// End tournament (POST)
Route::post('/guru/tournament/{id}/end', [TournamentController::class, 'endTournament'])->name('guru.tournament.end');

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

