<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TournamentController extends Controller
{
    /**
     * Display a listing of tournaments (legacy `turnamen` table).
     */
    public function index()
    {
        // Fetch tournaments with participant count
        $turnamens = DB::table('turnamen')
            ->leftJoin('pesertaturnamen', 'turnamen.id_turnamen', '=', 'pesertaturnamen.id_turnamen')
            ->selectRaw('turnamen.id_turnamen, turnamen.nama_turnamen, turnamen.created_at, turnamen.updated_at, COUNT(pesertaturnamen.id_peserta) as peserta_count')
            ->groupBy('turnamen.id_turnamen', 'turnamen.nama_turnamen', 'turnamen.created_at', 'turnamen.updated_at')
            ->orderBy('turnamen.created_at', 'desc')
            ->get();

        return view('guru.tournament.index', ['turnamens' => $turnamens]);
    }

    /**
     * Return tournaments as JSON for polling / realtime updates.
     */
    public function data()
    {
        $turnamens = DB::table('turnamen')
            ->leftJoin('pesertaturnamen', 'turnamen.id_turnamen', '=', 'pesertaturnamen.id_turnamen')
            ->select(
                'turnamen.id_turnamen',
                'turnamen.nama_turnamen',
                'turnamen.max_peserta',
                'turnamen.status',
                'turnamen.created_at',
                DB::raw('COUNT(pesertaturnamen.id_peserta) as peserta_count')
            )
            ->groupBy(
                'turnamen.id_turnamen',
                'turnamen.nama_turnamen',
                'turnamen.max_peserta',
                'turnamen.status',
                'turnamen.created_at'
            )
            ->orderBy('turnamen.created_at', 'desc')
            ->get();

        return response()->json($turnamens);
    }

    /**
     * Store a new tournament.
     * [DIPERBARUI]
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'mode' => 'required|string|in:solo,tim', // <-- BARU
            'maxTeamMembers' => 'nullable|integer|min:2', // <-- BARU
            'duration' => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'point_per_question' => 'required|integer|min:0',
            'bonus_exp' => 'required|integer|min:0',
            'questions' => 'required|array|min:1',
            // 'date' => 'nullable|date', // <-- DIHAPUS
        ]);

        // Validate questions
        foreach ($data['questions'] as $idx => $q) {
            if (!isset($q['text']) || !is_string($q['text']) || trim($q['text']) === '') {
                return response()->json(['message' => "Pertanyaan ke-" . ($idx + 1) . " belum diisi"], 422);
            }
            if (!isset($q['options']) || !is_array($q['options']) || count($q['options']) < 2) {
                return response()->json(['message' => "Pilihan jawaban untuk pertanyaan ke-" . ($idx + 1) . " tidak valid"], 422);
            }
        }

        // Generate unique kode_room
        do {
            $kode = Str::upper(Str::random(6));
        } while (DB::table('turnamen')->where('kode_room', $kode)->exists());

        $creatorId = session('pengguna_id') ?? null;
        $now = Carbon::now();

        // Use DB transaction
        $result = DB::transaction(function () use ($data, $kode, $creatorId, $now) {
            // Insert into `turnamen`
            $turnamenId = DB::table('turnamen')->insertGetId([
                'nama_turnamen' => $data['name'],
                'kode_room' => $kode,
                'dibuat_oleh' => $creatorId,
                'level_minimal' => 20,
                'status' => 'Menunggu', // <-- Default status
                // 'tanggal_pelaksanaan' => $data['date'] ?? null, // <-- DIHAPUS
                'mode' => $data['mode'], // <-- BARU
                'max_team_members' => ($data['mode'] === 'tim') ? $data['maxTeamMembers'] : null, // <-- BARU
                'durasi_pengerjaan' => $data['duration'],
                'skor_per_soal' => $data['point_per_question'],
                'max_peserta' => $data['max_participants'],
                'deskripsi' => $data['description'] ?? null,
                'bonus_exp' => $data['bonus_exp'],
                'created_at' => $now,
                'updated_at' => $now,
            ], 'id_turnamen');

            // Insert questions
            foreach ($data['questions'] as $q) {
                $poin = isset($q['poin_per_soal']) ? (int) $q['poin_per_soal'] : (int) $data['point_per_question'];

                $questionId = DB::table('turnamen_pertanyaan')->insertGetId([
                    'id_turnamen' => $turnamenId,
                    'teks_pertanyaan' => $q['text'],
                    'poin_per_soal' => $poin,
                    'tingkat_kesulitan' => $q['difficulty'] ?? 'sedang',
                    'mata_pelajaran' => $q['subject'] ?? null,
                    'created_at' => $now,
                ], 'id');

                // Insert choices
                foreach ($q['options'] as $optIndex => $optText) {
                    DB::table('turnamen_pilihan_jawaban')->insert([
                        'id_pertanyaan_turnamen' => $questionId,
                        'teks_jawaban' => $optText,
                        'adalah_benar' => (isset($q['correctAnswer']) && (int) $q['correctAnswer'] === $optIndex) ? 1 : 0,
                    ]);
                }
            }

            // Optionally add creator as participant, but only if creator is a siswa (student)
            if ($creatorId) {
                $creatorRole = DB::table('pengguna')->where('id_pengguna', $creatorId)->value('role');
                // Jika role tidak tersedia atau bukan 'siswa', jangan tambahkan
                if (strtolower((string) $creatorRole) === 'siswa') {
                    DB::table('pesertaturnamen')->insert([
                        'id_turnamen' => $turnamenId,
                        'id_pengguna' => $creatorId,
                        'skor_akhir' => 0,
                        'peringkat' => null,
                        'joined_at' => $now,
                        'status' => 'active',
                        'lives_remaining' => 3,
                    ]);
                }
            }


            // === BAGIAN 3: BUAT TIM OTOMATIS ===
            if ($data['mode'] === 'tim') {

                $turnamen = DB::table('turnamen')->where('id_turnamen', $turnamenId)->first();

                $maxMembers  = (int) ($turnamen->max_team_members ?? 4);
                $maxPeserta  = (int) ($turnamen->max_peserta ?? 30);

                $totalTeams = (int) ceil($maxPeserta / max(1, $maxMembers));

                for ($i = 1; $i <= $totalTeams; $i++) {
                    DB::table('tim_turnamen')->insert([
                        'id_turnamen' => $turnamenId,
                        'nama_tim' => "Tim {$i}",
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
            }


            return ['id' => $turnamenId, 'kode' => $kode];
        });

        return response()->json([
            'success' => true,
            'room_code' => $result['kode'],
            'turnamen_id' => $result['id'],
        ], 201);
    }

    /**
     * TAMPILAN SHOW "PINTAR"
     * Menampilkan Lobi, Monitor, atau Hasil berdasarkan status turnamen.
     * [DIPERBARUI]
     */
    public function show($id)
    {
        // Cek dan update status turnamen jika waktu sudah habis
        $this->checkAndUpdateStatus($id);

        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            abort(404);
        }

        // ==================================================================
        // 1. JIKA STATUS "MENUNGGU", TAMPILKAN LOBI
        // ==================================================================
        if ($turnamen->status === 'Menunggu') {
            // Lobi hanya perlu daftar peserta awal
            $participants = DB::table('pesertaturnamen')
                ->leftJoin('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
                ->where('pesertaturnamen.id_turnamen', $id)
                // Pastikan 'username' adalah kolom yang benar di tabel 'pengguna'
                ->select('pesertaturnamen.id_peserta as id', 'pengguna.username as nama')
                ->orderBy('pesertaturnamen.joined_at', 'asc')
                ->get();

            return view('guru.tournament.show', [
                'tournament' => $turnamen,
                'participants' => $participants, // Kirim data peserta awal
                'leaderboard' => [], // Kirim array kosong
                'questions' => [], // Kirim array kosong
            ]);
        }

        // ==================================================================
        // 2. JIKA "BERLANGSUNG" ATAU "SELESAI", TAMPILKAN MONITOR/HASIL
        //    (Ini adalah logika LENGKAP Anda yang sudah ada)
        // ==================================================================

        // participant count
        $pesertaCount = DB::table('pesertaturnamen')->where('id_turnamen', $id)->count();

        // questions + choices
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

            // map choices to A,B,C...
            $opsi = [];
            $letters = range('A', 'Z');
            $correctKey = null;
            foreach ($choicesRaw as $idx => $c) {
                $key = $letters[$idx] ?? (string) $idx;
                $opsi[$key] = $c->teks_jawaban;
                if ((int) $c->adalah_benar === 1) {
                    $correctKey = $key;
                }
            }

            $questions[] = [
                'id' => $q->id,
                'tipe' => 'Pilihan Ganda',
                'pertanyaan' => $q->teks_pertanyaan,
                'opsi' => $opsi,
                'jawaban_benar' => $correctKey,
            ];
        }

        // participants (detailed info)
        $participantsRaw = DB::table('pesertaturnamen')
            ->leftJoin('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $id)
            ->select('pesertaturnamen.*', 'pengguna.username as nama')
            ->orderBy('pesertaturnamen.joined_at', 'asc')
            ->get();

        $participants = [];
        $participantIds = $participantsRaw->pluck('id_peserta')->filter()->all();

        // Aggregate answers
        $answersAgg = [];
        if (!empty($participantIds)) {
            $answers = DB::table('turnamen_jawaban_peserta')
                ->whereIn('id_peserta', $participantIds)
                ->select(
                    'id_peserta',
                    DB::raw('COUNT(*) as total_answered'),
                    DB::raw('SUM(is_correct) as correct'),
                    DB::raw('SUM(CASE WHEN is_correct = 0 AND id_jawaban_dipilih IS NOT NULL THEN 1 ELSE 0 END) as wrong'),
                    DB::raw('MAX(answered_at) as last_answered')
                )
                ->groupBy('id_peserta')
                ->get()
                ->keyBy('id_peserta');

            foreach ($answers as $a) {
                $answersAgg[$a->id_peserta] = [
                    'total_answered' => (int) $a->total_answered,
                    'correct' => (int) $a->correct,
                    'wrong' => (int) $a->wrong,
                    'last_answered' => $a->last_answered,
                ];
            }
        }

        $now = Carbon::now();
        foreach ($participantsRaw as $p) {
            $agg = $answersAgg[$p->id_peserta] ?? null;

            $soalDijawab = $agg['total_answered'] ?? 0;
            $jawabanBenar = $agg['correct'] ?? 0;
            $jawabanSalah = $agg['wrong'] ?? 0;

            // compute waktu_tersisa
            $joined = isset($p->joined_at) ? Carbon::parse($p->joined_at) : null;
            $elapsedMin = 0;
            if ($joined) {
                $elapsedMin = max(0, (int) $joined->diffInMinutes($now));
            }
            $durasi = (int) ($turnamen->durasi_pengerjaan ?? 0);
            $waktuTersisa = max(0, $durasi - $elapsedMin);

            $participants[] = [
                'id' => $p->id_peserta,
                'nama' => $p->nama ?? ('User ' . $p->id_pengguna),
                'kelas' => $p->kelas ?? '-',
                'status' => ($p->status === 'active') ? 'mengerjakan' : (($p->status === 'finished') ? 'selesai' : 'belum'),
                'soal_dijawab' => $soalDijawab,
                'jawaban_benar' => $jawabanBenar,
                'jawaban_salah' => $jawabanSalah,
                'waktu_tersisa' => $waktuTersisa,
            ];
        }

        // Leaderboard
        $leaderboardRaw = DB::table('pesertaturnamen')
            ->leftJoin('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $id)
            ->select('pesertaturnamen.*', 'pengguna.username as nama')
            ->orderBy('pesertaturnamen.skor_akhir', 'desc')
            ->limit(50)
            ->get();

        $leaderboard = [];
        foreach ($leaderboardRaw as $r) {
            $leaderboard[] = [
                'id' => $r->id_peserta,
                'nama' => $r->nama ?? ('User ' . $r->id_pengguna),
                'kelas' => $r->kelas ?? '-',
                'skor' => $r->skor_akhir ?? 0,
                'waktu_selesai' => $r->waktu_selesai ?? null,
                'lulus' => ($r->skor_akhir ?? 0) >= ($turnamen->passing_grade ?? 0),
            ];
        }

        // Kirim semua data ke view 'show'
        return view('guru.tournament.show', [
            'tournament' => $turnamen,      // Data turnamen utama
            'questions' => $questions,      // Data pertanyaan
            'participants' => $participants,  // Data peserta terperinci
            'leaderboard' => $leaderboard,   // Data leaderboard
        ]);
    }

    /**
     * [BARU] [AJAX] Mengambil daftar peserta untuk lobi
     */
    public function getParticipants($id)
    {
        $participants = DB::table('pesertaturnamen')
            ->leftJoin('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $id)
            // Pastikan 'username' adalah kolom yang benar di tabel 'pengguna'
            ->select('pesertaturnamen.id_peserta as id', 'pengguna.username as nama')
            ->orderBy('pesertaturnamen.joined_at', 'asc')
            ->get();

        return response()->json($participants);
    }

    /**
     * [BARU] [AJAX] Memulai turnamen
     */
    public function startTournament(Request $request, $id)
    {
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();

        if (!$turnamen || $turnamen->status !== 'Menunggu') {
            return response()->json(['message' => 'Turnamen sudah dimulai atau selesai.'], 422);
        }

        $start = Carbon::now();
        $end   = $start->copy()->addMinutes($turnamen->durasi_pengerjaan);

        DB::transaction(function() use ($id, $turnamen, $start, $end) {

            // ============================
            // 1) Update status turnamen
            // ============================
            DB::table('turnamen')
                ->where('id_turnamen', $id)
                ->update([
                    'status' => 'Berlangsung',
                    'tanggal_pelaksanaan' => $start,
                    'start_time' => $start,
                    'end_time' => $end,
                    'updated_at' => Carbon::now()
                ]);

            // ============================
            // 2) Mode TIM → daftar tim sebagai peserta
            // ============================
            if ($turnamen->mode === 'tim') {

                // Ambil semua tim yang sudah dibuat otomatis pada saat create
                $teams = DB::table('tim_turnamen')
                    ->where('id_turnamen', $id)
                    ->get();

                foreach ($teams as $team) {

                    // Safety: hapus jika pernah ada duplikat (harusnya tidak ada)
                    DB::table('pesertaturnamen')
                        ->where('id_turnamen', $id)
                        ->where('id_tim', $team->id_tim)
                        ->delete();

                    // Tambahkan tim sebagai 1 "peserta"
                    DB::table('pesertaturnamen')->insert([
                        'id_turnamen' => $id,
                        'id_pengguna' => null,     // Karena ini peserta tim, bukan individu
                        'id_tim' => $team->id_tim, // <-- Penting!
                        'skor_akhir' => 0,
                        'peringkat' => null,
                        'joined_at' => $start,
                        'status' => 'active',
                        'lives_remaining' => null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            // ============================
            // 3) Mode SOLO → tidak perlu apa-apa
            // ============================
            // Peserta sudah masuk otomatis saat siswa join
        });

        return response()->json([
            'message'    => 'Turnamen berhasil dimulai!',
            'start_time' => $start->toDateTimeString(),
            'end_time'   => $end->toDateTimeString(),
        ]);
    }


    /**
     * [BARU] [AJAX] Mengakhiri turnamen (mengubah status menjadi Selesai)
     */
    public function endTournament(Request $request, $id)
    {
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();

        // Validasi: Hanya bisa diakhiri jika status "Berlangsung"
        if (!$turnamen || $turnamen->status !== 'Berlangsung') {
            return response()->json(['message' => 'Turnamen tidak sedang berlangsung.'], 422);
        }

        // --- UBAH STATUS DI DATABASE ---
        DB::table('turnamen')
            ->where('id_turnamen', $id)
            ->update([
                'status' => 'Selesai',
                'updated_at' => Carbon::now()
            ]);
        $this->giveBonusExpToTop3($id);
        return response()->json(['message' => 'Turnamen berhasil diakhiri!']);
    }

    /**
     * [BARU] Cek dan update status turnamen berdasarkan waktu
     * Method ini bisa dipanggil secara berkala atau saat halaman di-refresh
     */
    public function checkAndUpdateStatus($id)
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
                $this->giveBonusExpToTop3($id);
            }
        }
    }

    public function getData()
    {
        $guruId = session('pengguna_id'); 

        $turnamen = DB::table('turnamen')
            ->leftJoin('pesertaturnamen', 'turnamen.id_turnamen', '=', 'pesertaturnamen.id_turnamen')
            ->where('turnamen.dibuat_oleh', $guruId)
            ->select(
                'turnamen.id_turnamen',
                'turnamen.nama_turnamen',
                'turnamen.status',
                'turnamen.max_peserta',
                DB::raw('COUNT(pesertaturnamen.id_peserta) as peserta_count')
            )
            ->groupBy(
                'turnamen.id_turnamen',
                'turnamen.nama_turnamen',
                'turnamen.status',
                'turnamen.max_peserta'
            )
            ->orderBy('turnamen.created_at', 'desc')
            ->get();

        return response()->json($turnamen);
    }


    public function create()
    {
        return view('guru.tournament.create');
    }

    public function participants($id)
    {
        $participants = DB::table('pesertaturnamen')
            ->leftJoin('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $id)
            ->select(
                'pesertaturnamen.id_peserta as id',
                'pengguna.username as nama'
            )
            ->orderBy('pesertaturnamen.joined_at', 'asc')
            ->get();
    
        return response()->json($participants);
    }      

    public function ajaxStatus($id)
    {
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            return response()->json(['error' => 'Turnamen tidak ditemukan'], 404);
        }

        return response()->json([
            'id_turnamen' => $turnamen->id_turnamen,
            'status' => $turnamen->status,
            'tanggal_pelaksanaan' => $turnamen->tanggal_pelaksanaan,
            'start_time' => Carbon::parse($turnamen->start_time)->toIso8601String(),
            'end_time' => Carbon::parse($turnamen->end_time)->toIso8601String(),
            'durasi_pengerjaan' => $turnamen->durasi_pengerjaan,
        ]);
    }

    public function ajaxForceEnd(Request $request, $id)
    {
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            return response()->json(['error' => 'Turnamen tidak ditemukan'], 404);
        }

        // Jalankan check/update server-side
        $this->checkAndUpdateStatus($id);

        $turnamenUpdated = DB::table('turnamen')->where('id_turnamen', $id)->first();

        return response()->json([
            'message' => 'Check selesai',
            'status' => $turnamenUpdated->status,
            'end_time' => $turnamenUpdated->end_time,
        ]);
    }

    private function giveBonusExpToTop3($turnamenId)
    {
        // ambil bonus exp turnamen
        $turnamen = DB::table('turnamen')->where('id_turnamen', $turnamenId)->first();
        if (!$turnamen) return;

        $bonus = $turnamen->bonus_exp ?? 0;

        // ambil top 3 peserta berdasarkan skor_akhir
        $top3 = DB::table('pesertaturnamen')
            ->where('id_turnamen', $turnamenId)
            ->orderBy('skor_akhir', 'desc')
            ->limit(3)
            ->get();

        if ($top3->isEmpty()) return;

        // Hitungan bonus
        $bonusCalc = [
            0 => round($bonus * 0.50),
            1 => round($bonus * 0.30),
            2 => round($bonus * 0.20),
        ];

        foreach ($top3 as $i => $p) {
            DB::table('pesertaturnamen')
                ->where('id_peserta', $p->id_peserta)
                ->update([
                    'bonus_exp_didapat' => $bonusCalc[$i] ?? 0
                ]);
        }
    }

}