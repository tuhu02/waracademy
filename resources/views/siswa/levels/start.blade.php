<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Level {{ $id }} | WarAcademy</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@400;600&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom, #0f1b2e, #304863 50%, #3b5875);
      color: white;
      overflow-y: auto; /* ✅ sekarang bisa scroll vertikal */
      min-height: 100vh;
      position: relative; /* beri ruang bawah biar tidak kepotong */
      overflow-x: hidden;
    }

    #particles {
      position: absolute;
      inset: 0;
      z-index: 0;
    }

    .slide-in {
  animation: slideIn 0.6s ease forwards;
}

.slide-out {
  animation: slideOut 0.6s ease forwards;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(60px);
    filter: blur(6px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
    filter: blur(0);
  }
}

@keyframes slideOut {
  from {
    opacity: 1;
    transform: translateX(0);
    filter: blur(0);
  }
  to {
    opacity: 0;
    transform: translateX(-60px);
    filter: blur(6px);
  }
}

    .text-glow {
      text-shadow: 0 0 10px rgba(170,210,255,0.9),
                   0 0 25px rgba(90,150,255,0.6);
      font-family: 'Orbitron', sans-serif;
      letter-spacing: 1px;
      color: #dce6f2;
    }

    .soal-container {
      width: 90%;
      max-width: 850px;
      margin: 60px auto;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 18px;
      box-shadow: 0 0 25px rgba(80,130,255,0.3);
      backdrop-filter: blur(12px);
      padding: 32px;
      display: none;
      position: relative;
      z-index: 2;
      min-height: 70vh;
      animation: fadeIn 0.8s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .question {
      font-size: 1.2rem;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 600;
      text-shadow: 0 0 8px rgba(90,150,255,0.6);
    }

    .option-card {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 14px 18px;
      margin: 12px 0;
      cursor: pointer;
      transition: all 0.25s ease;
      box-shadow: 0 0 10px rgba(0,100,255,0.15);
    }

    .option-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 0 20px rgba(90,150,255,0.4);
      background: rgba(255,255,255,0.1);
    }

    .option-card.selected {
      background: linear-gradient(135deg, #2f5fa8, #0c2957);
      border-color: rgba(100,150,255,0.6);
      box-shadow: 0 0 25px rgba(100,150,255,0.6);
      transform: scale(1.03);
    }

    .btn-next {
      background: linear-gradient(to bottom, #2f5fa8, #0c2957);
      color: white;
      padding: 12px 32px;
      border-radius: 12px;
      font-family: 'Orbitron', sans-serif;
      text-transform: uppercase;
      border: 1px solid rgba(100,150,255,0.4);
      margin-top: 24px;
      display: none;
      transition: all 0.3s ease;
      box-shadow: 0 0 15px rgba(70,120,255,0.3);
    }

    .btn-next:hover {
      background: linear-gradient(to bottom, #3d6fc0, #14386d);
      transform: scale(1.05);
      box-shadow: 0 0 30px rgba(100,150,255,0.6);
    }

    .timer {
      position: fixed;
      top: 20px;
      right: 30px;
      background: rgba(0,40,90,0.3);
      border: 1px solid rgba(90,150,255,0.4);
      padding: 14px 26px;
      border-radius: 14px;
      font-family: 'Orbitron', sans-serif;
      font-size: 1.3rem;
      color: #a3d3fa;
      box-shadow: 0 0 25px rgba(0,150,255,0.4);
      backdrop-filter: blur(10px);
      display: none;
    }

    .start-countdown {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-family: 'Orbitron', sans-serif;
      font-size: 6rem;
      color: #6aa8fa;
      text-shadow: 0 0 30px #6aa8fa, 0 0 60px #1e3a8a;
      opacity: 0;
      animation: scalePop 1s ease forwards;
      z-index: 10;
    }

    @keyframes scalePop {
      0% { transform: translate(-50%, -50%) scale(0.3); opacity: 0; }
      50% { opacity: 1; transform: translate(-50%, -50%) scale(1.3); }
      100% { opacity: 0; transform: translate(-50%, -50%) scale(1); }
    }

    .logo-bg {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(1.2);
      opacity: 0.05;
      height: 300px;
      pointer-events: none;
      z-index: 0;
    }

    /* === HASIL / EVALUASI === */
#resultBox {
  display: none;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 60px 40px;
  min-height: 90vh;
  position: relative;
  overflow: hidden;
  background: radial-gradient(circle at center, rgba(15,30,60,0.8), rgba(5,10,25,0.95));
  border: 1px solid rgba(120,170,255,0.25);
  box-shadow: inset 0 0 60px rgba(50,120,255,0.3), 0 0 40px rgba(50,120,255,0.4);
  border-radius: 20px;
  animation: fadeIn 0.8s ease forwards;
}

/* Efek garis hologram berjalan */
#resultBox::after {
  content: '';
  position: absolute;
  top: -100%;
  left: 0;
  width: 100%;
  height: 200%;
  background: repeating-linear-gradient(
    to bottom,
    rgba(255,255,255,0.05) 0px,
    rgba(255,255,255,0.05) 2px,
    transparent 2px,
    transparent 6px
  );
  animation: scanMove 5s linear infinite;
  z-index: 1;
  pointer-events: none;
}
@keyframes scanMove {
  0% { transform: translateY(0); }
  100% { transform: translateY(100px); }
}

/* H1 */
#resultBox h1 {
  font-family: 'Orbitron', sans-serif;
  font-size: 2.5rem;
  color: #b9d7ff;
  text-shadow: 0 0 25px #7ab7ff, 0 0 60px #1c4db0;
  letter-spacing: 3px;
  text-shadow: 0 0 25px #7ab7ff, 0 0 60px #1c4db0;
  margin-bottom: 1.5rem;
  z-index: 2;
}

