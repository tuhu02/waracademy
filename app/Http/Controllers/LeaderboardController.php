<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;

class LeaderboardController extends Controller
{
    public function top100()
    {
        // Ambil semua pengguna terlebih dahulu
        $usersAll = Pengguna::select('id_pengguna', 'username', 'avatar_url')
            ->where('role', 'student')
            ->get()
            ->map(function ($user) {

                $expProgres = DB::table('progreslevelpengguna')
                    ->where('id_pengguna', $user->id_pengguna)
                    ->sum('exp');

                $expRiwayat = DB::table('riwayatpertandingan')
                    ->where('id_pengguna', $user->id_pengguna)
                    ->sum('exp_didapat');

                $expTurnamen = DB::table('pesertaturnamen')
                    ->where('id_pengguna', $user->id_pengguna)
                    ->sum('bonus_exp_didapat');

                $bintangProgres = DB::table('progreslevelpengguna')
                    ->where('id_pengguna', $user->id_pengguna)
                    ->sum('bintang');

                $bintangRiwayat = DB::table('riwayatpertandingan')
                    ->where('id_pengguna', $user->id_pengguna)
                    ->sum('bintang_didapat');

                $user->total_exp = (int)$expProgres + (int)$expRiwayat + (int)$expTurnamen;
                $user->total_bintang = (int)$bintangProgres + (int)$bintangRiwayat;

                return $user;
            })
            ->sortByDesc('total_exp')
            ->values();

        // Ambil top 100
        $users = $usersAll->take(100);

        // Ambil user login dari session
        $myUserId = session('pengguna_id');
        $myUser = null;
        $myUserRank = 0;

        if ($myUserId) {
            $myUser = Pengguna::find($myUserId);

            if ($myUser) {
                // Hitung total exp & total bintang user login
                $expProgres = DB::table('progreslevelpengguna')
                    ->where('id_pengguna', $myUser->id_pengguna)
                    ->sum('exp');

                $expRiwayat = DB::table('riwayatpertandingan')
                    ->where('id_pengguna', $myUser->id_pengguna)
                    ->sum('exp_didapat');

                $bintangProgres = DB::table('progreslevelpengguna')
                    ->where('id_pengguna', $myUser->id_pengguna)
                    ->sum('bintang');

                $bintangRiwayat = DB::table('riwayatpertandingan')
                    ->where('id_pengguna', $myUser->id_pengguna)
                    ->sum('bintang_didapat');

                $myUser->total_exp = (int)$expProgres + (int)$expRiwayat;
                $myUser->total_bintang = (int)$bintangProgres + (int)$bintangRiwayat;

                // Hitung rank user login
                $myUserRank = $usersAll->search(function ($u) use ($myUser) {
                    return $u->id_pengguna === $myUser->id_pengguna;
                });
                $myUserRank = $myUserRank !== false ? $myUserRank + 1 : 0;
            }
        }

        return view('siswa.leaderboard', compact('users', 'myUser', 'myUserRank'));
    }
}
