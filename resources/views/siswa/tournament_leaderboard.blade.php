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
        #top3-container {
            transition: .3s ease;
        }

        .podium-card {
            position: relative;
            padding: 24px;
            text-align:center;
            border-radius: 22px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.12);
            box-shadow: 0 8px 30px rgba(0,0,0,0.35);
            transition: .3s ease;
        }
        .podium-card:hover {
            transform: translateY(-8px) scale(1.05);
        }

        /* Medal Animasi */
        .medal {
            font-size: 3.4rem;
            margin-bottom: 8px;
            animation: float 2.5s ease-in-out infinite;
        }
        @keyframes float {
            0%{transform:translateY(0);}
            50%{transform:translateY(-8px);}
            100%{transform:translateY(0);}
        }

        /* Glow warna */
        .gold-glow { text-shadow:0 0 15px rgba(255,220,80,0.7); }
        .silver-glow{ text-shadow:0 0 15px rgba(200,200,200,0.7); }
        .bronze-glow{ text-shadow:0 0 15px rgba(255,160,90,0.7); }

        /* EXP Box */
        .exp-box {
            margin-top:10px;
            padding:6px 12px;
            border-radius:14px;
            border:1px solid rgba(255,255,255,0.1);
            font-size:.9rem;
            display:inline-block;
            backdrop-filter:blur(8px);
        }
        .exp-gold{ background:linear-gradient(90deg,rgba(255,230,100,.2),rgba(255,240,150,.1)); }
        .exp-silver{ background:linear-gradient(90deg,rgba(220,220,220,.2),rgba(240,240,240,.1)); }
        .exp-bronze{ background:linear-gradient(90deg,rgba(255,180,90,.2),rgba(255,200,130,.1)); }

        /* Podium Base */
        .podium-base {
            width:70px;
            margin:auto;
            border-radius:16px 16px 0 0;
            border-top:1px solid rgba(255,255,255,0.2);
            margin-top:20px;
        }
        .podium-0 { background:rgba(255,230,100,.25); }
        .podium-1 { background:rgba(200,200,200,.25); }
        .podium-2 { background:rgba(255,180,90,.25); }

        /* Shine overlay */
        .shine {
            position:absolute;
            inset:0;
            border-radius:22px;
            background:linear-gradient(135deg,rgba(255,255,255,0.2),transparent);
            opacity:0.05;
            pointer-events:none;
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

            {{-- TOP 3 TURNAMEN --}}
            @php
                $top3 = collect($leaderboard ?? [])->take(3)->values();
                $bonus = $turnamen->bonus_exp ?? 0;

                // Reorder manually so podium always: 2 - 1 - 3
                $podiumOrder = [
                    $top3[1] ?? null, // posisi kiri (peringkat 2)
                    $top3[0] ?? null, // posisi tengah (peringkat 1)
                    $top3[2] ?? null  // posisi kanan (peringkat 3)
                ];
            @endphp

            <div class="w-full flex flex-col items-center mb-10">

                <div id="podium-container" class="grid grid-cols-3 gap-6 items-end justify-center">

                    @foreach ($podiumOrder as $pos => $p)
                        @if(!$p) 
                            {{-- Jika data kurang dari 3 --}}
                            <div></div>
                            @continue
                        @endif

                        @php
                            // posisi podium sebenarnya (ranking asli)
                            $i = array_search($p, $top3->toArray());

                            // tinggi podium sesuai ranking
                            $heights = ['h-26', 'h-18', 'h-10'];
                            $podiumHeight = $heights[$i];
                        @endphp

                        <div class="relative flex flex-col items-center text-center 
                            px-6 py-6 rounded-3xl
                            bg-white/5 backdrop-blur-xl border border-white/10
                            shadow-[0_8px_30px_rgba(0,0,0,0.35)]
                            hover:scale-105 hover:-translate-y-1 transition-all duration-300
                            {{ $i==0 ? 'scale-110 z-10' : '' }}
                        ">

                            {{-- Medal --}}
                            <div class="text-6xl mb-3 drop-shadow-md animate-[bounce_2s_ease-in-out_infinite]
                                {{ $i==0 ? 'text-yellow-400' : ($i==1 ? 'text-gray-300' : 'text-orange-300') }}">
                                {{ ['🥇','🥈','🥉'][$i] }}
                            </div>

                            {{-- Nama --}}
                            <div class="text-xl font-bold truncate max-w-[180px]">
                                {{ $p['nama'] ?? 'Peserta' }}
                            </div>

                            {{-- Skor --}}
                            <div class="text-blue-200 text-sm mt-1">
                                Skor: <span class="font-bold">{{ $p['skor'] ?? 0 }}</span>
                            </div>

                            {{-- Progres --}}
                            <div class="text-gray-400 text-xs mt-1">
                                Progres: {{ ($p['correct'] ?? 0) }}/{{ ($p['answered'] ?? 0) }}
                            </div>

                            {{-- Bonus EXP --}}
                            <div class="mt-3 text-sm bg-gradient-to-r
                                {{ $i==0 ? 'from-yellow-400/20 to-yellow-200/10' : ($i==1 ? 'from-gray-300/20 to-gray-200/10' : 'from-orange-300/20 to-orange-200/10') }}
                                px-3 py-1 rounded-xl border border-white/10 text-white shadow-inner">
                                🎁 EXP:
                                <b>
                                    {{
                                        $i === 0
                                            ? round($bonus * 0.50)
                                            : ($i === 1
                                                ? round($bonus * 0.30)
                                                : round($bonus * 0.20))
                                    }}
                                </b>
                            </div>

                            {{-- Podium Box --}}
                            <div class="mt-6 w-full flex items-end justify-center">
                                <div class="w-20 {{ $podiumHeight }} rounded-t-xl 
                                    {{ $i==0 ? 'bg-yellow-400/20' : ($i==1 ? 'bg-gray-300/20' : 'bg-orange-300/20') }}
                                    border-t border-white/20 shadow-inner">
                                </div>
                            </div>

                            {{-- Shine Overlay --}}
                            <div class="absolute inset-0 rounded-3xl pointer-events-none
                                bg-gradient-to-br from-white/20 to-transparent opacity-5"></div>
                        </div>

                    @endforeach

                </div>

                @if(count($top3) === 0)
                    <div class="text-center text-gray-400 italic py-4">
                        Belum ada data Top 3.
                    </div>
                @endif

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
                            this.top3 = this.leaderboard.slice(0, 3)
                        }
                    } catch (error) {
                        console.error("Gagal memuat leaderboard:", error);
                    }
                }
            }
        }

        function loadLeaderboard() {
            fetch("{{ route('ajax-leaderboard', ['id' => $turnamen->id_turnamen]) }}")
                .then(res => res.json())
                .then(data => {
                    updatePodium(data.leaderboard);
                })
                .catch(err => console.error("Leaderboard error:", err));
        }

        function updatePodium(leaderboard) {
            const el = document.querySelector("#podium-container");
            if (!el) return;

            let top3 = leaderboard.slice(0, 3);

            let html = "";

            // Format ulang sesuai Blade sebelumnya → tetap podium 2 - 1 - 3
            let podiumOrder = [
                top3[1],
                top3[0],
                top3[2],
            ];

            podiumOrder.forEach((p, idx) => {
                if (!p) {
                    html += `<div></div>`;
                    return;
                }

                let i = idx === 0 ? 1 : (idx === 1 ? 0 : 2);
                let podiumHeight = ['h-26','h-18','h-10'][i];
                let medal = ['🥇','🥈','🥉'][i];
                let colors = ['text-yellow-400','text-gray-300','text-orange-300'][i];

                html += `
                    <div class="relative flex flex-col items-center text-center 
                        px-6 py-6 rounded-3xl bg-white/5 backdrop-blur-xl
                        border border-white/10 shadow-[0_8px_30px_rgba(0,0,0,0.35)]
                        hover:scale-105 hover:-translate-y-1 transition-all duration-300
                        ${i==0 ? 'scale-110 z-10' : ''}
                    ">
                        <div class="text-6xl mb-3 drop-shadow-md ${colors}">
                            ${medal}
                        </div>

                        <div class="text-xl font-bold truncate max-w-[180px]">
                            ${p.nama}
                        </div>

                        <div class="text-blue-200 text-sm mt-1">
                            Skor: <span class="font-bold">${p.skor}</span>
                        </div>

                        <div class="text-gray-400 text-xs mt-1">
                            Progres: ${p.correct}/${p.answered}
                        </div>

                        <div class="mt-6 w-full flex items-end justify-center">
                            <div class="w-20 ${podiumHeight} rounded-t-xl 
                                bg-white/10 border-t border-white/20 shadow-inner">
                            </div>
                        </div>
                    </div>
                `;
            });

            el.innerHTML = html;
        }

        setInterval(loadLeaderboard, 5000); // update tiap 5 detik
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