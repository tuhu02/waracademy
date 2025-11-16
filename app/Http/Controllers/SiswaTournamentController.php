<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pengguna; // Pastikan model ini ada
use Carbon\Carbon;

class SiswaTournamentController extends Controller
{
    /**
     * Menangani permintaan siswa untuk bergabung ke turnamen.
     */

    public function join(Request $req)
    {
        // Terima kode dari form (bisa bernama 'kode', 'code', 'kode_room' atau 'roomCode')
        $kode = $req->input('kode') ?? $req->input('code') ?? $req->input('kode_room') ?? $req->input('roomCode');

        if (empty($kode)) {
            return response()->json(['message' => 'Kode turnamen harus diisi.'], 422);
        }

        // Pastikan user terautentikasi via session
        $penggunaId = session('pengguna_id');
        if (!$penggunaId) {
            return response()->json(['message' => 'Sesi tidak valid. Silakan login.'], 401);
        }

        // Cari turnamen berdasarkan kode_room
        $turnamen = DB::table('turnamen')->where('kode_room', $kode)->first();
        if (!$turnamen) {
            return response()->json(['message' => 'Turnamen tidak ditemukan untuk kode tersebut.'], 404);
        }

        // Cek status (hanya boleh bergabung saat Menunggu)
        if (strtolower(trim($turnamen->status ?? '')) !== 'menunggu') {
            return response()->json(['message' => 'Turnamen tidak bisa diikuti saat ini.'], 403);
        }

        // Cek level minimal yang diperlukan (bandingkan berdasarkan nomor_level di tabel `level`)
        $levelMinimal = 20;
        if ($levelMinimal > 0) {
            // Cek apakah user sudah menyelesaikan level minimal: join ke tabel `level` dan bandingkan `nomor_level`
            $userLevel = DB::table('progreslevelpengguna')
                ->join('level', 'progreslevelpengguna.id_level', '=', 'level.id_level')
                ->where('progreslevelpengguna.id_pengguna', $penggunaId)
                ->where('level.nomor_level', '>=', $levelMinimal)
                ->exists();

            // Jika tidak ada record langsung, periksa level tertinggi (nomor_level) yang telah diselesaikan
            if (!$userLevel) {
                $maxLevelCompleted = DB::table('progreslevelpengguna')
                    ->join('level', 'progreslevelpengguna.id_level', '=', 'level.id_level')
                    ->where('progreslevelpengguna.id_pengguna', $penggunaId)
                    ->max('level.nomor_level');

                if (!$maxLevelCompleted || $maxLevelCompleted < $levelMinimal) {
                    return response()->json([
                        'message' => "Level Anda belum mencukupi. Turnamen ini memerlukan level minimal {$levelMinimal}."
                    ], 403);
                }
            }
        }

        // Cek kapasitas
        $pesertaCount = DB::table('pesertaturnamen')->where('id_turnamen', $turnamen->id_turnamen)->count();
        if (!is_null($turnamen->max_peserta) && $turnamen->max_peserta > 0 && $pesertaCount >= $turnamen->max_peserta) {
            return response()->json(['message' => 'Turnamen sudah penuh.'], 409);
        }

        // Masukkan peserta (jika belum ada)
        DB::table('pesertaturnamen')->updateOrInsert(
            ['id_turnamen' => $turnamen->id_turnamen, 'id_pengguna' => $penggunaId],
            ['joined_at' => Carbon::now()]
        );

        // Kembalikan URL yang valid — gunakan nama route yang ada di routes/web.php: 'tournament.lobby'
        // Gunakan URL langsung supaya tidak bergantung pada nama parameter rute ({code} vs {kode})
        $lobbyUrl = url('/tournament/lobby/' . urlencode($kode));
        return response()->json([
            'redirect_url' => $lobbyUrl
        ], 200);
    }

    /**
     * Tampilkan halaman permainan untuk siswa ketika turnamen dimulai.
     */
    public function startTournamentGame($id)
    {
        // Cek dan update status turnamen jika waktu sudah habis
        $this->checkTournamentStatus($id);

        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            abort(404, 'Turnamen tidak ditemukan.');
        }

