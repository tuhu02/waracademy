<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF token PENTING untuk AJAX POST -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Turnamen: {{ $tournament->nama_turnamen }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>

    <style>
        /* (Salin-tempel semua CSS dari file index/create Anda) */
        body { background: radial-gradient(circle at top left, #0a192f, #020c1b); color: #fff; font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        .content { margin-left: 270px; padding: 40px; }
        
        .btn-primary { background: #38bdf8; color: #0f172a; padding: 10px 20px; border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s; border:none; cursor: pointer; }
        .btn-primary:hover { background: #0ea5e9; }
        .btn-secondary { background: #475569; color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.3s; border: none; cursor: pointer; }
        .btn-secondary:hover { background: #64748b; }
        
        /* (Style khusus untuk Lobi/Show) */
        .box { background: #0f172a; border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        .code-display { background: #1e3a8a; padding: 20px; border-radius: 10px; text-align: center; font-size: 48px; font-weight: 800; letter-spacing: 8px; color: #38bdf8; font-family: 'Courier New', monospace; margin: 20px 0; border: 2px dashed #38bdf8; }
        .participant-list { background: #1e293b; border-radius: 10px; padding: 20px; min-height: 200px; text-align: left; }
        .participant-item { background: #334155; color: #e2e8f0; padding: 8px 15px; border-radius: 8px; margin-bottom: 8px; font-weight: 500; }
        .btn-start-game { background: #22c55e; color: #fff; padding: 20px 40px; border-radius: 12px; font-size: 24px; font-weight: 800; text-transform: uppercase; transition: all 0.3s; cursor: pointer; border: none; width: 100%; }
        .btn-start-game:hover { background: #16a34a; }
        .btn-start-game:disabled { background: #475569; cursor: not-allowed; }
        
        /* (Style untuk tabel monitor/hasil) */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th { text-align: left; padding: 10px; background: #1e293b; color: #cbd5e1; }
        table td { padding: 10px; border-top: 1px solid #1e293b; color: #e2e8f0; }
        table tr:hover td { background: rgba(56, 189, 248, 0.1); }
        
        #tsparticles { position: fixed; width: 100%; height: 100%; z-index: -1; top: 0; left: 0; }
    </style>
</head>
<body x-data="pageController()">

    <div id="tsparticles"></div>

    @include('guru.components.sidebar-guru')

    <!-- Main Content -->
    <div class="content">

        {{-- ====================================================== --}}
        {{-- 1. TAMPILAN LOBI (JIKA STATUS "MENUNGGU") --}}
        {{-- ====================================================== --}}
        @if($tournament->status === 'Menunggu')
        
            <div x-data="lobbyController()">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-bold">Lobi Turnamen</h1>
                        <p class="text-gray-400 text-xl">{{ $tournament->nama_turnamen }}</p>
                    </div>
                    <a href="{{ route('guru.tournament.index') }}" class="btn-secondary">← Kembali ke Daftar</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Kolom Kiri: Kode & Tombol Mulai -->
                    <div class="md:col-span-2">
                        <div class="box">
                            <h3 class="text-2xl font-bold text-cyan-400">Bagikan Kode Room Ini ke Siswa</h3>
                            
                            <div class="code-display" x-text="roomCode">
                                {{ $tournament->kode_room }}
                            </div>
                            
                            <button type"button" @click="copyRoomCode" class="btn-primary mb-8">
                                📋 Salin Kode
                            </button>
                            
                            <hr class="border-gray-700 my-8">
                            
                            <h3 class="text-2xl font-bold text-gray-300 mb-4">Mulai Turnamen</h3>
                            <p class="text-gray-400 mb-6" x-show="participants.length === 0">
                                Belum ada siswa yang bergabung. Turnamen bisa dimulai jika minimal 1 siswa sudah masuk.
                            </p>
                            
                            <button type="button" class="btn-start-game" 
                                @click="startGame" 
                                :disabled="participants.length === 0 || isLoading">
                                <span x-show="!isLoading">🚀 Mulai Turnamen Sekarang!</span>
                                <span x-show="isLoading">Memulai...</span>
                            </button>
                            
                            <p x-show="errorMessage" x-text="errorMessage" class="text-red-400 mt-4"></p>
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan: Daftar Peserta -->
                    <div class="md:col-span-1">
                        <div class="box">
                            <h3 class="text-2xl font-bold text-cyan-400 mb-4">
                                Peserta Bergabung (<span x-text="participants.length">0</span>/<span>{{ $tournament->max_peserta }}</span>)
                            </h3>
                            
                            <div class="participant-list">
                                <template x-if="participants.length === 0">
                                    <p class="text-gray-400 text-center py-16">Menunggu siswa bergabung...</p>
                                </template>
                                
                                <template x-for="participant in participants" :key="participant.id">
                                    <div class="participant-item" x-text="participant.nama"></div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Lobi x-data -->

        {{-- ====================================================== --}}
        {{-- 2. TAMPILAN MONITOR (JIKA STATUS "BERLANGSUNG") --}}
        {{-- ====================================================== --}}
        @elseif($tournament->status === 'Berlangsung')
        
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-green-400">Turnamen Berlangsung</h1>
                    <p class="text-gray-400 text-xl">{{ $tournament->nama_turnamen }}</p>
                </div>
                <a href="{{ route('guru.tournament.index') }}" class="btn-secondary">← Kembali ke Daftar</a>
            </div>
            
            <div class="box">
                <h2 class="text-2xl font-bold text-cyan-400 mb-4">Monitor Peserta (Live)</h2>
                <p class="text-gray-400 mb-4">Data akan diperbarui. Refresh halaman untuk data terbaru.</p>
                
                {{-- Ini adalah tabel 'participants' terperinci dari controller Anda --}}
                <table>
                    <thead>
                        <tr>
                            <th>Nama Peserta</th>
                            <th>Status</th>
                            <th>Soal Dijawab</th>
                            <th>Benar</th>
                            <th>Salah</th>
                            <th>Waktu Tersisa (menit)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($participants as $p)
                            <tr>
                                <td>{{ $p['nama'] ?? 'Siswa' }}</td>
                                <td>{{ $p['status'] ?? '-' }}</td>
                                <td>{{ $p['soal_dijawab'] ?? 0 }} / {{ count($questions) }}</td>
                                <td>{{ $p['jawaban_benar'] ?? 0 }}</td>
                                <td>{{ $p['jawaban_salah'] ?? 0 }}</td>
                                <td>{{ $p['waktu_tersisa'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400">Belum ada data peserta...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        {{-- ====================================================== --}}
        {{-- 3. TAMPILAN HASIL (JIKA STATUS "SELESAI" ATAU LAINNYA) --}}
        {{-- ====================================================== --}}
        @else 
        
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-yellow-400">Turnamen Selesai</h1>
                    <p class="text-gray-400 text-xl">{{ $tournament->nama_turnamen }}</p>
                </div>
                <a href="{{ route('guru.tournament.index') }}" class="btn-secondary">← Kembali ke Daftar</a>
            </div>
            
            <div class="box">
                <h2 class="text-2xl font-bold text-cyan-400 mb-4">Hasil Akhir (Leaderboard)</h2>
                
                {{-- Ini adalah tabel 'leaderboard' dari controller Anda --}}
                <table>
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Peserta</th>
                            <th>Skor Akhir</th>
                            <th>Kelas</th>
                            <th>Status Lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leaderboard as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['nama'] ?? 'Siswa' }}</td>
                                <td>{{ $item['skor'] ?? 0 }}</td>
                                <td>{{ $item['kelas'] ?? '-' }}</td>
                                <td>
                                    @if($item['lulus'])
                                        <span class="text-green-400">Lulus</span>
                                    @else
                                        <span class="text-red-400">Tidak Lulus</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-400">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        @endif

    </div>

    <script>
        tsParticles.load("tsparticles", {
            // ... (Konfigurasi particles Anda) ...
            background: { color: { value: "transparent" } }, fpsLimit: 60,
            particles: { color: { value: "#38bdf8" }, links: { color: "#38bdf8", distance: 150, enable: true, opacity: 0.3, width: 1 }, move: { direction: "none", enable: true, outModes: { default: "bounce" }, random: false, speed: 1, straight: false }, number: { density: { enable: true, area: 800 }, value: 80 }, opacity: { value: 0.3 }, shape: { type: "circle" }, size: { value: { min: 1, max: 3 } } },
        });

        // Controller Alpine utama
        function pageController() {
            return {
                // state global jika perlu
            };
        }

        // Controller khusus untuk Lobi (hanya aktif jika lobi ditampilkan)
        function lobbyController() {
            return {
                // Data dari Laravel (Blade)
                // Pastikan nama kolom ini (id_turnamen, kode_room, max_peserta)
                // sesuai dengan tabel 'turnamen' Anda
                tournamentId: '{{ $tournament->id_turnamen }}', 
                roomCode: '{{ $tournament->kode_room }}',
                maxParticipants: {{ $tournament->max_peserta }},
                
                // State
                participants: @json($participants), // Muat data peserta awal dari controller
                isLoading: false,
                errorMessage: '',
                pollInterval: null,

                init() {
                    // Mulai polling untuk daftar peserta
                    this.pollInterval = setInterval(() => this.fetchParticipants(), 5000); // Cek setiap 5 detik
                },
                
                destroy() {
                    // Hentikan polling jika pindah halaman
                    clearInterval(this.pollInterval);
                },

                fetchParticipants() {
                    // URL untuk mengambil daftar peserta (Route: guru.tournament.participants)
                    const pollUrl = `/guru/tournament/${this.tournamentId}/participants`; 
                    
                    fetch(pollUrl, { headers: { 'Accept': 'application/json' } })
                        .then(res => res.json())
                        .then(data => {
                            if (Array.isArray(data)) {
                                this.participants = data;
                            }
                        })
                        .catch(err => console.error('Gagal mengambil peserta:', err));
                },

                startGame() {
                    if (this.participants.length === 0) {
                        this.errorMessage = "Tidak bisa memulai turnamen tanpa peserta.";
                        return;
                    }
                    
                    this.isLoading = true;
                    this.errorMessage = '';
                    
                    // URL untuk memulai turnamen (Route: guru.tournament.start)
                    const startUrl = `/guru/tournament/${this.tournamentId}/start`;
                    
                    fetch(startUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    })
                    .then(res => {
                        if (!res.ok) { return res.json().then(err => Promise.reject(err)); }
                        return res.json();
                    })
                    .then(data => {
                        // SUKSES! Backend telah mengubah status
                        this.isLoading = false;
                        clearInterval(this.pollInterval); // Hentikan polling
                        
                        alert('Turnamen berhasil dimulai! Halaman akan dimuat ulang.');
                        window.location.reload(); 
                    })
                    .catch(err => {
                        // GAGAL
                        this.isLoading = false;
                        this.errorMessage = err.message || "Gagal memulai turnamen. Coba lagi.";
                    });
                },
                
                copyRoomCode() {
                    navigator.clipboard.writeText(this.roomCode);
                    alert('Kode Room berhasil disalin!');
                }
            }
        }
    </script>
</body>
</html>