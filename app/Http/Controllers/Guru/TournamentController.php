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
            ->select('turnamen.*', DB::raw('COUNT(pesertaturnamen.id_peserta) as peserta_count'))
            ->groupBy('turnamen.id_turnamen')
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
            ->select('turnamen.*', DB::raw('COUNT(pesertaturnamen.id_peserta) as peserta_count'))
            ->groupBy('turnamen.id_turnamen')
            ->orderBy('turnamen.created_at', 'desc')
            ->get();

        return response()->json($turnamens);
    }

    /**
     * Show detail page for a single tournament (dynamic).
     */
    public function show($id)
    {
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            abort(404);
        }

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

            // map choices to A,B,C... and find the correct key
            $opsi = [];
            $letters = range('A', 'Z');
            $correctKey = null;
            foreach ($choicesRaw as $idx => $c) {
                $key = $letters[$idx] ?? (string)$idx;
                $opsi[$key] = $c->teks_jawaban;
                if ((int)$c->adalah_benar === 1) {
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

        // participants (basic info). join with pengguna to get username
        $participantsRaw = DB::table('pesertaturnamen')
            ->leftJoin('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $id)
            ->select('pesertaturnamen.*', 'pengguna.username as nama')
            ->orderBy('pesertaturnamen.joined_at', 'asc')
            ->get();

        $participants = [];
        $participantIds = $participantsRaw->pluck('id_peserta')->filter()->all();

        // Aggregate answers per participant to avoid N+1 queries
        $answersAgg = [];
        if (!empty($participantIds)) {
            $answers = DB::table('turnamen_jawaban_peserta')
                ->whereIn('id_peserta', $participantIds)
                ->select('id_peserta',
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
                    'total_answered' => (int)$a->total_answered,
                    'correct' => (int)$a->correct,
                    'wrong' => (int)$a->wrong,
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

            // compute waktu_tersisa in minutes based on joined_at
            $joined = isset($p->joined_at) ? Carbon::parse($p->joined_at) : null;
            $elapsedMin = 0;
            if ($joined) {
                $elapsedMin = max(0, (int)$joined->diffInMinutes($now));
            }
            $durasi = (int)($turnamen->durasi_pengerjaan ?? 0);
            $waktuTersisa = max(0, $durasi - $elapsedMin);

            $participants[] = [
                'id' => $p->id_peserta,
                'nama' => $p->nama ?? ('User '.$p->id_pengguna),
                'kelas' => $p->kelas ?? '-',
                'status' => ($p->status === 'active') ? 'mengerjakan' : (($p->status === 'finished') ? 'selesai' : 'belum'),
                'soal_dijawab' => $soalDijawab,
                'jawaban_benar' => $jawabanBenar,
                'jawaban_salah' => $jawabanSalah,
                'waktu_tersisa' => $waktuTersisa,
            ];
        }

        // simple leaderboard from peserta table (top by skor_akhir)
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
                'nama' => $r->nama ?? ('User '.$r->id_pengguna),
                'kelas' => $r->kelas ?? '-',
                'skor' => $r->skor_akhir ?? 0,
                'waktu_selesai' => $r->waktu_selesai ?? null,
                'lulus' => ($r->skor_akhir ?? 0) >= ($turnamen->passing_grade ?? 0),
            ];
        }

        // Normalize tournament object for view
        $viewTournament = [
            'id' => $turnamen->id_turnamen,
            'nama_turnamen' => $turnamen->nama_turnamen,
            'status' => $turnamen->status ?? 'Menunggu',
            'tanggal_pelaksanaan' => $turnamen->tanggal_pelaksanaan,
            'durasi' => $turnamen->durasi_pengerjaan,
            'jumlah_soal' => count($questions),
            'peserta_count' => $pesertaCount,
            'max_peserta' => $turnamen->max_peserta,
            'passing_grade' => $turnamen->passing_grade ?? null,
            'deskripsi' => $turnamen->deskripsi,
        ];

        return view('guru.tournament.show', compact('viewTournament', 'questions', 'participants', 'leaderboard'));
    }
    /**
     * Store a new tournament.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'duration' => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'point_per_question' => 'required|integer|min:0',
            'bonus_exp' => 'required|integer|min:0',
            'questions' => 'required|array|min:1',
        ]);

        // Validate questions
        foreach ($data['questions'] as $idx => $q) {
            if (!isset($q['text']) || !is_string($q['text']) || trim($q['text']) === '') {
                return response()->json(['message' => "Pertanyaan ke-".($idx+1)." belum diisi"], 422);
            }
            if (!isset($q['options']) || !is_array($q['options']) || count($q['options']) < 2) {
                return response()->json(['message' => "Pilihan jawaban untuk pertanyaan ke-".($idx+1)." tidak valid"], 422);
            }
        }

        // Generate unique kode_room for legacy `turnamen` table
        do {
            $kode = Str::upper(Str::random(6));
        } while (DB::table('turnamen')->where('kode_room', $kode)->exists());

        $creatorId = session('pengguna_id') ?? null;
        $now = Carbon::now();

        // Use DB transaction to ensure consistency across tables
        $result = DB::transaction(function () use ($data, $kode, $creatorId, $now) {
            // Insert into `turnamen` (legacy table)
            $turnamenId = DB::table('turnamen')->insertGetId([
                'nama_turnamen' => $data['name'],
                'kode_room' => $kode,
                'dibuat_oleh' => $creatorId,
                'level_minimal' => 20,
                'status' => 'Menunggu',
                'tanggal_pelaksanaan' => $data['date'] ?? null,
                'durasi_pengerjaan' => $data['duration'],
                'max_peserta' => $data['max_participants'],
                'deskripsi' => $data['description'] ?? null,
                'bonus_exp' => $data['bonus_exp'],
                'created_at' => $now,
                'updated_at' => $now,
            ], 'id_turnamen');

            // Insert questions into `turnamen_pertanyaan`
            foreach ($data['questions'] as $q) {
                $poin = isset($q['poin_per_soal']) ? (int)$q['poin_per_soal'] : (int)$data['point_per_question'];

                $questionId = DB::table('turnamen_pertanyaan')->insertGetId([
                    'id_turnamen' => $turnamenId,
                    'teks_pertanyaan' => $q['text'],
                    'poin_per_soal' => $poin,
                    // waktu_pengerjaan use default DB value if not provided
                    'tingkat_kesulitan' => $q['difficulty'] ?? 'sedang',
                    'mata_pelajaran' => $q['subject'] ?? null,
                    'created_at' => $now,
                ], 'id');

                // Insert choices
                foreach ($q['options'] as $optIndex => $optText) {
                    DB::table('turnamen_pilihan_jawaban')->insert([
                        'id_pertanyaan_turnamen' => $questionId,
                        'teks_jawaban' => $optText,
                        'adalah_benar' => (isset($q['correctAnswer']) && (int)$q['correctAnswer'] === $optIndex) ? 1 : 0,
                    ]);
                }
            }

            // Optionally add creator as participant in pesertaturnamen
            if ($creatorId) {
                // pesertaturnamen.status accepts enum('active','eliminated','finished')
                // use a valid value (or omit to use DB default). Also set lives_remaining to 3.
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

            return ['id' => $turnamenId, 'kode' => $kode];
        });

        return response()->json([
            'success' => true,
            'room_code' => $result['kode'],
            'turnamen_id' => $result['id'],
        ], 201);
    }
}
