<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Soal Guru</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>

    <style>
        body { background: radial-gradient(circle at top left, #0a192f, #020c1b); color: #fff; font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        .content { margin-left: 270px; padding: 40px; }

        .table-section { background: #0f172a; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        .table-section h3 { font-size: 22px; font-weight: 600; margin-bottom: 20px; color: #38bdf8; }

        #tsparticles { position: fixed; width: 100%; height: 100%; z-index: -1; top: 0; left: 0; }
        [x-cloak] { display: none; }

        /* Custom smooth collapse */
        [x-collapse] {
            overflow: hidden;
            transition: height 0.35s ease, opacity 0.3s ease;
        }

        /* Fade-up animation for cards */
        .fade-up {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeUp 0.5s ease-out forwards;
        }
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .grid-cols-5 { grid-template-columns: 2fr 1fr 1fr 2fr 1fr; }
    </style>
</head>
<body>

<div id="tsparticles"></div>

@include('guru.components.sidebar-guru')

<div class="content">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Bank Soal</h1>
    </div>

    <div class="table-section">
        <h3>Daftar Soal</h3>

        <!-- HEADER -->
        <div class="grid grid-cols-5 bg-[#1f2a40] py-3 px-4 font-semibold rounded-lg">
            <div>Nama Turnamen</div>
            <div>Jumlah Soal</div>
            <div>Status</div>
            <div>Tanggal Pelaksanaan</div>
            <div>Aksi</div>
        </div>

        <!-- LIST -->
        @foreach($turnamen as $t)
        <div x-data="{ open:false, detail:[] }"
            class="mt-3 bg-[#0f1628] rounded-xl shadow p-4 fade-up 
                   transition duration-300 hover:shadow-lg hover:scale-[1.01]">

            <div class="grid grid-cols-5 items-center">

                <div class="text-cyan-300 font-semibold">{{ $t->nama_turnamen }}</div>

                <div class="text-gray-300">{{ $t->jumlah_soal }} Soal</div>

                <div class="text-gray-300">{{ $t->status }}</div>

                <div class="text-gray-300">{{ $t->tanggal_pelaksanaan }}</div>

                <div>
                    <button
                        class="text-cyan-400 hover:text-cyan-200 font-semibold flex items-center gap-1 transition-all"
                        @click="
                            if(!open){
                                if(detail.length === 0){
                                    fetch('{{ route('guru.soal.detail', $t->id_turnamen) }}')
                                    .then(res => res.json())
                                    .then(data => detail = data)
                                }
                            }
                            open = !open;
                        ">
                        <span x-text="open ? 'Tutup Detail' : 'Lihat Detail'"></span>
                        <span x-text="open ? '▲' : '▼'" 
                              class="transition-transform duration-300"
                              :class="open ? 'rotate-180' : ''"></span>
                    </button>
                </div>

            </div>

            <!-- DETAIL -->
            <div x-show="open"
                 x-collapse
                 x-transition.opacity.duration.400ms
                 x-transition.scale.origin.top.duration.400ms
                 class="mt-4 border-t border-gray-600 pt-4">

                <template x-if="detail.length === 0">
                    <p class="text-gray-400 animate-pulse">Memuat detail...</p>
                </template>

                <template x-for="(d, i) in detail" :key="i">
                    <div class="mb-4 p-4 bg-[#1e293b] rounded-lg transition transform hover:scale-[1.01]">

                        <h3 class="font-semibold text-cyan-300">
                            Soal #<span x-text="i+1"></span>
                        </h3>

                        <p class="mt-2" x-text="d.teks_pertanyaan"></p>

                        <div class="mt-3 ml-4">
                            <template x-for="j in d.jawaban">
                                <p class="mt-1 transition"
                                   :class="j.adalah_benar == 1 
                                          ? 'text-green-400 font-bold' 
                                          : 'text-gray-300' ">
                                    • <span x-text="j.teks_jawaban"></span>
                                    <template x-if="j.adalah_benar == 1">(Benar)</template>
                                </p>
                            </template>
                        </div>

                    </div>
                </template>

            </div>

        </div>
        @endforeach
    </div>

</div>

<script>
tsParticles.load("tsparticles", {
            background: { color: { value: "transparent" } },
            fpsLimit: 60,
            interactivity: {
                events: {
                    onHover: { enable: true, mode: "repulse" },
                    resize: true
                },
                modes: {
                    repulse: { distance: 100, duration: 0.4 }
                }
            },
            particles: {
                color: { value: "#38bdf8" },
                links: {
                    color: "#38bdf8",
                    distance: 150,
                    enable: true,
                    opacity: 0.3,
                    width: 1
                },
                move: {
                    direction: "none",
                    enable: true,
                    outModes: { default: "bounce" },
                    random: false,
                    speed: 1,
                    straight: false
                },
                number: {
                    density: { enable: true, area: 800 },
                    value: 80
                },
                opacity: { value: 0.3 },
                shape: { type: "circle" },
                size: { value: { min: 1, max: 3 } }
            },
            detectRetina: true
        });
    </script>

</body>
</html>
