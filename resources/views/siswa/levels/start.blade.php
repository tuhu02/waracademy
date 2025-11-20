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
      overflow-y: auto;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    #particles {
      position: fixed; /* Ubah ke fixed agar background diam saat scroll */
      inset: 0;
      z-index: 0;
      pointer-events: none;
    }

    /* Animasi Slide */
    .slide-in { animation: slideIn 0.6s ease forwards; }
    .slide-out { animation: slideOut 0.6s ease forwards; }

    @keyframes slideIn {
      from { opacity: 0; transform: translateX(60px); filter: blur(6px); }
      to { opacity: 1; transform: translateX(0); filter: blur(0); }
    }
    @keyframes slideOut {
      from { opacity: 1; transform: translateX(0); filter: blur(0); }
      to { opacity: 0; transform: translateX(-60px); filter: blur(6px); }
    }

    .text-glow {
      text-shadow: 0 0 10px rgba(170,210,255,0.9), 0 0 25px rgba(90,150,255,0.6);
      font-family: 'Orbitron', sans-serif;
      letter-spacing: 1px;
      color: #dce6f2;
    }

    /* Container Soal Responsif */
    .soal-container {
      width: 95%;
      max-width: 850px;
      /* Margin top besar agar tidak ketabrak timer/tombol back di mobile */
      margin: 90px auto 40px auto; 
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 18px;
      box-shadow: 0 0 25px rgba(80,130,255,0.3);
      backdrop-filter: blur(12px);
      padding: 20px; /* Padding mobile default */
      display: none;
      position: relative;
      z-index: 2;
      min-height: 60vh;
      animation: fadeIn 0.8s ease forwards;
    }
    
    /* Padding lebih besar di desktop */
    @media (min-width: 768px) {
      .soal-container {
        width: 90%;
        margin: 60px auto;
        padding: 32px;
        min-height: 70vh;
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .question {
      font-size: 1rem; /* Mobile text size */
      margin-bottom: 20px;
      text-align: center;
      font-weight: 600;
      text-shadow: 0 0 8px rgba(90,150,255,0.6);
      line-height: 1.5;
    }
    @media (min-width: 768px) {
      .question { font-size: 1.3rem; }
    }

    .option-card {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 12px 14px;
      margin: 10px 0;
      cursor: pointer;
      transition: all 0.25s ease;
      box-shadow: 0 0 10px rgba(0,100,255,0.15);
      font-size: 0.9rem;
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
      transform: scale(1.02);
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
      width: 100%; /* Full width di mobile */
    }
    @media(min-width: 768px) {
        .btn-next { width: auto; }
    }

    .btn-next:hover {
      background: linear-gradient(to bottom, #3d6fc0, #14386d);
      transform: scale(1.05);
      box-shadow: 0 0 30px rgba(100,150,255,0.6);
    }

    /* Timer & Back Button Responsif */
    .timer, .back-btn {
      position: fixed;
      top: 15px;
      z-index: 50;
      background: rgba(0,40,90,0.6);
      border: 1px solid rgba(90,150,255,0.4);
      padding: 8px 14px;
      border-radius: 10px;
      font-family: 'Orbitron', sans-serif;
      font-size: 0.9rem;
      color: #a3d3fa;
      box-shadow: 0 0 15px rgba(0,150,255,0.4);
      backdrop-filter: blur(10px);
      display: none;
    }
    
    .timer { right: 15px; }
    .back-btn { left: 15px; }

    /* Desktop styles untuk header buttons */
    @media (min-width: 768px) {
      .timer, .back-btn {
        top: 20px;
        padding: 14px 26px;
        border-radius: 14px;
        font-size: 1.2rem;
      }
      .timer { right: 30px; }
      .back-btn { left: 30px; }
    }

    .start-countdown {
      position: fixed;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      font-family: 'Orbitron', sans-serif;
      font-size: 4rem; /* Mobile size */
      color: #6aa8fa;
      text-shadow: 0 0 30px #6aa8fa, 0 0 60px #1e3a8a;
      opacity: 0;
      animation: scalePop 1s ease forwards;
      z-index: 10;
      text-align: center;
      width: 100%;
    }
    @media (min-width: 768px) {
        .start-countdown { font-size: 6rem; }
    }

    @keyframes scalePop {
      0% { transform: translate(-50%, -50%) scale(0.3); opacity: 0; }
      50% { opacity: 1; transform: translate(-50%, -50%) scale(1.3); }
      100% { opacity: 0; transform: translate(-50%, -50%) scale(1); }
    }

    .logo-bg {
      position: fixed; /* Ubah ke fixed */
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.05;
      height: auto; width: 80%; /* Responsive width */
      max-width: 400px;
      pointer-events: none;
      z-index: 0;
    }

    /* === HASIL / EVALUASI === */
    #resultBox {
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      /* Gunakan min-height flexibel */
      min-height: 80vh; 
      position: relative;
      overflow: hidden;
      background: radial-gradient(circle at center, rgba(15,30,60,0.95), rgba(5,10,25,0.98));
      border: 1px solid rgba(120,170,255,0.25);
      border-radius: 20px;
      animation: fadeIn 0.8s ease forwards;
    }

    #resultBox h1 {
      font-family: 'Orbitron', sans-serif;
      font-size: 1.8rem;
      color: #b9d7ff;
      margin-bottom: 1rem;
      z-index: 2;
    }
    @media (min-width: 768px) {
        #resultBox h1 { font-size: 2.5rem; margin-bottom: 1.5rem; }
    }

    #resultSummary {
      font-size: 1rem;
      color: #a7d8ff;
      margin-bottom: 1rem;
      background: rgba(15,35,75,0.6);
      border: 1px solid rgba(100,160,255,0.3);
      padding: 10px 16px;
      border-radius: 10px;
      animation: fadeInUp 1s ease both;
    }
    @media (min-width: 768px) {
        #resultSummary { font-size: 1.4rem; padding: 12px 24px; margin-bottom: 1.5rem; }
    }

    .star {
      font-size: 2.5rem;
      color: gold;
      filter: drop-shadow(0 0 20px gold);
      animation: starRise 0.6s ease forwards;
      transform: scale(0);
    }
    @media (min-width: 768px) {
        .star { font-size: 3.5rem; }
    }

    @keyframes starRise {
      0% { transform: scale(0); opacity: 0; }
      70% { transform: scale(1.4); opacity: 1; }
      100% { transform: scale(1); opacity: 1; }
    }
    .star.inactive {
      color: #2c3550; filter: none; opacity: 0.3;
    }

    #resultDetail {
      width: 100%;
      max-height: 250px;
      overflow-y: auto;
      background: rgba(5,15,35,0.8);
      border: 1px solid rgba(90,150,255,0.3);
      border-radius: 12px;
      padding: 12px;
      margin-top: 0.5rem;
      margin-bottom: 1.5rem;
      box-shadow: inset 0 0 25px rgba(50,100,255,0.3);
      z-index: 2;
      font-size: 0.85rem;
    }
    @media (min-width: 768px) {
        #resultDetail { max-height: 320px; padding: 16px; font-size: 1rem; }
    }

    #expResult {
      font-family: 'Orbitron', sans-serif;
      font-size: 1rem;
      color: #71c9ff;
      margin-bottom: 1.5rem;
    }
    @media (min-width: 768px) { #expResult { font-size: 1.2rem; } }

    /* Tombol di Result Box */
    #resultBox button {
      font-family: 'Orbitron', sans-serif;
      letter-spacing: 1px;
      transition: all 0.3s ease;
      width: 100%; /* Full width di mobile */
      margin-bottom: 10px;
    }
    @media (min-width: 768px) {
        #resultBox button { width: auto; margin-bottom: 0; }
    }

    /* Popup Styling */
    .popup {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.8);
      justify-content: center;
      align-items: center;
      z-index: 100;
      padding: 20px;
    }

    .popup-content {
      background: #1f2937;
      padding: 24px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 0 25px rgba(90,150,255,0.3);
      color: white;
      max-width: 400px;
      width: 100%;
      border: 1px solid rgba(90,150,255,0.2);
    }

    #yesButton, #cancelButton {
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.2s;
    }
    #yesButton { background: #ef4444; color: white; }
    #cancelButton { background: #374151; color: white; }
  </style>
