<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard Turnamen</title>

    <!-- FONT GOOGLE -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- TAILWIND CSS -->
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
</head>

<body class="min-h-screen bg-gradient-to-b from-[#0f1b2e] via-[#304863] to-[#3b5875] text-white font-poppins relative overflow-hidden select-none">

    <!-- CANVAS PARTIKEL -->
    <canvas id="particles" class="absolute inset-0 z-0"></canvas>

    <!-- LOGO TRANSPARAN -->
    <img src="/images/war.png" alt="Logo" 
       class="absolute opacity-20 scale-150 animate-fadeIn" 
       style="top: 35%; left: 50%; transform: translate(-50%, -50%); width: auto; height: 500px;">

    <!-- CONTENT WRAPPER -->
    <div class="relative z-10 w-full max-w-4xl mx-auto mt-20 p-8 rounded-2xl 
                bg-[#1b2636]/60 backdrop-blur-md shadow-[0_0_25px_rgba(70,150,255,0.4)] animate-fadeIn">
        <div class="flex justify-start mb-4">
            <a href="{{ route('home') }}">
                <button class="relative bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white px-6 py-2 rounded-xl font-semibold 
                            border border-[#1b3e75]
                            shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)]
                            hover:scale-105 hover:shadow-[0_0_20px_rgba(70,150,255,0.7)]
                            transition-all duration-300 ease-in-out overflow-hidden group">
                <span class="relative z-10">⬅ Kembali</span>
                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                                translate-x-[-100%] group-hover:translate-x-[100%] 
                                transition-transform duration-700"></span>
                </button>
            </a>
        </div>
        <!-- TITLE -->
        <div class="text-center mb-6">
            <h2 class="text-4xl font-blackops tracking-widest 
                       bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa]
                       bg-clip-text text-transparent drop-shadow-[0_0_10px_rgba(50,120,200,0.6)]">
                LEADERBOARD
            </h2>
        </div>

        <!-- TABLE -->
        <div class="overflow-hidden rounded-xl shadow-lg">
            <table class="w-full text-center text-white">
                <thead class="bg-[#233448]/80">
                    <tr>
                        <th class="py-3 font-semibold">Peringkat</th>
                        <th class="py-3 font-semibold">Nama</th>
                        <th class="py-3 font-semibold">Kelas</th>
                        <th class="py-3 font-semibold">Nilai</th>
                        <th class="py-3 font-semibold">Waktu</th>
                    </tr>
                </thead>

                {{-- MODE REFRESH OTOMATIS --}}
                @if($turnamen->status === 'Berlangsung')
                <tbody x-data="leaderboardController" x-init="startAutoRefresh()" class="bg-[#1c2a3a]/70">
                    <template x-for="(entry, index) in leaderboard" :key="entry.id || index">
                        <tr :class="entry.is_me ? 'bg-[#3d6fc0]/80 shadow-[0_0_10px_rgba(70,150,255,0.8)] font-bold' : 'odd:bg-[#1b2636]/40 even:bg-[#16202e]/40'">
                            <td class="py-3" x-text="entry.rank || (index + 1)"></td>
                            <td class="py-3" x-text="entry.nama || 'Siswa'"></td>
                            <td class="py-3" x-text="entry.kelas || '-'"></td>
                            <td class="py-3" x-text="entry.skor || 0"></td>
                            <td class="py-3" x-text="(entry.correct || 0) + '/' + (entry.answered || 0)"></td>
                        </tr>
                    </template>

                    <template x-if="leaderboard.length === 0">
                        <tr>
                            <td colspan="5" class="py-6 opacity-70 text-sm">Belum ada peserta.</td>
                        </tr>
                    </template>
                </tbody>

                @else
                {{-- MODE NORMAL --}}
                <tbody class="bg-[#1c2a3a]/70">
                    @forelse($leaderboard as $entry)
                        <tr class="{{ ($entry['is_me'] ?? false) 
                            ? 'bg-[#3d6fc0]/80 shadow-[0_0_10px_rgba(70,150,255,0.8)] font-bold' 
                            : 'odd:bg-[#1b2636]/40 even:bg-[#16202e]/40' }}">
                            <td class="py-3">{{ $entry['rank'] ?? $loop->iteration }}</td>
                            <td class="py-3">{{ $entry['nama'] ?? 'Siswa'}}</td>
                            <td class="py-3">{{ $entry['kelas'] ?? '-' }}</td>
                            <td class="py-3">{{ $entry['skor'] ?? 0}}</td>
                            <td class="py-3">{{ ($entry['correct'] ?? 0) . '/' . ($entry['answered'] ?? 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 opacity-70 text-sm">Belum ada peserta.</td>
                        </tr>
                    @endforelse
                </tbody>
                @endif

            </table>
        </div>

        @if($turnamen->status === 'Berlangsung')
        <div class="mt-4 text-sm opacity-80 text-center">
            ⟳ Leaderboard diperbarui otomatis setiap 5 detik...
        </div>
        @endif
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
                        if (data.leaderboard) {this.leaderboard = data.leaderboard;}
                    } catch (error) {
                        console.error("Gagal memuat leaderboard:", error);
                    }
                }
            }
        }
    </script>
    @endif


    <!-- SCRIPT PARTIKEL -->
    <script>
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        canvas.width = innerWidth;
        canvas.height = innerHeight;

        const particles = Array.from({ length: 60 }, () => ({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: Math.random() * 2,
            speedX: (Math.random() - 0.5) * 0.5,
            speedY: (Math.random() - 0.5) * 0.5,
        }));

        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fill();
                p.x += p.speedX;
                p.y += p.speedY;
                if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
                if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
            });
            requestAnimationFrame(drawParticles);
        }
        drawParticles();

        window.addEventListener('resize', () => {
            canvas.width = innerWidth;
            canvas.height = innerHeight;
        });
    </script>

</body>
</html>
