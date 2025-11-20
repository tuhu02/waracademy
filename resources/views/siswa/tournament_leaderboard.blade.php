<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Leaderboard Turnamen</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        poppins: ['Poppins', 'sans-serif'],
                        blackops: ['"Black Ops One"', 'sans-serif']
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: 0 }, '100%': { opacity: 1 } }
                    },
                    animation: { fadeIn: "fadeIn 1.5s ease-out" }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar untuk Tabel Mobile */
        .custom-scroll::-webkit-scrollbar {
            height: 4px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(106, 168, 250, 0.5);
            border-radius: 10px;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-b from-[#0f1b2e] via-[#304863] to-[#3b5875] text-white font-poppins relative overflow-x-hidden select-none">

    <canvas id="particles" class="fixed inset-0 z-0 pointer-events-none"></canvas>

    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0 overflow-hidden">
        <img src="/images/war.png" alt="Logo" 
           class="opacity-10 animate-fadeIn w-64 md:w-auto md:h-[500px] object-contain">
    </div>

    <div class="relative z-10 w-full max-w-5xl mx-auto mt-6 md:mt-20 p-4 md:p-8 
                animate-fadeIn flex flex-col min-h-[80vh]">
        
        <div class="bg-[#1b2636]/80 backdrop-blur-md shadow-[0_0_25px_rgba(70,150,255,0.4)] 
                    rounded-2xl p-4 md:p-8 border border-white/10">

            <div class="flex justify-start mb-6">
                <a href="{{ route('home') }}" class="w-full md:w-auto">
                    <button class="w-full md:w-auto relative bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white px-5 py-2.5 rounded-xl font-semibold 
                                border border-[#1b3e75] text-sm md:text-base
                                shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)]
                                hover:scale-105 transition-all duration-300 overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </span>
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                                    translate-x-[-100%] group-hover:translate-x-[100%] 
                                    transition-transform duration-700"></span>
                    </button>
                </a>
            </div>

            <div class="text-center mb-6 md:mb-8">
                <h2 class="text-3xl md:text-5xl font-blackops tracking-widest 
                           bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa]
                           bg-clip-text text-transparent drop-shadow-[0_0_10px_rgba(50,120,200,0.6)]">
                    LEADERBOARD
                </h2>
                <p class="text-gray-400 text-xs md:text-sm mt-2 font-light tracking-wide">
                    Peringkat Real-time Peserta Turnamen
                </p>
            </div>

            <div class="overflow-x-auto custom-scroll rounded-xl shadow-lg border border-white/5">
                <table class="w-full text-center text-white min-w-[350px]">
                    <thead class="bg-[#233448] text-xs md:text-sm uppercase tracking-wider text-blue-200">
                        <tr>
                            <th class="py-3 px-2 md:px-4 font-bold w-12 md:w-20">#</th>
                            <th class="py-3 px-2 md:px-4 font-bold text-left">Nama</th>
                            <th class="py-3 px-2 md:px-4 font-bold">Skor</th>
                            <th class="py-3 px-2 md:px-4 font-bold">Progres</th> </tr>
                    </thead>

                    {{-- MODE REFRESH OTOMATIS --}}
                    @if($turnamen->status === 'Berlangsung')
                    <tbody x-data="leaderboardController" x-init="startAutoRefresh()" class="bg-[#1c2a3a]/50 text-sm md:text-base">
                        <template x-for="(entry, index) in leaderboard" :key="entry.id || index">
                            <tr :class="entry.is_me 
                                ? 'bg-blue-600/40 border-l-4 border-blue-400 shadow-inner' 
                                : 'odd:bg-white/5 even:bg-transparent hover:bg-white/10 transition-colors'">
                                
                                <td class="py-3 px-2 md:px-4 font-blackops text-lg md:text-xl">
                                    <span x-text="entry.rank || (index + 1)" 
                                          :class="index < 3 ? 'text-yellow-400 drop-shadow-sm' : 'text-gray-400'"></span>
                                </td>

                                <td class="py-3 px-2 md:px-4 text-left">
                                    <div class="flex flex-col">
                                        <span class="font-semibold truncate max-w-[120px] md:max-w-xs" x-text="entry.nama || 'Siswa'"></span>
                                        <span x-show="entry.is_me" class="text-[10px] text-blue-300 md:hidden">It's You</span>
                                    </div>
                                </td>

                                <td class="py-3 px-2 md:px-4 font-bold text-yellow-100" x-text="entry.skor || 0"></td>

                                <td class="py-3 px-2 md:px-4 text-gray-300 text-xs md:text-sm" x-text="entry.progres || '-'"></td>
                            </tr>
                        </template>

                        <template x-if="leaderboard.length === 0">
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400 italic text-sm">
                                    Belum ada data masuk...
                                </td>
                            </tr>
                        </template>
                    </tbody>

                    @else
                    {{-- MODE NORMAL (STATIS) --}}
                    <tbody class="bg-[#1c2a3a]/50 text-sm md:text-base">
                        @forelse($leaderboard as $entry)
                            <tr class="{{ ($entry['is_me'] ?? false) 
                                ? 'bg-blue-600/40 border-l-4 border-blue-400 shadow-inner' 
                                : 'odd:bg-white/5 even:bg-transparent hover:bg-white/10 transition-colors' }}">
                                
                                <td class="py-3 px-2 md:px-4 font-blackops text-lg md:text-xl 
                                           {{ ($entry['rank'] ?? $loop->iteration) <= 3 ? 'text-yellow-400' : 'text-gray-400' }}">
                                    {{ $entry['rank'] ?? $loop->iteration }}
                                </td>
                                
                                <td class="py-3 px-2 md:px-4 text-left">
                                    <div class="truncate max-w-[120px] md:max-w-xs font-semibold">
                                        {{ $entry['nama'] ?? 'Siswa'}}
                                    </div>
                                </td>
                                
                                <td class="py-3 px-2 md:px-4 font-bold text-yellow-100">{{ $entry['skor'] ?? 0}}</td>
                                
                                <td class="py-3 px-2 md:px-4 text-gray-300 text-xs md:text-sm">
                                    {{ ($entry['correct'] ?? 0) . '/' . ($entry['answered'] ?? 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400 italic">Belum ada peserta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @endif

                </table>
            </div>

            @if($turnamen->status === 'Berlangsung')
            <div class="mt-4 flex items-center justify-center gap-2 text-xs md:text-sm text-blue-300 animate-pulse">
                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                Live Update setiap 5 detik
            </div>
            @endif
        </div>
    </div>

    {{-- SCRIPT AUTO REFRESH --}}
    @if($turnamen->status === 'Berlangsung')
    <script>
        function leaderboardController() {
            return {
                leaderboard: [],
                async startAutoRefresh() {
                    this.refresh();
                    setInterval(() => this.refresh(), 5000);
                },
                async refresh() {
                    try {
                        let url = @json(route('tournament.leaderboard.status', ['id' => $turnamen->id_turnamen]));
                        let response = await fetch(url);
                        let data = await response.json();
                        
                        if (data.leaderboard) {
                            // Format data agar sesuai dengan template x-text
                            this.leaderboard = data.leaderboard.map((item, idx) => ({
                                ...item,
                                rank: item.rank || (idx + 1),
                                progres: (item.correct ?? 0) + '/' + (item.answered ?? 0)
                            }));
                        }
                    } catch (error) {
                        console.error("Gagal memuat leaderboard:", error);
                    }
                }
            }
        }
    </script>
    @endif

    <script>
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        const particles = Array.from({ length: 50 }, () => ({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: Math.random() * 2 + 0.5,
            speedX: (Math.random() - 0.5) * 0.3,
            speedY: (Math.random() - 0.5) * 0.3,
        }));

        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fill();
                p.x += p.speedX;
                p.y += p.speedY;
                if (p.x < 0) p.x = canvas.width;
                if (p.x > canvas.width) p.x = 0;
                if (p.y < 0) p.y = canvas.height;
                if (p.y > canvas.height) p.y = 0;
            });
            requestAnimationFrame(drawParticles);
        }
        drawParticles();
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</body>
</html>