/* Ringkasan hasil */
#resultSummary {
  font-size: 1.4rem;
  color: #a7d8ff;
  margin-bottom: 1.5rem;
  background: rgba(15,35,75,0.6);
  border-color: rgba(100,160,255,0.3);
  box-shadow: 0 0 20px rgba(70,130,255,0.3);
  padding: 12px 24px;
  border-radius: 10px;
  animation: fadeInUp 1s ease both;
}

/* Bintang animasi */
.star {
  font-size: 3.5rem;
  color: gold;
  filter: drop-shadow(0 0 20px gold);
  animation: starRise 0.6s ease forwards;
  transform: scale(0);
}
@keyframes starRise {
  0% { transform: scale(0); opacity: 0; }
  70% { transform: scale(1.4); opacity: 1; }
  100% { transform: scale(1); opacity: 1; }
}
.star.inactive {
  color: #2c3550;
  filter: none;
  opacity: 0.3;
}

/* Detail jawaban */
#resultDetail {
  width: 100%;
  max-height: 320px;
  overflow-y: auto;
  background: rgba(5,15,35,0.8);
  border: 1px solid rgba(90,150,255,0.3);
  border-radius: 12px;
  padding: 16px;
  margin-top: 1rem;
  margin-bottom: 2rem;
  box-shadow: inset 0 0 25px rgba(50,100,255,0.3);
  z-index: 2;
  animation: fadeInUp 1.2s ease both;
}
#resultDetail::-webkit-scrollbar {
  width: 6px;
}
#resultDetail::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #2f5fa8, #1c3b6d);
  border-radius: 4px;
}

/* EXP hasil */
#expResult {
  font-family: 'Orbitron', sans-serif;
  font-size: 1.2rem;
  color: #71c9ff;
  text-shadow: 0 0 18px #3dd8ff;
  margin-bottom: 1.5rem;
  animation: fadeInUp 1.5s ease both;
}

