<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id)->first();
        if (!$turnamen) {
            abort(404, 'Turnamen tidak ditemukan.');
        }

        // Pastikan turnamen sudah Berlangsung
        if (strtolower(trim($turnamen->status ?? '')) !== 'berlangsung') {
            // Jika belum, arahkan kembali ke lobi
            return redirect()->route('tournament.lobby', ['kode' => $turnamen->kode_room]);
        }

        // Ambil soal untuk turnamen (minimal)
        $questionsRaw = DB::table('turnamen_pertanyaan')->where('id_turnamen', $id)->get();
        $questions = [];
        foreach ($questionsRaw as $q) {
            $choices = DB::table('turnamen_pilihan_jawaban')->where('id_pertanyaan_turnamen', $q->id)->get();
            $questions[] = [
                'id' => $q->id,
                'text' => $q->teks_pertanyaan ?? '',
                'choices' => $choices
            ];
        }

        return view('siswa.tournament_play', [
            'turnamen' => $turnamen,
            'questions' => $questions
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
        $totalTeams = (int) ceil($turnamen->max_peserta / $maxTeamSize);
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
                    // Jika slotnya belum terisi (ini untuk keamanan, seharusnya tidak terjadi)
                    if ($teams[$p->team_id]['members'][$p->slot_index] === null) {
                        $teams[$p->team_id]['members'][$p->slot_index] = [
                            'id' => $p->id_pengguna,
                            'username' => $p->username,
                            'avatar_url' => $p->avatar_url
                        ];
                    }
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

        // Siapkan waktu server (sinkronisasi)
        $serverTime = Carbon::now()->toDateTimeString();

        // Jika turnamen sudah berlangsung → kembalikan waktu mulai
        if (strtolower($turnamen->status) === 'berlangsung') {
            return response()->json([
                'status' => 'Berlangsung',
                'start_time' => $turnamen->start_time,
                'end_time' => $turnamen->end_time,
                'server_time' => $serverTime,
                'redirect_url' => url('/tournament/start/' . $turnamen->id_turnamen)
            ]);
        }

        // Jika sudah selesai
        if (strtolower($turnamen->status) === 'selesai') {
            return response()->json([
                'status' => 'Selesai',
                'redirect_url' => route('home')
            ]);
        }

        // Mode SOLO
        if ($turnamen->mode === 'solo') {
            $participants = DB::table('pesertaturnamen')
                ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
                ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
                ->select('pengguna.username', 'pengguna.avatar_url')
                ->get();

            return response()->json([
                'status' => $turnamen->status,
                'server_time' => $serverTime,
                'start_time' => $turnamen->start_time,
                'participants' => $participants
            ]);
        }

        // Mode TIM
        // ... (sama seperti sebelumnya, cukup tambahkan server_time dan start_time)
        $maxTeamSize = $turnamen->max_team_members ?? 4;
        $totalTeams = (int) ceil($turnamen->max_peserta / $maxTeamSize);
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
                $teams[$p->team_id]['members'][$p->slot_index] = [
                    'id' => $p->id_pengguna,
                    'username' => $p->username,
                    'avatar_url' => $p->avatar_url
                ];
            }
        }

        return response()->json([
            'status' => $turnamen->status,
            'server_time' => $serverTime,
            'start_time' => $turnamen->start_time,
            'teams' => array_values($teams)
        ]);
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
                // 1. Cek apakah slot baru sudah terisi
                $isOccupied = DB::table('pesertaturnamen')
                    ->where('id_turnamen', $turnamen->id_turnamen)
                    ->where('team_id', $newTeamId)
                    ->where('slot_index', $newSlotIndex)
                    ->lockForUpdate() // Kunci baris agar tidak ada 'race condition'
                    ->exists();

                if ($isOccupied) {
                    throw new \Exception('Slot sudah terisi oleh pemain lain.');
                }

                // 2. Kosongkan slot lama (jika ada)
                DB::table('pesertaturnamen')
                    ->where('id_peserta', $peserta->id_peserta)
                    ->update(['team_id' => null, 'slot_index' => null]);

                // 3. Isi slot baru
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
     * MENYELESAIKAN TURNAMEN & MENGHITUNG SKOR
     */
    public function finishTournament($idPeserta)
    {
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
        $baseScore = $correct * 10;

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
    }

}