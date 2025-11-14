<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Asumsi Anda akan menggunakan Auth
use App\Models\Pengguna; // Asumsi model Pengguna Anda
use Carbon\Carbon;

class SiswaTournamentController extends Controller
{
    /**
     * Menangani permintaan siswa untuk bergabung ke turnamen.
     */
    public function join(Request $req)
    {
        // terima dari beberapa sumber: body POST 'kode_room', 'code' atau query param 'kode'
        $kode = strtoupper(trim($req->input('kode_room') ?? $req->input('code') ?? $req->query('kode') ?? ''));

        if ($kode === '') {
            return response()->json(['message' => 'Kode turnamen tidak diberikan.'], 422);
        }

        $penggunaId = session('pengguna_id');
        if (!$penggunaId) {
            return response()->json(['message' => 'Anda harus login untuk bergabung.'], 401);
        }

        $turnamen = DB::table('turnamen')
            ->whereRaw('upper(kode_room) = ?', [$kode])
            ->first();

        if (!$turnamen) {
            \Log::debug('Tournament not found on join', ['kode' => $kode]);
            return response()->json(['message' => 'Turnamen dengan kode ini tidak ditemukan.'], 404);
        }

        // normalisasi status dan debug jika tidak sesuai
        $statusRaw = $turnamen->status ?? $turnamen->status_turnamen ?? $turnamen->tournament_status ?? null;
        $status = is_string($statusRaw) ? trim(strtolower($statusRaw)) : $statusRaw;

        if ($status !== 'menunggu') {
            \Log::debug('Join rejected: tournament status not open', ['kode' => $kode, 'status' => $statusRaw]);
            return response()->json([
                'message' => 'Turnamen ini tidak sedang menerima peserta baru.',
                'debug_status' => $statusRaw
            ], 403);
        }

        // 2. Validasi Jumlah Peserta
        $pesertaCount = DB::table('pesertaturnamen')
            ->where('id_turnamen', $turnamen->id_turnamen)
            ->count();

        if ($pesertaCount >= ($turnamen->max_peserta ?? 9999)) {
            return response()->json(['message' => 'Turnamen ini sudah penuh.'], 403);
        }

        // 3. Daftarkan Peserta (pastikan kolom id_turnamen dan id_pengguna diisi)
        try {
            DB::table('pesertaturnamen')->insertOrIgnore([
                'id_turnamen' => $turnamen->id_turnamen,
                'id_pengguna' => $penggunaId,
                'lives_remaining' => 3,
                'skor_akhir' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to insert participant', ['err' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            // sementara kembalikan pesan error lengkap untuk debugging (hapus di produksi)
            return response()->json(['message' => 'Gagal bergabung dengan turnamen.', 'error' => $e->getMessage()], 500);
        }

        return response()->json([
            'redirect_url' => route('tournament.lobby', ['code' => $kode])
        ], 200);
    }

    /**
     * Menampilkan halaman lobi untuk siswa.
     */
    public function lobby($kode)
    {
        // Ganti ini dengan Auth::user() jika perlu
        $user = Pengguna::find(session('pengguna_id')); 
        
        $turnamen = DB::table('turnamen')->where('kode_room', $kode)->first();

        if (!$turnamen) {
            abort(404, 'Turnamen tidak ditemukan.');
        }

        // Ambil daftar peserta awal
        $participants = DB::table('pesertaturnamen')
            ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
            ->select('pengguna.username', 'pengguna.avatar_url')
            ->get();

        return view('siswa.tournament_lobby', [
            'turnamen' => $turnamen,
            'initialParticipants' => $participants,
            'user' => $user
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

        // Normalisasi nama kolom status (sesuaikan jika DB pakai nama lain)
        $status = $turnamen->status ?? $turnamen->status_turnamen ?? $turnamen->tournament_status ?? null;

        if (!$status) {
            // Untuk debug: tampilkan kolom yg ada. Hapus 'record' saat produksi.
            return response()->json([
                'status' => 'error',
                'message' => 'Kolom status tidak ditemukan pada record turnamen.',
                'record' => $turnamen
            ], 500);
        }

        if ($status === 'Berlangsung') {
            return response()->json([
                'status' => 'Berlangsung',
                'redirect_url' => route('level.start', ['id' => $turnamen->id_turnamen])
            ]);
        }

        if ($status === 'Selesai') {
            return response()->json([
                'status' => 'Selesai',
                'redirect_url' => route('home')
            ]);
        }

        // masih menunggu → kirim daftar peserta terbaru
        $participants = DB::table('pesertaturnamen')
            ->join('pengguna', 'pesertaturnamen.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesertaturnamen.id_turnamen', $turnamen->id_turnamen)
            ->select('pengguna.username', 'pengguna.avatar_url')
            ->get();

        return response()->json([
            'status' => 'Menunggu',
            'participants' => $participants
        ]);
    }
}