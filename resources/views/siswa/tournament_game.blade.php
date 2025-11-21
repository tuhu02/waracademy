<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Turnamen Dimulai! | {{ $turnamen->nama_turnamen }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        blackops: ['"Black Ops One"', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>

    <style>
        [x-cloak] { display: none !important; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: rgba(106,168,250,0.3); border-radius: 10px; }
        
        /* Utilities */
        .btn-nav {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(106,168,250,0.55);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            backdrop-filter: blur(6px);
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        @media (min-width: 768px) {
            .btn-nav { padding: 10px 20px; font-size: 0.9rem; }
        }
        
        .btn-nav:hover { background: rgba(255,255,255,0.16); transform: translateY(-1px); }
        .btn-nav:active { transform: translateY(0); }
        .btn-nav:disabled { opacity: .5; cursor: not-allowed; transform: none; }

        .option-btn {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(106,168,250,0.4);
            backdrop-filter: blur(5px);
            transition: all .2s;
            text-align: left;
        }
        .option-btn:hover { background: rgba(106,168,250,0.2); border-color: rgba(106,168,250,0.8); }
        .option-btn:active { background: rgba(106,168,250,0.3); }
        .option-btn.selected { 
            background: linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%); 
            border-color: #60a5fa; 
            color: white; 
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }

        /* Modal Styles */
        .modal-backdrop { background: rgba(0,0,0,0.8); backdrop-filter: blur(4px); }
        .question-tile { cursor: pointer; transition: all .12s; }
        .question-tile:hover { transform: scale(1.05); }
        .tile-submitted { background: rgba(56,189,248,0.2); border: 1px solid #38bdf8; color: #bae6fd; }
        .tile-unsubmitted { background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.2); }

        /* Image in Questions Responsive */
        .question-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-[#0f1b2e] min-h-screen text-white font-poppins overflow-x-hidden">
    
    <div class="fixed inset-0 bg-gradient-to-b from-[#0f1b2e] via-[#243b55] to-[#3b5875] -z-20"></div>
    <img src="/images/war.png" alt="Logo" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 scale-[1.2] md:scale-[1.5] h-[300px] opacity-5 pointer-events-none -z-10 mix-blend-lighten" />

    <audio id="bgMusic" loop>
        <source src="/audio/sound.mp3" type="audio/mpeg" />
    </audio>

    <div class="relative z-10 px-4 py-6 md:p-8 max-w-5xl mx-auto flex flex-col min-h-screen">
        
        <div class="text-center mb-6 md:mb-8">
            <h1 class="text-2xl md:text-5xl font-blackops tracking-wide
                       bg-gradient-to-b from-[#e5f2ff] via-[#a3d3fa] to-[#6aa8fa]
                       bg-clip-text text-transparent 
                       drop-shadow-[0_0_15px_rgba(70,150,255,0.6)] leading-tight">
                {{ $turnamen->nama_turnamen }}
            </h1>
        </div>

        @if(empty($questions) || count($questions) === 0)
            <div class="bg-black/30 backdrop-blur-lg border border-red-500/40 rounded-2xl shadow-2xl p-6 md:p-10 text-center flex-1 flex flex-col justify-center items-center">
                <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-red-400"></i>
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-red-100 mb-2">Soal Belum Tersedia</h2>
                <p class="text-gray-400 text-sm md:text-base mb-6 max-w-lg">
                    Turnamen ini belum memiliki soal atau soal belum memiliki pilihan jawaban. Silakan hubungi guru atau admin untuk memeriksa konfigurasi turnamen.
                </p>
                <a href="{{ route('home') }}" class="btn-nav bg-white/10 hover:bg-white/20 border-white/20">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Home
                </a>
            </div>
        @else

            <script>
                window.tournamentData = {
                    tournamentId: {{ $turnamen->id_turnamen }},
                    duration: {{ $turnamen->durasi_pengerjaan }},
                    questions: @json(array_values($questions)),
                    submitQuestionUrl: '{{ route('tournament.submit.question', ['id' => $turnamen->id_turnamen]) }}',
                    submitAllUrl: '{{ route('tournament.submit.all', ['id' => $turnamen->id_turnamen]) }}',
                    mode: '{{ $turnamen->mode }}',
                    endTime: '{{ optional($turnamen->end_time)->toIso8601String() ?? '' }}',
                    serverTime: '{{ now()->toIso8601String() }}'
                };
            </script>

            <div x-data="quizController(window.tournamentData.duration, window.tournamentData.questions, window.tournamentData.submitQuestionUrl, window.tournamentData.submitAllUrl, window.tournamentData.mode)" 
                 x-init="init()" 
                 class="flex flex-col flex-1">

                <div class="flex flex-wrap justify-between items-end mb-4 gap-2">
                    <div class="text-xs md:text-sm text-blue-200 bg-blue-900/30 px-3 py-1.5 rounded-full border border-blue-500/30">
                        Mode: <strong class="text-white uppercase tracking-wider">{{ $turnamen->mode === 'tim' ? 'Tim' : 'Solo' }}</strong>
                    </div>

                    <template x-if="mode === 'tim'">
                        <button @click="showModal = true" class="btn-nav text-xs md:text-sm py-1.5 px-3">
                            <i class="fa-solid fa-list-check mr-2"></i> Daftar Soal
                        </button>
                    </template>
                </div>

                <div x-show="!isFinished" x-cloak class="flex-1 flex flex-col">
                    <div class="bg-[#1e293b]/60 backdrop-blur-xl border border-blue-400/20 rounded-2xl shadow-2xl overflow-hidden flex flex-col flex-1">

                        <div class="flex justify-between items-center px-4 py-3 md:px-6 md:py-4 bg-black/20 border-b border-white/5">
                            <div class="text-sm md:text-base font-medium text-gray-300">
                                Soal <span class="text-blue-400 font-bold text-lg ml-1" x-text="currentQuestionIndex + 1"></span> 
                                <span class="text-gray-500 mx-1">/</span> 
                                <span x-text="questions.length"></span>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <template x-if="mode === 'tim'">
                                    <div class="hidden md:flex items-center gap-1 text-[10px] text-green-400 bg-green-900/20 px-2 py-1 rounded border border-green-500/20">
                                        <i class="fa-solid fa-users"></i> Shared
                                    </div>
                                </template>

                                <div class="flex items-center gap-2 bg-black/40 px-3 py-1 rounded-lg border border-white/10">
                                    <i class="fa-regular fa-clock text-yellow-500 text-sm animate-pulse"></i>
                                    <div class="text-lg md:text-xl font-blackops text-yellow-400 tracking-widest" x-text="timerText">
                                        {{ $turnamen->durasi_pengerjaan }}:00
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 md:p-8 flex-1 overflow-y-auto">
                            <h2 class="text-base md:text-xl font-medium leading-relaxed mb-6 md:mb-8 question-content text-gray-100" x-html="currentQuestion.teks_pertanyaan"></h2>

                            <div class="space-y-3 md:space-y-4">
                                <template x-for="option in currentQuestion.options" :key="option.id_jawaban">
                                    <button
                                        @click="selectAnswer(currentQuestion.id, option.id_jawaban)"
                                        class="w-full p-3 md:p-4 rounded-xl option-btn flex items-start gap-3 group"
                                        :class="{ 'selected': answers[currentQuestion.id] == option.id_jawaban }"
                                    >
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-500 flex-shrink-0 mt-0.5 flex items-center justify-center group-hover:border-blue-400"
                                             :class="answers[currentQuestion.id] == option.id_jawaban ? 'border-white bg-transparent' : ''">
                                            <div class="w-2.5 h-2.5 rounded-full bg-white transform scale-0 transition-transform"
                                                 :class="answers[currentQuestion.id] == option.id_jawaban ? 'scale-100' : ''"></div>
                                        </div>
                                        <span class="text-sm md:text-base leading-snug text-gray-200 group-[.selected]:text-white" x-html="option.teks_jawaban"></span>
                                    </button>
                                </template>
                            </div>

                            <!-- Tombol submit untuk MODE TIM (submit per-soal) -->
                            <div class="mt-6" x-show="mode === 'tim'">
                                <button
                                    class="btn-nav bg-blue-600 hover:bg-blue-500"
                                    :disabled="!answers[currentQuestion.id] || submittingQuestion || submittedStatus[currentQuestion.id]"
                                    @click="submitSingle(currentQuestion.id)"
                                >
                                    <template x-if="!submittingQuestion && !submittedStatus[currentQuestion.id]">
                                        <i class="fa-solid fa-paper-plane mr-2"></i> Submit Jawaban (Tim)
                                    </template>
                                    <template x-if="submittingQuestion">
                                        <i class="fa-solid fa-spinner fa-spin mr-2"></i> Mengirim...
                                    </template>
                                    <template x-if="submittedStatus[currentQuestion.id] && !submittingQuestion">
                                        <i class="fa-solid fa-check mr-2"></i> Sudah Disubmit
                                    </template>
                                </button>
                                <p class="text-sm text-gray-300 mt-2" x-show="submittedStatus[currentQuestion.id]">
                                    Status: <span class="text-green-300">Sudah disubmit oleh tim</span>
                                </p>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between items-center p-4 bg-black/30 border-t border-blue-400/30">
                            <button @click="prevQuestion" :disabled="currentQuestionIndex === 0" class="btn-nav">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Sebelumnya
                            </button>

                            <template x-if="currentQuestionIndex < questions.length - 1">
                                <button @click="nextQuestion" class="btn-nav">
                                    Selanjutnya <i class="fa-solid fa-arrow-right ml-2"></i>
                                </button>
                            </template>

                            <template x-if="currentQuestionIndex === questions.length - 1">
                                <!-- Di mode individu: Submit akhir seperti sebelumnya -->
                                <template x-if="mode !== 'tim'">
                                    <button @click="submitQuiz" class="btn-nav bg-green-600 border-green-400 hover:bg-green-500">
                                        <i class="fa-solid fa-check mr-2"></i> Selesai & Kirim
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 md:p-6 bg-black/20 border-t border-white/5 flex justify-between items-center gap-2">
                            <button @click="prevQuestion" :disabled="currentQuestionIndex === 0" class="btn-nav flex-1 md:flex-none">
                                <i class="fa-solid fa-chevron-left md:mr-2"></i> <span class="hidden md:inline">Sebelumnya</span><span class="md:hidden">Prev</span>
                            </button>

                            <div class="flex-1 md:flex-none text-right">
                                <template x-if="currentQuestionIndex < questions.length - 1">
                                    <button @click="nextQuestion" class="btn-nav w-full md:w-auto">
                                        <span class="hidden md:inline">Selanjutnya</span><span class="md:hidden">Next</span> <i class="fa-solid fa-chevron-right md:ml-2"></i>
                                    </button>
                                </template>

                                <template x-if="currentQuestionIndex === questions.length - 1">
                                    <div>
                                        <template x-if="mode !== 'tim'">
                                            <button @click="submitQuiz" class="btn-nav bg-green-600 border-green-500 hover:bg-green-500 shadow-[0_0_15px_rgba(34,197,94,0.4)] w-full md:w-auto">
                                                <i class="fa-solid fa-flag-checkered mr-2"></i> Selesai
                                            </button>
                                        </template>
                                        <template x-if="mode === 'tim'">
                                            <button @click="submitAll()" class="btn-nav bg-green-600 border-green-500 hover:bg-green-500 shadow-[0_0_15px_rgba(34,197,94,0.4)] w-full md:w-auto">
                                                <i class="fa-solid fa-flag-checkered mr-2"></i> Selesai
                                            </button>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>

                <div x-show="showModal" x-cloak 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-90"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    
                    <div class="absolute inset-0 modal-backdrop" @click="showModal = false"></div>

                    <div class="relative z-10 bg-[#0f172a] border border-blue-500/30 w-full max-w-3xl rounded-2xl shadow-2xl flex flex-col max-h-[85vh]">
                        <div class="p-4 md:p-5 border-b border-white/10 flex justify-between items-center bg-[#1e293b]">
                            <h3 class="text-lg font-bold text-white"><i class="fa-solid fa-map mr-2 text-blue-400"></i> Peta Soal</h3>
                            <button @click="showModal = false" class="text-gray-400 hover:text-white transition"><i class="fa-solid fa-xmark text-xl"></i></button>
                        </div>

                        <div class="p-4 md:p-6 overflow-y-auto custom-scrollbar">
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3">
                                <template x-for="(q, idx) in questions" :key="q.id">
                                    <div class="rounded-lg question-tile relative group overflow-hidden"
                                         :class="submittedStatus[q.id] ? 'tile-submitted' : 'tile-unsubmitted'"
                                         @click="gotoQuestion(idx); showModal = false">
                                        
                                        <div class="p-3 text-center">
                                            <div class="text-xs uppercase tracking-wider text-gray-400 mb-1">Soal</div>
                                            <div class="text-xl font-blackops group-hover:text-white transition" 
                                                 :class="submittedStatus[q.id] ? 'text-blue-200' : 'text-gray-300'" 
                                                 x-text="idx + 1"></div>
                                        </div>
                                        
                                        <div class="absolute bottom-0 left-0 right-0 h-1" 
                                             :class="submittedStatus[q.id] ? 'bg-blue-400' : 'bg-gray-700'"></div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="p-4 border-t border-white/10 bg-[#1e293b] flex justify-end gap-3">
                            <button class="btn-nav text-gray-300 hover:text-white" @click="showModal = false">Tutup</button>
                            <button class="btn-nav bg-green-600 border-green-500 hover:bg-green-500" @click="submitAll()">
                                <i class="fa-solid fa-check-double mr-2"></i> Kirim Semua
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>

    <div x-data="{ showSetting: false, volume: 0.5, muted: false }" 
         x-init="(() => {
            const savedVol = localStorage.getItem('volume');
            const savedMute = localStorage.getItem('muted');
            const audio = document.getElementById('bgMusic');
            if (audio) {
                if (savedVol) { audio.volume = parseFloat(savedVol); volume = audio.volume; }
                if (savedMute !== null) { audio.muted = (savedMute === 'true'); muted = audio.muted; }
                const tryPlay = () => audio.play().catch(() => {});
                if (!audio.muted && !muted) { tryPlay(); }
                const unlock = () => {
                    if (!muted) { audio.muted = false; tryPlay(); }
                    window.removeEventListener('click', unlock);
                    window.removeEventListener('touchstart', unlock);
                };
                window.addEventListener('click', unlock, { once: true });
                window.addEventListener('touchstart', unlock, { once: true });
            }
         })()"
         class="fixed left-4 bottom-4 z-40">

        <div class="relative">
            <div x-show="showSetting" @click.away="showSetting = false" x-transition 
                 class="absolute bottom-full left-0 mb-3 w-64 bg-[#1e293b] text-white rounded-xl shadow-2xl border border-gray-600 p-4 text-sm">
                <h3 class="font-semibold text-gray-300 mb-3 border-b border-gray-600 pb-2">Pengaturan Suara</h3>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs uppercase tracking-wide text-gray-400">Background Music</span>
                    <button @click="muted = !muted; const audio = document.getElementById('bgMusic'); if (audio) { audio.muted = muted; if(muted){ audio.pause(); } else { audio.play().catch(() => {}); } } localStorage.setItem('muted', muted);"
                            class="w-10 h-5 rounded-full relative transition-colors duration-300"
                            :class="muted ? 'bg-gray-600' : 'bg-green-500'">
                        <div class="w-3 h-3 bg-white rounded-full absolute top-1 transition-all duration-300"
                             :class="muted ? 'left-1' : 'left-6'"></div>
                    </button>
                </div>
                <input type="range" min="0" max="1" step="0.01" x-model="volume" 
                       @input="const audio = document.getElementById('bgMusic'); if (audio) { audio.volume = volume; } localStorage.setItem('volume', volume);" 
                       class="w-full h-1 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-blue-500">
            </div>

            <button @click="showSetting = !showSetting" class="w-10 h-10 bg-black/50 border border-white/20 rounded-full text-white shadow-lg hover:bg-blue-600 hover:border-blue-400 transition flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-gear animate-spin-slow" style="animation-duration: 5s;"></i>
            </button>
        </div>
    </div>

    <script>
        function quizController(duration, questions, submitQuestionUrl, submitAllUrl, mode) {
            return {
                duration: duration,
                questions: questions || [],
                submitQuestionUrl: submitQuestionUrl,
                submitAllUrl: submitAllUrl,
                mode: mode || 'individu',
                currentQuestionIndex: 0,
                answers: {},
                timer: (duration || 0) * 60,
                isFinished: false,
                showModal: false,
                submittingQuestion: false,
                submittedStatus: {}, // { question_id: true/false }
                submittedCount: 0, // Counter to force reactivity
                isAutoSubmitting: false, // Flag to indicate auto-submit on timeout

                init() {
                    this.questions.forEach(q => { this.submittedStatus[q.id] = false; });

                    // Compute timer based on server-provided endTime when available so refresh doesn't reset timer
                    try {
                        if (window.tournamentData && window.tournamentData.endTime) {
                            const serverTimeMs = Date.parse(window.tournamentData.serverTime);
                            const endTimeMs = Date.parse(window.tournamentData.endTime);
                            const nowMs = Date.now();

                            // total remaining (seconds) from the server snapshot, minus seconds elapsed on client since that snapshot
                            const totalRemainingFromServer = Math.max(0, Math.floor((endTimeMs - serverTimeMs) / 1000));
                            const elapsedSinceServer = Math.max(0, Math.floor((nowMs - serverTimeMs) / 1000));
                            const remaining = Math.max(0, totalRemainingFromServer - elapsedSinceServer);
                            this.timer = remaining;
                        } else {
                            this.timer = (this.duration || 0) * 60;
                        }
                    } catch (e) {
                        this.timer = (this.duration || 0) * 60;
                    }

                    // try to start timer automatically
                    this.startTimer();

                    // For mode TIM: start polling team submission status every 2 seconds
                    if (this.mode === 'tim' && window.tournamentData) {
                        this.startPollingTeamStatus();
                        this.startPollingTeamFinish();
                    }

                    // expose for debug if needed
                    console.log('quizController init', { duration: this.duration, mode: this.mode, totalQ: this.questions.length, timer: this.timer });
                },
                get currentQuestion() {
                    return this.questions[this.currentQuestionIndex] || { options: [] };
                },
                get timerText() {
                    const minutes = Math.floor(this.timer / 60);
                    const seconds = this.timer % 60;
                    return `${minutes}:${seconds.toString().padStart(2, '0')}`;
                },
                startTimer() {
                    if (!this.timer || this.timer <= 0) return;
                    const that = this;
                    this._interval = setInterval(() => {
                        if (that.timer > 0) that.timer--;
                        else {
                            clearInterval(that._interval);
                            that.submitQuiz();
                        }
                    }, 1000);
                },
                selectAnswer(questionId, answerId) {
                    this.answers[questionId] = answerId;
                },
                nextQuestion() {
                    if (this.currentQuestionIndex < this.questions.length - 1) this.currentQuestionIndex++;
                },
                prevQuestion() {
                    if (this.currentQuestionIndex > 0) this.currentQuestionIndex--;
                },
                gotoQuestion(idx) {
                    if (idx >= 0 && idx < this.questions.length) this.currentQuestionIndex = idx;
                },
                async submitSingle(questionId) {
                    // Mode TIM: kirim jawaban untuk satu soal segera ke server
                    if (!this.answers[questionId]) {
                        alert('Pilih jawaban terlebih dahulu.');
                        return;
                    }

                    // Jangan kirim ulang jika sudah disubmit
                    if (this.submittedStatus[questionId]) {
                        console.log('Question already submitted:', questionId);
                        return;
                    }

                    this.submittingQuestion = true;
                    try {
                        const payload = { single: true, question_id: questionId, answer_id: this.answers[questionId], time_taken: (this.duration * 60) - this.timer };
                        const res = await fetch(this.submitQuestionUrl, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
                            body: JSON.stringify(payload)
                        });
                        if (!res.ok) throw new Error('Gagal submit');
                        this.submittedStatus[questionId] = true;
                        this.submittedCount++; // Force reactivity update
                        // optional: show toast / visual feedback
                        console.log('Submitted single question', questionId);

                    } catch (e) {
                        console.error('submitSingle error', e);
                        alert('Error: tidak dapat mengirim jawaban.');
                        this.submittingQuestion = false;
                    }
                },

                startPollingTeamStatus() {
                    // Poll server every 2 seconds to get submitted questions for entire team
                    // This ensures all team members see the same submitted status
                    const that = this;
                    if (this._pollingInterval) clearInterval(this._pollingInterval);

                    this._pollingInterval = setInterval(() => {
                        // Extract tournament ID from URL path: /tournament/start/{id}
                        const pathParts = window.location.pathname.split('/').filter(p => p);
                        // pathParts = ['tournament', 'start', '{id}']
                        const tournamentId = pathParts[pathParts.length - 1];
                        
                        if (!tournamentId) {
                            console.warn('Could not extract tournament ID from URL');
                            return;
                        }

                        fetch(`/tournament/${tournamentId}/team-submission-status`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data && Array.isArray(data.submitted_ids)) {
                                // Update submitted status for all submitted questions
                                let hasChanges = false;
                                data.submitted_ids.forEach(qid => {
                                    if (!that.submittedStatus[qid]) {
                                        that.submittedStatus[qid] = true;
                                        hasChanges = true;
                                    }
                                });
                                
                                // Force Alpine to update UI if there are changes
                                if (hasChanges) {
                                    // Increment counter to trigger Alpine reactivity
                                    that.submittedCount++;
                                    console.log('Team submission status updated:', data.submitted_ids, 'Count:', that.submittedCount);
                                }
                            }
                        })
                        .catch(err => console.warn('Team status polling error:', err));
                    }, 2000); // Poll every 2 seconds
                },

                startPollingTeamFinish() {
                    // Poll server every 2 seconds to check if team has finished
                    // When ANY team member submits all, redirect all members to leaderboard
                    const that = this;
                    if (this._finishPollingInterval) clearInterval(this._finishPollingInterval);

                    this._finishPollingInterval = setInterval(() => {
                        // Extract tournament ID from URL path: /tournament/start/{id}
                        const pathParts = window.location.pathname.split('/').filter(p => p);
                        const tournamentId = pathParts[pathParts.length - 1];
                        
                        if (!tournamentId) {
                            console.warn('Could not extract tournament ID from URL');
                            return;
                        }

                        fetch(`/tournament/${tournamentId}/team-finish-status`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            // If team has finished (one member submitted), redirect all to leaderboard
                            if (data && data.finished && data.team_finished) {
                                console.log('Team has finished, redirecting to leaderboard...');
                                clearInterval(that._finishPollingInterval);
                                // Redirect to leaderboard with tournament ID
                                window.location.href = `/tournament/leaderboard/${tournamentId}`;
                            }
                        })
                        .catch(err => console.warn('Team finish polling error:', err));
                    }, 2000); // Poll every 2 seconds
                },

                async submitAll(isAutoSubmit = false) {
                    // Submit semua jawaban yang ada (untuk mode tim jika ingin submit final),
                    // atau bisa dipakai sebagai convenience: kirim semua yang sudah terpilih.
                    const answersToSend = this.answers;

                    // Show confirmation alert if manually triggered (not auto-submit on timeout)
                    if (!isAutoSubmit) {
                        if (!confirm('Apakah yakin submit all?')) return;
                    }

                    // Mark as auto-submitting to prevent user interaction during timeout
                    if (isAutoSubmit) {
                        this.isAutoSubmitting = true;
                    }

                    try {
                        const payload = { single: false, answers: this.answers, time_taken: (this.duration * 60) - this.timer };
                        const res = await fetch(this.submitAllUrl, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
                            body: JSON.stringify(payload)
                        });

                        if (!res.ok) {
                            const err = await res.json().catch(()=>({ message: 'Unknown error' }));
                            if (!isAutoSubmit) {
                                alert('Gagal submit all: ' + (err.message || res.statusText));
                            }
                            console.error('submitAll error:', err);
                            return;
                        }

                        // If server redirects or returns JSON success
                        const data = await res.json().catch(()=>null);
                        console.log('Submit all response', data);
                        // Mark all sent questions as submitted (best-effort)
                        Object.keys(this.answers).forEach(qid => this.submittedStatus[qid] = true);

                        // Extract tournament ID from current URL or use data if provided
                        const tournamentId = this.extractTournamentId();
                        
                        // Redirect to leaderboard with tournament ID
                        window.location.href = `/tournament/leaderboard/${tournamentId}`;
                    } catch (e) {
                        console.error('submitAll error', e);
                        if (!isAutoSubmit) {
                            alert('Gagal mengirim semua jawaban.');
                        }
                    }
                },

                extractTournamentId() {
                    // First try to get from window.tournamentData if available
                    if (window.tournamentData && window.tournamentData.tournamentId) {
                        return window.tournamentData.tournamentId;
                    }
                    // Fallback: Extract tournament ID from URL /tournament/start/{id}
                    const pathParts = window.location.pathname.split('/').filter(p => p);
                    if (pathParts.length >= 3 && pathParts[1] === 'start') {
                        return pathParts[2];
                    }
                    return 'leaderboard'; // Fallback URL
                },

                async submitQuiz() {
                    // Mode individu: kirim seluruh jawaban seperti sebelumnya
                    if (this.mode === 'tim') {
                        // Jika mode tim, gunakan submitAll agar konsisten, atau biarkan user memilih submit per-soal
                        return this.submitAll(true);  // Pass true to indicate this is auto-submit on timeout
                    }

                    try {
                        const payload = {
                            answers: this.answers,
                            time_taken: (this.duration * 60) - this.timer
                        };

                        const res = await fetch(this.submitUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        if (!res.ok) {
                            alert('Error submitting quiz');
                            return;
                        }

                        const data = await res.json().catch(()=>null);
                        if (data && data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else {
                            window.location.href = '/tournament/leaderboard';
                        }
                    } catch (error) {
                        console.error('Submit error:', error);
                        alert('Error submitting quiz');
                    }
                }
            };
        }
    </script>
</body>
</html>