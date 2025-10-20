<?php

namespace App\Http\Controllers;

// PASTIKAN SEMUA USE STATEMENT INI ADA
use App\Models\Pengguna; // Pastikan Anda punya model ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    // app/Http/Controllers/ProfileController.php

// app/Http/Controllers/ProfileController.php

public function show($id)
{
    // 1. Ambil data utama pengguna
    $pengguna = \App\Models\Pengguna::findOrFail($id);

    // 2. Kalkulasi Player Status (NAMA KOLOM DIPERBAIKI)
    $playerStats = DB::table('riwayatpertandingan')
        ->where('id_pengguna', $id) // <-- PERUBAHAN DI SINI
        ->selectRaw('
            COUNT(*) as matches,
            SUM(CASE WHEN bintang_didapat >= 3 THEN 1 ELSE 0 END) as wins
        ')
        ->first();

    // 3. Kalkulasi Tournament Stats (NAMA KOLOM DIPERBAIKI)
    $tournamentStats = DB::table('pesertaturnamen')
        ->where('id_pengguna', $id) // <-- PERUBAHAN DI SINI
        ->selectRaw('
            COUNT(*) as matches,
            SUM(CASE WHEN peringkat = 1 THEN 1 ELSE 0 END) as wins
        ')
        ->first();

    // 4. Kirim data ke view
    return view('profil', [
        'pengguna' => $pengguna,
        'playerStats' => $playerStats,
        'tournamentStats' => $tournamentStats,
    ]);
}
}
