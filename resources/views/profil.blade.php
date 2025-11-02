<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pemain - WarAcademy</title>
    {{-- Pastikan Tailwind CSS sudah ter-link di proyek Anda --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Font jika diperlukan */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1A2754; /* Warna biru gelap dasar */
            overflow-x: hidden; 
            position: relative; 
        }

        /* === Efek Bintang Bergerak (Dot Pattern) yang LEBIH JARANG === */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; 
            z-index: -1; 
            /* Mengurangi ukuran titik (2px jadi 1px dan 1px jadi 0.5px) */
            background-image: radial-gradient(white, rgba(255, 255, 255, 0.1) 1px, transparent 150px),
                              radial-gradient(white, rgba(255, 255, 255, 0.15) 0.5px, transparent 100px);
            
            /* Memperbesar ukuran pola (80px jadi 150px dan 60px jadi 120px)
               Ini membuat bintang saling berjarak lebih jauh. */
            background-size: 150px 150px, 120px 120px; 
            
            /* Mengubah offset pola kedua (40px jadi 75px) */
            background-position: 0 0, 75px 75px; 
            
            animation: moveBackground 90s linear infinite; /* Animasi diperlambat (60s ke 90s) agar lebih subtle */
            opacity: 0.7; /* Opasitas sedikit dikurangi */
        }

        /* Keyframes untuk pergerakan bintang */
        @keyframes moveBackground {
            from {
                background-position: 0 0, 75px 75px;
            }
            to {
                /* Bergerak perlahan ke kanan bawah */
                background-position: 1500px 1500px, 1575px 1575px; 
            }
        }
    </style>
</head>
<body class="text-white p-4 sm:p-8">

    <div class="max-w-7xl mx-auto z-10 relative"> 
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                {{-- Menggunakan $pengguna->avatar jika ada, fallback ke URL placeholder --}}
                <img src="{{ $pengguna->avatar ?? 'https://cdn.pixabay.com/photo/2022/10/19/01/02/woman-7531315_640.png' }}" alt="Avatar" class="w-12 h-12 rounded-full border-2 border-white">
                <div>
                    <h1 class="text-xl font-bold">{{ $pengguna->username }}</h1>
                    <p class="text-sm text-gray-300">Level {{ $pengguna->level_id ?? '1' }}</p> {{-- Asumsi ada relasi level --}}
                </div>
            </div>
            <a href="{{ route('home') }}" class="text-gray-300 hover:text-white">&larr; Back</a>
        </header>

        <main class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <div class="lg:col-span-1 bg-blue-900/50 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6 border-b border-blue-700 pb-2">Player Status</h2>
                <div class="space-y-3 text-lg">
                    <div class="flex justify-between"><span>Matches</span> <span class="font-semibold">{{ $playerStats->matches }}</span></div>
                    <div class="flex justify-between"><span>Wins</span> <span class="font-semibold text-green-400">{{ $playerStats->wins }}</span></div>
                    <div class="flex justify-between"><span>Loose</span> <span class="font-semibold text-red-400">{{ $playerStats->matches - $playerStats->wins }}</span></div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-blue-900/50 p-6 rounded-lg shadow-lg flex flex-col items-center">
                {{-- Menggunakan $pengguna->avatar jika ada, fallback ke URL placeholder --}}
                <img src="{{ $pengguna->avatar ?? 'https://cdn.pixabay.com/photo/2022/10/19/01/02/woman-7531315_640.png' }}" alt="Avatar Utama" class="w-40 h-40 rounded-full border-4 border-white shadow-2xl ring-4 ring-blue-500 mb-6">

                <div class="w-full text-lg space-y-3 mt-4">
                    <div class="flex justify-between p-3 bg-blue-800/40 rounded-md">
                        <span class="text-gray-300">Player Name</span>
                        <span class="font-bold">{{ $pengguna->username }}</span>
                    </div>
                    <div class="flex justify-between p-3 bg-blue-800/40 rounded-md">
                        <span class="text-gray-300">Player Level</span>
                        <span class="font-bold">{{ $pengguna->level_id ?? '1' }}</span>
                    </div>
                    {{-- Menggunakan tanggal_registrasi untuk "Started On" --}}
                    <div class="flex justify-between p-3 bg-blue-800/40 rounded-md">
                        <span class="text-gray-300">Started On</span>
                        <span class="font-bold">{{ \Carbon\Carbon::parse($pengguna->tanggal_registrasi)->format('F j, Y') }}</span>
                    </div>
                    {{-- Menggunakan tanggal_registrasi untuk "Player ID" dengan format patenfiks --}}
                    <div class="flex justify-between p-3 bg-blue-800/40 rounded-md">
                        <span class="text-gray-300">Player ID</span>
                        <span class="font-bold">
                            {{ \Carbon\Carbon::parse($pengguna->tanggal_registrasi)->format('siHdmy') }}
                        </span>
                    </div>
                </div>
            </div>

                <div class="bg-blue-900/50 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-6 border-b border-blue-700 pb-2">Tournament Stats</h2>
                    <div class="space-y-3 text-lg">
                        <div class="flex justify-between"><span>Matches</span> <span class="font-semibold">{{ $playerStats->matches }}</span></div>
                        <div class="flex justify-between"><span>Wins</span> <span class="font-semibold text-green-400">{{ $playerStats->wins }}</span></div>
                        <div class="flex justify-between"><span>Loose</span> <span class="font-semibold text-red-400">{{ $playerStats->matches - $playerStats->wins }}</span></div>
                    </div>
                </div>
            

        </main>
    </div>

</body>
</html>
