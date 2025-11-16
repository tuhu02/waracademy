<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Top
{
    public static function top5Players()
    {
        return DB::table('pengguna')
            ->leftJoin('progreslevelpengguna', 'pengguna.id_pengguna', '=', 'progreslevelpengguna.id_pengguna')
            ->leftJoin('riwayatpertandingan', 'pengguna.id_pengguna', '=', 'riwayatpertandingan.id_pengguna')
            ->select(
                'pengguna.id_pengguna',
                'pengguna.username',
                DB::raw('
                    COALESCE(SUM(progreslevelpengguna.exp),0)
                    + COALESCE(SUM(riwayatpertandingan.exp_didapat),0)
                    AS total_exp
                ')
            )
            ->groupBy('pengguna.id_pengguna', 'pengguna.username')
            ->orderByDesc('total_exp')
            ->limit(5)
            ->get();
    }
}
