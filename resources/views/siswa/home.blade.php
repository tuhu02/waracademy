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

  <style>
    /* Animasi Mahkota */
    @keyframes crownBounce {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-3px) rotate(-8deg); }
        100% { transform: translateY(0) rotate(0deg); }
    }

    /* Efek Glow */
    .glow-rank {
        box-shadow: 0 0 12px rgba(255, 255, 255, 0.5),
                   0 0 20px rgba(255, 255, 255, 0.3);
    }

    /* Animasi Masuk */
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
</head>

<body class="font-poppins relative bg-gradient-to-b from-[#0f1b2e] via-[#304863] to-[#3b5875] min-h-screen flex flex-col justify-between text-white overflow-x-hidden overflow-y-auto select-none">

  {{-- Sidebar Hamburger --}}
  @include('siswa.sidebar')

  <audio id="bgMusic" loop>
    <source src="/audio/sound.mp3" type="audio/mpeg">
  </audio>

  <canvas id="particles" class="fixed inset-0 z-0 pointer-events-none"></canvas>

  <img src="/images/war.png" alt="Logo" 
     style="
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%) scale(1.5);
        height: 300px; opacity: 0.05;
        pointer-events: none; z-index: 0;
        mix-blend-mode: lighten;
     ">

  <div class="relative w-full text-center animate-fadeInDown z-0 pt-6 px-6">
    <h1 class="font-blackops text-3xl md:text-5xl font-extrabold bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(70,150,255,0.6)]">
      Menu Utama
    </h1>

    <!-- Wrapper Desktop -->
    <div class="absolute right-0 md:right-5 top-3 flex flex-col md:flex-row items-start md:items-center space-y-3 md:space-y-0 md:space-x-4 bg-white/10 px-6 py-3 rounded-2xl border border-[#6aa8fa]/50 backdrop-blur-md shadow-lg hidden md:flex">
      
      <!-- Avatar + Username -->
      <div class="flex items-center space-x-3">
        <img src="{{ asset('avatars/' . ($user->avatar_url ?? 'cat.png')) }}" 
            alt="Avatar" 
            class="w-10 h-10 border-2 border-[#6aa8fa] rounded-full bg-white/20 shadow-sm backdrop-blur-sm object-cover">
        <span class="text-white/90 font-medium text-shadow">{{ session('pengguna_username') ?? 'Siswa' }}</span>
      </div>

      <!-- EXP BAR -->
      <div class="relative flex flex-col w-full md:w-36">
        <div class="flex items-center mb-1">
          <span class="text-yellow-300 text-xl drop-shadow-[0_0_5px_rgba(255,230,120,0.8)]">⚡</span>
          <span class="ml-2 text-sm font-semibold text-blue-100 tracking-wide">EXP</span>
        </div>
        <div class="relative w-full h-3 bg-blue-950/50 rounded-full overflow-hidden border border-blue-400/40">
          <div id="expBar" class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#38bdf8] via-[#3b82f6] to-[#2563eb] shadow-[0_0_10px_rgba(59,130,246,0.6)] transition-all duration-700 ease-out" style="width: {{ $expPercent }}%"></div>
        </div>
        <span id="expValue" class="mt-1 text-sm text-blue-100 font-bold tracking-wide">{{$exp}}</span>
      </div>

      <!-- BINTANG -->
      <div class="relative flex flex-col w-full md:w-20">
        <div class="flex items-center mb-1">
          <span class="relative inline-block text-yellow-400 text-xl animate-spin-slow drop-shadow-[0_0_8px_rgba(255,220,100,0.8)]">⭐</span>
          <span class="ml-2 text-sm font-semibold text-blue-100 tracking-wide">Bintang</span>
        </div>
        <div class="relative w-full h-3 bg-blue-950/50 rounded-full overflow-hidden border border-yellow-400/40">
          <div id="starBar" class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#fde68a] via-[#facc15] to-[#fbbf24] shadow-[0_0_8px_rgba(250,204,21,0.7)] transition-all duration-700 ease-out" style="width: {{ $starPercent }}%"></div>
        </div>
        <span id="starValue" class="mt-1 text-sm text-blue-100 font-bold tracking-wide">{{ $bintang }}</span>
      </div>
    </div>

    <!-- Mobile: Avatar + Popover -->
    <div x-data="{ open: false }" class="absolute right-6 top-6 flex items-center md:hidden">
      <button @click="open = !open" class="focus:outline-none">
        <img src="{{ asset('avatars/' . ($user->avatar_url ?? 'cat.png')) }}" 
            alt="Avatar" 
            class="w-12 h-12 border-2 border-[#6aa8fa] rounded-full bg-white/20 shadow-sm backdrop-blur-sm object-cover cursor-pointer">
      </button>

      <!-- Popover Mobile -->
      <div x-show="open"
        @click.away="open = false"
        x-transition
        class="fixed top-[calc(50px+0.5rem)] right-6 w-64 bg-white rounded-2xl p-4 border border-gray-300 shadow-lg z-00">
        <!-- Username -->
        <div class="px-2 py-1 font-bold text-black border-b border-gray-200">
          {{ session('pengguna_username') ?? 'Siswa' }}
        </div>

        <!-- EXP -->
        <div class="flex flex-col w-full">
          <div class="flex items-center mb-1">
            <span class="text-yellow-300 text-xl">⚡</span>
            <span class="ml-2 text-sm font-semibold text-black tracking-wide">EXP</span>
          </div>
          <div class="relative w-full h-3 bg-blue-950/50 rounded-full overflow-hidden border border-blue-400/40">
            <div id="expBarMobile" class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#38bdf8] via-[#3b82f6] to-[#2563eb] shadow-[0_0_10px_rgba(59,130,246,0.6)] transition-all duration-700 ease-out" style="width: {{ $expPercent }}%"></div>
          </div>
          <span class="mt-1 text-sm text-black font-bold tracking-wide">{{$exp}}</span>
        </div>

        <!-- Bintang -->
        <div class="flex flex-col w-full">
          <div class="flex items-center mb-1">
            <span class="text-yellow-400 text-xl">⭐</span>
            <span class="ml-2 text-sm font-semibold text-black tracking-wide">Bintang</span>
          </div>
          <div class="relative w-full h-3 bg-blue-950/50 rounded-full overflow-hidden border border-yellow-400/40">
            <div id="starBarMobile" class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#fde68a] via-[#facc15] to-[#fbbf24] shadow-[0_0_8px_rgba(250,204,21,0.7)] transition-all duration-700 ease-out" style="width: {{ $starPercent }}%"></div>
          </div>
          <span class="mt-1 text-sm text-black font-bold tracking-wide">{{ $bintang }}</span>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
          @csrf
          <button type="submit" 
              class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 font-semibold rounded-lg">
              Logout
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="flex-1 w-full max-w-[1400px] mx-auto z-0 flex items-center py-8 px-6">
    
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 w-full items-center">

        <div class="md:col-span-3 order-2 md:order-1 animate-slideInLeft delay-200 flex justify-center md:justify-start">
            <div class="border border-[#6aa8fa]/60 rounded-xl w-full max-w-[320px] p-4 
                bg-[#0f1b2e]/40 backdrop-blur-md shadow-lg animate-fadeIn">

                <h2 class="font-blackops text-[#cfe4ff] mb-4 text-center tracking-wider text-lg border-b border-white/10 pb-2">
                    🏆 TOP 5 AGENTS
                </h2>

                <div class="flex flex-col gap-3">
                    @forelse ($topPlayers as $rank => $p)
                        <div class="flex items-center gap-3 
                                    bg-[#0f1b2e]/60 border border-[#6aa8fa]/30 rounded-xl p-2 
                                    hover:bg-[#0f1b2e]/80 transition-all group">
                            
                            <div class="relative flex-none w-10 h-10 flex items-center justify-center font-black text-lg rounded-lg shadow-md
                                @if ($rank == 0) bg-gradient-to-br from-yellow-300 to-yellow-600 text-black ring-1 ring-yellow-200/50
                                @elseif ($rank == 1) bg-gradient-to-br from-slate-200 to-slate-400 text-slate-900 ring-1 ring-slate-300/50
                                @elseif ($rank == 2) bg-gradient-to-br from-orange-400 to-orange-700 text-white ring-1 ring-orange-300/50
                                @else bg-white/10 text-gray-300 border border-white/10
                                @endif">
                                <span class="z-0 leading-none pt-[2px]">{{ $rank + 1 }}</span>
                                @if ($rank <= 2)
                                    <span class="absolute -top-3 -right-2 text-xl drop-shadow-md" style="animation: crownBounce 3s infinite ease-in-out;">👑</span>
                                @endif
                            </div>

                            <div class="flex flex-col justify-center w-full overflow-hidden">
                                <span class="text-white font-bold text-sm truncate tracking-wide group-hover:text-[#6aa8fa] transition-colors">
                                    {{ $p->username }}
                                </span>
                                <span class="text-[10px] text-blue-300/80 font-mono uppercase tracking-wider">
                                    {{ $p->total_exp }} XP
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-blue-200 text-sm text-center py-4 italic opacity-70">
                            Belum ada data agent.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="md:col-span-6 order-1 md:order-2 flex flex-col md:flex-row gap-6 justify-center items-center w-full">
             <div class="relative animate-slideInRight delay-300 group w-full max-w-sm md:w-64 md:h-64 h-32">
                <a href="{{ route('level') }}" class="w-full h-full flex flex-row md:flex-col items-center justify-center gap-6 md:gap-4 text-xl md:text-2xl font-semibold 
                            bg-white/5 border border-[#6aa8fa]/50 rounded-2xl backdrop-blur-sm
                            shadow-[0_0_15px_rgba(0,0,0,0.3)] hover:shadow-[0_0_30px_rgba(106,168,250,0.5)] hover:bg-white/10 hover:border-[#6aa8fa]
                            transition-all duration-300 transform group-hover:-translate-y-2">
                    <span class="text-5xl md:text-7xl drop-shadow-xl transition-transform group-hover:scale-110 duration-300">🚀</span>
                    <span class="tracking-wider text-shadow-md">Level</span>
                </a>
            </div>

            <div class="relative animate-slideInRight delay-400 group w-full max-w-sm md:w-64 md:h-64 h-32">
                <a href="{{ route('tournament') }}" class="w-full h-full flex flex-row md:flex-col items-center justify-center gap-6 md:gap-4 text-xl md:text-2xl font-semibold 
                            bg-white/5 border border-[#6aa8fa]/50 rounded-2xl backdrop-blur-sm
                            shadow-[0_0_15px_rgba(0,0,0,0.3)] hover:shadow-[0_0_30px_rgba(106,168,250,0.5)] hover:bg-white/10 hover:border-[#6aa8fa]
                            transition-all duration-300 transform group-hover:-translate-y-2">
                    <span class="text-5xl md:text-7xl drop-shadow-xl transition-transform group-hover:scale-110 duration-300">🏆</span>
                    <span class="tracking-wider text-shadow-md">Tournament</span>
                </a>
            </div>
        </div>

        <div class="md:col-span-3 order-3 hidden md:block"></div>

    </div>
  </div>

  <div class="w-full max-w-[1400px] mx-auto px-6 pb-6 pt-4 flex justify-between items-end animate-slideInUp delay-500 z-20 relative" 
       x-data="{ showSetting: false, volume: 0.5, muted: false }" 
       x-init="
          const savedVol = localStorage.getItem('volume');
          const savedMute = localStorage.getItem('muted');
          if(savedVol) volume = parseFloat(savedVol);
          if(savedMute) muted = savedMute === 'true';
          const audio = document.getElementById('bgMusic');
          audio.volume = volume;
          if(!muted) {
              const playPromise = audio.play();
              if (playPromise !== undefined) playPromise.catch(error => {});
          }
       ">

    <div class="relative">
      <button @click="showSetting = !showSetting" 
              class="flex items-center gap-2 bg-[#0f1b2e]/60 border border-[#6aa8fa]/40 rounded-xl px-4 py-3 text-white font-medium shadow-lg hover:bg-[#1e3a8a]/60 backdrop-blur-md transition transform hover:scale-105 active:scale-95">
        <span class="text-xl">⚙️</span> <span class="hidden md:inline font-semibold">Setting</span>
      </button>

      <div x-show="showSetting" 
           @click.away="showSetting = false"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 translate-y-4 scale-95"
           x-transition:enter-end="opacity-100 translate-y-0 scale-100"
           x-transition:leave="transition ease-in duration-200"
           class="absolute bottom-full mb-4 left-0 w-72 bg-[#1f2937] text-white rounded-2xl shadow-2xl border border-gray-600 
                  p-5 text-sm backdrop-blur-xl z-50 origin-bottom-left">

          <h3 class="font-bold text-lg mb-3 border-b border-gray-600 pb-2">🎵 Pengaturan Suara</h3>
          
          <div class="flex justify-between items-center mb-4">
            <span class="text-gray-300">Musik Background</span>
            <button @click="
                muted = !muted;
                const audio = document.getElementById('bgMusic');
                if(muted){ audio.pause(); } else { audio.play(); }
                localStorage.setItem('muted', muted);
             "
             class="px-3 py-1 rounded-lg font-bold text-xs uppercase tracking-wide transition shadow-md"
             :class="muted ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'">
              <span x-text="muted ? 'OFF' : 'ON'"></span>
            </button>
          </div>

          <label class="block mb-2 text-gray-300 font-medium text-xs uppercase">Volume Master</label>
          <input type="range" min="0" max="1" step="0.01" x-model="volume"
                 @input="
                    const audio = document.getElementById('bgMusic');
                    audio.volume = volume;
                    localStorage.setItem('volume', volume);
                 "
                 class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer accent-blue-500">
      </div>
    </div>

    <a href="{{ route('leaderboard.top100') }}">
        <button class="relative bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white px-5 py-3 rounded-xl font-bold 
                      border border-[#4fa3ff]/50 text-sm md:text-base tracking-wide
                      shadow-[0_0_15px_rgba(0,0,0,0.5)]
                      hover:scale-105 hover:shadow-[0_0_25px_rgba(70,150,255,0.7)] hover:border-[#4fa3ff]
                      transition-all duration-300 overflow-hidden group">
          <span class="relative z-0 flex items-center gap-2">
              <span>🏆</span> Top 100
          </span>
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                        translate-x-[-150%] group-hover:translate-x-[150%] 
                        transition-transform duration-700 ease-in-out"></div>
        </button>
    </a>
  </div>

  <div class="fixed right-10 bottom-10 w-32 h-32 rounded-full bg-blue-500/20 blur-[80px] pointer-events-none z-0"></div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const expBar = document.getElementById('expBar');
      const starBar = document.getElementById('starBar');

      // Ambil persentase dari Blade
      const expPercent = {{ $expPercent }};
      const starPercent = {{ $starPercent }};

      // Animasi naik bar
      setTimeout(() => { expBar.style.width = expPercent + '%'; }, 300);
      setTimeout(() => { starBar.style.width = starPercent + '%'; }, 500);
    });

    const audio = document.getElementById('bgMusic');

    // Fungsi fade out navigasi halus
    document.querySelectorAll('a[href]').forEach(link => {
      link.addEventListener('click', e => {
        const href = link.getAttribute('href');
        if (href.startsWith('http') || href.startsWith('#')) return; 
        e.preventDefault(); 
        
        const step = 0.1;
        const fadeOut = setInterval(() => {
            if (audio.volume > 0.1) {
                audio.volume -= step;
            } else {
                clearInterval(fadeOut);
                window.location.href = href;
            }
        }, 50);
      });
    });

    // Canvas Partikel
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    const particles = Array.from({ length: 60 }, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      size: Math.random() * 2 + 0.5,
      speedX: (Math.random() - 0.5) * 0.3,
      speedY: (Math.random() - 0.5) * 0.3,
      opacity: Math.random() * 0.5 + 0.2
    }));

    function drawParticles() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particles.forEach(p => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(255, 255, 255, ${p.opacity})`;
        ctx.fill();
        p.x += p.speedX;
        p.y += p.speedY;
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