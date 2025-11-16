<?php 
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.dashboard', [
            // Total Soal buatan guru (dari tabel pertanyaan)
            'totalSoal' => DB::table('turnamen_pertanyaan')->count(),

            // Jumlah siswa (role = student)
            'totalSiswa' => DB::table('pengguna')
                ->where('role', 'student')
                ->count(),

            // Jumlah turnamen aktif (status = ongoing)
            'turnamenAktif' => DB::table('turnamen')
                ->where('status', 'Sedang Berlangsung')
                ->count(),

            // Daftar turnamen terbaru (limit 5)
            'turnamenTerbaru' => DB::table('turnamen')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ]);
    }
}
