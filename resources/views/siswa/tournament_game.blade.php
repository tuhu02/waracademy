<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Turnamen Dimulai! | {{ $turnamen->nama_turnamen }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        blackops: ['"Black Ops One"', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    {{-- (Salin script musik dari level.blade.php) --}}
    <script type="module">
    window.addEventListener("DOMContentLoaded", () => {
        const audio = document.getElementById("bgMusic");
        if (!audio) return;
        const savedVol = parseFloat(localStorage.getItem("volume"));
        const savedMute = localStorage.getItem("muted");
        const savedTime = parseFloat(localStorage.getItem("bgmCurrentTime"));
        const volume = !isNaN(savedVol) ? savedVol : 0.5;
        const muted = savedMute === "true";
        audio.volume = volume;
        audio.muted = muted; 
        if (!isNaN(savedTime) && savedTime > 0) {
            audio.currentTime = savedTime;
        }
        if (!audio.muted && audio.volume > 0) {
            audio.play().catch(e => console.warn("Autoplay musik dicegah"));
        } else {
            audio.pause();
        }
        window.addEventListener("beforeunload", () => {
            if (!audio.paused && !audio.muted && audio.currentTime > 0) {
                localStorage.setItem("bgmCurrentTime", audio.currentTime);
            } else {
                localStorage.removeItem("bgmCurrentTime");
            }
        });
    });
    </script>

    <style>
        /* (Salin style dari level.blade.php) */
        .btn-nav {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(106,168,250,0.55);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            backdrop-filter: blur(6px);
            transition: all 0.2s;
        }
        .btn-nav:hover { background: rgba(255,255,255,0.16); }
        .btn-nav:disabled { opacity: 0.5; cursor: not-allowed; }

        .option-btn {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(106,168,250,0.4);
            backdrop-filter: blur(5px);
            transition: all 0.2s;
            text-align: left;
        }
        .option-btn:hover {
            background: rgba(106,168,250,0.3);
            border-color: rgba(106,168,250,0.8);
        }
        .option-btn.selected {
            background: #3b82f6; /* Biru */
            border-color: #a3d3fa;
            color: white;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-[#0f1b2e] via-[#243b55] to-[#3b5875] min-h-screen text-white font-poppins">
    
    <audio id="bgMusic" loop>
        <source src="/audio/sound.mp3" type="audio/mpeg">
    </audio>
    <img src="/images/war.png" alt="Logo"
         style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) scale(1.5);
                height:300px;opacity:0.05;pointer-events:none;z-index:0;mix-blend-mode:lighten;">

    
    <div class="relative z-10 p-6 max-w-4xl mx-auto" 
         x-data="quizController(
             {{ $turnamen->durasi_pengerjaan }}, 
             @json($questions),
             '{{ route('tournament.submit', ['id' => $turnamen->id_turnamen]) }}'
         )">
        
        <div class="text-center mb-6">
            <h1 class="text-3xl md:text-5xl font-blackops
                       bg-gradient-to-b from-[#e5f2ff] via-[#a3d3fa] to-[#6aa8fa]
                       bg-clip-text text-transparent 
                       drop-shadow-[0_0_15px_rgba(70,150,255,0.6)]">
                {{ $turnamen->nama_turnamen }}
            </h1>
        </div>

        <template x-if="!isFinished">
            <div class="bg-black/20 backdrop-blur-lg border border-blue-400/30 rounded-xl shadow-2xl overflow-hidden">
                
                <div class="flex justify-between items-center p-4 bg-black/30 border-b border-blue-400/30">
                    <div class="text-lg">
                        Soal <strong class="text-cyan-300" x-text="currentQuestionIndex + 1"></strong> / <span x-text="questions.length"></span>
                    </div>
                    <div class="text-2xl font-blackops text-yellow-400" x-text="timerText">
                        {{ $turnamen->durasi_pengerjaan }}:00
                    </div>
                </div>

                <div class="p-6 md:p-8 min-h-[300px]">
                    <h2 class="text-xl md:text-2xl font-semibold mb-6" x-html="currentQuestion.teks_pertanyaan">
                        ...
                    </h2>
                    
                    <div class="space-y-3">
                        <template x-for="option in currentQuestion.options" :key="option.id_jawaban">
                            <button 
                                @click="selectAnswer(currentQuestion.id, option.id_jawaban)"
                                class="w-full p-4 rounded-lg option-btn"
                                :class="{ 'selected': answers[currentQuestion.id] == option.id_jawaban }">
                                <span x-html="option.teks_jawaban"></span>
                            </button>
                        </template>
                    </div>
                </div>

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
                        <button @click="submitQuiz" class="btn-nav bg-green-600 border-green-400 hover:bg-green-500">
                            <i class="fa-solid fa-check mr-2"></i> Selesai & Kirim
                        </button>
                    </template>
                </div>

            </div>
        </template>
        
        <template x-if="isFinished">
            <div class="bg-black/20 backdrop-blur-lg border border-blue-400/30 rounded-xl shadow-2xl p-8 text-center">
                 <h2 class="text-3xl font-bold text-green-400 mb-4">Turnamen Selesai!</h2>
                 <p class="text-gray-300 text-lg mb-6">Jawaban Anda telah dikirim. Menunggu hasil dari guru...</p>
                 <svg class="animate-spin h-12 w-12 text-green-400 mx-auto mb-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                 <a href="{{ route('home') }}" class="btn-nav">
                     <i class="fa-solid fa-home mr-2"></i> Kembali ke Home
                 </a>
            </div>
        </template>
    </div>

    <script>
    function quizController(durationInMinutes, questionsData, submitUrl) {
        return {
            questions: questionsData,
            currentQuestionIndex: 0,
            answers: {}, // { question_id: choice_id }
            timeRemaining: durationInMinutes * 60,
            timerText: `${durationInMinutes}:00`,
            timerInterval: null,
            isFinished: false,
            submitUrl: submitUrl,

            get currentQuestion() {
                // Tampilkan soal pertama saat dimuat
                if (!this.questions || this.questions.length === 0) {
                    return { teks_pertanyaan: 'Memuat soal...', options: [] };
                }
                return this.questions[this.currentQuestionIndex];
            },

            init() {
                this.startTimer();
                // Render MathJax saat soal pertama muncul
                this.$nextTick(() => {
                    if (window.MathJax) {
                        window.MathJax.typeset();
                    }
                });

                // Tonton perubahan indeks soal, lalu render ulang MathJax
                this.$watch('currentQuestionIndex', () => {
                    this.$nextTick(() => {
                        if (window.MathJax) {
                            window.MathJax.typeset();
                        }
                    });
                });
            },

            startTimer() {
                this.timerInterval = setInterval(() => {
                    this.timeRemaining--;
                    
                    const minutes = Math.floor(this.timeRemaining / 60);
                    const seconds = this.timeRemaining % 60;
                    this.timerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                    if (this.timeRemaining <= 0) {
                        this.submitQuiz();
                    }
                }, 1000);
            },

            nextQuestion() {
                if (this.currentQuestionIndex < this.questions.length - 1) {
                    this.currentQuestionIndex++;
                }
            },

            prevQuestion() {
                if (this.currentQuestionIndex > 0) {
                    this.currentQuestionIndex--;
                }
            },

            selectAnswer(questionId, choiceId) {
                this.answers[questionId] = choiceId;
            },

            submitQuiz() {
                if (this.isFinished) return; // Mencegah submit ganda

                this.isFinished = true;
                clearInterval(this.timerInterval);
                
                // Buat form dinamis untuk submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = this.submitUrl;

                // 1. CSRF Token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                // 2. Data Jawaban
                const answersInput = document.createElement('input');
                answersInput.type = 'hidden';
                answersInput.name = 'answers'; // Controller akan menerima 'answers'
                answersInput.value = JSON.stringify(this.answers);
                form.appendChild(answersInput);

                // 3. Waktu (opsional, tapi bagus)
                const timeTaken = (durationInMinutes * 60) - this.timeRemaining;
                const timeInput = document.createElement('input');
                timeInput.type = 'hidden';
                timeInput.name = 'time_taken';
                timeInput.value = timeTaken;
                form.appendChild(timeInput);

                // Submit form
                document.body.appendChild(form);
                form.submit();
            }
        }
    }
    </script>
</body>
</html>