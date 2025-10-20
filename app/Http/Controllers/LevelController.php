<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\KisiKisi;
use App\Models\Pertanyaan;
use App\Models\Pilihanjawaban;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    /**
     * Tampilkan peta level (map).
     * view: resources/views/siswa/maplevel.blade.php
     */
    public function map()
    {
        // ambil semua level (urut berdasarkan nomor)
        $levels = Level::orderBy('nomor_level', 'asc')->get();

        return view('siswa.maplevel', compact('levels'));
    }

    /**
     * Preview (kisi-kisi) untuk satu level.
     * view: resources/views/siswa/levels/preview.blade.php
     */
    public function preview($id)
    {
        // ambil level + relasi kisi (one-to-many)
        $level = Level::with('kisiKisi')->where('id_level', $id)->first();

        if (!$level) {
            return abort(404, 'Level tidak ditemukan.');
        }

        // ambil satu kisi (kalau per level cuma ada satu kisi)
        $kisi = $level->kisiKisi->first();

        // kalau nanti mau looping semua, bisa juga pakai $kisiList = $level->kisiKisi;
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
        // pastikan level ada
        $level = Level::where('id_level', $id)->first();
        if (!$level) {
            return abort(404, 'Level tidak ditemukan.');
        }

        // ambil 1 pertanyaan acak
        $pertanyaan = Pertanyaan::where('id_level', $id)
                        ->inRandomOrder()
                        ->with(['pilihanjawaban'])
                        ->first();

        if (!$pertanyaan) {
            return redirect()->route('level.preview', $id)
                             ->with('warning', 'Belum ada soal untuk level ini.');
        }

        // ambil kisi pertama
        $kisi = $level->kisiKisi->first();

        return view('siswa.levels.start', [
            'id' => $id,
            'level' => $level,
            'pertanyaan' => $pertanyaan,
            'kisi' => $kisi
        ]);
    }

    /**
     * Submit jawaban user untuk soal level.
     */
    public function submit(Request $request, $id)
    {
        $request->validate([
            'pertanyaan_id' => 'required|integer',
            'jawaban_id' => 'required|integer'
        ]);

        $pertanyaanId = $request->input('pertanyaan_id');
        $jawabanId = $request->input('jawaban_id');

        $pert = Pertanyaan::where('id_pertanyaan', $pertanyaanId)
                          ->where('id_level', $id)
                          ->first();

        if (!$pert) {
            return redirect()->back()->with('error', 'Soal tidak valid untuk level ini.');
        }

        $jawaban = Pilihanjawaban::where('id_jawaban', $jawabanId)
                                 ->where('id_pertanyaan', $pertanyaanId)
                                 ->first();

        if (!$jawaban) {
            return redirect()->back()->with('error', 'Pilihan jawaban tidak ditemukan.');
        }

        $isCorrect = (bool) $jawaban->adalah_benar;

        try {
            DB::table('riwayatpertandingan')->insert([
                'id_pengguna' => session('pengguna_id') ?? null,
                'id_level' => $id,
                'exp_didapat' => $isCorrect ? 50 : 0,
                'bintang_didapat' => $isCorrect ? 1 : 0,
                'waktu_selesai' => now()
            ]);
        } catch (\Exception $e) {
            // abaikan jika tabel belum ada
        }

        return redirect()->route('level.preview', $id)
                         ->with('result', [
                             'pertanyaan_id' => $pertanyaanId,
                             'jawaban_id' => $jawabanId,
                             'is_correct' => $isCorrect,
                             'pesan' => $isCorrect ? 'Jawaban benar! 🎉' : 'Jawaban salah. Coba lagi.'
                         ]);
    }
}
