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

    // Ambil progres terakhir pengguna
    $progres = DB::table('progreslevelpengguna')
        ->where('id_pengguna', $user->id_pengguna)
        ->orderByDesc('id_progres')
        ->first();

    $expFromProgres = DB::table('progreslevelpengguna')
        ->where('id_pengguna', $user->id_pengguna)
        ->sum('exp'); // otomatis menjumlahkan semua baris
    $expFromUser = $user->total_exp ?? 0;
    $bintang = DB::table('progreslevelpengguna')
        ->where('id_pengguna', $user->id_pengguna)
        ->sum('bintang'); // otomatis menjumlahkan semua baris

    $expFromTournament = DB::table('pesertaturnamen')
    ->where('id_pengguna', $user->id_pengguna)
    ->sum('bonus_exp_didapat');

    $exp = $expFromProgres + $expFromUser + $expFromTournament;

    // Hitung persentase (misal max EXP 1000, max Bintang 20)
    $expPercent = min(100, ($exp / 1000) * 100);
    $starPercent = min(100, ($bintang / 60) * 100);

    // === TOP 5 PLAYER ===
    $topPlayers = DB::table('pengguna')
        ->select(
            'pengguna.id_pengguna',
            'pengguna.username',
            'pengguna.avatar_url',
            DB::raw('
                COALESCE(pengguna.total_exp,0) +
                COALESCE((SELECT SUM(exp) FROM progreslevelpengguna WHERE id_pengguna=pengguna.id_pengguna),0) +
                COALESCE((SELECT SUM(exp_didapat) FROM riwayatpertandingan WHERE id_pengguna=pengguna.id_pengguna),0) +
                COALESCE((SELECT SUM(bonus_exp_didapat) FROM pesertaturnamen WHERE id_pengguna=pengguna.id_pengguna),0)
            AS total_exp')
        )
        ->orderByDesc('total_exp')
        ->where('role', 'student')
        ->limit(5)
        ->get();

    return view('siswa.home', [
        'username' => session('pengguna_username'),
        'user' => $user,
        'topPlayers' => $topPlayers,
        'exp' => $exp,
        'bintang' => $bintang,
        'expPercent' => $expPercent,
        'starPercent' => $starPercent
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
        // Cek session pengguna
        if (!session()->has('pengguna_id')) {
            return redirect()->route('login');
        }
    
        $userId = session('pengguna_id');
    
        // Ambil data pengguna
        $user = Pengguna::find($userId);
    
        // Ambil progres EXP & Bintang
        $progres = DB::table('progreslevelpengguna')
            ->where('id_pengguna', $userId)
            ->orderByDesc('id_progres')
            ->first(); // ambil progres terakhir
    
        // Inisialisasi default
        $exp = 0;
        $bintang = 0;
        $expPercent = 0;
        $starPercent = 0;
    
        if ($progres) {
            $exp = $progres->exp;
            $bintang = $progres->bintang;
    
            // Hitung persentase EXP (max 1000)
            $expPercent = min(100, ($exp / 1000) * 100);
    
            // Hitung persentase bintang (max 20)
            $starPercent = min(100, ($bintang / 20) * 100);
        }
    
        return view('siswa.tournament', [
            'username' => session('pengguna_username'),
            'user' => $user,
            'exp' => $exp,
            'bintang' => $bintang,
            'expPercent' => $expPercent,
            'starPercent' => $starPercent
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

/* POLLING TEAM SUBMISSION STATUS */
Route::get('/tournament/{id}/team-submission-status', [SiswaTournamentController::class, 'teamSubmissionStatus'])
    ->name('tournament.team.submission.status');

/* FINISH (SOL0 / TIM) */
Route::post('/tournament/finish/{idPeserta}', [SiswaTournamentController::class, 'finishTournament'])
    ->name('tournament.finish');

/* LEADERBOARD */
Route::get('/tournament/leaderboard/{id}', [SiswaTournamentController::class, 'leaderboard'])
    ->name('tournament.leaderboard');

Route::get('/tournament/leaderboard/{id}/status', [SiswaTournamentController::class, 'leaderboardStatus'])
    ->name('tournament.leaderboard.status');

/* TEAM FINISH STATUS - for polling when one member submits */
Route::get('/tournament/{id}/team-finish-status', [SiswaTournamentController::class, 'teamFinishStatus'])
    ->name('tournament.team-finish-status');


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

Route::get('/guru/tournament/{id}/participants',
    [TournamentController::class, 'participants']
)->name('guru.tournament.participants');

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

Route::get(
    '/guru/tournament/{id}/ajax-status',
    [TournamentController::class, 'ajaxStatus']
)->name('ajax-status');

Route::post(
    '/guru/tournament/{id}/ajax-force-end',
    [TournamentController::class, 'ajaxForceEnd']
)->name('ajax-force-end');

Route::get('/guru/tournament/{id}/ajax-top3', [TournamentController::class, 'ajaxTop3']);

// Realtime Leaderboard
Route::get('/siswa/tournament/{id}/ajax-leaderboard', [SiswaController::class, 'ajaxLeaderboard'])
    ->name('ajax-leaderboard');

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
