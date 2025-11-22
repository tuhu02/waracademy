<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournament | WarAcademy</title>

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

<body class="relative font-poppins min-h-screen flex flex-col text-white overflow-x-hidden select-none bg-[#0f1b2e]"
  style="background-image: url('/images/tournament.png');
         background-size: cover;
         background-position: center;
         background-repeat: no-repeat;
         background-attachment: fixed;">

  <audio id="bgMusic" src="{{ asset('audio/sound.mp3') }}" preload="auto" loop muted autoplay></audio>

  <div id="overlay" class="fixed inset-0 bg-gradient-to-b from-[#0f1b2e]/80 via-[#304863]/80 to-[#3b5875]/80 z-0 pointer-events-none"></div>

  <canvas id="particles" class="fixed inset-0 z-0 pointer-events-none"></canvas>

  <header class="relative z-50 w-full p-4 md:p-6 flex justify-between items-center">
    
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="p-2 text-white bg-white/10 rounded-lg hover:bg-white/20 focus:outline-none transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <div x-show="open" @click="open = false" x-transition.opacity class="fixed inset-0 bg-black/60 z-[60]"></div>

      <div x-show="open" 
           x-transition:enter="transition transform ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition transform ease-in duration-300"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed top-0 left-0 h-full w-64 bg-[#0b1120] text-white p-5 z-[70] shadow-2xl border-r border-white/10 flex flex-col">
        
        <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
            <span class="font-blackops text-2xl text-blue-400 tracking-wider">MENU</span>
            <button @click="open = false" class="text-gray-400 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('home') }}" class="flex items-center w-full space-x-3 px-3 py-3 rounded-lg hover:bg-white/10 transition-colors group">
                <span class="text-xl group-hover:scale-110 transition-transform">🏠</span> 
                <span class="font-medium">Home</span>
            </a>

            <button @click="open = false; window.dispatchEvent(new CustomEvent('openSetting'))" class="flex items-center w-full space-x-3 px-3 py-3 rounded-lg hover:bg-white/10 transition-colors group">
                <span class="text-xl group-hover:scale-110 transition-transform">⚙️</span> 
                <span class="font-medium">Audio Setting</span>
            </button>

             <button @click="open = false; window.dispatchEvent(new CustomEvent('openLeaderboard'))" class="flex items-center w-full space-x-3 px-3 py-3 rounded-lg hover:bg-white/10 transition-colors group">
                <span class="text-xl group-hover:scale-110 transition-transform">🏆</span> 
                <span class="font-medium">Leaderboard</span>
            </button>

            <div class="border-t border-gray-700 my-4 pt-4">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full space-x-3 px-3 py-3 rounded-lg hover:bg-red-500/20 text-red-400 hover:text-red-300 transition-colors group">
                        <span class="text-xl group-hover:scale-110 transition-transform">🚪</span> 
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
      </div>
    </div>

    <h1 class="absolute left-1/2 transform -translate-x-1/2 font-blackops text-2xl md:text-4xl font-extrabold 
               bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent 
               drop-shadow-[0_0_15px_rgba(70,150,255,0.6)] whitespace-nowrap pointer-events-none">
      TOURNAMENT
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
  </header>


  <main class="flex-1 relative flex flex-col md:flex-row justify-center items-center z-10 w-full p-4 gap-8 md:gap-0">

    <div class="w-full max-w-sm md:w-auto md:absolute md:left-8 md:top-1/2 md:-translate-y-1/2 animate-slideInLeft">
      
      <div class="relative group border border-[#6aa8fa]/50 bg-gradient-to-b from-white/10 to-[#1b2e4a]/60 
                  rounded-2xl w-full md:w-72 p-5 backdrop-blur-md shadow-[0_0_20px_rgba(70,150,255,0.2)] overflow-hidden transition-all hover:shadow-[0_0_30px_rgba(70,150,255,0.4)]">
        
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent 
                    translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-[1500ms] ease-out pointer-events-none"></div>

        <h2 class="font-semibold text-[#cfe4ff] mb-4 text-lg flex items-center gap-2 border-b border-white/10 pb-2">
          🏆 <span class="tracking-wide">Active Event</span>
        </h2>

        <div class="space-y-3">
            <div class="bg-black/20 border border-[#6aa8fa]/30 rounded-lg p-2.5 flex items-center justify-between hover:bg-white/10 transition cursor-pointer group/item">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-2 h-2 rounded-full bg-green-400 shadow-[0_0_5px_#4ade80] animate-pulse"></div>
                    <span class="text-sm text-gray-200 truncate group-hover/item:text-white transition font-medium">Weekly Battle Arena</span>
                </div>
                <span class="text-[10px] uppercase font-bold text-gray-400 border border-gray-600 px-1.5 py-0.5 rounded">Solo</span>
            </div>

            <div class="bg-black/20 border border-[#6aa8fa]/30 rounded-lg p-2.5 flex items-center justify-between hover:bg-white/10 transition cursor-pointer group/item">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-2 h-2 rounded-full bg-blue-400 shadow-[0_0_5px_#60a5fa] animate-pulse"></div>
                    <span class="text-sm text-gray-200 truncate group-hover/item:text-white transition font-medium">Champions Cup</span>
                </div>
                <span class="text-[10px] uppercase font-bold text-gray-400 border border-gray-600 px-1.5 py-0.5 rounded">Team</span>
            </div>
            
             <div class="bg-black/20 border border-[#6aa8fa]/30 rounded-lg p-2.5 flex items-center justify-between hover:bg-white/10 transition cursor-pointer group/item">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-2 h-2 rounded-full bg-yellow-400 shadow-[0_0_5px_#facc15] animate-pulse"></div>
                    <span class="text-sm text-gray-200 truncate group-hover/item:text-white transition font-medium">Fast Math Comp</span>
                </div>
                <span class="text-[10px] uppercase font-bold text-gray-400 border border-gray-600 px-1.5 py-0.5 rounded">Solo</span>
            </div>
        </div>

        <button class="mt-5 w-full py-2.5 bg-gradient-to-r from-[#2f5fa8] to-[#0c2957] rounded-lg text-xs font-bold uppercase tracking-wider text-blue-100 border border-blue-500/50 hover:brightness-110 transition shadow-lg hover:scale-[1.02]">
            View All Events
        </button>
      </div>
    </div>

    <div class="w-full max-w-md text-center z-20" x-data="joinForm()">
        <div class="bg-black/40 backdrop-blur-md p-6 md:p-10 rounded-3xl border border-white/10 shadow-2xl transform transition hover:scale-[1.01] duration-300">
            <div class="mb-6">
                <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-400/30">
                    <span class="text-3xl">🚀</span>
                </div>
                <h2 class="text-xl md:text-3xl font-bold mb-2 text-white tracking-tight">Gabung Pertempuran</h2>
                <p class="text-gray-300 text-sm md:text-base">Masukkan kode akses dari gurumu untuk memulai.</p>
            </div>

            <div class="relative mb-6 group">
                <input type="text" x-model="roomCode" 
                       @keyup.enter="submitJoin()"
                       placeholder="KODE ROOM (ex: WAR123)" 
                       class="w-full bg-white/5 border-2 border-white/20 rounded-2xl px-6 py-4 text-center text-white placeholder-gray-500 text-lg md:text-xl font-bold tracking-[0.2em] focus:outline-none focus:border-[#6aa8fa] focus:bg-white/10 transition-all uppercase shadow-inner group-hover:border-white/30">
            </div>

            <button @click="submitJoin()" :disabled="isLoading"
                    class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-500/30 transform active:scale-95 transition-all disabled:opacity-70 disabled:cursor-not-allowed flex justify-center items-center gap-3 text-lg border border-white/10">
                <span x-show="!isLoading">JOIN TURNAMEN</span>
                <span x-show="isLoading" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menghubungkan...
                </span>
            </button>

            <div x-show="message" x-transition class="mt-6 p-3 rounded-xl text-sm font-medium border flex items-center justify-center gap-2"
                 :class="isError ? 'bg-red-500/20 border-red-500/50 text-red-200' : 'bg-green-500/20 border-green-500/50 text-green-200'">
                <span x-show="isError">⚠️</span>
                <span x-show="!isError">✅</span>
                <p x-text="message"></p>
            </div>
        </div>
    </div>

  </main>


  <footer class="relative z-20 w-full p-4 md:p-6 flex flex-col-reverse md:flex-row justify-between items-center gap-4 mt-auto">
    
    <div class="relative hidden md:block" x-data="{ showSetting: false, volume: 0.5, muted: false }" id="footerSettingContainer">
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('audioControl', () => ({
                    volume: 0.5,
                    muted: false,
                    init() {
                        const savedVol = localStorage.getItem('volume');
                        const savedMute = localStorage.getItem('muted');
                        const audio = document.getElementById('bgMusic');
                        if (audio) {
                            if (savedVol) { audio.volume = parseFloat(savedVol); this.volume = audio.volume; }
                            if (savedMute !== null) { audio.muted = (savedMute === 'true'); this.muted = audio.muted; }
                            const tryPlay = () => audio.play().catch(() => {});
                            if (!audio.muted && !this.muted) { tryPlay(); }
                            const unlock = () => {
                                if (!this.muted) { audio.muted = false; tryPlay(); }
                                window.removeEventListener('click', unlock);
                                window.removeEventListener('touchstart', unlock);
                            };
                            window.addEventListener('click', unlock, { once: true });
                            window.addEventListener('touchstart', unlock, { once: true });
                        }
                        // Listener untuk trigger dari mobile menu
                        window.addEventListener('openSetting', () => { 
                             const audioModal = document.getElementById('mobileAudioSettings');
                             if(audioModal) audioModal.style.display = 'flex';
                        });
                         window.addEventListener('openLeaderboard', () => { 
                            // Redirect atau scroll
                             const btn = document.getElementById('top100Button');
                             if (btn) btn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        });
                    },
                    toggleMute() {
                        this.muted = !this.muted;
                        const audio = document.getElementById('bgMusic');
                        if(audio) {
                            audio.muted = this.muted;
                            if(this.muted) audio.pause(); else audio.play().catch(()=>{});
                        }
                        localStorage.setItem('muted', this.muted);
                    },
                    updateVolume() {
                        const audio = document.getElementById('bgMusic');
                        if(audio) audio.volume = this.volume;
                        localStorage.setItem('volume', this.volume);
                    }
                }))
            })
         </script>

         <div x-data="audioControl">
             <button @click="showSetting = !showSetting" class="flex items-center gap-2 bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm transition transform hover:scale-105">
                <span>⚙️</span> Setting
             </button>

             <div x-show="showSetting" @click.away="showSetting = false" x-transition 
                  class="absolute bottom-full mb-3 left-0 w-72 bg-white/95 text-gray-800 rounded-2xl shadow-2xl border border-gray-300/70 p-5 text-sm backdrop-blur-xl z-30 origin-bottom-left">
                <h3 class="font-semibold text-gray-700 mb-2">🎵 Pengaturan Suara</h3>
                <div class="flex justify-between items-center mb-3">
                    <span>Musik</span>
                    <button @click="toggleMute()" class="px-3 py-1 rounded-md font-semibold transition text-xs"
                            :class="muted ? 'bg-red-500 text-white' : 'bg-green-500 text-white'">
                        <span x-text="muted ? 'Mati' : 'Hidup'"></span>
                    </button>
                </div>
                <label class="block mb-1 text-gray-700 font-medium">Volume</label>
                <input type="range" min="0" max="1" step="0.01" x-model="volume" @input="updateVolume()" class="w-full accent-blue-600 cursor-pointer">
             </div>
         </div>
    </div>

    <div id="mobileAudioSettings" style="display: none;" class="fixed inset-0 z-[100] bg-black/80 justify-center items-center p-4 backdrop-blur-sm"
         x-data="audioControl">
         <div class="bg-[#1f2937] text-white w-full max-w-sm rounded-2xl p-6 shadow-2xl relative border border-gray-600">
            <button @click="$el.closest('#mobileAudioSettings').style.display='none'" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl">&times;</button>
            <h3 class="font-bold text-lg mb-6 text-center border-b border-gray-600 pb-4">Pengaturan Audio</h3>
            
            <div class="flex justify-between items-center mb-6">
                <span class="font-medium text-gray-300">Musik Background</span>
                <button @click="toggleMute()" class="px-4 py-2 rounded-lg font-bold text-sm transition shadow-md"
                        :class="muted ? 'bg-red-600 text-white' : 'bg-green-600 text-white'">
                    <span x-text="muted ? 'MATI' : 'HIDUP'"></span>
                </button>
            </div>
            
            <div class="mb-2">
                <label class="block mb-3 font-medium text-gray-300">Volume Master</label>
                <input type="range" min="0" max="1" step="0.01" x-model="volume" @input="updateVolume()" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer accent-blue-500">
            </div>
            
            <button @click="$el.closest('#mobileAudioSettings').style.display='none'" class="w-full mt-6 bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl font-semibold">
                Tutup
            </button>
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

  </footer>

  <div class="fixed right-4 bottom-4 w-32 h-32 bg-blue-500/20 rounded-full blur-[60px] pointer-events-none z-0"></div>


  <script>
    // Particles
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
    }));

    function drawParticles() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = 'rgba(255, 255, 255, 0.4)';
      particles.forEach(p => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
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

    // Form Logic
    function joinForm() {
      return {
        roomCode: '',
        isLoading: false,
        message: '',
        isError: false,

        async submitJoin() {
          this.message = '';
          this.isError = false;
          const kode = (this.roomCode || '').trim();
          
          if (!kode) {
            this.isError = true;
            this.message = '⚠️ Masukkan kode turnamen dulu ya!';
            return;
          }

          this.isLoading = true;
          try {
            const body = new URLSearchParams({ kode_room: kode });
            const res = await fetch('{{ route("tournament.join") }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              },
              body: body.toString()
            });

            const text = await res.text();
            let data;
            try { data = JSON.parse(text); } catch(e) { data = { raw: text }; }

            if (res.ok && data.redirect_url) {
              window.location.href = data.redirect_url;
              return;
            }

            this.isError = true;
            this.message = data.message || 'Kode turnamen salah atau tidak valid.';
          } catch (e) {
            console.error(e);
            this.isError = true;
            this.message = 'Gagal terhubung ke server.';
          } finally {
            this.isLoading = false;
          }
        }
      }
    }
  </script>
</body>
</html>
