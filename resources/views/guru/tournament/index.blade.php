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
        }

        .btn-primary:hover {
            background: #0ea5e9;
        }

        .table-section {
            background: #0f172a;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .table-section h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #38bdf8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            text-align: left;
            padding: 10px;
            background: #1e293b;
            color: #cbd5e1;
        }

        table td {
            padding: 10px;
            border-top: 1px solid #1e293b;
            color: #e2e8f0;
        }

        table tr:hover td {
            background: rgba(56, 189, 248, 0.1);
        }

        #tsparticles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <div id="tsparticles"></div>

    <div class="sidebar">
        <div>
            <h1>Guru Panel</h1>
            <a href="{{ route('guru.dashboard') }}">🏠 Dashboard</a>
            <a href="#">📘 Bank Soal</a>
            <a href="{{ route('guru.tournament.index') }}" class="active">🏆 Turnamen</a>
            <a href="#">📊 Statistik Siswa</a>
        </div>
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
                        <th>Tanggal</th>
                        <th>Peserta</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tournament-tbody">
                    <tr>
                        <td colspan="5" class="text-center text-gray-400">Memuat daftar turnamen…</td>
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
        <script>
            // Poll the server every 10 seconds for updated tournaments
            (function pollTournaments(){
                const url = '{{ route("guru.tournament.data") }}';

            const baseShowUrl = '{{ url('/guru/tournament') }}';

            fetch(url, { headers: { 'Accept': 'application/json' } })
                    .then(res => res.json())
                    .then(data => {
                        const tbody = document.querySelector('table tbody');
                        if (!tbody) return;

                        if (!Array.isArray(data) || data.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-400">Belum ada turnamen.</td></tr>';
                            return;
                        }

                        const rows = data.map(t => {
                            // parse tanggal_pelaksanaan into local Date
                            let start = null;
                            if (t.tanggal_pelaksanaan) {
                                // MySQL DATETIME like '2025-11-09 12:50:00' — convert to ISO-like for reliable parsing
                                const s = String(t.tanggal_pelaksanaan).trim().replace(' ', 'T');
                                start = new Date(s);
                                if (isNaN(start.getTime())) start = null;
                            }

                            const durationMin = parseInt(t.durasi_pengerjaan || t.duration || 0, 10) || 0;
                            const end = start ? new Date(start.getTime() + durationMin * 60000) : null;

                            // compute status on client
                            let statusText = 'Menunggu';
                            if (!start) {
                                // no scheduled time
                                statusText = 'Menunggu';
                            } else {
                                const now = new Date();
                                if (now < start) statusText = 'Akan Datang';
                                else if (end && now >= end) statusText = 'Selesai';
                                else statusText = 'Berlangsung';
                            }

                            const tanggal = start ? start.toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';
                            const peserta = (t.peserta_count || 0) + ' / ' + (t.max_peserta || '-');

                            let statusClass = 'text-blue-400';
                            if (statusText.toLowerCase() === 'berlangsung') statusClass = 'text-green-400';
                            if (statusText.toLowerCase() === 'selesai') statusClass = 'text-yellow-400';
                            if (statusText.toLowerCase() === 'akan datang' || statusText.toLowerCase() === 'menunggu') statusClass = 'text-blue-400';

                            const detailHref = baseShowUrl + '/' + encodeURIComponent(t.id_turnamen || t.id);
                            return `
                                <tr>
                                    <td>${escapeHtml(t.nama_turnamen || '-')}</td>
                                    <td>${escapeHtml(tanggal)}</td>
                                    <td>${escapeHtml(peserta)}</td>
                                    <td><span class="${statusClass}">${escapeHtml(statusText)}</span></td>
                                    <td><a href="${detailHref}" class="text-cyan-400 hover:underline">Detail</a></td>
                                </tr>
                            `;
                        }).join('');

                        tbody.innerHTML = rows;
                    })
                    .catch(err => console.error('Polling tournaments failed', err))
                    .finally(() => setTimeout(pollTournaments, 10000));

                // basic HTML escape
                function escapeHtml(str){
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