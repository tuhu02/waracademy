<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
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

        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h2 {
            font-size: 36px;
            color: #38bdf8;
            margin-bottom: 10px;
        }

        .card p {
            color: #cbd5e1;
            font-weight: 500;
        }

        .table-section {
            margin-top: 50px;
            background: #0f172a;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .table-section h3 {
            font-size: 20px;
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
            <a href="{{ route('guru.dashboard') }}" class="active">🏠 Dashboard</a>
            <a href="#">📘 Bank Soal</a>
            <a href="{{ route('guru.tournament.index') }}">🏆 Turnamen</a>
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
        <h1 class="text-3xl font-bold mb-6">Selamat Datang, {{ session('pengguna_username') }}!</h1>

        <!-- Statistik -->
        <div class="grid-stats">
            <div class="card">
                <h2>1250</h2>
                <p>Total Soal</p>
            </div>
            <div class="card">
                <h2>87</h2>
                <p>Siswa Terdaftar</p>
            </div>
            <div class="card">
                <h2>3</h2>
                <p>Turnamen Aktif</p>
            </div>
        </div>

        <!-- Daftar Turnamen -->
        <div class="table-section">
            <h3>Turnamen Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Turnamen</th>
                        <th>Tanggal</th>
                        <th>Jumlah Peserta</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Turnamen Sains Nasional</td>
                        <td>15 November 2025</td>
                        <td>42</td>
                        <td><span class="text-green-400">Sedang Berlangsung</span></td>
                    </tr>
                    <tr>
                        <td>Kompetisi Matematika</td>
                        <td>10 Oktober 2025</td>
                        <td>35</td>
                        <td><span class="text-yellow-400">Selesai</span></td>
                    </tr>
                    <tr>
                        <td>English Debate Challenge</td>
                        <td>2 Desember 2025</td>
                        <td>58</td>
                        <td><span class="text-blue-400">Akan Datang</span></td>
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
