<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Turnamen - War Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap"
        rel="stylesheet">
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

        .content {
            margin-left: 270px;
            padding: 40px;
        }

        .form-section {
            background: #0f172a;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        .form-section h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #38bdf8;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #cbd5e1;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #1e3a8a;
            background: #1e293b;
            color: #fff;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-group input[type="radio"] {
            width: auto;
            /* Agar radio button tidak 100% */
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        }

        .question-item {
            background: #1e293b;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 1px solid #334155;
        }

        .question-item h4 {
            color: #38bdf8;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .option-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .option-group input[type="radio"] {
            width: auto;
        }

        .option-group input[type="text"] {
            flex: 1;
        }

        .btn-primary {
            background: #38bdf8;
            color: #0f172a;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #0ea5e9;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #475569;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #64748b;
        }

        .btn-danger {
            background: #ef4444;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .code-display {
            background: #1e3a8a;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 4px;
            color: #38bdf8;
            font-family: 'Courier New', monospace;
            margin: 20px 0;
        }

        #tsparticles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            top: 0;
            left: 0;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid #22c55e;
            color: #86efac;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
    </style>
</head>

<body x-data="tournamentApp()">
    <div id="tsparticles"></div>

    @include('guru.components.sidebar-guru')

    <div class="content">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Buat Turnamen Baru</h1>
            <a href="{{ route('guru.tournament.index') }}" class="btn-secondary">← Kembali</a>
        </div>

        <div x-show="showSuccess" class="alert alert-success">
            <strong>Turnamen Berhasil Dibuat!</strong><br>
            Kode Room: <span x-text="roomCode"></span><br>
            Bagikan kode ini kepada siswa untuk bergabung.
        </div>

        <form @submit.prevent="createTournament">
            @csrf
            <div class="form-section">
                <h3>📋 Informasi Dasar</h3>

                <div class="form-group">
                    <label for="name">Nama Turnamen *</label>
                    <input type="text" id="name" x-model="tournament.name" required
                        placeholder="Contoh: Ujian Matematika Semester 1">
                </div>

                <div class="form-group">
                    <label>Mode Turnamen *</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="solo" x-model="tournament.mode" class="w-auto">
                            <span>Solo (Individu)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="tim" x-model="tournament.mode" class="w-auto">
                            <span>Tim</span>
                        </label>
                    </div>
                </div>

                <div class="form-group" x-show="tournament.mode === 'tim'" x-transition>
                    <label for="maxTeamMembers">Maksimal Anggota per Tim *</label>
                    <input type="number" id="maxTeamMembers" x-model="tournament.maxTeamMembers"
                        @input="updateMaxTeams()" placeholder="Contoh: 3" min="2" class="w-full md:w-1/2">
                    <p class="text-xs text-gray-400 mt-1">Hanya diisi jika mode tim (minimal 2).</p>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="duration">Durasi Pengerjaan (menit) *</label>
                        <input type="number" id="duration" x-model="tournament.duration" required
                            placeholder="Contoh: 45" min="1">
                    </div>
                    <div class="form-group" x-show="tournament.mode === 'solo'">
                        <label for="maxParticipants">Batas Maksimal Peserta *</label>
                        <input type="number" id="maxParticipants" x-model="tournament.maxParticipants"
                            :required="tournament.mode === 'solo'" placeholder="Contoh: 30" min="1">
                    </div>
                    <div class="form-group" x-show="tournament.mode === 'tim'" x-transition>
                        <label for="maxTeams">Batas Maksimal Tim *</label>
                        <input type="number" id="maxTeams" x-model="tournament.maxTeams" @input="validateMaxTeams()"
                            :required="tournament.mode === 'tim'" :step="tournament.maxTeamMembers || 1"
                            :min="tournament.maxTeamMembers || 1" placeholder="Contoh: 10">
                        <p class="text-xs text-gray-400 mt-1" x-show="tournament.maxTeamMembers">
                            Total maksimal peserta = <span class="text-cyan-400 font-bold"
                                x-text="(tournament.maxTeams || 0) * (tournament.maxTeamMembers || 1)"></span>
                            (<span x-text="tournament.maxTeams || 0"></span> tim × <span
                                x-text="tournament.maxTeamMembers || 0"></span> anggota)
                        </p>
                        <p class="text-xs text-yellow-400 mt-1"
                            x-show="tournament.mode === 'tim' && tournament.maxTeamMembers && tournament.maxTeams && (tournament.maxTeams % tournament.maxTeamMembers !== 0)">
                            ⚠️ Jumlah tim harus kelipatan dari maksimal anggota per tim (<span
                                x-text="tournament.maxTeamMembers"></span>)
                        </p>
                        <p class="text-xs text-gray-400 mt-1" x-show="tournament.maxTeamMembers">
                            Contoh kelipatan: <span class="text-cyan-400" x-text="getMultiplesExample()"></span>
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" x-model="tournament.description" rows="3"
                        placeholder="Jelaskan tujuan dan aturan turnamen..."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>⚙️ Pengaturan Penilaian</h3>
                <div class="grid-2">
                    <div class="form-group">
                        <label for="pointPerQuestion">Poin per Soal Benar *</label>
                        <input type="number" id="pointPerQuestion" x-model="tournament.pointPerQuestion" required
                            placeholder="Contoh: 10" min="1">
                    </div>
                    <div class="form-group">
                        <label for="bonusExp">Bonus EXP untuk Pemenang *</label>
                        <input type="number" id="bonusExp" x-model="tournament.bonusExp" required
                            placeholder="Contoh: 500" min="0">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>❓ Bank Soal Turnamen</h3>
                <p class="text-gray-400 mb-4">Masukkan soal-soal yang akan digunakan dalam turnamen ini</p>

                <template x-for="(question, index) in tournament.questions" :key="index">
                    <div class="question-item">
                        <div class="flex justify-between items-center mb-3">
                            <h4>Soal <span x-text="index + 1"></span></h4>
                            <button type="button" @click="removeQuestion(index)" class="btn-danger"
                                x-show="tournament.questions.length > 1">
                                🗑️ Hapus
                            </button>
                        </div>

                        <div class="form-group">
                            <label>Pertanyaan *</label>
                            <textarea x-model="question.text" rows="3" required
                                placeholder="Tulis pertanyaan di sini..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Pilihan Jawaban *</label>
                            <template x-for="(option, optIndex) in question.options" :key="optIndex">
                                <div class="option-group">
                                    <input type="radio" :name="'correct_' + index"
                                        :checked="question.correctAnswer === optIndex"
                                        @change="question.correctAnswer = optIndex">
                                    <input type="text" x-model="question.options[optIndex]" required
                                        :placeholder="'Pilihan ' + (optIndex + 1)">
                                </div>
                            </template>
                            <p class="text-xs text-gray-400 mt-2">* Pilih radio button untuk menandai jawaban yang benar
                            </p>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Tingkat Kesulitan</label>
                                <select x-model="question.difficulty">
                                    <option value="mudah">Mudah</option>
                                    <option value="sedang">Sedang</option>
                                    <option value="sulit">Sulit</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select x-model="question.subject">
                                    <option value="matematika">Matematika</option>
                                    <option value="ipa">IPA</option>
                                    <option value="ips">IPS</option>
                                    <option value="bahasa_indonesia">Bahasa Indonesia</option>
                                    <option value="bahasa_inggris">Bahasa Inggris</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </template>

                <button type="button" @click="addQuestion" class="btn-secondary mt-4">
                    ➕ Tambah Soal
                </button>
                <button type="button" @click="openBankSoalModal" class="btn-primary mt-4">
                    📚 Ambil dari Bank Soal
                </button>
            </div>

            <div class="form-section">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400">Total Soal: <span class="text-cyan-400 font-bold"
                                x-text="tournament.questions.length"></span></p>
                        <p class="text-gray-400">Estimasi Durasi: <span class="text-cyan-400 font-bold"
                                x-text="tournament.duration"></span> menit</p>
                    </div>
                    <button type="submit" class="btn-primary">
                        🚀 Buat Turnamen & Generate Kode Room
                    </button>
                </div>
            </div>
        </form>

        <div x-show="showSuccess" class="form-section">
            <h3>🎉 Turnamen Berhasil Dibuat!</h3>
            <p class="text-gray-400 mb-4">Bagikan kode room ini kepada siswa untuk bergabung:</p>
            <div class="code-display" x-text="roomCode"></div>
            <div class="flex gap-3 justify-center">
                <button type="button" @click="copyRoomCode" class="btn-primary">
                    📋 Salin Kode
                </button>
                <a href="#" class="btn-secondary">
                    📊 Lihat Dashboard Turnamen
                </a>
            </div>
        </div>

        <div x-show="showBankSoal"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
            x-transition.opacity>
            
            <div class="bg-[#0f172a] w-full max-w-3xl rounded-xl p-6 shadow-xl border border-slate-700"
                x-transition.scale.origin.top>
                
                <h2 class="text-xl font-bold mb-5 text-cyan-400 text-center">
                    Pilih Soal dari Bank Soal
                </h2>

                <div class="max-h-[65vh] overflow-y-auto pr-2 space-y-4">

                    <template x-for="(soal, sIndex) in bankSoal" :key="sIndex">
                        <div class="border border-slate-700 bg-[#111c2f] p-5 rounded-lg shadow-sm hover:border-cyan-400/40 transition">

                            <p class="font-semibold text-gray-200 leading-relaxed"
                            x-text="soal.text"></p>

                            <ul class="ml-4 mt-3 text-gray-400 text-sm space-y-1">
                                <template x-for="(op, oi) in soal.options" :key="oi">
                                    <li class="flex items-start gap-1">

                                        <span class="mt-[2px]">•</span>

                                        <span x-text="op"></span>

                                        <span class="text-green-400 font-medium ml-1"
                                            x-show="soal.correctAnswer === oi">
                                            (benar)
                                        </span>
                                    </li>
                                </template>
                            </ul>

                            <div class="flex justify-end mt-4">
                                <button type="button"
                                    @click="addFromBank(soal)"
                                    class="bg-cyan-500 hover:bg-cyan-400 text-black px-4 py-2 rounded-lg font-semibold shadow transition">
                                    ➕ Gunakan Soal Ini
                                </button>
                            </div>

                        </div>
                    </template>

                </div>

                <div class="flex justify-end mt-6">
                    <button class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg font-semibold shadow transition"
                            @click="closeBankSoalModal">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function tournamentApp() {
            return {
                tournament: {
                    name: '',
                    // date: '', // <-- DIHAPUS
                    mode: 'solo', // <-- BARU: 'solo' atau 'tim'
                    maxTeamMembers: null, // <-- BARU: untuk menyimpan maks anggota tim
                    duration: 45,
                    maxParticipants: 30, // Untuk mode solo
                    maxTeams: 10, // Untuk mode tim
                    description: '',
                    pointPerQuestion: 10,
                    bonusExp: 500,
                    minLevel: 1, // Level minimal yang diperlukan
                    questions: [
                        {
                            text: '',
                            options: ['', '', '', ''],
                            correctAnswer: 0,
                            difficulty: 'sedang',
                            subject: 'matematika'
                        }
                    ]
                },
                roomCode: '',
                showSuccess: false,
                bankSoal: [],       // ← daftar soal dari database Laravel
                showBankSoal: false,

                addQuestion() {
                    this.tournament.questions.push({
                        text: '',
                        options: ['', '', '', ''],
                        correctAnswer: 0,
                        difficulty: 'sedang',
                        subject: 'matematika'
                    });
                },

                removeQuestion(index) {
                    if (this.tournament.questions.length > 1) {
                        this.tournament.questions.splice(index, 1);
                    }
                },

                openBankSoalModal() {
                    this.showBankSoal = true;

                    // Ambil bank soal dari Laravel via API
                    fetch("{{ route('guru.soal.json') }}")
                        .then(r => r.json())
                        .then(data => {
                            this.bankSoal = data;
                        });
                },

                closeBankSoalModal() {
                    this.showBankSoal = false;
                },

                addFromBank(soal) {
                    let emptyIndex = this.tournament.questions.findIndex(q =>
                        (!q.text || q.text.trim() === '') &&
                        (!q.options || q.options.every(op => !op || op.trim() === ''))
                    );

                    if (emptyIndex !== -1) {
                        this.tournament.questions[emptyIndex] = {
                            text: soal.text,
                            options: [...soal.options],
                            correctAnswer: soal.correctAnswer,
                            difficulty: soal.difficulty,
                            subject: soal.subject,
                        };
                        this.showBankSoal = false;
                        return;
                    }

                    this.tournament.questions.push({
                        text: soal.text,
                        options: soal.options,
                        correctAnswer: soal.correctAnswer,
                        difficulty: soal.difficulty,
                        subject: soal.subject,
                    });

                    this.showBankSoal = false;
                },

                updateMaxTeams() {
                    // Saat maxTeamMembers berubah, sesuaikan maxTeams agar tetap kelipatan
                    if (this.tournament.mode === 'tim' && this.tournament.maxTeamMembers && this.tournament.maxTeams) {
                        // Bulatkan ke kelipatan terdekat
                        const currentMaxTeams = this.tournament.maxTeams;
                        const rounded = Math.round(currentMaxTeams / this.tournament.maxTeamMembers) * this.tournament.maxTeamMembers;
                        if (rounded > 0 && rounded !== currentMaxTeams) {
                            this.tournament.maxTeams = rounded;
                        }
                    }
                },

                validateMaxTeams() {
                    // Validasi bahwa maxTeams adalah kelipatan dari maxTeamMembers
                    if (this.tournament.mode === 'tim' && this.tournament.maxTeamMembers && this.tournament.maxTeams) {
                        if (this.tournament.maxTeams % this.tournament.maxTeamMembers !== 0) {
                            // Bulatkan ke kelipatan terdekat
                            const rounded = Math.round(this.tournament.maxTeams / this.tournament.maxTeamMembers) * this.tournament.maxTeamMembers;
                            if (rounded > 0) {
                                this.tournament.maxTeams = rounded;
                            }
                        }
                    }
                },

                getMultiplesExample() {
                    if (!this.tournament.maxTeamMembers || this.tournament.maxTeamMembers < 2) {
                        return '';
                    }
                    const multiples = [];
                    for (let i = 1; i <= 5; i++) {
                        multiples.push(this.tournament.maxTeamMembers * i);
                    }
                    return multiples.join(', ') + ', ...';
                },

                generateRoomCode() {
                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    let code = '';
                    for (let i = 0; i < 6; i++) {
                        code += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    return code;
                },

                createTournament() {
                    // Validasi client-side
                    const invalidQuestions = this.tournament.questions.filter(q =>
                        !q.text || q.options.some(opt => !opt)
                    );

                    if (invalidQuestions.length > 0) {
                        alert('Mohon lengkapi semua soal dan pilihan jawaban!');
                        return;
                    }

                    // [BARU] Validasi untuk mode tim
                    if (this.tournament.mode === 'tim') {
                        if (!this.tournament.maxTeamMembers || this.tournament.maxTeamMembers < 2) {
                            alert('Untuk mode tim, mohon isi maksimal anggota tim (minimal 2).');
                            return;
                        }
                        if (!this.tournament.maxTeams || this.tournament.maxTeams < 1) {
                            alert('Untuk mode tim, mohon isi maksimal tim (minimal 1).');
                            return;
                        }
                        // Validasi bahwa maxTeams adalah kelipatan dari maxTeamMembers
                        if (this.tournament.maxTeams % this.tournament.maxTeamMembers !== 0) {
                            alert(`Jumlah tim harus kelipatan dari maksimal anggota per tim (${this.tournament.maxTeamMembers}).\nContoh: ${this.tournament.maxTeamMembers}, ${this.tournament.maxTeamMembers * 2}, ${this.tournament.maxTeamMembers * 3}, dst.`);
                            return;
                        }
                    }

                    // Hitung max_participants berdasarkan mode
                    let maxParticipants;
                    if (this.tournament.mode === 'tim') {
                        // Untuk mode tim: max_participants = maxTeams × maxTeamMembers
                        maxParticipants = this.tournament.maxTeams * this.tournament.maxTeamMembers;
                    } else {
                        // Untuk mode solo: gunakan maxParticipants langsung
                        maxParticipants = this.tournament.maxParticipants;
                    }

                    // Siapkan payload
                    const payload = {
                        name: this.tournament.name,
                        // date: this.tournament.date, // <-- DIHAPUS
                        mode: this.tournament.mode, // <-- BARU
                        maxTeamMembers: this.tournament.mode === 'tim' ? this.tournament.maxTeamMembers : null, // <-- BARU
                        duration: this.tournament.duration,
                        max_participants: maxParticipants, // Dihitung otomatis untuk mode tim
                        description: this.tournament.description,
                        point_per_question: this.tournament.pointPerQuestion,
                        bonus_exp: this.tournament.bonusExp,
                        questions: this.tournament.questions
                    };

                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Kirim ke backend
                    fetch('/guru/tournament', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                        .then(async res => {
                            if (!res.ok) {
                                const json = await res.json().catch(() => ({}));
                                const msg = json.message || 'Gagal membuat turnamen. Periksa input dan coba lagi.';
                                alert(msg);
                                throw new Error(msg);
                            }
                            return res.json();
                        })
                        .then(json => {
                            // Backend menyediakan room_code
                            this.roomCode = json.room_code || this.generateRoomCode();
                            this.showSuccess = true;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        })
                        .catch(err => {
                            console.error('Error creating tournament:', err);
                        });
                },

                copyRoomCode() {
                    navigator.clipboard.writeText(this.roomCode);
                    alert('Kode Room berhasil disalin!');
                }
            }
        }

        // Initialize particles
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