<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\KisiKisi;
use App\Models\Pertanyaan;
use App\Models\Pilihanjawaban;
use Illuminate\Support\Facades\DB;
use App\Models\ProgresLevelUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class LevelController extends Controller
{

    public function map()
    {
        // Ambil semua level (urut berdasarkan nomor)
        $levels = Level::orderBy('nomor_level', 'asc')->get();

        return view('siswa.maplevel', compact('levels'));
    }

    /**
     * Preview (kisi-kisi) untuk satu level.
     * view: resources/views/siswa/levels/preview.blade.php
     */
    public function preview($id)
    {
        // Ambil level + relasi kisi (one-to-many)
        $level = Level::with('KisiKisi')->where('id_level', $id)->first();

        if (!$level) {
            return abort(404, 'Level tidak ditemukan.');
        }

        // Ambil satu kisi (kalau per level cuma ada satu kisi)
        $kisi = KisiKisi::with('level')->get();


        return view('siswa.levels.preview', [
            'id' => $id,
            'level' => $level,
            'kisi' => $kisi,
            'kisiList' => $level->kisiKisi,
        ]);
    }

    /**
     * Mulai level -> ambil soal (random) untuk level tersebut.
     * view: resources/views/siswa/levels/start.blade.php
     */
    public function start($id)
    {
        // Cek level
        $level = Level::where('id_level', $id)->first();
        if (!$level) {
            return abort(404, 'Level tidak ditemukan.');
        }

        // Ambil pertanyaan dari database berdasarkan level
        // Diacak dan ambil maksimal 5 pertanyaan (ubah jumlah sesuai kebutuhan)
        $pertanyaanList = Pertanyaan::where('id_level', $id)
            ->with(['pilihanjawaban'])
            ->inRandomOrder()
            ->take(10)
            ->get();

        // Jika database kosong, tampilkan pesan error
        if ($pertanyaanList->isEmpty()) {
            return redirect()->route('level.preview', $id)
                ->with('error', 'Belum ada soal untuk level ini.');
        }

        return view('siswa.levels.start', [
            'id' => $id,
            'level' => $level,
            'pertanyaanList' => $pertanyaanList,
        ]);
    }

    /**
     * Submit jawaban user untuk soal level.
     */
 public function submit(Request $request, $id)
    {
        // 🔹 1. Validasi input dari form game
        $validated = $request->validate([
            'benar' => 'required|integer|min:0',
            'exp' => 'required|integer|min:0',
            'jawaban' => 'nullable',
        ]);

        // 🔹 2. Ambil id pengguna (pastikan sesi login aktif)
        $idPengguna = session('pengguna_id'); 
        if (!$idPengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $benar = $validated['benar'];
        $exp = $validated['exp'];

        // 🔹 3. Hitung jumlah bintang berdasarkan skor benar
        if ($benar =10) $bintang = 3;
        elseif ($benar >= 7) $bintang = 2;
        elseif ($benar >= 4) $bintang = 1;
        else $bintang = 0;

        // 🔹 4. Cek apakah progres sudah ada (unik per pengguna + level)
        $existing = DB::table('progreslevelpengguna')
            ->where('id_pengguna', $idPengguna)
            ->where('id_level', $id)
            ->first();

        if ($existing) {
            // Update hanya jika hasil baru lebih baik
            $bintangBaru = max($existing->bintang, $bintang);
            $expBaru = max($existing->exp, $exp);

            DB::table('progreslevelpengguna')
                ->where('id_progres', $existing->id_progres)
                ->update([
                    'bintang' => $bintangBaru,
                    'exp' => $expBaru,
                ]);
        } else {
            // 🔹 5. Jika belum ada, simpan baru
            DB::table('progreslevelpengguna')->insert([
                'id_pengguna' => $idPengguna,
                'id_level' => $id,
                'bintang' => $bintang,
                'exp' => $exp,
            ]);
        }

        // 🔹 6. Redirect ke halaman preview dengan pesan hasil
        return redirect()
            ->route('level.preview', $id)
            ->with('result', [
                'bintang' => $bintang,
                'exp' => $exp,
                'benar' => $benar,
                'pesan' => $bintang > 0
                    ? "🎉 Hasil tersimpan! Kamu dapat {$bintang} bintang dan {$exp} EXP."
                    : "💀 Gagal! Coba lagi untuk dapat bintang.",
            ]);
    }

}
