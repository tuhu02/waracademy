<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pengguna; 
use Carbon\Carbon;

class SiswaTournamentController extends Controller
{
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
        $levelMinimal = 2;
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

        // Ambil data user
        $user = DB::table('pengguna')->where('id_pengguna', $penggunaId)->first();

        // Broadcast via Pusher
        event(new \App\Events\SiswaJoinedTournament($turnamen->id_turnamen, [
            'id' => $user->id_pengguna,
            'username' => $user->username,
            'avatar_url' => $user->avatar_url
        ]));

        // Kembalikan URL yang valid — gunakan nama route yang ada di routes/web.php: 'tournament.lobby'
        // Gunakan URL langsung supaya tidak bergantung pada nama parameter rute ({code} vs {kode})
        $lobbyUrl = route('tournament.lobby', ['kode' => $kode]);
        return response()->json([
            'redirect_url' => $lobbyUrl
        ], 200);
    }

    private function checkTournamentStatus($id)
    {
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();

        if (!$turnamen) {
            return;
        }

        $now = now();

        // Jika turnamen berstatus "Berlangsung" dan waktu sudah habis
        if ($turnamen->status === 'Berlangsung' && $turnamen->end_time && $now->gt($turnamen->end_time)) {
            // Update status ke "Selesai"
            DB::table('turnamen')->where('id_turnamen', $id)
                ->update(['status' => 'Selesai']);
        }
        
        // Jika turnamen berstatus "Menunggu" dan sudah waktunya mulai
        if ($turnamen->status === 'Menunggu' && $turnamen->start_time && $now->gte($turnamen->start_time)) {
            // Update status ke "Berlangsung"
            DB::table('turnamen')->where('id_turnamen', $id)
                ->update(['status' => 'Berlangsung']);
        }
    }

    public function startTournament($id)
    {
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        
        if (!$turnamen) {
            abort(404, 'Turnamen tidak ditemukan.');
        }


        if ($turnamen->end_time && now()->gt($turnamen->end_time)) {
            return redirect()->route('tournament.leaderboard', $id)
                ->with('error', 'Waktu turnamen telah habis.');
        }


        // Debug: Lihat status sebenarnya
        // dd($turnamen->status, $turnamen->id_turnamen, $turnamen->mode); // Uncomment untuk debugging

        // Izinkan akses jika status "Berlangsung" ATAU "Menunggu" (untuk testing)
        if (strtolower(trim($turnamen->status ?? '')) !== 'berlangsung') {
            // Untuk sementara, izinkan akses meskipun status bukan "Berlangsung"
            // return redirect()->route('tournament.lobby', ['kode' => $turnamen->kode_room])
            //     ->with('error', 'Turnamen belum dimulai atau sudah selesai.');
            
            // Atau tampilkan error JSON (sesuai pesan yang Anda lihat)
            return response()->json(['message' => 'Turnamen sudah dimulai atau selesai.'], 403);
        }

        // Ambil soal untuk turnamen
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

            if (count($choices) > 0) {
                $questions[] = [
                    'id' => $q->id,
                    'teks_pertanyaan' => $q->teks_pertanyaan ?? '',
                    'options' => $choices
                ];
            }
        }

        // dd($questionsf);

        // Render gameplay blade
        return view('siswa.tournament_game', [
            'turnamen' => $turnamen,
            'questions' => $questions
        ]);
    }

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
        $answers = [];
        
        if (!empty($answersJson)) {
            if (is_string($answersJson)) {
                $answers = json_decode($answersJson, true) ?? [];
            } elseif (is_array($answersJson)) {
                $answers = $answersJson;
            }
        }        

        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        $skorPerSoal = $turnamen->skor_per_soal ?? 10; 
        $timeTaken = max(0, Carbon::parse($turnamen->start_time)->diffInSeconds(now()));

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

            $choiceIds = array_values(array_filter($answers, fn($v) => $v !== null));
            if (!empty($choiceIds)) {
                $allChoices = DB::table('turnamen_pilihan_jawaban')
                    ->whereIn('id_jawaban', $choiceIds)
                    ->get()
                    ->keyBy('id_jawaban'); // Key by id_jawaban untuk lookup cepat
            }
        }

        try {
            DB::transaction(function () use ($peserta, $answers, &$totalScore, &$correctCount, &$answeredCount, $timeTaken, $totalTime, &$remainingTime, $allQuestions, $allChoices, $skorPerSoal) {
                // Hapus jawaban lama (jika ada) untuk peserta ini agar tidak duplikat
                DB::table('turnamen_jawaban_peserta')
                    ->where('id_peserta', $peserta->id_peserta)
                    ->delete();

                $baseScore = 0; // Base score akan dihitung dari poin_per_soal

                foreach ($answers as $questionId => $choiceId) {
                    $answeredCount++; // Hitung jumlah soal yang dijawab

                    // Ambil data pertanyaan dari collection yang sudah di-load (tidak perlu query lagi)
                    $question = $allQuestions->get($questionId);
                    $poinPerSoal = $skorPerSoal;

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
                        'skor_akhir' => $totalScore, // Bulatkan ke 2 desimal
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

        // Mode TIM: Ambil leaderboard per tim dari tim_turnamen
        if ($turnamen->mode === 'tim') {
            $leaderboardRaw = DB::table('pesertaturnamen')
                ->join('tim_turnamen', function($join) use ($id) {
                    $join->on('pesertaturnamen.id_tim', '=', 'tim_turnamen.id_tim')
                         ->where('tim_turnamen.id_turnamen', '=', $id);
                })
                ->where('pesertaturnamen.id_turnamen', $id)
                ->where('pesertaturnamen.id_pengguna', null)  // Hanya ambil peserta tim (bukan individual)
                ->select(
                    'pesertaturnamen.*',
                    'tim_turnamen.nama_tim as nama',
                    DB::raw("NULL as avatar_url")
                )
                ->orderBy('pesertaturnamen.skor_akhir', 'desc')
                ->orderBy('pesertaturnamen.updated_at', 'asc')
                ->get();
        } else {
            // Mode SOLO: Ambil leaderboard per individu
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
        }

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

            // Cek apakah ini data user saat ini (untuk solo: id_pengguna; untuk tim: id_tim)
            $isMe = $turnamen->mode === 'tim' ? ($r->id_tim == $peserta->id_tim) : ($r->id_pengguna == $penggunaId);

            $leaderboard[] = [
                'rank' => $currentRank,
                'id' => $r->id_peserta,
                'nama' => $r->nama ?? 'Tim Tidak Diketahui',
                'kelas' => '-',
                'avatar_url' => $r->avatar_url,
                'skor' => $r->skor_akhir ?? 0,
                'correct' => $participantCorrect,
                'answered' => $participantAnswered,
                'status' => $r->status ?? 'active',
                'is_me' => $isMe,
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

        // Ambil peserta untuk user
        $peserta = DB::table('pesertaturnamen')
            ->where('id_turnamen', $id)
            ->where('id_pengguna', $penggunaId)
            ->first();

        // Mode TIM: Ambil leaderboard per tim dari tim_turnamen
        if ($turnamen->mode === 'tim') {
            $leaderboardRaw = DB::table('pesertaturnamen')
                ->join('tim_turnamen', function($join) use ($id) {
                    $join->on('pesertaturnamen.id_tim', '=', 'tim_turnamen.id_tim')
                         ->where('tim_turnamen.id_turnamen', '=', $id);
                })
                ->where('pesertaturnamen.id_turnamen', $id)
                ->where('pesertaturnamen.id_pengguna', null)  // Hanya ambil peserta tim (bukan individual)
                ->select(
                    'pesertaturnamen.*',
                    'tim_turnamen.nama_tim as nama',
                    DB::raw("NULL as avatar_url")
                )
                ->orderBy('pesertaturnamen.skor_akhir', 'desc')
                ->orderBy('pesertaturnamen.updated_at', 'asc')
                ->get();
        } else {
            // Mode SOLO: Ambil leaderboard per individu
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
        }

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

            // Cek apakah ini data user saat ini (untuk solo: id_pengguna; untuk tim: id_tim)
            $isMe = $turnamen->mode === 'tim' ? ($r->id_tim == ($peserta->id_tim ?? null)) : ($r->id_pengguna == $penggunaId);

            $leaderboard[] = [
                'rank' => $currentRank,
                'id' => $r->id_peserta,
                'nama' => $r->nama ?? 'Tim Tidak Diketahui',
                'kelas' => '-',
                'avatar_url' => $r->avatar_url,
                'skor' => $r->skor_akhir ?? 0,
                'correct' => $participantCorrect,
                'answered' => $participantAnswered,
                'status' => $r->status ?? 'active',
                'is_me' => $isMe,
            ];
        }

        $myRank = collect($leaderboard)->where('is_me', true)->first()['rank'] ?? null;
        $myScore = $peserta->skor_akhir ?? 0;

        return response()->json([
            'status' => $turnamen->status,
            'leaderboard' => $leaderboard,
            'myRank' => $myRank,
            'myScore' => $myScore,
        ]);
    }

    public function lobby($kode)
    {
        
        
        $user = Pengguna::find(session('pengguna_id'));
        $turnamen = DB::table('turnamen')->where('kode_room', $kode)->first();
        
        if (!$turnamen) {
            abort(404, 'Turnamen tidak ditemukan.');
        }

        $peserta = DB::table('pesertaturnamen')
            ->where('id_turnamen', $turnamen->id_turnamen)
            ->where('id_pengguna', session('pengguna_id'))
            ->first();

        if (!$peserta) {
            return redirect()->route('home')->with('error', 'Anda belum bergabung pada turnamen ini.');
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
        ->select('pengguna.id_pengguna', 'pengguna.username', 'pengguna.avatar_url', 'pesertaturnamen.id_tim', 'pesertaturnamen.slot_index')
        ->get();
        
        // 3. Masukkan peserta ke slot tim mereka
        foreach ($participants as $p) {
            if ($p->id_tim !== null && $p->slot_index !== null) {
                // Pastikan id_tim dan slot_index valid
                if (isset($teams[$p->id_tim])) {
                    // Update slot dengan data peserta (overwrite untuk sinkronisasi)
                    $teams[$p->id_tim]['members'][$p->slot_index] = [
                        'id' => $p->id_pengguna,
                        'username' => $p->username,
                        'avatar_url' => $p->avatar_url ?? null
                    ];
                }
            }
        }

        // dd($teams);
        return view('siswa.tournament_lobby', [
            'turnamen' => $turnamen,
            'initialParticipants' => [], // Kosongkan, kita pakai $teams
            'user' => $user,
            'teams' => array_values($teams) // Kirim sebagai array [ {tim1}, {tim2}, ... ]
        ]);
    }

    public function lobbyStatus($kode)
    {
        
        $turnamen = DB::table('turnamen')->where('kode_room', $kode)->first();
        if (!$turnamen) {
            return response()->json(['status' => 'error', 'message' => 'Not Found'], 404);
        }

        $status = $turnamen->status ?? 'Menunggu';

        // server time (untuk countdown)
        $server_time = now()->toDateTimeString();
        $start_time = $turnamen->start_time ?? $turnamen->tanggal_pelaksanaan ?? null;
        $redirect_url = url('/tournament/start/' . $turnamen->id_turnamen);

        $response = [
            'status' => $status,
            'server_time' => $server_time,
            'start_time' => $start_time ? (string)$start_time : null,
            'redirect_url' => $redirect_url,
        ];

        // Logika untuk mode solo
        if ($turnamen->mode === 'solo') {
            $participants = DB::table('pesertaturnamen')
                ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
                ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
                ->select('pengguna.username', 'pengguna.avatar_url')
                ->get();
            $response['participants'] = $participants;
        } 
        // Logika untuk mode tim
        else {
            $maxTeamSize = $turnamen->max_team_members ?? 4;
            $totalTeams = (int) ($turnamen->max_peserta / $maxTeamSize);
            
            $teams = [];
            for ($i = 1; $i <= $totalTeams; $i++) {
                $teams[$i] = [
                    'id' => $i,
                    'name' => 'Team ' . $i,
                    'members' => array_fill(0, $maxTeamSize, null)
                ];
            }

            // Ambil peserta dan masukkan ke slot
            $participants = DB::table('pesertaturnamen')
                ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
                ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
                ->select('pengguna.id_pengguna', 'pengguna.username', 'pengguna.avatar_url', 'pesertaturnamen.id_tim', 'pesertaturnamen.slot_index')
                ->get();

            foreach ($participants as $p) {
                if ($p->id_tim !== null && $p->slot_index !== null && isset($teams[$p->id_tim])) {
                    $teams[$p->id_tim]['members'][$p->slot_index] = [
                        'id' => $p->id_pengguna,
                        'username' => $p->username,
                        'avatar_url' => $p->avatar_url ?? null
                    ];
                }
            }

            $response['teams'] = array_values($teams);
        }

        return response()->json($response);
    }   

    public function submitQuestion(Request $request, $id)
    {
        $userId = session('pengguna_id');

        if (!$userId) {
            return response()->json(['message' => 'Sesi tidak valid.'], 401);
        }

        $questionId = $request->input('id_pertanyaan_turnamen');
        $chosen = $request->input('chosen_option');

        if (!$questionId) {
            return response()->json(['message' => 'id_pertanyaan_turnamen required'], 422);
        }

        // Ambil turnamen (ada mode: solo/tim)
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            return response()->json(['message' => 'Turnamen tidak ditemukan.'], 404);
        }
        $isSolo = ($turnamen->mode === 'solo');
        if ($isSolo) {
            $peserta = DB::table('pesertaturnamen')
                ->where('id_turnamen', $id)
                ->where('id_pengguna', $userId)
                ->first();
            if (!$peserta) {
                $pesertaId = DB::table('pesertaturnamen')->insertGetId([
                    'id_turnamen' => $id,
                    'id_pengguna' => $userId,
                    'team_id' => null,   // SOLO → tidak pakai tim
                    'created_at' => now()
                ]);

                $peserta = DB::table('pesertaturnamen')->where('id_peserta', $pesertaId)->first();
            }

        }
        else {
            if (!Schema::hasTable('tim_anggota')) {
                return response()->json(['message' => 'Mode tim tidak bisa digunakan karena tabel tim_anggota tidak ada.'], 500);
            }

            // Cek tim
            $anggota = DB::table('tim_anggota')->where('id_pengguna', $userId)->first();
            if (!$anggota) {
                return response()->json(['message' => 'Anda belum berada di tim.'], 403);
            }

            // Cek peserta tim
            $peserta = DB::table('pesertaturnamen')
                ->where('id_turnamen', $id)
                ->where('team_id', $anggota->team_id)
                ->first();

            if (!$peserta) {
                return response()->json(['message' => 'Tim Anda tidak terdaftar dalam turnamen ini.'], 404);
            }
        }

        $exists = DB::table('turnamen_jawaban_peserta')
            ->where('id_peserta', $peserta->id_peserta)
            ->where('id_pertanyaan_turnamen', $questionId)
            ->first();

        $isCorrect = 0;

        if (!is_null($chosen)) {
            $jaw = DB::table('turnamen_pilihan_jawaban')
                ->where('id_pertanyaan_turnamen', $questionId)
                ->where(function ($q) use ($chosen) {
                    $q->where('id_jawaban', $chosen)
                    ->orWhere('teks_jawaban', $chosen);
                })
                ->first();

            if ($jaw && (int)$jaw->adalah_benar === 1) {
                $isCorrect = 1;
            }
        }

        $now = Carbon::now();

        if ($exists) {
            DB::table('turnamen_jawaban_peserta')->where('id', $exists->id)
                ->update([
                    'id_jawaban_dipilih' => $chosen,
                    'is_correct' => $isCorrect,
                    'answered_at' => $now
                ]);
            Log::info('Answer updated', [
                'id_peserta' => $peserta->id_peserta,
                'id_pertanyaan' => $questionId,
                'is_correct' => $isCorrect
            ]);
        } else {
            DB::table('turnamen_jawaban_peserta')->insert([
                'id_peserta' => $peserta->id_peserta,
                'id_pertanyaan_turnamen' => $questionId,
                'id_jawaban_dipilih' => $chosen,
                'is_correct' => $isCorrect,
                'answered_at' => $now
            ]);
            Log::info('Answer inserted', [
                'id_peserta' => $peserta->id_peserta,
                'id_pertanyaan' => $questionId,
                'is_correct' => $isCorrect
            ]);
        }

        return response()->json(['success' => true, 'is_correct' => $isCorrect, 'peserta_id' => $peserta->id_peserta]);
    }

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

        $newTeamId = $request->input('id_tim');
        $newSlotIndex = $request->input('slot_index');

        // Jika newTeamId atau newSlotIndex adalah null, berarti siswa 'Keluar dari Tim'
        if ($newTeamId === null || $newSlotIndex === null) {
            DB::table('pesertaturnamen')
                ->where('id_peserta', $peserta->id_peserta)
                ->update(['id_tim' => null, 'slot_index' => null]);
            // Hapus juga entri di `tim_anggota` agar sumber kebenaran tetap konsisten
            $deleted = DB::table('tim_anggota')->where('id_pengguna', $penggunaId)->delete();
            if ($deleted) {
                Log::info('Removed tim_anggota entry when user left team', [
                    'user_id' => $penggunaId,
                    'turnamen_kode' => $kode ?? null,
                    'context' => 'moveTeam.leave'
                ]);
            }
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
                    ->where('id_tim', $newTeamId)
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
                    ->update(['id_tim' => null, 'slot_index' => null]);

                // 4. Isi slot baru
                DB::table('pesertaturnamen')
                    ->where('id_peserta', $peserta->id_peserta)
                    ->update([
                        'id_tim' => $newTeamId,
                        'slot_index' => $newSlotIndex
                    ]);

                // --- Sinkronisasi: pastikan `tim_anggota` mencerminkan perubahan ini ---
                // Hapus entri lama (jika ada) untuk pengguna ini
                DB::table('tim_anggota')->where('id_pengguna', $penggunaId)->delete();

                // Masukkan entri baru untuk anggota tim
                DB::table('tim_anggota')->insert([
                    'id_tim' => $newTeamId,
                    'id_pengguna' => $penggunaId,
                    'slot_index' => $newSlotIndex,
                    'joined_at' => now()
                ]);

                Log::info('Synchronized tim_anggota after moveTeam', [
                    'user_id' => $penggunaId,
                    'turnamen_id' => $turnamen->id_turnamen ?? null,
                    'new_team_id' => $newTeamId,
                    'new_slot_index' => $newSlotIndex,
                    'context' => 'moveTeam.update'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409); // 409 = Conflict
        }

        return response()->json(['success' => true, 'message' => 'Berhasil pindah tim.']);
    }

    public function finishTournament($idPeserta)
    {
        try {
            $peserta = DB::table('pesertaturnamen')
            ->where('id_peserta', $idPeserta)
            ->first();

            if (!$peserta) {
                return response()->json(['message' => 'Peserta tidak ditemukan'], 404);
            }

            $turnamen = DB::table('turnamen')
                ->where('id_turnamen', $peserta->id_turnamen)
                ->first();

            // Ambil aggregate jawaban
            $stat = DB::table('turnamen_jawaban_peserta')
                ->where('id_peserta', $idPeserta)
                ->selectRaw('COUNT(*) as answered, SUM(is_correct) as correct')
                ->first();

            $answered = (int) ($stat->answered ?? 0);
            $correct  = (int) ($stat->correct ?? 0);

            // === BASE SCORE ===
            $baseScore = $correct * ($turnamen->skor_per_soal);

            // === ACCURACY BONUS ===
            if ($answered > 0) {
                $accuracy = $correct / $answered;
                $accuracyBonus = $accuracy * 20;
            } else {
                $accuracy = 0;
                $accuracyBonus = 0;
            }

            // === SPEED BONUS ===
            $totalTime = (int) $turnamen->durasi_pengerjaan * 60; // detik

            $start = Carbon::parse($turnamen->start_time);
            $finish = Carbon::now();
            $elapsed = $finish->diffInSeconds($start);

            $remaining = max(0, $totalTime - $elapsed);

            $speedBonus = ($totalTime > 0)
                ? ($remaining / $totalTime) * 20
                : 0;

            // === FINAL SCORE ===
            $totalScore = $baseScore + $accuracyBonus + $speedBonus;

            DB::table('pesertaturnamen')
                ->where('id_peserta', $idPeserta)
                ->update([
                    'skor_akhir' => round($totalScore, 2),
                    'waktu_selesai' => Carbon::now(),
                    'status' => 'finished',
                ]);

            return response()->json([
                'success' => true,
                'total_score' => round($totalScore, 2),
                'detail' => [
                    'correct' => $correct,
                    'answered' => $answered,
                    'base_score' => round($baseScore, 2),
                    'accuracy_bonus' => round($accuracyBonus, 2),
                    'speed_bonus' => round($speedBonus, 2),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
        
    }

    public function submitAll(Request $request, $id)
    {
        // id = id_turnamen
        $userId = session('pengguna_id');
        if (!$userId) {
            return response()->json(['message' => 'Sesi tidak valid.'], 401);
        }

        // temukan tim dan peserta
        $anggota = DB::table('tim_anggota')->where('id_pengguna', $userId)->first();
        if (!$anggota) {
            // fallback: periksa pesertaturnamen untuk id_tim yang mungkin disimpan langsung di participant
            $pFallback = DB::table('pesertaturnamen')
                ->where('id_turnamen', $id)
                ->where('id_pengguna', $userId)
                ->first();

            if ($pFallback && !is_null($pFallback->id_tim)) {
                Log::warning('tim_anggota missing; falling back to pesertaturnamen for team id', [
                    'user_id' => $userId,
                    'turnamen_id' => $id,
                    'fallback_id_tim' => $pFallback->id_tim,
                    'context' => 'submitAll'
                ]);
                $anggota = (object)[ 'id_tim' => $pFallback->id_tim, 'id_pengguna' => $userId ];
            } else {
                return response()->json(['message' => 'Anda belum berada di tim.'], 403);
            }
        }

        $peserta = DB::table('pesertaturnamen')
            ->where('id_turnamen', $id)
            ->where('team_id', $anggota->id_tim)
            ->first();

        if (!$peserta) return response()->json(['message' => 'Peserta tim tidak ditemukan.'], 404);

        $now = Carbon::now();

        // tandai peserta selesai
        DB::table('pesertaturnamen')
            ->where('id_peserta', $peserta->id_peserta)
            ->update([
                'status' => 'finished',
                'waktu_selesai' => $now,
                'waktu_submit' => $now,
                'updated_at' => Carbon::now()
            ]);

        // hitung skor akhir (team)
        $teamScore = \App\Services\TournamentScoringService::calculateTeamScore($anggota->id_tim, $id);

        DB::table('pesertaturnamen')
            ->where('id_peserta', $peserta->id_peserta)
            ->update(['skor_akhir' => $teamScore]);

        return response()->json(['success' => true, 'skor_akhir' => $teamScore]);
    }

    public function ajaxLeaderboard($id)
    {
        $leaderboard = $this->leaderboardStatus($id); // method yang sudah ada

        return response()->json([
            'leaderboard' => $leaderboard,
        ]);
    }

}