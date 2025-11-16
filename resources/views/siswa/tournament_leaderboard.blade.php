<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard Turnamen</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0e0e0e;
            color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #1b1b1b;
            border-radius: 15px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
            margin-top: 20px;
        }

        table th {
            background: #2d2d2d;
            padding: 12px;
            font-weight: 600;
        }

        table td {
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #262626;
        }

        tr:nth-child(odd) {
            background: #1f1f1f;
        }

        .highlight {
            background: #3b82f6 !important;
        }

        .refresh-info {
            margin-top: 10px;
            font-size: 14px;
            opacity: 0.7;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Leaderboard Turnamen</h2>

        <table>
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama</th>
                    <th>Nilai</th>
                </tr>
            </thead>

            {{-- ============================= --}}
            {{-- MODE AUTO REFRESH BERLANGSUNG --}}
            {{-- ============================= --}}

            @if($turnamen->status === 'Berlangsung')
                <tbody x-data="leaderboardController" x-init="startAutoRefresh()">
                    <template x-for="(entry, index) in leaderboard" :key="entry.id || index">
                        <tr :class="entry.is_me ? 'highlight' : ''">
                            <td x-text="entry.rank || (index + 1)"></td>
                            <td x-text="entry.nama || 'Siswa'"></td>
                            <td x-text="entry.skor || 0"></td>
                        </tr>
                    </template>
                    <template x-if="leaderboard.length === 0">
                        <tr>
                            <td colspan="3" style="padding:20px; text-align:center; opacity:0.6;">
                                Belum ada peserta yang menyelesaikan turnamen.
                            </td>
                        </tr>
                    </template>
                </tbody>

            @else
                {{-- ============================= --}}
                {{-- MODE NORMAL (TIDAK BERLANGSUNG) --}}
                {{-- ============================= --}}

                <tbody>
                    @forelse($leaderboard as $entry)
                        <tr class="{{ ($entry['is_me'] ?? false) ? 'highlight' : '' }}">
                            <td>{{ $entry['rank'] ?? $loop->iteration }}</td>
                            <td>{{ $entry['nama'] ?? 'Siswa' }}</td>
                            <td>{{ $entry['skor'] ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding:20px; text-align:center; opacity:0.6;">
                                Belum ada peserta yang menyelesaikan turnamen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            @endif

        </table>

        @if($turnamen->status === 'Berlangsung')
            <div class="refresh-info">
                ⟳ Leaderboard diperbarui otomatis setiap 5 detik...
            </div>
        @endif

    </div>

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
                                this.leaderboard = data.leaderboard;
                            }
                        } catch (error) {
                            console.error("Gagal memuat leaderboard:", error);
                        }
                    }
                }
            }
        </script>

    @endif

</body>

</html>