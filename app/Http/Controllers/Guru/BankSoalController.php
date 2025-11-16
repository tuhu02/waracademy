<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankSoalController extends Controller
{
    public function index()
    {
        // Ambil daftar turnamen + jumlah soal
        $turnamen = DB::table('turnamen')
            ->leftJoin('turnamen_pertanyaan', 'turnamen.id_turnamen', '=', 'turnamen_pertanyaan.id_turnamen')
            ->select(
                'turnamen.id_turnamen',
                'turnamen.nama_turnamen',
                'turnamen.status',
                'turnamen.tanggal_pelaksanaan',
                DB::raw('COUNT(turnamen_pertanyaan.id) as jumlah_soal')
            )
            ->groupBy(
                'turnamen.id_turnamen',
                'turnamen.nama_turnamen',
                'turnamen.status',
                'turnamen.tanggal_pelaksanaan'
            )
            ->orderBy('turnamen.id_turnamen', 'DESC')
            ->get();
    
        return view('guru.soal.index', compact('turnamen'));
    }


    // API: Detail soal untuk accordion FAQ
    public function detail($id_turnamen)
    {
        $soal = DB::table('turnamen_pertanyaan')
            ->where('turnamen_pertanyaan.id_turnamen', $id_turnamen)
            ->get()
            ->map(function ($q) {
                $q->jawaban = DB::table('turnamen_pilihan_jawaban')
                    ->where('id_pertanyaan_turnamen', $q->id)
                    ->get();
                return $q;
            });

        return response()->json($soal);
    }
}