        // Pastikan turnamen sudah Berlangsung
        if (strtolower(trim($turnamen->status ?? '')) !== 'berlangsung') {
            // Jika sudah selesai, arahkan ke home
            if (strtolower(trim($turnamen->status ?? '')) === 'selesai') {
                return redirect()->route('home')->with('message', 'Turnamen sudah selesai.');
            }
            // Jika belum, arahkan kembali ke lobi
            return redirect()->route('tournament.lobby', ['kode' => $turnamen->kode_room]);
        }

        // Ambil soal untuk turnamen (minimal)
        $questionsRaw = DB::table('turnamen_pertanyaan')
            ->where('id_turnamen', $id)
            ->orderBy('id', 'asc')
            ->get();

        $questions = [];
        foreach ($questionsRaw as $q) {
            $choicesRaw = DB::table('turnamen_pilihan_jawaban')
                ->where('id_pertanyaan_turnamen', $q->id)
                ->orderBy('id_jawaban', 'asc')
                ->get();

            $choices = [];
            foreach ($choicesRaw as $c) {
                $choices[] = [
                    'id_jawaban' => $c->id_jawaban,
                    'teks_jawaban' => $c->teks_jawaban ?? ''
                ];
            }

            // Hanya tambahkan soal jika ada pilihan jawaban
            if (count($choices) > 0) {
                $questions[] = [
                    'id' => $q->id,
                    'teks_pertanyaan' => $q->teks_pertanyaan ?? '',
                    'options' => $choices
                ];
            }
        }

