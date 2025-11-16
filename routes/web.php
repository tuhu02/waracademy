<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Guru\TournamentController;
use App\Http\Controllers\Guru\BankSoalController;
use App\Http\Controllers\SiswaTournamentController;
use App\Http\Controllers\TopController; 
use App\Models\Pengguna;
use App\Models\TurnamenPertanyaan;
use App\Http\Controllers\LeaderboardController;

/*
|--------------------------------------------------------------------------
| Landing & Auth
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('landing'))->name('landing');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');


/*
|--------------------------------------------------------------------------
| Home Siswa
|--------------------------------------------------------------------------
*/
use Illuminate\Support\Facades\DB;

Route::get('/home', function () {
    if (!session()->has('pengguna_id')) return redirect()->route('login');

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


/*
|--------------------------------------------------------------------------
| Profil
|--------------------------------------------------------------------------
*/

Route::get('/profil/{id}', [ProfileController::class, 'index'])->name('profil');
Route::put('/profil/update/{id}', [ProfileController::class, 'update'])->name('profil.update');

/*
|--------------------------------------------------------------------------
| TURNAMEN SISWA (JOIN, LOBBY, START, SUBMIT, LEADERBOARD)
|--------------------------------------------------------------------------
*/

Route::match(['get', 'post'], '/tournament/join', [SiswaTournamentController::class, 'join'])
    ->name('tournament.join');

// leaderboard
Route::get('/leaderboard/top100', [LeaderboardController::class, 'top100'])
    ->name('leaderboard.top100');

Route::get('/tournament', function () {
    if (!session()->has('pengguna_id')) return redirect()->route('login');

    $user = Pengguna::find(session('pengguna_id'));
    return view('siswa.tournament', [
        'username' => session('pengguna_username'),
        'user' => $user
    ]);
})->name('tournament');

/* LOBBY */
Route::get('/tournament/lobby/{kode}', [SiswaTournamentController::class, 'lobby'])
    ->name('tournament.lobby');

Route::get('/tournament/lobby/{kode}/status', [SiswaTournamentController::class, 'lobbyStatus'])
    ->name('tournament.lobby.status');

/* MOVE SLOT TEAM */
Route::post('/tournament/lobby/{kode}/move', [SiswaTournamentController::class, 'moveTeam'])
    ->name('tournament.move');

/* START GAME */
Route::get('/tournament/start/{id}', [SiswaTournamentController::class, 'startTournament'])
    ->name('tournament.start');

/* SUBMIT SOLO (OLD) */
Route::post('/tournament/submit/{id}', [SiswaTournamentController::class, 'submitAnswers'])
    ->name('tournament.submit');

/* SUBMIT TIM (NEW) */
Route::post('/tournament/{id}/submit-question', [SiswaTournamentController::class, 'submitQuestion'])
    ->name('tournament.submit.question');

Route::post('/tournament/{id}/submit-all', [SiswaTournamentController::class, 'submitAll'])
    ->name('tournament.submit.all');

/* FINISH (SOL0 / TIM) */
Route::post('/tournament/finish/{idPeserta}', [SiswaTournamentController::class, 'finishTournament'])
    ->name('tournament.finish');

/* LEADERBOARD */
Route::get('/tournament/leaderboard/{id}', [SiswaTournamentController::class, 'leaderboard'])
    ->name('tournament.leaderboard');

Route::get('/tournament/leaderboard/{id}/status', [SiswaTournamentController::class, 'leaderboardStatus'])
    ->name('tournament.leaderboard.status');


/*
|--------------------------------------------------------------------------
| TURNAMEN GURU
|--------------------------------------------------------------------------
*/

Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');

Route::get('/guru/home', function () {
    if (!session()->has('pengguna_id')) return redirect()->route('login');
    return view('guru.home', ['username' => session('pengguna_username')]);
})->name('guru.home');

/* LIST */
Route::get('/guru/tournament', [TournamentController::class, 'index'])
    ->name('guru.tournament.index');

/* JSON DATA */
Route::get('/guru/tournament/data', [TournamentController::class, 'getData'])
    ->name('guru.tournament.data');

/* CREATE */
Route::get('/guru/tournament/create', [TournamentController::class, 'create'])
    ->name('guru.tournament.create');

/* STORE */
Route::post('/guru/tournament/store', [TournamentController::class, 'store'])
    ->name('guru.tournament.store');

/* DETAIL */
Route::get('/guru/tournament/{id}', [TournamentController::class, 'show'])
    ->name('guru.tournament.show');

/* START / END */
Route::post('/guru/tournament/{id}/start', [TournamentController::class, 'startTournament'])
    ->name('guru.tournament.start');

Route::post('/guru/tournament/{id}/end', [TournamentController::class, 'endTournament'])
    ->name('guru.tournament.end');

Route::get('/guru/soal/json', function () {

    return TurnamenPertanyaan::with([
        'jawaban' => function ($q) {
            $q->orderBy('id_jawaban'); // urutkan stabil A–D
        }
    ])
    ->get()
    ->map(function ($soal) {

        // cari index jawaban benar (0–3)
        $correctIndex = $soal->jawaban->search(function ($j) {
            return $j->adalah_benar == 1;
        });

        return [
            'text' => $soal->teks_pertanyaan,
            'options' => $soal->jawaban->pluck('teks_jawaban')->toArray(),
            'correctAnswer' => $correctIndex,
            'difficulty' => $soal->tingkat_kesulitan ?? 'sedang',
            'subject' => $soal->mata_pelajaran ?? 'umum',
        ];
    });

})->name('guru.soal.json');

/*
|--------------------------------------------------------------------------
| LEVEL
|--------------------------------------------------------------------------
*/

Route::get('/level', [LevelController::class, 'map'])->name('level');

Route::get('/level/{id}', [LevelController::class, 'preview'])->name('level.preview');

Route::get('/level/{id}/start', [LevelController::class, 'start'])->name('level.start');

Route::post('/level/{id}/submit', [LevelController::class, 'submit'])->name('level.submit');

Route::prefix('guru')->group(function () {
    Route::get('/bank-soal', [BankSoalController::class, 'index'])->name('guru.soal.index');
    Route::get('/bank-soal/detail/{id}', [BankSoalController::class, 'detail'])->name('guru.soal.detail');
    Route::get('/bank-soal/data', [BankSoalController::class, 'data'])->name('guru.soal.data');
});
