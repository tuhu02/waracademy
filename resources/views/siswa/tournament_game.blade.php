<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Turnamen Dimulai! | {{ $turnamen->nama_turnamen }}</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- MathJax -->
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

        .btn-nav {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(106,168,250,0.55);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            backdrop-filter: blur(6px);
            transition: all .2s;
        }
        .btn-nav:hover { background: rgba(255,255,255,0.16); }
        .btn-nav:disabled { opacity: .5; cursor: not-allowed; }

        .option-btn {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(106,168,250,0.4);
            backdrop-filter: blur(5px);
            transition: all .2s;
            text-align: left;
        }
        .option-btn:hover { background: rgba(106,168,250,0.3); border-color: rgba(106,168,250,0.8); }
        .option-btn.selected { background: #3b82f6; border-color: #a3d3fa; color: white; }

        /* Modal */
        .modal-backdrop { background: rgba(0,0,0,0.6); }
        .question-tile { cursor: pointer; transition: transform .12s; }
        .question-tile:hover { transform: translateY(-4px); }
        .tile-submitted { background: rgba(56,189,248,0.12); border: 1px solid rgba(56,189,248,0.4); }
        .tile-unsubmitted { background: rgba(255,255,255,0.03); border: 1px dashed rgba(255,255,255,0.06); }
    </style>
</head>

<body class="bg-gradient-to-b from-[#0f1b2e] via-[#243b55] to-[#3b5875] min-h-screen text-white font-poppins">
    <audio id="bgMusic" loop>
        <source src="/audio/sound.mp3" type="audio/mpeg" />
    </audio>

    <img src="/images/war.png" alt="Logo" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 scale-[1.5] h-[300px] opacity-5 pointer-events-none z-0 mix-blend-lighten" />

    <div class="relative z-10 p-6 max-w-4xl mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-3xl md:text-5xl font-blackops
                        bg-gradient-to-b from-[#e5f2ff] via-[#a3d3fa] to-[#6aa8fa]
                        bg-clip-text text-transparent 
                        drop-shadow-[0_0_15px_rgba(70,150,255,0.6)]">
                {{ $turnamen->nama_turnamen }}
            </h1>
        </div>

        @if(empty($questions) || count($questions) === 0)
            <div class="bg-black/20 backdrop-blur-lg border border-red-400/30 rounded-xl shadow-2xl p-8 text-center">
                <h2 class="text-2xl font-bold text-red-400 mb-4">⚠️ Belum Ada Soal</h2>
                <p class="text-gray-300 text-lg mb-6">Turnamen ini belum memiliki soal atau soal belum memiliki pilihan jawaban. Silakan hubungi guru untuk menambahkan soal.</p>
                <a href="{{ route('home') }}" class="btn-nav">
                    <i class="fa-solid fa-home mr-2"></i> Kembali ke Home
                </a>
            </div>
        @else

            <script>

                // Shared data injected from server
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
                console.log("Alpine ready, tournamentData:", window.tournamentData);

            </script>


            
            <div x-data="quizController(window.tournamentData.duration, window.tournamentData.questions, window.tournamentData.submitQuestionUrl, window.tournamentData.submitAllUrl, window.tournamentData.mode)" x-init="init()">

                <!-- Top controls -->
                <div class="flex justify-between items-center mb-4">
                    <div class="text-sm text-gray-300">
                        Mode: <strong class="text-white">{{ $turnamen->mode === 'tim' ? 'Tim' : 'Individu' }}</strong>
                    </div>

                    <!-- Jika mode tim, tampilkan tombol Daftar Soal (modal) -->
                    <div>
                        <template x-if="mode === 'tim'">
                            <button @click="showModal = true" class="btn-nav">
                                <i class="fa-solid fa-list mr-2"></i> Daftar Soal
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Quiz area -->
                <div x-show="!isFinished" x-cloak>
                    <div class="bg-black/20 backdrop-blur-lg border border-blue-400/30 rounded-xl shadow-2xl overflow-hidden">

                        <!-- Header -->
                        <div class="flex justify-between items-center p-4 bg-black/30 border-b border-blue-400/30">
                            <div class="text-lg">
                                Soal <strong class="text-cyan-300" x-text="currentQuestionIndex + 1"></strong> /
                                <span x-text="questions.length"></span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-2xl font-blackops text-yellow-400" x-text="timerText">
                                    {{ $turnamen->durasi_pengerjaan }}:00
                                </div>
                                <!-- Untuk mode tim, tunjukkan indikator simple -->
                                <template x-if="mode === 'tim'">
                                    <div class="text-sm text-cyan-200 bg-black/20 px-3 py-1 rounded-full border border-cyan-400/30">
                                        Shared Team Answers
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Question -->
                        <div class="p-6 md:p-8 min-h-[300px]">
                            <h2 class="text-xl md:text-2xl font-semibold mb-6" x-html="currentQuestion.teks_pertanyaan"></h2>

                            <div class="space-y-3">
                                <template x-for="option in currentQuestion.options" :key="option.id_jawaban">
                                    <button
                                        @click="selectAnswer(currentQuestion.id, option.id_jawaban)"
                                        class="w-full p-4 rounded-lg option-btn"
                                        :class="{ 'selected': answers[currentQuestion.id] == option.id_jawaban }"
                                    >
                                        <span x-html="option.teks_jawaban"></span>
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
                                </template>

                                <!-- Di mode tim bisa tetap ada tombol submit all di akhir -->
                                <template x-if="mode === 'tim'">
                                    <button @click="submitAll()" class="btn-nav bg-green-600 border-green-400 hover:bg-green-500">
                                        <i class="fa-solid fa-check-double mr-2"></i> Submit All (Tim)
                                    </button>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Modal Daftar Soal (mode tim) -->
                <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 modal-backdrop" @click="showModal = false"></div>

                    <div class="relative z-10 max-w-3xl w-full mx-4">
                        <div class="bg-[#071226] rounded-xl shadow-2xl p-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">Preview Daftar Soal</h3>
                                <div class="flex items-center gap-2">
                                    <button class="btn-nav" @click="submitAll()">
                                        <i class="fa-solid fa-check-double mr-2"></i> Submit All
                                    </button>
                                    <button class="btn-nav" @click="showModal = false">Tutup</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                                <template x-for="(q, idx) in questions" :key="q.id">
                                    <div
                                        class="p-3 rounded-lg question-tile"
                                        :class="submittedStatus[q.id] ? 'tile-submitted' : 'tile-unsubmitted'"
                                        @click="gotoQuestion(idx); showModal = false"
                                    >
                                        <div class="text-sm font-semibold mb-2">Soal <span x-text="idx + 1"></span></div>
                                        <div class="text-xs text-gray-300 mb-2 truncate" x-html="(q.teks_pertanyaan.length > 60) ? q.teks_pertanyaan.slice(0,60)+'...' : q.teks_pertanyaan"></div>

                                        <div class="flex items-center justify-between">
                                            <div class="text-xs text-gray-400" x-show="submittedStatus[q.id]">Sudah</div>
                                            <div class="text-xs text-gray-400" x-show="!submittedStatus[q.id]">Belum</div>
                                            <div>
                                                <button
                                                    class="btn-nav text-xs px-2 py-1"
                                                    @click.stop="gotoQuestion(idx)"
                                                >Buka</button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal -->

            </div>
        @endif
    </div>

    <script>
        function quizController(duration, questions, submitQuestionUrl, submitAllUrl, mode) {
            return {
                duration: duration,
                questions: questions || [],
                submitQuestionUrl: submitQuestionUrl,
                submitAllUrl: submitAllUrl,
                mode: mode || 'individu',

                        // state
                currentQuestionIndex: 0,
                answers: {}, // { question_id: answer_id }
                timer: (duration || 0) * 60,
                isFinished: false,
                showModal: false,
                submittingQuestion: false,
                submittedStatus: {}, // { question_id: true/false }
                submittedCount: 0, // Counter to force reactivity
                isAutoSubmitting: false, // Flag to indicate auto-submit on timeout

                init() {
                    // init submitted status if provided by server later
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
                    this.$nextTick?.(() => {}); // compatibility
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
                        const payload = {
                            single: true,
                            question_id: questionId,
                            answer_id: this.answers[questionId],
                            time_taken: (this.duration * 60) - this.timer
                        };

                        const res = await fetch(this.submitQuestionUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        if (!res.ok) {
                            const err = await res.json().catch(()=>({ message: 'Unknown server error' }));
                            alert('Gagal submit: ' + (err.message || res.statusText));
                            this.submittingQuestion = false;
                            return;
                        }

                        // assume server replied success
                        this.submittingQuestion = false;
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
                        const payload = {
                            single: false,
                            answers: answersToSend,
                            time_taken: (this.duration * 60) - this.timer
                        };

                        const res = await fetch(this.submitAllUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
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
    
    <div x-data="{ showSetting: false, volume: 0.5, muted: false }" x-init="(() => {
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
    class="fixed left-4 bottom-4 z-50">

        <div class="relative">
            <button x-show="!showSetting" @click="showSetting = true" x-transition.opacity.duration.200ms class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-3 py-2 text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm transition">
                ⚙️
            </button>

            <div x-show="showSetting" @click.away="showSetting = false" x-transition class="absolute bottom-full left-0 mb-4 w-64 bg-white/95 text-gray-800 rounded-2xl shadow-2xl border border-gray-300/70 p-4 text-sm">
                <h3 class="font-semibold text-gray-700 mb-2">🎵 Pengaturan Suara</h3>

                <div class="flex justify-between items-center mb-3">
                    <span>Musik</span>
                    <button @click="muted = !muted; const audio = document.getElementById('bgMusic'); if (audio) { audio.muted = muted; if(muted){ audio.pause(); } else { audio.play().catch(() => {}); } } localStorage.setItem('muted', muted);"
                        class="px-3 py-1 rounded-md font-semibold transition text-xs"
                        :class="muted ? 'bg-red-500 text-white' : 'bg-green-500 text-white'">
                        <span x-text="muted ? 'Mati' : 'Hidup'"></span>
                    </button>
                </div>

                <label class="block mb-1 text-gray-700 font-medium">Volume</label>
                <input type="range" min="0" max="1" step="0.01" x-model="volume" @input="const audio = document.getElementById('bgMusic'); if (audio) { audio.volume = volume; } localStorage.setItem('volume', volume);" class="w-full accent-blue-600 cursor-pointer">
            </div>
        </div>
    </div>
</body>
</html>
