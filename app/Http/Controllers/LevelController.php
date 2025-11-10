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
public function map()
{
    $idPengguna = session('pengguna_id');
    $levels = Level::orderBy('nomor_level', 'asc')->get();

    // Ambil progres bintang pengguna
    $userProgressStars = \DB::table('progreslevelpengguna')
        ->where('id_pengguna', $idPengguna)
        ->pluck('bintang', 'id_level')
        ->toArray();

    // Tambahkan status "locked" ke setiap level
    foreach ($levels as $index => $level) {
        if ($index == 0) {
            // Level pertama selalu terbuka
            $level->locked = false;
        } else {
            $prevLevelId = $levels[$index - 1]->id;
            // Cek apakah level sebelumnya sudah dikerjakan
            $level->locked = !isset($userProgressStars[$prevLevelId]);
        }
    }

    return view('siswa.level', compact('levels', 'userProgressStars'));
}


 public function preview($id)
{
    $level = Level::with('kisiKisi')->where('id_level', $id)->first();

    if (!$level) {
        return abort(404, 'Level tidak ditemukan.');
    }

    $kisiList = KisiKisi::where('id_level', $id)->get();

    return view('siswa.levels.preview', [
        'id' => $id,
        'level' => $level,
        'kisiList' => $kisiList,
    ]);
}



    /**
     * Mulai level dan tampilkan soal.
     */
public function start($id)
{
    // 🔹 Ambil data level
    $level = Level::where('id_level', $id)->first();
    if (!$level) {
        return abort(404, 'Level tidak ditemukan.');
    }

    // 🔹 Ambil waktu dari tabel kisi_kisi
    $kisi = KisiKisi::where('id_level', $id)->first();
    $durasiLevel = $kisi ? ($kisi->waktu_menit * 60) : 300; // default 5 menit kalau kosong

    // 🔹 Ambil 10 pertanyaan acak sesuai level
    $pertanyaanList = Pertanyaan::where('id_level', $id)
        ->with(['pilihanjawaban'])
        ->inRandomOrder()
        ->take(10)
        ->get();

    if ($pertanyaanList->isEmpty()) {
        return redirect()->route('level.preview', $id)
                        ->with('error', 'Belum ada soal untuk level ini.');
    }

    // 🔹 Siapkan data soal untuk dikirim ke JavaScript
    $soalData = $pertanyaanList->map(function ($pertanyaan) {
        return [
            'id' => $pertanyaan->id_pertanyaan,
            'q' => $pertanyaan->teks_pertanyaan ?? 'Pertanyaan tidak tersedia',
            'a' => $pertanyaan->pilihanjawaban->pluck('teks_jawaban')->shuffle()->toArray(),
            'correct' => optional(
                $pertanyaan->pilihanjawaban->firstWhere('adalah_benar', 1)
            )->teks_jawaban,
        ];
    });

    // 🔹 Kirim ke view
    return view('siswa.levels.start', [
        'id' => $id,
        'level' => $level,
        'pertanyaanList' => $pertanyaanList,
        'soalData' => $soalData,
        'durasiLevel' => $durasiLevel, // ⏰ dikirim ke JS
    ]);
}

    public function replay(Request $request, $id)
    {
        DB::table('progreslevelpengguna')->updateOrInsert(
            [
                'id_pengguna' => session('pengguna_id'),
                'id_level' => $id,
            ],
            [
                'bintang' => max(1, $request->input('benar') >= 1 ? 1 : 0),
                'exp' => $request->input('exp'),
            ]
        );

        return redirect()->route('level', ['id' => $id]);
    }

   public function submit(Request $request, $id)
{
    // 🔹 1. Validasi input dari form game
    $validated = $request->validate([
        'benar'   => 'nullable|integer|min:0',
        'exp'     => 'required|integer|min:0',
        'bintang' => 'required|integer|min:0|max:3',
        'jawaban' => 'nullable',
    ]);

    // 🔹 2. Ambil id pengguna dari session
    $idPengguna = session('pengguna_id'); 
    if (!$idPengguna) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // 🔹 3. Ambil data yang dikirim
    $benar   = $validated['benar'] ?? 0;
    $bintang = $validated['bintang'];
    $exp     = $validated['exp'];

    // 🔹 4. Cek apakah progres pengguna untuk level ini sudah ada
    $existing = DB::table('progreslevelpengguna')
        ->where('id_pengguna', $idPengguna)
        ->where('id_level', $id)
        ->first();

    if ($existing) {
        // Hanya update kalau hasil baru lebih baik
        $bintangBaru = max($existing->bintang, $bintang);
        $expBaru = max($existing->exp, $exp);

        DB::table('progreslevelpengguna')
            ->where('id_progres', $existing->id_progres)
            ->update([
                'bintang' => $bintangBaru,
                'exp' => $expBaru,
            ]);
    } else {
        // 🔹 5. Jika belum ada, buat data baru
        DB::table('progreslevelpengguna')->insert([
            'id_pengguna' => $idPengguna,
            'id_level'    => $id,
            'bintang'     => $bintang,
            'exp'         => $exp,
        ]);
    }

    // 🔹 6. Redirect ke halaman preview dengan flash message
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