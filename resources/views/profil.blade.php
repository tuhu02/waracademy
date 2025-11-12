@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Profil Saya</h1>
        <button class="btn" onclick="document.getElementById('editProfilModal').classList.remove('hidden')">Edit Profil</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Panel Kiri: Profil Card -->
        <div class="col-span-1 bg-white p-4 rounded shadow">
            <div class="flex flex-col items-center">
                <img src="{{ asset($user->avatar_url ?? 'avatars/cat.png') }}" alt="Avatar" class="w-36 h-36 rounded-full object-cover mb-3">
                <h2 class="text-xl font-bold">{{ $user->username }}</h2>
                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                <p class="mt-3 text-sm">{{ $user->deskripsi_profil ?? 'Belum ada deskripsi.' }}</p>

                <div class="w-full mt-4">
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div>
                            <div class="text-lg font-semibold">{{ number_format($totalExp) }}</div>
                            <div class="text-xs text-gray-500">Total EXP</div>
                        </div>
                        <div>
                            <div class="text-lg font-semibold">{{ $totalBintang }} / {{ $maxBintangPossible }}</div>
                            <div class="text-xs text-gray-500">Total Bintang</div>
                        </div>
                        <div>
                            <div class="text-lg font-semibold">{{ $jumlahTurnamen }}</div>
                            <div class="text-xs text-gray-500">Turnamen</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Tabs -->
        <div class="col-span-2 bg-white p-4 rounded shadow">
            <div>
                <ul class="flex border-b mb-4">
                    <li class="mr-4"><a href="#tab-level" class="pb-2 border-b-2 border-transparent hover:border-gray-300">Riwayat Level</a></li>
                    <li class="mr-4"><a href="#tab-turnamen" class="pb-2 border-b-2 border-transparent hover:border-gray-300">Riwayat Turnamen</a></li>
                </ul>

                <div id="tab-level">
                    <h3 class="font-semibold mb-2">Riwayat Level</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-600">
                                    <th class="p-2">Level</th>
                                    <th class="p-2">EXP</th>
                                    <th class="p-2">Bintang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatLevel as $row)
                                <tr class="border-t">
                                    <td class="p-2">{{ optional($row->level)->nomor_level ?? $row->id_level }}</td>
                                    <td class="p-2">{{ $row->exp }}</td>
                                    <td class="p-2">{{ $row->bintang }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="tab-turnamen" class="mt-6">
                    <h3 class="font-semibold mb-2">Riwayat Turnamen</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-600">
                                    <th class="p-2">Nama Turnamen</th>
                                    <th class="p-2">Kode Room</th>
                                    <th class="p-2">Peringkat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatTurnamen as $p)
                                <tr class="border-t">
                                    <td class="p-2">{{ optional($p->turnamen)->nama_turnamen ?? '-' }}</td>
                                    <td class="p-2">{{ optional($p->turnamen)->kode_room ?? '-' }}</td>
                                    <td class="p-2">{{ $p->peringkat ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('partials.edit-profil-modal')
@endsection