</head>

<body class="flex flex-col items-center justify-center select-none">
  <audio id="bgMusic" loop>
      <source src="/audio/tegang.mp3" type="audio/mpeg">
  </audio>

 <form id="submitForm" method="POST" action="{{ route('level.submit', $id) }}" style="display:none;">
    @csrf
    <input type="hidden" name="bintang" id="inputBintang">
    <input type="hidden" name="exp" id="inputExp">
    <input type="hidden" name="id_level" value="{{ $id }}">
</form>

  <canvas id="particles"></canvas>
  <img src="{{ asset('images/war.png') }}" alt="Logo" class="logo-bg">

  <div class="timer" id="timer"><span id="countdown">00:00</span></div>
  <button id="backButton" class="back-btn">← <span class="hidden md:inline">Kembali</span></button>

  <div id="countdownStart" class="start-countdown"></div>

  <div id="quiz" class="soal-container">
    <h1 class="text-xl md:text-3xl mb-4 md:mb-6 text-center text-glow font-bold">Level {{ $id }}</h1>
    <div id="questionBox"></div>
    <button id="nextBtn" class="btn-next">Selanjutnya ➤</button>
  </div>

  <div id="resultBox" class="soal-container">
    <div class="absolute inset-0 bg-gradient-to-br from-[#0a1a3a] via-[#102b52] to-[#1c3b6d] opacity-80 blur-xl"></div>
    
    <div class="relative z-10 flex flex-col items-center text-center w-full">
      <h1 class="text-2xl md:text-4xl mb-4 md:mb-6 text-glow font-bold tracking-widest">🎯 EVALUASI MISI</h1>
      
      <div id="resultSummary" class="font-semibold text-blue-200">
        Menganalisis hasil...
      </div>

      <div id="starContainer" class="flex justify-center mb-4 space-x-2 md:space-x-3"></div>

      <div id="resultDetail" class="custom-scrollbar"></div>

      <div id="expResult" class="text-blue-300 font-orbitron"></div>

      <div class="flex flex-col md:flex-row gap-3 md:gap-6 mt-4 w-full justify-center items-center">
        <button id="restartBtn" class="hidden px-6 py-3 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-900 border border-blue-400 text-white font-orbitron uppercase tracking-wide shadow-lg hover:scale-105">
          🔁 Ulangi
        </button>
        <button id="nextLevelBtn" class="hidden px-6 py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-800 border border-green-400 text-white font-orbitron uppercase tracking-wide shadow-lg hover:scale-105">
          ➤ Lanjut Level
        </button>
        </div>
    </div>
  </div>

  <div id="backPopup" class="popup">
    <div class="popup-content">
      <p class="mb-6 font-semibold text-lg">Yakin ingin keluar dari pertempuran?</p>
      <div class="flex justify-center gap-4">
        <button id="yesButton">Ya, Keluar</button>
        <button id="cancelButton">Batal</button>
      </div>
    </div>
  </div>

