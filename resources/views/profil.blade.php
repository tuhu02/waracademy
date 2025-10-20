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
            background-color: #1a2754; /* Warna biru gelap dari gambar referensi */
        }
    </style>
</head>
<body class="text-white p-4 sm:p-8">

    <div class="max-w-7xl mx-auto">
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <img src="https://cdn.pixabay.com/photo/2022/10/19/01/02/woman-7531315_640.png{{ $pengguna->id }}" alt="Avatar" class="w-12 h-12 rounded-full border-2 border-white">
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
                 <img src="https://cdn.pixabay.com/photo/2022/10/19/01/02/woman-7531315_640.png{{ $pengguna->id }}" alt="Avatar Utama" class="w-40 h-40 rounded-full border-4 border-white shadow-2xl ring-4 ring-blue-500 mb-6">

                 <div class="w-full text-lg space-y-3 mt-4">
                     <div class="flex justify-between p-3 bg-blue-800/40 rounded-md">
                         <span class="text-gray-300">Player Name</span>
                         <span class="font-bold">{{ $pengguna->username }}</span>
                     </div>
                      <div class="flex justify-between p-3 bg-blue-800/40 rounded-md">
                         <span class="text-gray-300">Player Level</span>
                         <span class="font-bold">{{ $pengguna->level_id ?? '1' }}</span>
                     </div>
                     <div class="flex justify-between p-3 bg-blue-800/40 rounded-md">
                         <span class="text-gray-300">Started On</span>
                         <span class="font-bold">{{ \Carbon\Carbon::parse($pengguna->created_at)->format('F j, Y') }}</span>
                     </div>
                     <div class="flex justify-between p-3 bg-blue-800/40 rounded-md">
                         <span class="text-gray-300">Player ID</span>
                         <span class="font-bold">{{ $pengguna->id }}</span>
                     </div>
                 </div>
            </div>

            {{-- <div class="lg:col-span-1 space-y-8">
                <div class="bg-blue-900/50 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-6 border-b border-blue-700 pb-2">Clan Stats</h2>
                     <p class="text-center text-gray-400">Fitur Clan belum tersedia.</p>
                </div> --}}

                <div class="bg-blue-900/50 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-6 border-b border-blue-700 pb-2">Tournament Stats</h2>
                    <div class="space-y-3 text-lg">
                        <div class="flex justify-between"><span>Matches</span> <span class="font-semibold">{{ $playerStats->matches }}</span></div>
                        <div class="flex justify-between"><span>Wins</span> <span class="font-semibold text-green-400">{{ $playerStats->wins }}</span></div>
                        <div class="flex justify-between"><span>Loose</span> <span class="font-semibold text-red-400">{{ $playerStats->matches - $playerStats->wins }}</span></div>
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
