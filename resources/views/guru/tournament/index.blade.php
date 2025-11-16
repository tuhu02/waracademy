<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnamen Guru</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>

    <style>
        /* ... (Semua CSS Anda tetap sama) ... */
        body { background: radial-gradient(circle at top left, #0a192f, #020c1b); color: #fff; font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        .content { margin-left: 270px; padding: 40px; }
        .btn-primary { background: #38bdf8; color: #0f172a; padding: 10px 20px; border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s; }
        .btn-primary:hover { background: #0ea5e9; }
        .table-section { background: #0f172a; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        .table-section h3 { font-size: 22px; font-weight: 600; margin-bottom: 20px; color: #38bdf8; }
        table { width: 100%; border-collapse: collapse; }
        table th { text-align: left; padding: 10px; background: #1e293b; color: #cbd5e1; }
        table td { padding: 10px; border-top: 1px solid #1e293b; color: #e2e8f0; }
        table tr:hover td { background: rgba(56, 189, 248, 0.1); }
        #tsparticles { position: fixed; width: 100%; height: 100%; z-index: -1; top: 0; left: 0; }
    </style>
</head>
<body>
    <div id="tsparticles"></div>

<<<<<<< HEAD
    @include('guru.components.sidebar-guru')
=======
    <div class="sidebar">
        @include('guru.components.sidebar-guru')
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="block w-full text-left px-4 py-2 text-white-400 hover:text-cyan-500 transition">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>
>>>>>>> 350fa1ba9819f99c2470623017da41f36448f59c

    <div class="content">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Daftar Turnamen</h1>
            <a href="{{ route('guru.tournament.create') }}" class="btn-primary">+ Buat Turnamen</a>
        </div>

        <div class="table-section">
            <h3>Turnamen Aktif & Selesai</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Turnamen</th>
                        <th>Peserta</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tournament-tbody">
                    <tr>
                        <td colspan="4" class="text-center text-gray-400">Memuat daftar turnamen…</td>
                    </tr>
                </tbody>
            </table>
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
        <script>
            // Poll the server every 10 seconds for updated tournaments
            (function pollTournaments() {
                const url = '{{ route("guru.tournament.data") }}';
                const baseShowUrl = '{{ url("/guru/tournament") }}';

                fetch(url, { headers: { 'Accept': 'application/json' } })
                    .then(res => res.json())
                    .then(data => {
                        const tbody = document.getElementById('tournament-tbody');
                        if (!tbody) return;

                        if (!Array.isArray(data) || data.length === 0) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="4" class="text-center text-gray-400">
                                        Belum ada turnamen.
                                    </td>
                                </tr>`;
                            return;
                        }

                        const rows = data.map(t => {
                            // === Perbaikan kolom ===
                            const id = t.id_turnamen;
                            const nama = t.nama_turnamen ?? '-';
                            const pesertaCount = t.peserta_count ?? 0;
                            const maxPeserta = t.max_peserta ?? '-';

                            // status dari DB bisa "Menunggu" / "Berlangsung" / "Selesai"
                            const rawStatus = (t.status || 'Menunggu').toString().trim();
                            const statusLower = rawStatus.toLowerCase();

                            let statusClass = 'text-blue-400';
                            if (statusLower === 'berlangsung') statusClass = 'text-green-400';
                            if (statusLower === 'selesai') statusClass = 'text-yellow-400';

                            // Teks aksi sesuai status
                            let aksiText = 'Detail';
                            if (statusLower === 'menunggu') aksiText = 'Buka Lobi';
                            else if (statusLower === 'berlangsung') aksiText = 'Monitor';
                            else if (statusLower === 'selesai') aksiText = 'Lihat Hasil';

                            const detailHref = `${baseShowUrl}/${encodeURIComponent(id)}`;
                            
                            return `
                                <tr>
                                    <td>${escapeHtml(nama)}</td>
                                    <td>${escapeHtml(pesertaCount + ' / ' + maxPeserta)}</td>
                                    <td><span class="${statusClass}">${escapeHtml(rawStatus)}</span></td>
                                    <td>
                                        <a href="${detailHref}" class="text-cyan-400 hover:underline">
                                            ${aksiText}
                                        </a>
                                    </td>
                                </tr>
                            `;
                        }).join('');

                        tbody.innerHTML = rows;
                    })
                    .catch(err => console.error('Polling tournaments failed:', err))
                    .finally(() => setTimeout(pollTournaments, 10000));

                /** Escape HTML */
                function escapeHtml(str) {
                    return String(str)
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#39;');
                }
            })();
        </script>
</body>
</html>