        // Render full gameplay blade (the user-facing quiz UI)
        return view('siswa.tournament_game', [
            'turnamen' => $turnamen,
            'questions' => $questions
        ]);
    }

    /**
     * Menangani submit jawaban turnamen dari siswa.
     */
    public function submitAnswers(Request $req, $id)
    {
        $penggunaId = session('pengguna_id');
        if (!$penggunaId) {
            return redirect()->route('login');
        }

        // Temukan peserta untuk pengguna ini pada turnamen yang diberikan
        $peserta = DB::table('pesertaturnamen')
            ->where('id_turnamen', $id)
            ->where('id_pengguna', $penggunaId)
            ->first();

        if (!$peserta) {
            abort(403, 'Anda belum terdaftar sebagai peserta turnamen ini.');
        }

        $answersJson = $req->input('answers');
        $timeTaken = $req->input('time_taken');

        $answers = [];
        if (!empty($answersJson)) {
            $answers = json_decode($answersJson, true);
            if (!is_array($answers)) {
                $answers = [];
            }
        }

        // Simpan jawaban dan hitung skor dengan formula baru
        $totalScore = 0;
        $correctCount = 0;
        $answeredCount = 0;
        $remainingTime = 0;
        $totalTime = 0;

        // Ambil data turnamen untuk mendapatkan durasi
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            return redirect()->route('home')->with('error', 'Turnamen tidak ditemukan.');
        }
        $totalTime = ($turnamen->durasi_pengerjaan ?? 45) * 60; // Convert menit ke detik

        // OPTIMASI: Ambil semua pertanyaan dan pilihan jawaban sekali saja (hindari N+1 query)
        $allQuestions = collect();
        $allChoices = collect();

        if (!empty($answers)) {
            $questionIds = array_keys($answers);
            $allQuestions = DB::table('turnamen_pertanyaan')
                ->whereIn('id', $questionIds)
                ->get()
                ->keyBy('id'); // Key by ID untuk lookup cepat

            $choiceIds = array_values(array_filter($answers)); // Filter null values
            if (!empty($choiceIds)) {
                $allChoices = DB::table('turnamen_pilihan_jawaban')
                    ->whereIn('id_jawaban', $choiceIds)
                    ->get()
                    ->keyBy('id_jawaban'); // Key by id_jawaban untuk lookup cepat
            }
        }

        try {
            DB::transaction(function () use ($peserta, $answers, &$totalScore, &$correctCount, &$answeredCount, $timeTaken, $totalTime, &$remainingTime, $allQuestions, $allChoices) {
                // Hapus jawaban lama (jika ada) untuk peserta ini agar tidak duplikat
                DB::table('turnamen_jawaban_peserta')
                    ->where('id_peserta', $peserta->id_peserta)
                    ->delete();

                $baseScore = 0; // Base score akan dihitung dari poin_per_soal

                foreach ($answers as $questionId => $choiceId) {
                    $answeredCount++; // Hitung jumlah soal yang dijawab

                    // Ambil data pertanyaan dari collection yang sudah di-load (tidak perlu query lagi)
                    $question = $allQuestions->get($questionId);
                    $poinPerSoal = $question->poin_per_soal ?? 10; // Default 10 jika tidak ada

                    // Cari pilihan dari collection yang sudah di-load (tidak perlu query lagi)
                    $choice = $allChoices->get($choiceId);
                    $isCorrect = ($choice && ($choice->adalah_benar == 1)) ? 1 : 0;

                    if ($isCorrect) {
                        $correctCount++; // Hitung jumlah jawaban benar
                        // Tambahkan poin dari pertanyaan ini ke base score
                        $baseScore += $poinPerSoal;
                    }

                    DB::table('turnamen_jawaban_peserta')->insert([
                        'id_peserta' => $peserta->id_peserta,
                        'id_pertanyaan_turnamen' => $questionId,
                        'id_jawaban_dipilih' => $choiceId,
                        'waktu_jawab' => $timeTaken !== null ? intval($timeTaken) : null,
                        'is_correct' => $isCorrect,
                        'answered_at' => now()
                    ]);
                }

                // Hitung remaining_time (waktu tersisa dalam detik)
                $remainingTime = max(0, $totalTime - ($timeTaken ?? 0));

                // PERHITUNGAN SKOR BARU (TERINTEGRASI DENGAN POIN PER SOAL)
                // 1. Base Score = sum(poin_per_soal untuk setiap jawaban benar)
                //    Base score sudah dihitung di loop di atas

                // 2. Bonus Akurasi
                // accuracy = correct / answered_questions
                $accuracy = $answeredCount > 0 ? ($correctCount / $answeredCount) : 0;
                // accuracy_bonus = accuracy × (20% dari total poin maksimal)
                // Atau bisa menggunakan persentase tetap (20 poin maksimal)
                $accuracyBonusMax = 20; // Maksimal 20 poin untuk bonus akurasi
                $accuracyBonus = $accuracy * $accuracyBonusMax;

                // 3. Speed Bonus
                // speed_bonus = (remaining_time / total_time) × 20
                $speedBonusMax = 20; // Maksimal 20 poin untuk bonus kecepatan
                $speedBonus = $totalTime > 0 ? (($remainingTime / $totalTime) * $speedBonusMax) : 0;

                // 4. Total Score
                // total_score = base_score + accuracy_bonus + speed_bonus
                $totalScore = $baseScore + $accuracyBonus + $speedBonus;

                // Update skor_akhir di tabel pesertaturnamen
                DB::table('pesertaturnamen')
                    ->where('id_peserta', $peserta->id_peserta)
                    ->update([
                        'skor_akhir' => round($totalScore, 2), // Bulatkan ke 2 desimal
                        'status' => 'finished',
                        'updated_at' => now()
                    ]);
            });

            // Setelah submit, arahkan ke halaman leaderboard
            return redirect()->route('tournament.leaderboard', ['id' => $id])->with('message', 'Jawaban berhasil dikirim.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error submitting tournament answers: ' . $e->getMessage(), [
                'tournament_id' => $id,
                'user_id' => $penggunaId,
                'trace' => $e->getTraceAsString()
            ]);

            // Tetap redirect ke leaderboard meskipun ada error (jangan biarkan user stuck)
            return redirect()->route('tournament.leaderboard', ['id' => $id])
                ->with('error', 'Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan halaman leaderboard turnamen untuk siswa
     */
    public function leaderboard($id)
    {
        $penggunaId = session('pengguna_id');
        if (!$penggunaId) {
            return redirect()->route('login');
        }

        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            abort(404, 'Turnamen tidak ditemukan.');
        }

        // Cek apakah user adalah peserta turnamen ini
        $peserta = DB::table('pesertaturnamen')
            ->where('id_turnamen', $id)
            ->where('id_pengguna', $penggunaId)
            ->first();

        if (!$peserta) {
            return redirect()->route('home')->with('error', 'Anda bukan peserta turnamen ini.');
        }

        // Ambil data user
        $user = Pengguna::find($penggunaId);

        // Ambil total soal
        $totalQuestions = DB::table('turnamen_pertanyaan')
            ->where('id_turnamen', $id)
            ->count();

        // Ambil data jawaban user untuk detail
        $userAnswers = DB::table('turnamen_jawaban_peserta')
            ->where('id_peserta', $peserta->id_peserta)
            ->get();

        $correctCount = $userAnswers->where('is_correct', 1)->count();
        $answeredCount = $userAnswers->count();
        $wrongCount = $answeredCount - $correctCount;

        // Ambil leaderboard (semua peserta)
        $leaderboardRaw = DB::table('pesertaturnamen')
            ->leftJoin('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $id)
            ->select(
                'pesertaturnamen.*',
                'pengguna.username as nama',
                'pengguna.avatar_url'
            )
            ->orderBy('pesertaturnamen.skor_akhir', 'desc')
            ->orderBy('pesertaturnamen.updated_at', 'asc') // Yang selesai lebih dulu ranking lebih tinggi jika skor sama
            ->get();

        // Hitung peringkat dan siapkan data leaderboard
        $leaderboard = [];
        $currentRank = 1;
        $previousScore = null;

        foreach ($leaderboardRaw as $index => $r) {
            // Jika skor berbeda dengan peserta sebelumnya, update ranking
            if ($previousScore !== null && $r->skor_akhir != $previousScore) {
                $currentRank = $index + 1;
            } elseif ($previousScore === null) {
                $currentRank = 1;
            }
            // Jika skor sama, tetap gunakan ranking yang sama (tidak increment)

            $previousScore = $r->skor_akhir;

            // Ambil data jawaban untuk peserta ini
            $participantAnswers = DB::table('turnamen_jawaban_peserta')
                ->where('id_peserta', $r->id_peserta)
                ->get();

            $participantCorrect = $participantAnswers->where('is_correct', 1)->count();
            $participantAnswered = $participantAnswers->count();

            $leaderboard[] = [
                'rank' => $currentRank,
                'id' => $r->id_peserta,
                'nama' => $r->nama ?? ('User ' . $r->id_pengguna),
                'kelas' => '-', // Kolom kelas tidak ada di tabel pengguna, set default
                'avatar_url' => $r->avatar_url,
                'skor' => $r->skor_akhir ?? 0,
                'correct' => $participantCorrect,
                'answered' => $participantAnswered,
                'status' => $r->status ?? 'active',
                'is_me' => $r->id_pengguna == $penggunaId,
            ];
        }

        return view('siswa.tournament_leaderboard', [
            'turnamen' => $turnamen,
            'user' => $user,
            'peserta' => $peserta,
            'leaderboard' => $leaderboard,
            'myRank' => collect($leaderboard)->where('is_me', true)->first()['rank'] ?? null,
            'myScore' => $peserta->skor_akhir ?? 0,
            'myCorrect' => $correctCount,
            'myAnswered' => $answeredCount,
            'myWrong' => $wrongCount,
            'totalQuestions' => $totalQuestions,
        ]);
    }

    /**
     * API endpoint untuk polling leaderboard (real-time update)
     */
    public function leaderboardStatus($id)
    {
        $penggunaId = session('pengguna_id');
        if (!$penggunaId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            return response()->json(['error' => 'Tournament not found'], 404);
        }

        // Ambil leaderboard (semua peserta)
        $leaderboardRaw = DB::table('pesertaturnamen')
            ->leftJoin('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $id)
            ->select(
                'pesertaturnamen.*',
                'pengguna.username as nama',
                'pengguna.avatar_url'
            )
            ->orderBy('pesertaturnamen.skor_akhir', 'desc')
            ->orderBy('pesertaturnamen.updated_at', 'asc')
            ->get();

        // Hitung peringkat dan siapkan data leaderboard
        $leaderboard = [];
        $currentRank = 1;
        $previousScore = null;

        foreach ($leaderboardRaw as $index => $r) {
            // Jika skor berbeda dengan peserta sebelumnya, update ranking
            if ($previousScore !== null && $r->skor_akhir != $previousScore) {
                $currentRank = $index + 1;
            } elseif ($previousScore === null) {
                $currentRank = 1;
            }

            $previousScore = $r->skor_akhir;

            // Ambil data jawaban untuk peserta ini
            $participantAnswers = DB::table('turnamen_jawaban_peserta')
                ->where('id_peserta', $r->id_peserta)
                ->get();

            $participantCorrect = $participantAnswers->where('is_correct', 1)->count();
            $participantAnswered = $participantAnswers->count();

            $leaderboard[] = [
                'rank' => $currentRank,
                'id' => $r->id_peserta,
                'nama' => $r->nama ?? ('User ' . $r->id_pengguna),
                'kelas' => '-', // Kolom kelas tidak ada di tabel pengguna, set default
                'avatar_url' => $r->avatar_url,
                'skor' => $r->skor_akhir ?? 0,
                'correct' => $participantCorrect,
                'answered' => $participantAnswered,
                'status' => $r->status ?? 'active',
                'is_me' => $r->id_pengguna == $penggunaId,
            ];
        }

        // Ambil data user untuk myRank dan myScore
        $peserta = DB::table('pesertaturnamen')
            ->where('id_turnamen', $id)
            ->where('id_pengguna', $penggunaId)
            ->first();

        $myRank = collect($leaderboard)->where('is_me', true)->first()['rank'] ?? null;
        $myScore = $peserta->skor_akhir ?? 0;

        return response()->json([
            'status' => $turnamen->status,
            'leaderboard' => $leaderboard,
            'myRank' => $myRank,
            'myScore' => $myScore,
        ]);
    }

    /**
     * Menampilkan halaman lobi untuk siswa (Solo atau Tim).
     */
    public function lobby($kode)
    {
        $user = Pengguna::find(session('pengguna_id'));
        $turnamen = DB::table('turnamen')->where('kode_room', $kode)->first();

        if (!$turnamen) {
            abort(404, 'Turnamen tidak ditemukan.');
        }

        // --- Logika untuk SOLO ---
        if ($turnamen->mode === 'solo') {
            $participants = DB::table('pesertaturnamen')
                ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
                ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
                ->select('pengguna.username', 'pengguna.avatar_url')
                ->get();

            return view('siswa.tournament_lobby', [
                'turnamen' => $turnamen,
                'initialParticipants' => $participants,
                'user' => $user,
                'teams' => [] // Kirim array kosong
            ]);
        }

        // --- Logika BARU untuk TIM ---

        // 1. Buat struktur tim kosong
        $maxTeamSize = $turnamen->max_team_members ?? 4; // Ambil dari DB, default 4
        // Hitung jumlah tim: max_peserta adalah hasil dari maxTeams × maxTeamMembers
        // Jadi jumlah tim = max_peserta / max_team_members (tanpa ceil karena sudah pasti kelipatan)
        $totalTeams = (int) ($turnamen->max_peserta / $maxTeamSize);
        $teams = [];
        for ($i = 1; $i <= $totalTeams; $i++) {
            $teams[$i] = [
                'id' => $i,
                'name' => 'Team ' . $i,
                'members' => array_fill(0, $maxTeamSize, null) // Buat slot kosong [null, null, null, null]
            ];
        }

        // 2. Ambil semua peserta yang sudah ada di lobi ini
        $participants = DB::table('pesertaturnamen')
            ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
            ->select('pengguna.id_pengguna', 'pengguna.username', 'pengguna.avatar_url', 'pesertaturnamen.team_id', 'pesertaturnamen.slot_index')
            ->get();

        // 3. Masukkan peserta ke slot tim mereka
        foreach ($participants as $p) {
            if ($p->team_id !== null && $p->slot_index !== null) {
                // Pastikan team_id dan slot_index valid
                if (isset($teams[$p->team_id]) && isset($teams[$p->team_id]['members'][$p->slot_index])) {
                    // Update slot dengan data peserta (overwrite untuk sinkronisasi)
                    $teams[$p->team_id]['members'][$p->slot_index] = [
                        'id' => $p->id_pengguna,
                        'username' => $p->username,
                        'avatar_url' => $p->avatar_url ?? null
                    ];
                }
            }
        }

        return view('siswa.tournament_lobby', [
            'turnamen' => $turnamen,
            'initialParticipants' => [], // Kosongkan, kita pakai $teams
            'user' => $user,
            'teams' => array_values($teams) // Kirim sebagai array [ {tim1}, {tim2}, ... ]
        ]);
    }

    /**
     * Endpoint JSON untuk polling status lobi oleh siswa.
     */
    public function lobbyStatus($kode)
    {
        $turnamen = DB::table('turnamen')->where('kode_room', $kode)->first();
        if (!$turnamen) {
            return response()->json(['status' => 'error', 'message' => 'Not Found'], 404);
        }

        // Cek dan update status turnamen jika waktu sudah habis
        $this->checkTournamentStatus($turnamen->id_turnamen);

        // Refresh data turnamen setelah update
        $turnamen = DB::table('turnamen')->where('kode_room', $kode)->first();

        $status = strtolower(trim($turnamen->status ?? ''));

        if ($status === 'berlangsung') {
            // Arahkan ke halaman start turnamen (halaman kuis/permainan)
            $tournamentStartUrl = url('/tournament/start/' . $turnamen->id_turnamen);
            return response()->json([
                'status' => 'Berlangsung',
                'redirect_url' => $tournamentStartUrl
            ]);
        }
        if ($status === 'selesai') {
            return response()->json(['status' => 'Selesai', 'redirect_url' => route('home')]);
        }

        // --- Logika Data Polling ---
        $response = ['status' => $turnamen->status]; // misal: 'Menunggu'

        if ($turnamen->mode === 'solo') {
            $participants = DB::table('pesertaturnamen')
                ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
                ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
                ->select('pengguna.username', 'pengguna.avatar_url')
                ->get();
            $response['participants'] = $participants;

        } else {
            // --- Logika BARU untuk TIM (Sama seperti di method lobby()) ---
            $maxTeamSize = $turnamen->max_team_members ?? 4;
            // Hitung jumlah tim: max_peserta adalah hasil dari maxTeams × maxTeamMembers
            // Jadi jumlah tim = max_peserta / max_team_members
            $totalTeams = (int) ($turnamen->max_peserta / $maxTeamSize);
            $teams = [];
            for ($i = 1; $i <= $totalTeams; $i++) {
                $teams[$i] = ['id' => $i, 'name' => 'Team ' . $i, 'members' => array_fill(0, $maxTeamSize, null)];
            }
            $participants = DB::table('pesertaturnamen')
                ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
                ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
                ->select('pengguna.id_pengguna', 'pengguna.username', 'pengguna.avatar_url', 'pesertaturnamen.team_id', 'pesertaturnamen.slot_index')
                ->get();
            foreach ($participants as $p) {
                if ($p->team_id !== null && $p->slot_index !== null) {
                    if (isset($teams[$p->team_id]) && isset($teams[$p->team_id]['members'][$p->slot_index])) {
                        // Update slot dengan data peserta (overwrite untuk sinkronisasi)
                        $teams[$p->team_id]['members'][$p->slot_index] = [
                            'id' => $p->id_pengguna,
                            'username' => $p->username,
                            'avatar_url' => $p->avatar_url ?? null
                        ];
                    }
                }
            }
            $response['teams'] = array_values($teams);
        }

        return response()->json($response);
    }

    /**
     * [METHOD BARU] Menangani perpindahan tim/slot oleh siswa.
     */
    public function moveTeam(Request $request, $kode)
    {
        $penggunaId = session('pengguna_id');
        if (!$penggunaId) {
            return response()->json(['message' => 'Sesi tidak valid.'], 401);
        }

        $turnamen = DB::table('turnamen')->where('kode_room', $kode)->first();
        if (!$turnamen || $turnamen->status !== 'Menunggu') {
            return response()->json(['message' => 'Turnamen tidak bisa digabungi.'], 403);
        }

        // Ambil data 'peserta' untuk pengguna ini
        $peserta = DB::table('pesertaturnamen')
            ->where('id_turnamen', $turnamen->id_turnamen)
            ->where('id_pengguna', $penggunaId)
            ->first();

        if (!$peserta) {
            return response()->json(['message' => 'Anda belum bergabung dengan turnamen ini.'], 403);
        }

        $newTeamId = $request->input('team_id');
        $newSlotIndex = $request->input('slot_index');

        // Jika newTeamId atau newSlotIndex adalah null, berarti siswa 'Keluar dari Tim'
        if ($newTeamId === null || $newSlotIndex === null) {
            DB::table('pesertaturnamen')
                ->where('id_peserta', $peserta->id_peserta)
                ->update(['team_id' => null, 'slot_index' => null]);
            return response()->json(['success' => true, 'message' => 'Keluar dari tim.']);
        }

        // --- Logika Pindah Slot ---
        try {
            DB::transaction(function () use ($turnamen, $peserta, $penggunaId, $newTeamId, $newSlotIndex) {
                // 1. Validasi slot index tidak melebihi max_team_members
                $maxTeamSize = $turnamen->max_team_members ?? 4;
                if ($newSlotIndex >= $maxTeamSize || $newSlotIndex < 0) {
                    throw new \Exception('Slot index tidak valid.');
                }

                // 2. Cek apakah slot baru sudah terisi (kecuali jika itu slot yang sama dengan user ini)
                $existingSlot = DB::table('pesertaturnamen')
                    ->where('id_turnamen', $turnamen->id_turnamen)
                    ->where('team_id', $newTeamId)
                    ->where('slot_index', $newSlotIndex)
                    ->where('id_peserta', '!=', $peserta->id_peserta) // Kecuali jika itu slot user sendiri
                    ->lockForUpdate() // Kunci baris agar tidak ada 'race condition'
                    ->first();

                if ($existingSlot) {
                    throw new \Exception('Slot sudah terisi oleh pemain lain.');
                }

                // 3. Kosongkan slot lama (jika ada)
                DB::table('pesertaturnamen')
                    ->where('id_peserta', $peserta->id_peserta)
                    ->update(['team_id' => null, 'slot_index' => null]);

                // 4. Isi slot baru
                DB::table('pesertaturnamen')
                    ->where('id_peserta', $peserta->id_peserta)
                    ->update([
                        'team_id' => $newTeamId,
                        'slot_index' => $newSlotIndex
                    ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409); // 409 = Conflict
        }

        return response()->json(['success' => true, 'message' => 'Berhasil pindah tim.']);
    }

    /**
     * [BARU] Cek dan update status turnamen berdasarkan waktu
     */
    private function checkTournamentStatus($id)
    {
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();

        if (!$turnamen || $turnamen->status !== 'Berlangsung') {
            return; // Tidak perlu update jika bukan status Berlangsung
        }

        // Cek apakah waktu turnamen sudah habis
        if ($turnamen->tanggal_pelaksanaan) {
            $startTime = Carbon::parse($turnamen->tanggal_pelaksanaan);
            $duration = $turnamen->durasi_pengerjaan ?? 45; // dalam menit
            $endTime = $startTime->copy()->addMinutes($duration);
            $now = Carbon::now();

            // Jika waktu sudah habis, ubah status menjadi Selesai
            if ($now->greaterThanOrEqualTo($endTime)) {
                DB::table('turnamen')
                    ->where('id_turnamen', $id)
                    ->update([
                        'status' => 'Selesai',
                        'updated_at' => $now
                    ]);
            }
        }
    }
}   