<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;

class HomeController extends Controller
{
    public function index()
    {
        $userId = session('pengguna_id');

        // Ambil data pengguna
        $user = Pengguna::find($userId);

        // Ambil progres EXP & Bintang
        $progres = DB::table('progreslevelpengguna')
            ->where('id_pengguna', $userId)
            ->orderByDesc('id_progres')
            ->first(); // ambil progres terakhir

        $exp = $progres->exp ?? 0;
        $bintang = $progres->bintang ?? 0;

        // Hitung persentase EXP (misal max 1000 EXP per level)
        $expPercent = min(100, ($exp / 1000) * 100); 

        // Hitung persentase bintang (misal max 20 bintang untuk full bar)
        $starPercent = min(100, ($bintang / 20) * 100);

        return view('siswa.home', compact('user', 'exp', 'bintang', 'expPercent', 'starPercent'));
    }
}
