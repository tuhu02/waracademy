<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Pengguna;
use App\Models\ProgresLevelUser;
use App\Models\Level;
use App\Models\PesertaTurnamen;

class ProfileController extends Controller
{
    public function index(Request $id)
    {
        /** @var Pengguna $user */
        $id = session('id_pengguna');
        $user = Pengguna::find($id);
        
        if (!$user) {
            return redirect()->route('login');
        }

        $id = $user->id_pengguna;

        // Exp dari tabel progreslevelpengguna
        $expFromProgres = ProgresLevelUser::where('id_pengguna', $id)->sum('exp');

        // Exp dari riwayatpertandingan (table name: riwayatpertandingan)
        $expFromRiwayat = DB::table('riwayatpertandingan')
            ->where('id_pengguna', $id)
            ->sum('exp_didapat');

        $totalExp = ($user->total_exp ?? 0) + (int)$expFromProgres + (int)$expFromRiwayat;

        // Total bintang: ambil max bintang per level lalu jumlahkan
        $bintangPerLevel = DB::table('progreslevelpengguna')
            ->where('id_pengguna', $id)
            ->select(DB::raw('MAX(bintang) as b'))
            ->groupBy('id_level')
            ->pluck('b');

        $totalBintang = $bintangPerLevel->sum();

        $jumlahLevel = Level::count();
        $maxBintangPossible = $jumlahLevel * 3; // asumsi max 3 bintang per level

        // Riwayat level (ambil data progres per level)
        $riwayatLevel = ProgresLevelUser::with('level')
            ->where('id_pengguna', $id)
            ->orderBy('id_level')
            ->get();

        // Riwayat turnamen
        $riwayatTurnamen = PesertaTurnamen::with('turnamen')
            ->where('id_pengguna', $id)
            ->get();

        $jumlahTurnamen = $riwayatTurnamen->count();

        // Daftar avatar statis (sesuaikan dengan file di public/avatars)
        $availableAvatars = [
            'cat.png','dog.png','fox.png','lion.png','owl.png','panda.png'
        ];

        return view('profil', compact(
            'user', 'totalExp', 'totalBintang', 'maxBintangPossible',
            'riwayatLevel', 'riwayatTurnamen', 'jumlahTurnamen', 'availableAvatars'
        ));
    }

    public function update(Request $request)
    {
        /** @var Pengguna $user */
        $id = session('id_pengguna');
        $user = Pengguna::find($id);

        if (!$user) {
            return redirect()->route('login');
        }

        $id = $user->id_pengguna;

        $rules = [
            'username' => [
                'required', 'string', 'max:50',
                Rule::unique('pengguna', 'username')->ignore($id, 'id_pengguna')
            ],
            'deskripsi_profil' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', Rule::in(['cat.png','dog.png','fox.png','lion.png','owl.png','panda.png'])],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->username = $request->input('username');
        $user->deskripsi_profil = $request->input('deskripsi_profil');

        if ($request->filled('avatar')) {
            $user->avatar_url = 'avatars/' . $request->input('avatar');
        }

        $user->save();

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