<script>
  const soalData = @json($soalData);
  const durasiLevel = {{ $durasiLevel }};
  const currentLevelId = {{ $id }}; 

  const quizBox = document.getElementById("quiz");
  const questionBox = document.getElementById("questionBox");
  const nextBtn = document.getElementById("nextBtn");
  const timerDiv = document.getElementById("timer");
  const backButton = document.getElementById("backButton");
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
  let timeLeft = {{ $durasiLevel }}; 
  let timerInterval = null;

  function updateTimer() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerDisplay.textContent = `${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
    
    // Visual effect low time
    if(timeLeft <= 10) timerDiv.style.color = "#ef4444";
  }

  function startTimer() {
    timerDiv.style.display = "block"; // Changed from flex to block to respect CSS
    updateTimer();
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(() => {
      if (timeLeft > 0) {
        timeLeft--;
        updateTimer();
      } else {
        clearInterval(timerInterval);
        timerInterval = null;
        alert("⏰ Waktu Habis!");
        showResult();
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
    if (!timerInterval && timeLeft > 0) {
      startTimer();
    }
  }

  backButton.addEventListener('click', () => {
    backPopup.style.display = 'flex';
    pauseTimer();
  });

  cancelButton.addEventListener('click', () => {
    backPopup.style.display = 'none';
    resumeTimer();
  });

  yesButton.addEventListener('click', () => {
    window.location.href = "/level/" + currentLevelId;
  });

  function showQuestion(index) {
    const soal = soalData[index];
    questionBox.innerHTML = `
      <p class="question">#${index + 1}. ${soal.q}</p>
      <div class="w-full">
        ${soal.a.map((opt, i) => 
          `<div class="option-card" data-value="${opt}">
             <span class="font-bold text-blue-300 mr-2">${String.fromCharCode(65 + i)}.</span> ${opt}
           </div>`
        ).join("")}
      </div>
    `;

    nextBtn.style.display = "none";
    questionBox.classList.remove("slide-out");
    questionBox.classList.add("slide-in");

    document.querySelectorAll(".option-card").forEach((card) => {
      card.addEventListener("click", () => {
        document.querySelectorAll(".option-card").forEach((c) => c.classList.remove("selected"));
        card.classList.add("selected");
        answers[current] = card.dataset.value;
        nextBtn.style.display = "inline-block"; // Will follow CSS media query width
      });
    });
  }

  async function simpanHasilKeDB(bintang, exp, benar) {
    try {
      const tokenInput = submitForm.querySelector('input[name="_token"]');
      const csrfToken = tokenInput ? tokenInput.value : '';
      const fd = new FormData();
      fd.append('bintang', bintang);
      fd.append('exp', exp);
      fd.append('benar', benar ?? 0);
      fd.append('id_level', submitForm.querySelector('input[name="id_level"]').value);

      const res = await fetch(submitForm.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: fd,
        credentials: 'same-origin'
      });
      if (!res.ok) return false;
      return true;
    } catch (err) {
      return false;
    }
  }

  async function showResult() {
    const safeTimeLeft = Number(timeLeft) || 0;
    clearInterval(timerInterval);
    pauseTimer();

    quizBox.style.display = "none";
    timerDiv.style.display = "none";
    backButton.style.display = "none";
    resultBox.style.display = "flex"; // This enables flex layout for centering

    correctCount = soalData.filter((s, i) => answers[i] === s.correct).length;
    const total = soalData.length;
    resultSummary.textContent = `Skor: ${correctCount} / ${total} Benar`;

    resultDetail.innerHTML = soalData.map((s, i) => {
      const isCorrect = answers[i] === s.correct;
      return `
        <div class="mb-3 p-3 rounded bg-slate-900/50 border border-slate-700">
          <p class="mb-1 font-medium text-gray-200 text-sm md:text-base">#${i + 1}. ${s.q}</p>
          <div class="flex justify-between text-xs md:text-sm">
             <span class="${isCorrect ? 'text-green-400' : 'text-red-400'}">Jawab: ${answers[i] || "-"}</span>
             <span class="text-blue-400">Kunci: ${s.correct}</span>
          </div>
        </div>`;
    }).join('');

    let stars = 0;
    if (correctCount === 10) stars = 3;
    else if (correctCount >= 7) stars = 2;
    else if (correctCount >= 4) stars = 1;

    starContainer.innerHTML = "";
    for (let i = 1; i <= 3; i++) {
      const starEl = document.createElement("span");
      starEl.classList.add("star");
      if (i > stars) starEl.classList.add("inactive");
      starEl.textContent = "★";
      starContainer.appendChild(starEl);
    }

    const totalDuration = Number(@json($durasiLevel));
    let durationUsed = totalDuration - safeTimeLeft;
    if (durationUsed < 0) durationUsed = 0;

    const minutes = Math.floor(durationUsed / 60);
    const seconds = durationUsed % 60;

    let exp = 0;
    if (correctCount >= 5) {
      if (stars === 3) exp = correctCount * 15 + Math.round(safeTimeLeft * 1);
      else if (stars === 2) exp = correctCount * 10 + Math.round(safeTimeLeft * 0.5);
      else if (stars === 1) exp = correctCount * 5 + Math.round(safeTimeLeft * 0.2);
      else exp = correctCount * 2;
    }
    exp = Math.max(0, Math.floor(exp));
    
    expResult.innerHTML = `<i class="fa-solid fa-clock"></i> ${minutes}m ${seconds}d &nbsp;|&nbsp; <i class="fa-solid fa-bolt"></i> +${exp} EXP`;

    let feedbackText = "", feedbackColor = "";
    if (stars === 0) { feedbackText = "GAGAL"; feedbackColor = "text-red-500"; }
    else if (stars === 1) { feedbackText = "CUKUP"; feedbackColor = "text-yellow-400"; }
    else if (stars === 2) { feedbackText = "BAGUS!"; feedbackColor = "text-blue-300"; }
    else if (stars === 3) { feedbackText = "SEMPURNA!"; feedbackColor = "text-green-400"; }

    const feedbackEl = document.createElement("div");
    feedbackEl.className = `${feedbackColor} text-3xl md:text-4xl font-orbitron font-bold my-2 animate-pulse`;
    feedbackEl.textContent = feedbackText;
    resultSummary.after(feedbackEl);

    // Logic Button Visibility
    restartBtn.style.display = stars < 3 ? "inline-block" : "none";
    // Jika di mobile, display harus block/inline-block, layout diatur parent flex
    restartBtn.classList.remove('hidden'); 
    
    if(stars >= 2) {
        nextLevelBtn.classList.remove('hidden');
        nextLevelBtn.style.display = "inline-block";
    } else {
        nextLevelBtn.style.display = "none";
    }

    if (stars < 1) {
      resultSummary.innerHTML += `<br><span class="text-red-400 text-sm">Minimal bintang 1 untuk lanjut.</span>`;
    }

    restartBtn.onclick = () => location.reload();

    // Tombol Kembali ke Peta (Dynamic)
    const backBtn = document.createElement("button");
    backBtn.innerHTML = "⬅ Peta";
    backBtn.className = "px-6 py-3 bg-gray-700 text-white font-semibold rounded-xl hover:bg-gray-600 transition-all duration-200 shadow-lg font-orbitron uppercase tracking-wide w-full md:w-auto";
    backBtn.onclick = () => window.location.href = "{{ route('level') }}";
    
    // Append ke grup tombol
    const btnGroup = nextLevelBtn.parentElement;
    btnGroup.appendChild(backBtn);

    await simpanHasilKeDB(stars, exp, correctCount);
  }

  nextBtn.onclick = () => {
    current++;
    if (current < soalData.length) {
      questionBox.classList.add("slide-out");
      setTimeout(() => {
          showQuestion(current); 
          questionBox.classList.remove("slide-out");
      }, 300);
    } else {
      if (timerInterval) clearInterval(timerInterval);
      showResult();
    }
  };

  nextLevelBtn.addEventListener('click', () => {
    const nextLevel = {{ $id }} + 1;
    if (nextLevel <= 20) {
      window.location.href = `/level/${nextLevel}`;
    } else {
      alert("🎉 Selamat! Semua level sudah selesai!");
    }
  });

  // --- COUNTDOWN & INIT ---
  const countdownVals = ["3", "2", "1", "GO!"];
  const beepShort = new Audio("https://actions.google.com/sounds/v1/alarms/beep_short.ogg");
  const beepLong = new Audio("https://cdn.pixabay.com/audio/2022/03/15/audio_34b52b59cf.mp3");

  async function playCountdown() {
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
        await new Promise((r) => setTimeout(r, 1000));
      }
    }

    countdownEl.style.display = "none";
    quizBox.style.display = "block"; 
    timerDiv.style.display = "block";
    backButton.style.display = "block";
    showQuestion(current);
    startTimer();

    // Music Logic
    const bgMusic = document.getElementById("bgMusic");
    const savedVol = parseFloat(localStorage.getItem("volume"));
    const savedMute = localStorage.getItem("muted");
    const volume = !isNaN(savedVol) ? savedVol : 0.5;
    const muted = savedMute === "true";

    bgMusic.volume = volume;
    bgMusic.muted = muted;

    if (!bgMusic.muted && bgMusic.volume > 0) {
      bgMusic.play().catch(() => console.log("Audio play prevented"));
    }
  }
  window.onload = playCountdown;

  // --- PARTICLES ---
  const canvas = document.getElementById("particles");
  const ctx = canvas.getContext("2d");
  
  function resizeCanvas() {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
  }
  window.addEventListener('resize', resizeCanvas);
  resizeCanvas();

  const particles = Array.from({ length: 80 }, () => ({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    size: Math.random() * 2,
    speedX: (Math.random() - 0.5) * 0.5,
    speedY: (Math.random() - 0.5) * 0.5,
  }));

  function drawParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = "rgba(255, 255, 255, 0.6)";
    particles.forEach((p) => {
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
      ctx.fill();
      p.x += p.speedX;
      p.y += p.speedY;
      
      // Wrap around
      if (p.x < 0) p.x = canvas.width;
      if (p.x > canvas.width) p.x = 0;
      if (p.y < 0) p.y = canvas.height;
      if (p.y > canvas.height) p.y = 0;
    });
    requestAnimationFrame(drawParticles);
  }
  drawParticles();
</script>

</body>
</html>