/* Progress bar EXP */
.exp-bar {
  width: 100%;
  height: 14px;
  border-radius: 10px;
  background: rgba(30,60,120,0.4);
  overflow: hidden;
  margin-bottom: 2rem;
  box-shadow: 0 0 15px rgba(70,130,255,0.3);
}
.exp-fill {
  height: 100%;
  width: 0%;
  background: linear-gradient(90deg, #1cb4ff, #00ffd5);
  box-shadow: 0 0 15px #00eaff;
  animation: fillExp 2s ease forwards;
}
@keyframes fillExp {
  from { width: 0%; }
  to { width: 85%; } /* bisa disesuaikan sesuai nilai exp */
}

/* Tombol */
#resultBox button {
  position: relative;
  z-index: 2;
  font-family: 'Orbitron', sans-serif;
  letter-spacing: 1px;
  transition: all 0.3s ease;
}
#resultBox button:hover {
  transform: scale(1.08);
  box-shadow: 0 0 25px rgba(100,255,200,0.6);
}
#nextLevelBtn {
  background: linear-gradient(to right, #00aaff, #0055ff);
  border: 1px solid rgba(120,200,255,0.5);
  color: white;
  animation: pulseBtn 2s infinite;
}
#restartBtn {
  background: linear-gradient(to right, #1e2a78, #001a44);
  border: 1px solid rgba(140,140,255,0.5);
  color: #cfd4ff;
}
@keyframes pulseBtn {
  0%,100% { box-shadow: 0 0 15px rgba(80,180,255,0.5); }
  50% { box-shadow: 0 0 35px rgba(80,180,255,0.9); }
}

/* Animasi naik halus */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.back-btn {
     position: fixed;
      top: 20px;
      left: 30px;
      background: rgba(0,40,90,0.3);
      border: 1px solid rgba(90,150,255,0.4);
      padding: 14px 26px;
      border-radius: 14px;
      font-family: 'Orbitron', sans-serif;
      font-size: 14px;
      color: #a3d3fa;
      box-shadow: 0 0 25px rgba(0,150,255,0.4);
      backdrop-filter: blur(10px);
      display: none
}

.popup {
  display: none; /* default hidden */
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5); /* overlay gelap */
  justify-content: center;
  align-items: center;
  z-index: 5; /* pastikan di atas semua elemen lain */
}

.popup-content {
  background: #1f2937;
  padding: 30px;
  border-radius: 12px;
  text-align: center;
  box-shadow: 0 0 20px rgba(0,0,0,0.5);
  color: white;
  pointer-events: auto; /* tombol bisa diklik */
}


.popup-buttons button {
  margin: 10px;
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
}

#yesButton {
  color: white;
  background: rgba(0,40,90,0.3);
      border: 1px solid rgba(90,150,255,0.4);
}

#cancelButton {
  background-color: #ddd;
}

  </style>
</head>

<body class="flex flex-col items-center justify-center select-none">
  <audio id="bgMusic" loop>
      <source src="/audio/tegang.mp3" type="audio/mpeg">
      Browser kamu tidak mendukung audio.
  </audio>

   <!-- ✅ Tambahkan form tersembunyi di sini -->
 <form id="submitForm" method="POST" action="{{ route('level.submit', $id) }}" style="display:none;">
    @csrf
    <input type="hidden" name="bintang" id="inputBintang">
    <input type="hidden" name="exp" id="inputExp">
    <input type="hidden" name="id_level" value="{{ $id }}">
