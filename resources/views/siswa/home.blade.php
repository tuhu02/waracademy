<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Utama (Siswa) | WarAcademy</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        poppins: ['Poppins', 'sans-serif'],
                        blackops: ['"Black Ops One"', 'sans-serif']
                    }
                }
            }
        }
  </script>
</head>

<body class="font-poppins relative bg-gradient-to-b from-[#0f1b2e] via-[#304863] to-[#3b5875] min-h-screen flex flex-col justify-between p-6 text-white overflow-hidden select-none">

  {{-- Sidebar Hamburger --}}
  @include('siswa.sidebar')

  <!-- MUSIC BACKGROUND -->

<audio id="bgMusic" loop>
    <source src="/audio/sound.mp3" type="audio/mpeg">
</audio>
  <!-- CANVAS PARTIKEL -->
  <canvas id="particles" class="absolute inset-0 z-0"></canvas>

  <!-- LOGO LATAR TRANSPARAN -->
  <img src="/images/war.png" alt="Logo" 
     style="
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(1.5);
        height: 300px;
        opacity: 0.05;
        pointer-events: none;
        z-index: 0;
        mix-blend-mode: lighten;
     ">

  <!-- HEADER -->
  <div class="relative w-full text-center animate-fadeInDown z-10">
    <h1 class="font-blackops text-3xl md:text-4xl font-extrabold bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(70,150,255,0.6)]">
      Menu Utama
    </h1>

    <!-- Profile -->
    <div x-data="{ open: false }" class="absolute right-0 top-0 flex items-center space-x-2">
      <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
        <span class="text-white/90 font-medium">{{ session('pengguna_username') ?? 'Nama' }}</span>
        <div class="w-8 h-8 border-2 border-[#6aa8fa] rounded-full bg-white/20 shadow-sm backdrop-blur-sm"></div>
      </button>

      <!-- Dropdown -->
      <div x-show="open" @click.away="open = false"
          x-transition
          class="absolute right-0 mt-12 w-40 bg-white/90 border border-gray-200 rounded-lg shadow-lg py-2 text-sm z-20">
          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" 
                  class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                  Logout
              </button>
          </form>
      </div>
    </div>
  </div>

  <!-- MAIN SECTION -->
  <div class="flex-1 relative flex justify-center items-center z-10">
    <div class="absolute top-0 left-0 mt-6 ml-6 text-center animate-slideInLeft delay-200">
      <div class="border border-[#6aa8fa]/60 rounded-xl w-44 h-40 p-4 bg-white/10 backdrop-blur-md shadow-lg hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] transition duration-300">
        <h2 class="font-semibold text-[#cfe4ff] mb-3 drop-shadow-sm">Achievement</h2>
        <div class="space-y-2 text-blue-100">
          <div class="w-28 h-1 bg-blue-300/60 rounded"></div>
          <div class="w-32 h-1 bg-blue-200/60 rounded"></div>
          <div class="w-24 h-1 bg-blue-200/50 rounded"></div>
        </div>
      </div>
    </div>

    <div class="flex items-center space-x-12">
      <div class="relative animate-slideInRight delay-300 group" style="width: 240px; height: 240px;">
          <a href="{{ route('level') }}" class="w-full h-full flex flex-col items-center justify-center text-2xl font-semibold 
                      bg-white/10 border border-[#6aa8fa]/60 rounded-xl backdrop-blur-md
                      shadow-lg hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] hover:bg-white/20
                      transition-all duration-300 transform group-hover:scale-105">
              <span class="text-6xl mb-3 drop-shadow-lg">🚀</span>
              <span>Level</span>
          </a>
      </div>

      <div class="relative animate-slideInRight delay-400 group" style="width: 240px; height: 240px;">
          <a href="{{ route('tournament') }}" class="w-full h-full flex flex-col items-center justify-center text-2xl font-semibold 
                      bg-white/10 border border-[#6aa8fa]/60 rounded-xl backdrop-blur-md
                      shadow-lg hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] hover:bg-white/20
                      transition-all duration-300 transform group-hover:scale-105">
              <span class="text-6xl mb-3 drop-shadow-lg">🏆</span>
              <span>Tournament</span>
          </a>
      </div>
    </div>
  </div>

  <!-- FOOTER BUTTONS -->
  <div class="flex justify-between items-end animate-slideInUp delay-500 z-10 relative" 
       x-data="{ showSetting: false, volume: 0.5, muted: false }" 
       x-init="
          const savedVol = localStorage.getItem('volume');
          const savedMute = localStorage.getItem('muted');
          if(savedVol) volume = parseFloat(savedVol);
          if(savedMute) muted = savedMute === 'true';
          const audio = document.getElementById('bgMusic');
          audio.volume = volume;
          if(!muted) audio.play();
       ">

    <!-- SETTING BUTTON -->
    <div class="relative">
      <button @click="showSetting = !showSetting" 
              class="flex items-center gap-2 bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm transition transform hover:scale-105">
        ⚙️ Setting
      </button>

      <!-- DROPDOWN -->
      <div x-show="showSetting" 
           @click.away="showSetting = false"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 translate-y-3 scale-95"
           x-transition:enter-end="opacity-100 translate-y-0 scale-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 translate-y-0 scale-100"
           x-transition:leave-end="opacity-0 translate-y-2 scale-95"
           class="absolute bottom-full mb-4 left-0 w-72 bg-white/95 text-gray-800 rounded-2xl shadow-2xl border border-gray-300/70 
                  p-5 text-sm backdrop-blur-xl z-30 origin-bottom-left">

          <h3 class="font-semibold text-gray-700 mb-2">🎵 Pengaturan Suara</h3>
          
          <!-- Toggle Musik -->
          <div class="flex justify-between items-center mb-3">
            <span>Musik</span>
            <button @click="
                muted = !muted;
                const audio = document.getElementById('bgMusic');
                if(muted){ audio.pause(); } else { audio.play(); }
                localStorage.setItem('muted', muted);
             "
             class="px-3 py-1 rounded-md font-semibold transition"
             :class="muted ? 'bg-red-500 text-white' : 'bg-green-500 text-white'">
              <span x-text="muted ? 'Mati' : 'Hidup'"></span>
            </button>
          </div>

          <!-- Slider Volume -->
          <label class="block mb-1 text-gray-700 font-medium">Volume</label>
          <input type="range" min="0" max="1" step="0.01" x-model="volume"
                 @input="
                    const audio = document.getElementById('bgMusic');
                    audio.volume = volume;
                    localStorage.setItem('volume', volume);
                 "
                 class="w-full accent-blue-600 cursor-pointer">
      </div>
    </div>

    <!-- TOP 100 -->
    <button class="relative bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white px-6 py-2 rounded-xl font-semibold 
                  border border-[#1b3e75]
                  shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)]
                  hover:scale-105 hover:shadow-[0_0_20px_rgba(70,150,255,0.7)]
                  transition-all duration-300 ease-in-out overflow-hidden group">
      <span class="relative z-10">🏆 Top 100</span>
      <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                    translate-x-[-100%] group-hover:translate-x-[100%] 
                    transition-transform duration-700"></span>
    </button>
  </div>

  <!-- Cahaya kecil -->
  <div class="absolute right-8 bottom-6 w-4 h-4 rounded-full bg-white/80 blur-[2px] shadow-[0_0_25px_rgba(255,255,255,0.6)] animate-pulseLight"></div>

  <!-- STYLE ANIMASI -->
  <style>
    @keyframes slideInLeft { 0% { opacity: 0; transform: translateX(-40px); } 100% { opacity: 1; transform: translateX(0); } }
    @keyframes slideInRight { 0% { opacity: 0; transform: translateX(40px); } 100% { opacity: 1; transform: translateX(0); } }
    @keyframes slideInUp { 0% { opacity: 0; transform: translateY(40px); } 100% { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { 0% { opacity: 0; } 100% { opacity: 1; } }
    @keyframes pulseLight { 0%,100% { opacity: 0.7; transform: scale(1); } 50% { opacity: 1; transform: scale(1.3); } }

    .animate-slideInLeft { animation: slideInLeft 0.6s ease-out forwards; }
    .animate-slideInRight { animation: slideInRight 0.6s ease-out forwards; }
    .animate-slideInUp { animation: slideInUp 0.6s ease-out forwards; }
    .animate-fadeInDown { animation: fadeInDown 1s ease-out forwards; }
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
    .animate-pulseLight { animation: pulseLight 3s ease-in-out infinite; }

    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
  </style>

  <!-- SCRIPT PARTIKEL -->
  <script>
    const audio = document.getElementById('bgMusic');

    // Fungsi fade out
    function fadeOutAudio(audio, duration, callback) {
      const step = 50; 
      const fadeAmount = audio.volume / (duration / step);
      const fadeInterval = setInterval(() => {
        if (audio.volume - fadeAmount > 0) {
          audio.volume -= fadeAmount;
        } else {
          audio.volume = 0;
          clearInterval(fadeInterval);
          audio.pause();
          if (callback) callback();
        }
      }, step);
    }

    // Tambahkan efek fade-out pada tombol navigasi
    document.querySelectorAll('a[href]').forEach(link => {
      link.addEventListener('click', e => {
        const href = link.getAttribute('href');
        if (href.startsWith('http') || href.startsWith('#')) return; // skip eksternal

        e.preventDefault(); // hentikan pindah halaman dulu
        fadeOutAudio(audio, 1500, () => {
          window.location.href = href; // pindah halaman setelah fade out selesai
        });
      });
    });

    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    canvas.width = innerWidth;
    canvas.height = innerHeight;

    const particles = Array.from({ length: 60 }, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      size: Math.random() * 2,
      speedX: (Math.random() - 0.5) * 0.4,
      speedY: (Math.random() - 0.5) * 0.4,
    }));

    function drawParticles() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
      particles.forEach(p => {
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

    window.addEventListener('resize', () => {
      canvas.width = innerWidth;
      canvas.height = innerHeight;
    });
  </script>
</body>
</html>
