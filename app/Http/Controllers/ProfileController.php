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
    public function index($idPengguna)
    {
        /** @var Pengguna $user */

        $user = \App\Models\Pengguna::findOrFail($idPengguna);

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

        $expFromTournament = DB::table('pesertaturnamen')
            ->where('id_pengguna', $user->id_pengguna)
            ->sum('bonus_exp_didapat');

        $totalExp = ($user->total_exp ?? 0) + (int)$expFromProgres + (int)$expFromRiwayat + (int)$expFromTournament;

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

        // Hitung peringkat untuk tiap riwayat turnamen
        // Untuk setiap peserta, ambil daftar peserta turnamen yang sama
        // diurutkan berdasarkan skor_akhir desc, updated_at asc, lalu temukan indeksnya.
        foreach ($riwayatTurnamen as $rt) {
            try {
                $participantsOrdered = DB::table('pesertaturnamen')
                    ->where('id_turnamen', $rt->id_turnamen)
                    ->orderByDesc('skor_akhir')
                    ->orderBy('updated_at', 'asc')
                    ->pluck('id_peserta')
                    ->toArray();

                // Temukan posisi peserta ini
                $pos = array_search($rt->id_peserta, $participantsOrdered, true);
                if ($pos === false) {
                    $rt->peringkat = null;
                    $rt->total_participants = count($participantsOrdered);
                } else {
                    $rt->peringkat = $pos + 1; // array index -> rank
                    $rt->total_participants = count($participantsOrdered);
                    $rt->bonus_exp_didapat = $rt->bonus_exp_didapat ?? DB::table('pesertaturnamen')
                    ->where('id_peserta', $rt->id_peserta)
                    ->value('bonus_exp_didapat') ?? 0;
                }
            } catch (\Exception $e) {
                // Jika terjadi error (mis. kolom tidak ada), biarkan peringkat null
                $rt->peringkat = null;
            }
        }

        $jumlahTurnamen = $riwayatTurnamen->count();

        // Daftar avatar statis (sesuaikan dengan file di public/avatars)
        $availableAvatars = [
            'cat.png','dog.png','fox.png','lion.png','owl.png','panda.png'
        ];

        session(['pengguna_id' => $id]);
        // dd(session('pengguna_id'));
        return view('profil', compact(
            'user', 'totalExp', 'totalBintang', 'maxBintangPossible',
            'riwayatLevel', 'riwayatTurnamen', 'jumlahTurnamen', 'availableAvatars'
        ));
    }
    public function update(Request $request, $id)
    {
        // $id = session('id_pengguna');
        $user = Pengguna::find($id);

        if (!$user) {
            return redirect()->route('login');
        }

        $rules = [
            'username' => [
                'required', 'string', 'max:50',
                Rule::unique('pengguna', 'username')->ignore($id, 'id_pengguna')
            ],
            'deskripsi_profil' => ['nullable', 'string', 'max:1000'],
            'avatar_url' => ['nullable', Rule::in(['cat.png','dog.png','fox.png','lion.png','owl.png','panda.png'])],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->username = $request->input('username');
        $user->deskripsi_profil = $request->input('deskripsi_profil');
        if ($request->filled('avatar_url')) {
            $user->avatar_url = $request->input('avatar_url');
        }

        $user->save();

       
        session(['id_pengguna' => $user->id_pengguna]);
        session(['pengguna_username' => $user->username]);

        return redirect()->route('profil', session('pengguna_id'))->with('success', 'Profil berhasil diperbarui.');
    }

}