</form>

  <!-- ✅ Selesai form -->

  <canvas id="particles"></canvas>
  <img src="{{ asset('images/war.png') }}" alt="Logo" class="logo-bg">

  
  <div class="timer" id="timer"><span id="countdown">00:00</span></div>
  <div id="countdownStart" class="start-countdown"></div>
  <button id="backButton" class="back-btn">← Kembali</button>



  <div id="quiz" class="soal-container">
    <h1 class="text-3xl mb-6 text-center text-glow font-bold">Level {{ $id }}</h1>
    <div id="questionBox"></div>
    <button id="nextBtn" class="btn-next">Selanjutnya ➤</button>
  </div>

  <!-- HASIL -->
  <div id="resultBox" class="soal-container relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-[#0a1a3a] via-[#102b52] to-[#1c3b6d] opacity-80 rounded-2xl blur-xl"></div>
    
    <div class="relative z-10 flex flex-col items-center text-center">
      <h1 class="text-4xl mb-6 text-glow font-bold tracking-widest">🎯 EVALUASI MISI</h1>
      
      <div id="resultSummary" class="text-xl mb-6 font-semibold text-blue-200">
        Menganalisis hasil pertempuran...
      </div>

      <div id="starContainer" class="flex justify-center mb-6 space-x-3"></div>

      <div id="resultDetail" class="text-left w-full max-h-72 overflow-y-auto bg-[#0d1e3a]/40 rounded-xl p-4 mb-6 border border-blue-800 shadow-inner"></div>

      <div id="expResult" class="text-lg text-blue-300 font-orbitron mb-6"></div>

      <div class="flex space-x-6 mt-4">
        <button id="restartBtn" class="hidden px-6 py-3 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-900 border border-blue-400 text-white font-orbitron uppercase tracking-wide shadow-lg hover:scale-105 transition-all duration-300">
          🔁 Ulangi Level
        </button>
        <button id="nextLevelBtn" class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-800 border border-green-400 text-white font-orbitron uppercase tracking-wide shadow-lg hover:scale-105 transition-all duration-300">
          ➤ Lanjut Level Berikutnya
        </button>
      </div>
    </div>
  </div>
<div id="backPopup" class="popup">
  <div class="popup-content">
    <p class="mb-4 font-semibold text-lg">Apakah kamu yakin ingin kembali ke halaman preview?</p>
    <div class="popup-buttons flex justify-center">
      <button id="yesButton" class="px-6 py-2 rounded-lg bg-red-500 text-white mr-3">Iya</button>
      <button id="cancelButton" class="px-6 py-2 rounded-lg bg-gray-300 text-black">Batal</button>
    </div>
  </div>
