<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Turnamen</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>

    <style>
        body {
            background: radial-gradient(circle at top left, #0a192f, #020c1b);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            background: #0b2239;
            width: 250px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 15px rgba(0,0,0,0.4);
        }

        .sidebar h1 {
            font-family: 'Black Ops One', cursive;
            font-size: 26px;
            color: #38bdf8;
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: #a0aec0;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #1e3a8a;
            color: #fff;
        }

        .content {
            margin-left: 270px;
            padding: 40px;
        }

        .btn-primary {
            background: #38bdf8;
            color: #0f172a;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #0ea5e9;
        }

        .btn-secondary {
            background: #475569;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #334155;
        }

        .btn-danger {
            background: #ef4444;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .card {
            background: #0f172a;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            margin-bottom: 20px;
        }

        .card h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #38bdf8;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #1e293b;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #38bdf8;
        }

        .info-item label {
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 5px;
        }

        .info-item .value {
            font-size: 18px;
            font-weight: 600;
            color: #e2e8f0;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-pending {
            background: #3b82f6;
            color: #fff;
        }

        .status-berlangsung {
            background: #10b981;
            color: #fff;
        }

        .status-selesai {
            background: #f59e0b;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            text-align: left;
            padding: 12px;
            background: #1e293b;
            color: #cbd5e1;
            font-weight: 600;
        }

        table td {
            padding: 12px;
            border-top: 1px solid #1e293b;
            color: #e2e8f0;
        }

        table tr:hover td {
            background: rgba(56, 189, 248, 0.1);
        }

        .rank-1 {
            color: #ffd700;
        }

        .rank-2 {
            color: #c0c0c0;
        }

        .rank-3 {
            color: #cd7f32;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        #tsparticles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            top: 0;
            left: 0;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #1e293b;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #94a3b8;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .tab:hover {
            color: #38bdf8;
        }

        .tab.active {
            color: #38bdf8;
            border-bottom-color: #38bdf8;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <div id="tsparticles"></div>

    <div class="sidebar">
        <div>
            <h1>Guru Panel</h1>
            <a href="#">🏠 Dashboard</a>
            <a href="#">📘 Bank Soal</a>
            <a href="#" class="active">🏆 Turnamen</a>
            <a href="#">📊 Statistik Siswa</a>
        </div>
        <div>
            <form method="POST" action="#">
                <button type="submit"
                    class="block w-full text-left px-4 py-2 text-white-400 hover:text-cyan-500 transition">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>

    <div class="content" x-data="tournamentDetail()">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="#" class="text-cyan-400 hover:underline mb-2 inline-block">← Kembali ke Daftar Turnamen</a>
                <h1 class="text-3xl font-bold" x-text="tournament.nama_turnamen"></h1>
            </div>
            <div class="flex gap-2">
                <a href="#" class="btn-secondary">✏️ Edit</a>
                <button @click="confirmDelete()" class="btn-danger">🗑️ Hapus</button>
            </div>
        </div>

        <!-- Info Utama -->
        <div class="card">
            <h3>Informasi Turnamen</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Status</label>
                    <div class="value">
                        <span class="status-badge" :class="{
                            'status-pending': tournament.status.toLowerCase() === 'pending',
                            'status-berlangsung': tournament.status.toLowerCase() === 'berlangsung',
                            'status-selesai': tournament.status.toLowerCase() === 'selesai'
                        }" x-text="tournament.status"></span>
                    </div>
                </div>
                <div class="info-item">
                    <label>Tanggal Pelaksanaan</label>
                    <div class="value" x-text="formatDate(tournament.tanggal_pelaksanaan)"></div>
                </div>
                <div class="info-item">
                    <label>Durasi</label>
                    <div class="value" x-text="tournament.durasi + ' Menit'"></div>
                </div>
                <div class="info-item">
                    <label>Jumlah Soal</label>
                    <div class="value" x-text="tournament.jumlah_soal + ' Soal'"></div>
                </div>
                <div class="info-item">
                    <label>Peserta</label>
                    <div class="value" x-text="tournament.peserta_count + ' / ' + tournament.max_peserta"></div>
                </div>
                <div class="info-item">
                    <label>Passing Grade</label>
                    <div class="value" x-text="tournament.passing_grade"></div>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="card" x-show="tournament.deskripsi">
            <h3>Deskripsi</h3>
            <p class="text-gray-300" x-text="tournament.deskripsi"></p>
        </div>

        <!-- Tabs -->
        <div class="card">
            <div class="tabs">
                <div class="tab active" @click="switchTab('peserta')">👥 Peserta</div>
                <div class="tab" @click="switchTab('leaderboard')">🏆 Leaderboard</div>
                <div class="tab" @click="switchTab('soal')">📝 Soal</div>
            </div>

            <!-- Tab Peserta -->
            <div class="tab-content active" id="tab-peserta">
                <div class="mb-4 flex gap-4">
                    <div class="info-item flex-1">
                        <label>Sedang Mengerjakan</label>
                        <div class="value text-blue-400" x-text="getStatusCount('mengerjakan')"></div>
                    </div>
                    <div class="info-item flex-1">
                        <label>Selesai</label>
                        <div class="value text-green-400" x-text="getStatusCount('selesai')"></div>
                    </div>
                    <div class="info-item flex-1">
                        <label>Belum Mengerjakan</label>
                        <div class="value text-gray-400" x-text="getStatusCount('belum')"></div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status Pengerjaan</th>
                            <th>Progress</th>
                            <th>Benar/Salah</th>
                            <th>Waktu Tersisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(peserta, index) in participants" :key="peserta.id">
                            <tr>
                                <td x-text="index + 1"></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <span x-text="peserta.nama"></span>
                                        <span class="w-2 h-2 rounded-full" 
                                              :class="{
                                                  'bg-blue-400 animate-pulse': peserta.status === 'mengerjakan',
                                                  'bg-green-400': peserta.status === 'selesai',
                                                  'bg-gray-400': peserta.status === 'belum'
                                              }"></span>
                                    </div>
                                </td>
                                <td x-text="peserta.kelas"></td>
                                <td>
                                    <span class="status-badge text-sm py-1 px-3" 
                                          :class="{
                                              'bg-blue-500': peserta.status === 'mengerjakan',
                                              'bg-green-500': peserta.status === 'selesai',
                                              'bg-gray-500': peserta.status === 'belum'
                                          }">
                                        <span x-show="peserta.status === 'mengerjakan'">⏳ Sedang Mengerjakan</span>
                                        <span x-show="peserta.status === 'selesai'">✓ Selesai</span>
                                        <span x-show="peserta.status === 'belum'">⊘ Belum Mulai</span>
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-gray-700 rounded-full h-2 overflow-hidden">
                                            <div class="bg-cyan-400 h-2 transition-all duration-500" 
                                                 :style="`width: ${(peserta.soal_dijawab / tournament.jumlah_soal * 100)}%`"></div>
                                        </div>
                                        <span class="text-sm text-gray-400" x-text="`${peserta.soal_dijawab}/${tournament.jumlah_soal}`"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-1">
                                            <span class="text-green-400 font-bold" x-text="peserta.jawaban_benar">0</span>
                                            <span class="text-green-400">✓</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="text-red-400 font-bold" x-text="peserta.jawaban_salah">0</span>
                                            <span class="text-red-400">✗</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span x-show="peserta.status === 'mengerjakan'" 
                                          class="font-mono"
                                          :class="{
                                              'text-red-400': peserta.waktu_tersisa <= 10,
                                              'text-yellow-400': peserta.waktu_tersisa > 10 && peserta.waktu_tersisa <= 30,
                                              'text-gray-300': peserta.waktu_tersisa > 30
                                          }"
                                          x-text="formatTime(peserta.waktu_tersisa)"></span>
                                    <span x-show="peserta.status === 'selesai'" class="text-gray-400">-</span>
                                    <span x-show="peserta.status === 'belum'" class="text-gray-400">90:00</span>
                                </td>
                            </tr>
                        </template>
                        <template x-if="participants.length === 0">
                            <tr>
                                <td colspan="7" class="text-center text-gray-400">Belum ada peserta terdaftar.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Tab Leaderboard -->
            <div class="tab-content" id="tab-leaderboard">
                <table>
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Skor</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(rank, index) in leaderboard" :key="rank.id">
                            <tr>
                                <td>
                                    <span :class="{
                                        'rank-1': index === 0,
                                        'rank-2': index === 1,
                                        'rank-3': index === 2
                                    }" x-text="index + 1"></span>
                                    <span x-show="index === 0">🥇</span>
                                    <span x-show="index === 1">🥈</span>
                                    <span x-show="index === 2">🥉</span>
                                </td>
                                <td x-text="rank.nama"></td>
                                <td x-text="rank.kelas"></td>
                                <td><strong x-text="rank.skor"></strong></td>
                                <td x-text="rank.waktu_selesai + ' menit'"></td>
                                <td>
                                    <span class="text-green-400" x-show="rank.lulus">✓ Lulus</span>
                                    <span class="text-red-400" x-show="!rank.lulus">✗ Tidak Lulus</span>
                                </td>
                            </tr>
                        </template>
                        <template x-if="leaderboard.length === 0">
                            <tr>
                                <td colspan="6" class="text-center text-gray-400">Belum ada data hasil turnamen.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Tab Soal -->
            <div class="tab-content" id="tab-soal">
                <div class="mb-4">
                    <p class="text-gray-300">Total Soal: <strong x-text="questions.length"></strong></p>
                </div>
                <template x-for="(soal, index) in questions" :key="soal.id">
                    <div class="bg-slate-800 p-4 rounded-lg mb-3">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-cyan-400">Soal #<span x-text="index + 1"></span></h4>
                            <span class="text-sm text-gray-400" x-text="soal.tipe"></span>
                        </div>
                        <p class="text-gray-200 mb-3" x-text="soal.pertanyaan"></p>
                        <div class="space-y-2">
                            <template x-for="(opsi, key) in soal.opsi" :key="key">
                                <div class="flex items-center gap-2">
                                    <span class="text-cyan-400 font-semibold" x-text="key + '.'"></span>
                                    <span x-text="opsi" :class="soal.jawaban_benar === key ? 'text-green-400 font-semibold' : 'text-gray-300'"></span>
                                    <span x-show="soal.jawaban_benar === key" class="text-green-400 text-sm">✓ Jawaban Benar</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
                <template x-if="questions.length === 0">
                    <p class="text-center text-gray-400">Belum ada soal untuk turnamen ini.</p>
                </template>
            </div>
        </div>
    </div>

        <script>
        function tournamentDetail() {
            return {
                // server-provided data (normalized for the view)
                tournament: @json($viewTournament ?? []),
                participants: @json($participants ?? []),
                leaderboard: @json($leaderboard ?? []),
                questions: @json($questions ?? []),

                formatDate(dateStr) {
                    if (!dateStr) return '-';
                    const date = new Date(dateStr);
                    return date.toLocaleDateString('id-ID', { 
                        day: 'numeric', 
                        month: 'long', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },
                formatDateTime(dateStr) {
                    if (!dateStr) return '-';
                    const date = new Date(dateStr);
                    return date.toLocaleDateString('id-ID', { 
                        day: 'numeric', 
                        month: 'short', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },
                formatTime(minutes) {
                    const mins = Math.floor(minutes);
                    const secs = Math.floor((minutes - mins) * 60);
                    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                },
                getStatusCount(status) {
                    return this.participants.filter(p => p.status === status).length;
                },
                // No realtime simulation — data is loaded from the database on page render
                init() {
                    // Intentionally left blank: participants/questions/leaderboard come from server-side DB
                },
                switchTab(tabName) {
                    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                    event.target.classList.add('active');
                    document.getElementById('tab-' + tabName).classList.add('active');
                },
                confirmDelete() {
                    if (confirm('Apakah Anda yakin ingin menghapus turnamen ini? Tindakan ini tidak dapat dibatalkan.')) {
                        alert('Turnamen berhasil dihapus! (Demo only)');
                    }
                }
            }
        }

        // Initialize particles
        tsParticles.load("tsparticles", {
            background: { color: { value: "transparent" } },
            fpsLimit: 60,
            interactivity: {
                events: { onHover: { enable: true, mode: "repulse" }, resize: true },
                modes: { repulse: { distance: 100, duration: 0.4 } }
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
                number: { density: { enable: true, area: 800 }, value: 80 },
                opacity: { value: 0.3 },
                shape: { type: "circle" },
                size: { value: { min: 1, max: 3 } }
            },
            detectRetina: true
        });
    </script>
</body>
</html>