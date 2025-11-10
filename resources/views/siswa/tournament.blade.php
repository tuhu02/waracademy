<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournament | WarAcademy</title>

  <!-- Fonts & Tailwind -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap"
    rel="stylesheet">
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

<body
  class="relative font-poppins min-h-screen flex flex-col justify-between p-4 md:p-6 text-white overflow-x-hidden select-none"
  style="background-image: url('/images/tournament.png');
             background-size: cover;
             background-position: center;
             background-repeat: no-repeat;
             background-attachment: fixed;">
  <!-- Background music (autoplay muted per browser policy, unmute on user interaction) -->
  <audio id="bgMusic" src="{{ asset('audio/sound.mp3') }}" preload="auto" loop muted autoplay></audio>

  <!-- Overlay gelap (atur opacity di sini) -->
  <div id="overlay" class="absolute inset-0 bg-gradient-to-b from-[#0f1b2e]/0 via-[#304863]/0 to-[#3b5875]/0 
            opacity-0 z-0 transition-all duration-[2000ms] ease-in-out"></div>

  <!-- Canvas Partikel -->
  <canvas id="particles" class="absolute inset-0 z-0"></canvas>

  <!-- Header -->
  <header class="relative w-full text-center md:animate-fadeInDown mb-4 md:mb-0" style="z-index:2147483645;">
  <div x-data="{ open:false }" @keydown.window.escape="open=false" x-effect="$watch('open', v => { document.documentElement.style.overflow = v ? 'hidden' : ''; })" class="fixed inset-0 md:hidden pointer-events-none" style="z-index:2147483646;">
    <!-- Tombol hamburger -->
  <button @click="open = !open" class="absolute left-3 top-3 p-2 bg-[#0b1120] text-white rounded-lg shadow-md focus:outline-none pointer-events-auto">
      <template x-if="!open">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </template>
      <template x-if="open">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 18L18 6M6 6l12 12" />
        </svg>
      </template>
    </button>

    <!-- Overlay (penutup layar belakang) -->
    <div
      x-show="open"
      @click="open=false"
  class="fixed inset-0 bg-black/60 pointer-events-auto" style="z-index:2147483646;"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0">
    </div>

    <!-- Sidebar -->
  <div
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 h-screen w-64 bg-[#0b1120]/100 text-white shadow-2xl flex flex-col pt-5 pb-5 pl-5 pr-10 space-y-4 md:border-r md:border-[#6aa8fa]/30 backdrop-blur-none md:backdrop-blur-md pointer-events-auto isolate"
    style="background-color: #0b1120 !important; backdrop-filter: none !important; -webkit-backdrop-filter: none !important; z-index:2147483647;"
  >
      <!-- Close button -->
      <button @click="open=false" aria-label="Close menu" class="absolute top-3 right-3 p-2 rounded-md bg-white/10 hover:bg-white/20 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <h2 class="text-2xl font-bold mb-4 border-b border-gray-600 pb-2">Menu</h2>
      <a href="#" class="flex items-center space-x-2 hover:text-blue-400">
        <span>⚙️</span>
        <span>Setting</span>
      </a>
      <a href="#" class="flex items-center space-x-2 hover:text-blue-400">
        <span>🏆</span>
        <span>Leaderboard</span>
      </a>
    </div>
  </div>

    <h1 class="font-blackops text-2xl md:text-4xl font-extrabold bg-gradient-to-b 
               from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent 
               drop-shadow-[0_0_15px_rgba(70,150,255,0.6)] mb-2 md:mb-0">
      Tournament
    </h1>

    <!-- Profil Dropdown -->
    <div x-data="{ open: false }" class="absolute right-0 top-0 flex items-center space-x-2">
      <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
        <span class="text-white/90 font-medium text-sm md:text-base max-w-[120px] md:max-w-[180px] truncate inline-block align-middle">{{ session('pengguna_username') ?? 'Nama' }}</span>
        <div class="w-6 h-6 md:w-8 md:h-8 border-2 border-[#6aa8fa] rounded-full bg-white/20 
                    shadow-sm backdrop-blur-sm"></div>
      </button>

      <!-- Dropdown Menu -->
      <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-10 md:mt-12 w-32 md:w-40 bg-white/90 border border-gray-200 
                  rounded-lg shadow-lg py-2 text-xs md:text-sm z-20">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="block w-full text-left px-3 md:px-4 py-2 text-red-600 hover:bg-red-50">
            Logout
          </button>
        </form>
      </div>
    </div>
  </header>

  <!-- Main Section -->
  <main class="flex-1 relative flex flex-col md:flex-row justify-center items-center z-10 mt-4 md:mt-0 gap-6 md:gap-0">

    <!-- Daftar turnament yang di ikuti - PERBAIKAN: HAPUS SCROLL MOBILE -->
    <div
      class="w-full md:w-auto md:absolute md:top-0 md:left-0 md:mt-6 md:ml-6 animate-slideInLeft delay-200 mb-6 md:mb-0">
  <div class="relative group border border-[#6aa8fa]/50 bg-gradient-to-b from-white/10 to-[#1b2e4a]/30 
      rounded-2xl w-full md:w-64 p-4 md:p-5 backdrop-blur-md shadow-[0_0_15px_rgba(70,150,255,0.3)] 
      overflow-hidden mx-auto max-w-xs md:max-w-none">

        <!-- Cahaya animasi -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent 
                    translate-x-[-100%] group-hover:translate-x-[100%] 
                    transition-transform duration-[1500ms] ease-out"></div>

        <!-- Judul -->
        <h2 class="font-semibold text-[#cfe4ff] mb-3 md:mb-4 text-base md:text-lg drop-shadow-sm tracking-wide">
          🏆 Tournaments
        </h2>

        <!-- Daftar Turnamen - PERBAIKAN UTAMA: HAPUS OVERFLOW DAN BATASAN TINGGI -->
        <div class="space-y-2 md:space-y-3 text-blue-100 text-xs md:text-sm">
          <!-- Item 1 -->
          <div class="bg-white/5 border border-[#6aa8fa]/30 rounded-lg p-2 px-3 flex justify-between items-center 
                      hover:bg-white/10 transition">
            <a href="" class="block w-full"><span class="block w-full truncate text-white">Fast Tournament Competition</span></a>
          </div>

          <!-- Item 2 -->
          <div class="bg-white/5 border border-[#6aa8fa]/30 rounded-lg p-2 px-3 flex justify-between items-center 
                      hover:bg-white/10 transition">
            <a href="" class="block w-full"><span class="block w-full truncate text-white">Weekly Battle Arena</span></a>
          </div>

          <!-- Item 3 -->
          <div class="bg-white/5 border border-[#6aa8fa]/30 rounded-lg p-2 px-3 flex justify-between items-center 
                      hover:bg-white/10 transition">
            <a href="" class="block w-full"><span class="block w-full truncate text-white">War Masters League</span></a>
          </div>

          <!-- Item 4 -->
          <div class="bg-white/5 border border-[#6aa8fa]/30 rounded-lg p-2 px-3 flex justify-between items-center 
                      hover:bg-white/10 transition">
            <a href="" class="block w-full"><span class="block w-full truncate text-white">Champions Cup 2024</span></a>
          </div>
        </div>

        <!-- Tombol lihat semua -->
        <button class="mt-4 md:mt-3 bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white 
                      px-4 py-1.5 rounded-lg text-xs font-semibold border border-[#1b3e75]
                      shadow-[0_4px_8px_rgba(0,0,30,0.4)]
                      hover:shadow-[0_0_20px_rgba(70,150,255,0.5)] 
                      transition-all duration-300 w-full md:w-auto">
          View All
        </button>
      </div>
    </div>

    <!-- Input Kode Turnamen -->
    <div class="text-center w-full md:w-auto">
      <h2 class="text-base md:text-lg font-semibold mb-3 text-white">Enter Tournament Code</h2>
      <input type="text" class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium 
                    shadow-md hover:bg-white/20 backdrop-blur-sm focus:bg-white/20 focus:border-blue-400 
                    focus:outline-none w-full max-w-xs md:w-64 text-center placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] 
                    transition duration-300 mb-3 md:mb-0" placeholder="Example: WAR123">

      <button class="relative bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white px-6 py-2 
                    rounded-xl font-semibold border border-[#1b3e75]
                    shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)]
                    hover:scale-105 hover:shadow-[0_0_20px_rgba(70,150,255,0.7)]
                    transition-all duration-300 ease-in-out overflow-hidden group w-full max-w-xs md:w-auto mt-2">
        <span class="relative z-10">Join</span>
        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                    translate-x-[-100%] group-hover:translate-x-[100%] 
                    transition-transform duration-700"></span>
      </button>
    </div>
  </main>

  <!-- Footer -->
  <div
    class="flex flex-col-reverse md:flex-row justify-between items-center md:items-end animate-slideInUp delay-500 z-10 relative mt-6 md:mt-0"
    x-data="{ showSetting: false, volume: 0.5, muted: false }" x-init="
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

          // Open controls from mobile hamburger
          window.addEventListener('openSetting', () => { 
            showSetting = true; 
            const container = document.getElementById('footerSettingContainer');
            container && container.scrollIntoView({ behavior: 'smooth', block: 'center' });
          });
          window.addEventListener('openLeaderboard', () => {
            const btn = document.getElementById('top100Button');
            if (btn) {
              btn.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
          });
       ">

    <!-- SETTING BUTTON -->
    <div class="relative mt-4 md:mt-0 hidden md:block" id="footerSettingContainer">
      <button @click="showSetting = !showSetting"
        class="flex items-center gap-2 bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm transition transform hover:scale-105 text-sm md:text-base">
        ⚙️ Setting
      </button>

      <!-- DROPDOWN -->
      <div x-show="showSetting" @click.away="showSetting = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95" class="absolute bottom-full mb-4 left-0 w-64 md:w-72 bg-white/95 text-gray-800 rounded-2xl shadow-2xl border border-gray-300/70 
                  p-4 md:p-5 text-xs md:text-sm backdrop-blur-xl z-30 origin-bottom-left">

        <h3 class="font-semibold text-gray-700 mb-2">🎵 Pengaturan Suara</h3>

        <!-- Toggle Musik -->
        <div class="flex justify-between items-center mb-3">
          <span>Musik</span>
          <button @click="
                muted = !muted;
                const audio = document.getElementById('bgMusic');
                if (audio) {
                  audio.muted = muted;
                  if(muted){ audio.pause(); } else { audio.play().catch(() => {}); }
                }
                localStorage.setItem('muted', muted);
              " class="px-3 py-1 rounded-md font-semibold transition text-xs md:text-sm"
            :class="muted ? 'bg-red-500 text-white' : 'bg-green-500 text-white'">
            <span x-text="muted ? 'Mati' : 'Hidup'"></span>
          </button>
        </div>

        <!-- Slider Volume -->
        <label class="block mb-1 text-gray-700 font-medium">Volume</label>
        <input type="range" min="0" max="1" step="0.01" x-model="volume" @input="
              const audio = document.getElementById('bgMusic');
              if (audio) { audio.volume = volume; }
              localStorage.setItem('volume', volume);
            " class="w-full accent-blue-600 cursor-pointer">
      </div>
    </div>

    <!-- TOP 100 -->
    <button id="top100Button"
      class="hidden md:inline-flex relative bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white px-6 py-2 rounded-xl font-semibold 
                   border border-[#1b3e75]
                   shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)]
                   hover:scale-105 hover:shadow-[0_0_20px_rgba(70,150,255,0.7)]
                   transition-all duration-300 ease-in-out overflow-hidden group w-full max-w-xs md:w-auto text-sm md:text-base">
      <span class="relative z-10">🏆 Top 100</span>
      <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                    translate-x-[-100%] group-hover:translate-x-[100%] 
                    transition-transform duration-700"></span>
    </button>
  </div>

  <!-- Efek Cahaya -->
  <div class="absolute right-4 md:right-8 bottom-4 md:bottom-6 w-3 h-3 md:w-4 md:h-4 rounded-full bg-white/80 blur-[2px] 
              shadow-[0_0_25px_rgba(255,255,255,0.6)] animate-pulseLight"></div>

  <!-- Animasi -->
  <style>
    @keyframes slideInLeft {
      0% {
        opacity: 0;
        transform: translateX(-40px);
      }

      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideInRight {
      0% {
        opacity: 0;
        transform: translateX(40px);
      }

      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideInUp {
      0% {
        opacity: 0;
        transform: translateY(40px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideInDown {
      0% {
        opacity: 0;
        transform: translateY(-40px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInDown {
      0% {
        opacity: 0;
        transform: translateY(-20px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    @keyframes pulseLight {

      0%,
      100% {
        opacity: 0.7;
        transform: scale(1);
      }

      50% {
        opacity: 1;
        transform: scale(1.3);
      }
    }

    .animate-slideInLeft {
      animation: slideInLeft 0.6s ease-out forwards;
    }

    .animate-slideInRight {
      animation: slideInRight 0.6s ease-out forwards;
    }

    .animate-slideInUp {
      animation: slideInUp 0.6s ease-out forwards;
    }

    .animate-fadeInDown {
      animation: fadeInDown 1s ease-out forwards;
    }

    .animate-fadeIn {
      animation: fadeIn 1s ease-out forwards;
    }

    .animate-pulseLight {
      animation: pulseLight 3s ease-in-out infinite;
    }

    .delay-200 {
      animation-delay: 0.2s;
    }

    .delay-300 {
      animation-delay: 0.3s;
    }

    .delay-400 {
      animation-delay: 0.4s;
    }

    .delay-500 {
      animation-delay: 0.5s;
    }
  </style>

  <!-- Script Partikel -->
  <script>
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

    window.addEventListener('load', () => {
      const overlay = document.getElementById('overlay');
      setTimeout(() => {
        overlay.classList.remove('opacity-0');
        overlay.classList.add('opacity-100');
        overlay.classList.remove('from-[#0f1b2e]/0', 'via-[#304863]/0', 'to-[#3b5875]/0');
        overlay.classList.add('from-[#0f1b2e]/80', 'via-[#304863]/80', 'to-[#3b5875]/80');
      }, 200);
    });
  </script>

</body>

</html>