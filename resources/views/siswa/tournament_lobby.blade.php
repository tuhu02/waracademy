<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lobi Turnamen | WarAcademy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('/images/tournament.png');
            /* Pastikan path ini benar */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .font-blackops {
            font-family: '"Black Ops One"', sans-serif;
        }

        /* [STYLE BARU UNTUK TIM] */
        .team-box {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(106, 168, 250, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .team-slot {
            width: 80px;
            /* Lebar slot */
            height: 100px;
            /* Tinggi slot + nama */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .slot-box {
            width: 80px;
            height: 80px;
            background: rgba(0, 0, 0, 0.3);
            border: 2px dashed rgba(106, 168, 250, 0.4);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            overflow: hidden;
            /* Untuk avatar */
        }

        .slot-box:hover {
            background: rgba(106, 168, 250, 0.2);
            border-color: rgba(106, 168, 250, 0.8);
        }

        .slot-box.occupied {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(106, 168, 250, 0.8);
            cursor: not-allowed;
        }

        .slot-box.is-me {
            border: 3px solid #38bdf8;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.7);
        }

        .slot-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .slot-name {
            width: 80px;
            text-align: center;
            font-size: 0.75rem;
            /* 12px */
            color: #e2e8f0;
            margin-top: 0.5rem;
            /* 8px */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .slot-empty-icon {
            font-size: 2.5rem;
            /* 40px */
            color: rgba(106, 168, 250, 0.5);
            line-height: 1;
        }
    </style>
</head>

<body class="relative font-poppins min-h-screen flex flex-col p-4 md:p-6 text-white overflow-y-auto select-none">

    <div class="absolute inset-0 bg-gradient-to-b from-[#0f1b2e]/80 via-[#304863]/80 to-[#3b5875]/80 z-0"></div>

    {{-- ====================================================== --}}
    {{-- PENGECEKAN MODE DIMULAI DI SINI --}}
    {{-- ====================================================== --}}
    @if($turnamen->mode === 'tim')

        {{-- =================================== --}}
        {{-- TAMPILAN LOBI MODE TIM --}}
        {{-- =================================== --}}
        <div x-data="teamLobbyController(
                            '{{ $turnamen->kode_room }}',
                            {{ $user->id_pengguna }},
                            '{{ $user->username }}',
                            '{{ $user->avatar_url ?? '' }}',
                            {{ json_encode($teams) }}
                        )">
            <header class="relative w-full text-center z-10 mb-6">
                <h1
                    class="font-blackops text-2xl md:text-4xl font-extrabold bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(70,150,255,0.6)] mb-2">
                    {{ $turnamen->nama_turnamen }}
                </h1>
                <p class="text-lg text-cyan-300">Kode Room:
                    <strong class="font-bold text-2xl tracking-widest text-white">{{ $turnamen->kode_room }}</strong>
                </p>
                <div
                    class="mt-2 text-sm text-gray-200 bg-black/20 backdrop-blur-sm inline-block px-3 py-1 rounded-full border border-cyan-400/50">
                    Mode: <strong class="font-semibold text-white">Tim</strong>
                    <span class="mx-2">|</span>
                    Maks. Anggota per Tim: <strong class="font-semibold text-white">{{ $turnamen->max_team_members }}
                        orang</strong>
                    <span class="mx-2">|</span>
                    Total Tim: <strong
                        class="font-semibold text-white">{{ (int) ($turnamen->max_peserta / $turnamen->max_team_members) }}
                        tim</strong>
                </div>
            </header>

            <main class="flex-1 relative flex flex-col justify-start items-center z-10 w-full pb-6">
                <div class="w-full max-w-md text-center mb-8">
                    <div class="bg-white/10 border border-[#6aa8fa]/50 rounded-xl p-6 shadow-xl backdrop-blur-md">
                        <h2 class="text-2xl font-bold text-white mb-3">Menunggu Guru Memulai...</h2>
                        <p class="text-gray-300">Pilih slot tim Anda. Permainan akan dimulai otomatis.</p>
                        <svg class="animate-spin h-8 w-8 text-cyan-400 mx-auto mt-4" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(team, teamIndex) in teams" :key="'team-' + team.id + '-' + teamIndex">
                        <div class="team-box">
                            <h3 class="text-xl font-bold text-cyan-300 mb-4" x-text="team.name"></h3>
                            <div class="flex flex-wrap gap-3 justify-center">
                                <template x-for="(member, index) in team.members"
                                    :key="'slot-' + team.id + '-' + index + '-' + (member ? member.id : 'empty')">
                                    <div class="team-slot">
                                        <div @click="clickSlot(team.id, index)" :class="{
                                                                'slot-box': true,
                                                                'occupied': member !== null,
                                                                'is-me': member !== null && member.id === myId
                                                             }">

                                            <template x-if="member">
                                                <img :src="member.avatar_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(member.username) + '&background=0b2239&color=38bdf8'"
                                                    :alt="member.username" class="slot-avatar">
                                            </template>

                                            <template x-if="!member">
                                                <span class="slot-empty-icon">+</span>
                                            </template>
                                        </div>
                                        <p class="slot-name" x-text="member ? member.username : 'Kosong'"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </main>
        </div>

    @else

        {{-- =================================== --}}
        {{-- TAMPILAN LOBI MODE SOLO --}}
        {{-- =================================== --}}
        <div x-data="soloLobbyController(
                            '{{ $turnamen->kode_room }}',
                            {{ json_encode($initialParticipants) }}
                        )">
            <header class="relative w-full text-center z-10 mb-6">
                <h1 class="font-blackops text-2xl md:text-4xl font-extrabold bg-gradient-to-b 
                                           from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent 
                                           drop-shadow-[0_0_15px_rgba(70,150,255,0.6)] mb-2">
                    {{ $turnamen->nama_turnamen }}
                </h1>
                <p class="text-lg text-cyan-300">Kode Room:
                    <strong class="font-bold text-2xl tracking-widest text-white">{{ $turnamen->kode_room }}</strong>
                </p>
                <div
                    class="mt-2 text-sm text-gray-200 bg-black/20 backdrop-blur-sm inline-block px-3 py-1 rounded-full border border-cyan-400/50">
                    Mode: <strong class="font-semibold text-white">Solo (Individu)</strong>
                </div>
            </header>

            <main class="flex-1 relative flex flex-col justify-start items-center z-10 w-full pb-6">
                <div class="w-full max-w-md text-center mb-8">
                    <div class="bg-white/10 border border-[#6aa8fa]/50 rounded-xl p-6 shadow-xl backdrop-blur-md">
                        <h2 class="text-2xl font-bold text-white mb-3">Menunggu Guru Memulai...</h2>
                        <p class="text-gray-300">Tetap di halaman ini. Permainan akan dimulai secara otomatis.</p>
                        <svg class="animate-spin h-8 w-8 text-cyan-400 mx-auto mt-4" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <p class="text-gray-300 mb-4" id="participantCount"
                        x-text="`${participants.length} / {{ $turnamen->max_peserta }} Peserta Telah Bergabung`"></p>

                    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-4 justify-center max-w-2xl mx-auto"
                        id="participantsContainer">
                        <template x-if="participants.length === 0">
                            <p class="col-span-4 text-gray-400">Belum ada peserta yang bergabung.</p>
                        </template>
                        <template x-for="p in participants" :key="p.username">
                            <div class="flex flex-col items-center w-20">
                                <div
                                    class="w-20 h-20 rounded-full border-2 border-cyan-400 flex items-center justify-center overflow-hidden bg-gray-800">
                                    <img :src="p.avatar_url || 'https://ui-avatars.com/api/?name=' + p.username + '&background=0b2239&color=38bdf8'"
                                        :alt="p.username" class="w-full h-full object-cover">
                                </div>
                                <p class="text-sm text-gray-300 mt-2 truncate w-full text-center" x-text="p.username"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </main>
        </div>

    @endif

    <footer class="relative z-10 text-center text-gray-400 text-sm mt-6">
        © {{ date('Y') }} WarAcademy.
    </footer>

    <script>
        // Controller untuk Lobi SOLO
        function soloLobbyController(roomCode, initialParticipants) {
            return {
                participants: initialParticipants,
                pollInterval: null,
                init() {
                    // Gunakan route() helper dari Laravel Blade untuk mendapatkan URL yang benar
                    this.pollUrl = '{{ route("tournament.lobby.status", ["kode" => $turnamen->kode_room]) }}';
                    this.pollInterval = setInterval(() => this.pollStatus(), 3000); // Poll setiap 3 detik
                },
                destroy() {
                    clearInterval(this.pollInterval);
                },
                async pollStatus() {
                    try {
                        const res = await fetch(this.pollUrl);
                        const data = await res.json();


                        if (data.status === 'Berlangsung') {
                            const server = new Date(data.server_time).getTime();
                            const start  = new Date(data.start_time).getTime();

                            if (server < start) {
                                // Belum mulai → lakukan countdown
                                const diff = Math.floor((start - server) / 1000);
                                console.log("Countdown:", diff);

                                setTimeout(() => {
                                    window.location.href = data.redirect_url;
                                }, diff * 1000);

                                clearInterval(this.pollInterval);
                                return;
                            }

                            // Sudah lewat start time → masuk langsung
                            window.location.href = data.redirect_url;
                            return;
                        }


                        if (data.participants) {
                            this.participants = data.participants;
                        }
                    } catch (e) { console.error('Polling error:', e); }
                }
            };
        }

        // Controller untuk Lobi TIM
        function teamLobbyController(roomCode, userId, userName, userAvatar, initialTeams) {
            return {
                teams: initialTeams,
                myId: userId,
                myName: userName,
                myAvatar: userAvatar || 'https://ui-avatars.com/api/?name=' + userName + '&background=0b2239&color=38bdf8',
                pollInterval: null,
                isMoving: false, // Untuk mencegah klik ganda

                // URLs
                statusUrl: '{{ route("tournament.lobby.status", ["kode" => $turnamen->kode_room]) }}',
                moveUrl: '{{ route("tournament.move", ["kode" => $turnamen->kode_room]) }}',
                csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                init() {
                    this.pollInterval = setInterval(() => this.pollStatus(), 3000);
                },
                destroy() {
                    clearInterval(this.pollInterval);
                },
                async pollStatus() {
                    if (this.isMoving) return; // Jangan polling saat sedang pindah
                    try {
                        const res = await fetch(this.statusUrl);
                        const data = await res.json();

                        if (data.status === 'Berlangsung') {
                            const server = new Date(data.server_time).getTime();
                            const start  = new Date(data.start_time).getTime();

                            if (server < start) {
                                // Belum mulai → lakukan countdown
                                const diff = Math.floor((start - server) / 1000);
                                console.log("Countdown:", diff);

                                setTimeout(() => {
                                    window.location.href = data.redirect_url;
                                }, diff * 1000);

                                clearInterval(this.pollInterval);
                                return;
                            }

                            // Sudah lewat start time → masuk langsung
                            window.location.href = data.redirect_url;
                            return;
                        }

                        if (data.teams) {
                            // Force Alpine.js reactivity dengan membuat array baru
                            this.teams = JSON.parse(JSON.stringify(data.teams));
                        }
                    } catch (e) { console.error('Polling error:', e); }
                },
                async clickSlot(teamId, slotIndex) {
                    if (this.isMoving) return;

                    const targetTeam = this.teams.find(t => t.id === teamId);
                    if (!targetTeam) return;

                    const targetSlot = targetTeam.members[slotIndex];

                    // Jika mengklik slot yang sudah terisi (DAN BUKAN DIRI SENDIRI)
                    if (targetSlot && targetSlot.id !== this.myId) {
                        alert('Slot ini sudah terisi oleh pemain lain.');
                        return; // Jangan lakukan apa-apa
                    }

                    // Jika mengklik diri sendiri (artinya mau keluar tim)
                    if (targetSlot && targetSlot.id === this.myId) {
                        if (!confirm('Apakah Anda yakin ingin keluar dari tim?')) return;
                        this.isMoving = true;
                        this.leaveCurrentSlot(); // Hapus dari UI
                        await this.sendMoveRequest(null, null); // Kirim 'null' ke server
                        this.isMoving = false;
                        // Refresh data setelah keluar
                        await this.pollStatus();
                        return;
                    }

                    // Jika mengklik slot kosong
                    this.isMoving = true;

                    // Kirim ke server dulu (tidak optimistic update untuk menghindari race condition)
                    const success = await this.sendMoveRequest(teamId, slotIndex);
                    if (success) {
                        // Jika berhasil, tunggu sebentar lalu refresh data dari server
                        await new Promise(resolve => setTimeout(resolve, 300)); // Tunggu 300ms untuk memastikan DB sudah update
                        this.isMoving = false; // Set false sebelum polling
                        await this.pollStatus();
                    } else {
                        this.isMoving = false;
                    }
                },
                async sendMoveRequest(teamId, slotIndex) {
                    try {
                        const res = await fetch(this.moveUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken
                            },
                            body: JSON.stringify({ team_id: teamId, slot_index: slotIndex })
                        });

                        if (!res.ok) {
                            const errData = await res.json();
                            alert(`Gagal pindah tim: ${errData.message}`);
                            return false;
                        }
                        return true;
                    } catch (e) {
                        alert('Error: Tidak dapat terhubung ke server.');
                        console.error('Error pindah tim:', e);
                        return false;
                    }
                },
                leaveCurrentSlot() {
                    // Fungsi helper untuk menghapus user dari slot lama di UI
                    for (const team of this.teams) {
                        for (let i = 0; i < team.members.length; i++) {
                            if (team.members[i] && team.members[i].id === this.myId) {
                                team.members[i] = null;
                                return; // Keluar setelah ditemukan
                            }
                        }
                    }
                }
            };
        }
    </script>
</body>

</html>