</div>
<script>
  // Ambil data dari controller (Laravel)
  const soalData = @json($soalData);
  const durasiLevel = {{ $durasiLevel }};
  const currentLevelId = {{ $id }}; // <-- Pastikan ini ada!

  const quizBox = document.getElementById("quiz");
  const questionBox = document.getElementById("questionBox");
  const nextBtn = document.getElementById("nextBtn");
  const timerDiv = document.getElementById("timer");
  const backButton = document.getElementById("backButton"); // FIX: gunakan nama yang konsisten
  const backPopup = document.getElementById('backPopup');
  const yesButton = document.getElementById('yesButton');
  const cancelButton = document.getElementById('cancelButton');
  const countdownEl = document.getElementById("countdownStart");
  const timerDisplay = document.getElementById("countdown");
  const resultBox = document.getElementById("resultBox");
  const resultDetail = document.getElementById("resultDetail");
  const starContainer = document.getElementById("starContainer");
  const expResult = document.getElementById("expResult");
  const resultSummary = document.getElementById("resultSummary");
  const submitForm = document.getElementById('submitForm');
  const nextLevelBtn = document.getElementById("nextLevelBtn");
  const restartBtn = document.getElementById("restartBtn");

  let current = 0;
  let answers = {};
  let correctCount = 0;
  let timeLeft = {{ $durasiLevel }}; // <- ambil otomatis dari DB
  let timerInterval = null;

  /* -----------------------
     Utility: update timer UI
  ------------------------*/
  function updateTimer() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerDisplay.textContent = `${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
  }

  /* -----------------------
     Timer control: start/pause/resume
  ------------------------*/
  function startTimer() {
    timerDiv.style.display = "flex";
    updateTimer(); // penting: tampilkan waktu awal langsung

    // clear dulu kalau ada interval lama
    if (timerInterval) clearInterval(timerInterval);

    timerInterval = setInterval(() => {
      if (timeLeft > 0) {
        timeLeft--;
        updateTimer();
      } else {
        clearInterval(timerInterval);
        timerInterval = null;
        alert("⏰ Waktu untuk level ini habis!");
        showResult(); // panggil showResult saat habis
      }
    }, 1000);
  }

  function pauseTimer() {
    if (timerInterval) {
      clearInterval(timerInterval);
      timerInterval = null;
    }
  }

  function resumeTimer() {
    if (!timerInterval) {
      timerInterval = setInterval(() => {
        if (timeLeft > 0) {
          timeLeft--;
          updateTimer();
        } else {
          clearInterval(timerInterval);
          timerInterval = null;
          alert("⏰ Waktu untuk level ini habis!");
          showResult();
        }
      }, 1000);
    }
  }

  /* -----------------------
     Back button + popup (fix pointer/variable issues)
  ------------------------*/
  backButton.addEventListener('click', () => {
    backPopup.style.display = 'flex';
    pauseTimer();
  });

  cancelButton.addEventListener('click', () => {
    backPopup.style.display = 'none';
    resumeTimer();
  });

  yesButton.addEventListener('click', () => {
    // redirect ke peta level (ubah url kalau perlu)
    window.location.href = "/level/" + currentLevelId;
  });
  /* -----------------------
     Tampilkan soal
  ------------------------*/
  function showQuestion(index) {
    const soal = soalData[index];

    questionBox.innerHTML = `
      <p class="question">#${index + 1}. ${soal.q}</p>
      <div class="options-container">
        ${soal.a
          .map(
            (opt, i) =>
              `<div class="option-card" data-value="${opt}">
                ${String.fromCharCode(65 + i)}. ${opt}
              </div>`
          )
          .join("")}
      </div>
    `;

    nextBtn.style.display = "none";
    questionBox.classList.remove("slide-out");
    questionBox.classList.add("slide-in");

    document.querySelectorAll(".option-card").forEach((card) => {
      card.addEventListener("click", () => {
        document
          .querySelectorAll(".option-card")
          .forEach((c) => c.classList.remove("selected"));
        card.classList.add("selected");
        answers[current] = card.dataset.value;
        nextBtn.style.display = "inline-block";
      });
    });
  }

  /* -----------------------
     AJAX save ke server (fetch)
     - Menggunakan submitForm.action dan token dari form
  ------------------------*/
  async function simpanHasilKeDB(bintang, exp, benar) {
    try {
      // ambil token CSRF dari form hidden (generated by @csrf)
      const tokenInput = submitForm.querySelector('input[name="_token"]');
      const csrfToken = tokenInput ? tokenInput.value : '';

      // siapkan payload form data (sama seperti form submit biasa)
      const fd = new FormData();
      fd.append('bintang', bintang);
      fd.append('exp', exp);
      fd.append('benar', benar ?? 0);
      fd.append('id_level', submitForm.querySelector('input[name="id_level"]').value);

      const res = await fetch(submitForm.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        body: fd,
        credentials: 'same-origin'
      });

      if (!res.ok) {
        console.error('Gagal menyimpan hasil ke server (status ' + res.status + ')');
        return false;
      }

      console.log('✅ Hasil berhasil tersimpan otomatis');
      return true;
    } catch (err) {
      console.error('Error simpanHasilKeDB:', err);
      return false;
    }
  }

  /* -----------------------
     showResult: now async — simpan otomatis, lalu tampilkan hasil
  ------------------------*/
  async function showResult() {
  // 🕒 Simpan nilai timeLeft sebelum timer benar-benar dihentikan
  const safeTimeLeft = Number(timeLeft) || 0;

  // 🔹 Hentikan timer dulu
  clearInterval(timerInterval);
  pauseTimer();

  // 🔹 Sembunyikan elemen quiz
  quizBox.style.display = "none";
  timerDiv.style.display = "none";
  backButton.style.display = "none";
  resultBox.style.display = "flex";

  // 🔹 Hitung skor benar
  correctCount = soalData.filter((s, i) => answers[i] === s.correct).length;
  const total = soalData.length;
  resultSummary.textContent = `Kamu menjawab ${correctCount} dari ${total} soal dengan benar!`;

  // 🔹 Detail hasil per soal
  resultDetail.innerHTML = soalData
    .map((s, i) => {
      const isCorrect = answers[i] === s.correct;
      return `
        <p class="mb-2 ${isCorrect ? "text-green-400" : "text-red-400"}">
          <span class="font-semibold">#${i + 1}</span> ${s.q}<br>
          <span class="text-sm text-gray-300">
            Jawabanmu: ${answers[i] || "-"} | Benar: ${s.correct}
          </span>
        </p>`;
    })
    .join('<hr class="my-2 border-gray-700 opacity-40">');

  // 🔹 Hitung jumlah bintang
  let stars = 0;
  if (correctCount === 10) stars = 3;
  else if (correctCount >= 7) stars = 2;
  else if (correctCount >= 4) stars = 1;

  // 🔹 Tampilkan bintang
  starContainer.innerHTML = "";
  for (let i = 1; i <= 3; i++) {
    const starEl = document.createElement("span");
    starEl.classList.add("star");
    if (i > stars) starEl.classList.add("inactive");
    starEl.textContent = "★";
    starContainer.appendChild(starEl);
  }

  // 🕓 Hitung waktu pengerjaan
const totalDuration = Number(@json($durasiLevel)); // detik, dari DB
  let durationUsed = totalDuration - safeTimeLeft;
  if (durationUsed < 0) durationUsed = 0; // amanin dari nilai negatif

  const minutes = Math.floor(durationUsed / 60);
  const seconds = durationUsed % 60;

  // 🔹 Hitung EXP (baru dapet kalau ≥5 benar)
  let exp = 0;
  if (correctCount >= 5) {
    if (stars === 3) {
      exp = correctCount * 15 + Math.round(safeTimeLeft * 1);
    } else if (stars === 2) {
      exp = correctCount * 10 + Math.round(safeTimeLeft * 0.5);
    } else if (stars === 1) {
      exp = correctCount * 5 + Math.round(safeTimeLeft * 0.2);
    } else {
      exp = correctCount * 2;
    }
  }

  exp = Math.max(0, Math.floor(exp)); // jaga dari NaN / negatif
  expResult.textContent = `⌛ Waktu pengerjaan: ${minutes} menit ${seconds} detik | 🔥 EXP: +${exp}`;

  // 🔹 Feedback teks
  let feedbackText = "", feedbackColor = "";
  if (stars === 0) {
    feedbackText = "💀 LOSER 💀"; feedbackColor = "text-red-500";
  } else if (stars === 1) {
    feedbackText = "📘 Coba Belajar Lagi!"; feedbackColor = "text-yellow-400";
  } else if (stars === 2) {
    feedbackText = "💪 Baik! Tetap Belajar!"; feedbackColor = "text-blue-300";
  } else if (stars === 3) {
    feedbackText = "🏆 Kamu Hebat!"; feedbackColor = "text-green-400";
  }

  const feedbackEl = document.createElement("div");
  feedbackEl.className = `${feedbackColor} text-4xl font-orbitron font-bold mt-4 mb-6 animate-pulse drop-shadow-[0_0_20px_rgba(255,255,255,0.5)]`;
  feedbackEl.textContent = feedbackText;
  resultSummary.after(feedbackEl);

  // 🔹 Tampilkan tombol
  restartBtn.style.display = stars < 3 ? "inline-block" : "none";
  nextLevelBtn.style.display = stars >= 2 ? "inline-block" : "none";

  if (stars < 1) {
    resultSummary.innerHTML = `<span class="text-red-400 font-bold">⚠️ Kamu gagal menyelesaikan misi!</span><br>Coba lagi untuk membuka level berikutnya.`;
  }

  restartBtn.onclick = () => location.reload();

  // 🔹 Tombol kembali ke peta
  const backBtn = document.createElement("button");
  backBtn.textContent = "⬅️ Kembali ke Peta Level";
  backBtn.className = "px-6 py-3 bg-gray-700 text-white font-semibold rounded-xl hover:bg-gray-600 transition-all duration-200 shadow-lg";
  backBtn.onclick = () => window.location.href = "{{ route('level') }}";

  // 🔹 Bungkus tombol (sejajar)
  const buttonGroup = document.createElement("div");
  buttonGroup.className = "flex flex-row justify-center gap-4 mt-8";
  buttonGroup.appendChild(nextLevelBtn);
  buttonGroup.appendChild(restartBtn);
  buttonGroup.appendChild(backBtn);
  resultBox.appendChild(buttonGroup);

  // 🔹 Simpan otomatis ke DB
  await simpanHasilKeDB(stars, exp, correctCount);
}


  nextBtn.onclick = () => {
    current++;
    if (current < soalData.length) {
      questionBox.classList.add("slide-out");
      setTimeout(() => showQuestion(current), 400);
    } else {
      // FIX: clearInterval pada timerInterval (bukan timer)
      if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
      }
      // panggil showResult (async fine)
      showResult();
    }
  };

  /* -----------------------
     nextLevelBtn: tetap navigasi (tidak submit lagi)
     Ubah target URL sesuai kebutuhan (preview/next level).
     Di bawah gue arahkan ke preview level (sama seperti controller redirect).
  ------------------------*/
 nextLevelBtn.addEventListener('click', () => {
  const nextLevel = {{ $id }} + 1;
  if (nextLevel <= 20) {
    window.location.href = `/level/${nextLevel}`;
  } else {
    alert("🎉 Selamat! Semua level sudah selesai!");
  }
});


  /* -----------------------
     COUNTDOWN AWAL (tak berubah banyak)
  ------------------------*/
  const countdownVals = ["3", "2", "1", "GO!"];
  const beepShort = new Audio("https://actions.google.com/sounds/v1/alarms/beep_short.ogg");
  const beepLong = new Audio("https://cdn.pixabay.com/audio/2022/03/15/audio_34b52b59cf.mp3");

  async function playCountdown() {
    // Bagian countdown SFX biarkan seperti aslinya
    for (let i = 0; i < countdownVals.length; i++) {
      countdownEl.textContent = countdownVals[i];
      countdownEl.style.animation = "none";
      void countdownEl.offsetWidth;
      countdownEl.style.animation = "scalePop 1s ease";

      if (i < countdownVals.length - 1) {
        beepShort.currentTime = 0;
        await beepShort.play().catch(() => {});
        await new Promise((r) => setTimeout(r, 1000));
      } else {
        beepLong.currentTime = 0;
        await beepLong.play().catch(() => {});
        await new Promise((r) => setTimeout(r, 1500));
      }
    }

    countdownEl.style.display = "none";
    quizBox.style.display = "block";
    timerDiv.style.display = "flex";
    backButton.style.display = "flex";
    showQuestion(current);
    startTimer();

    // --- REVISI MULAI DI SINI ---

    const bgMusic = document.getElementById("bgMusic");

    // 1. Ambil setting volume dari Home (kunci: 'volume' dan 'muted')
    const savedVol = parseFloat(localStorage.getItem("volume"));
    const savedMute = localStorage.getItem("muted");

    // 2. Tentukan nilainya (dengan default 0.5 jika belum diset)
    const volume = !isNaN(savedVol) ? savedVol : 0.5;
    const muted = savedMute === "true"; // 'true' (string)

    // 3. Terapkan setting ke bgMusic
    bgMusic.volume = volume;
    bgMusic.muted = muted;

    // 4. Hanya putar musik jika tidak di-mute DAN volume > 0
    if (!bgMusic.muted && bgMusic.volume > 0) {
      bgMusic.play().catch(() => {
        console.error("Audio gagal diputar.");
      });
    }
    
    // --- SELESAI REVISI ---
  }
  window.onload = playCountdown;

  // === PARTIKEL LATAR === (tetap)
  const canvas = document.getElementById("particles");
  const ctx = canvas.getContext("2d");
  canvas.width = innerWidth;
  canvas.height = innerHeight;

  const particles = Array.from({ length: 90 }, () => ({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    size: Math.random() * 2.2,
    speedX: (Math.random() - 0.5) * 0.5,
    speedY: (Math.random() - 0.5) * 0.5,
  }));

  function drawParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = "rgba(255, 255, 255, 0.7)";
    particles.forEach((p) => {
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
      ctx.fill();
      p.x += p.speedX;
      p.y += p.speedY;
      if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
      if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
    });
    requestAnimationFrame(drawParticles);
  }
  drawParticles();
</script>

</body>
</html>