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
class="relative font-poppins h-[100dvh] box-border flex flex-col p-4 md:p-6 text-white overflow-hidden select-none"
style="background-image: url('/images/tournament.png');" >
  <!-- Background music (autoplay muted per browser policy, unmute on user interaction) -->
  <audio id="bgMusic" src="{{ asset('audio/sound.mp3') }}" preload="auto" loop muted autoplay></audio>

  <!-- Overlay gelap (atur opacity di sini) -->
  <div id="overlay" class="absolute inset-0 bg-gradient-to-b from-[#0f1b2e]/0 via-[#304863]/0 to-[#3b5875]/0 
            opacity-0 z-0 transition-all duration-[2000ms] ease-in-out"></div>

  <!-- Canvas Partikel -->
  <canvas id="particles" class="absolute inset-0 z-0 w-full h-full"></canvas>

  <!-- Header -->
  <header class="relative w-full text-center md:animate-fadeInDown mb-4 md:mb-0" style="z-index:2147483645;">
    <!-- Mobile Hamburger (full-screen overlay sidebar) -->
    <div x-data="{ open:false }" @keydown.window.escape="open=false" x-effect="$watch('open', v => { document.documentElement.style.overflow = v ? 'hidden' : ''; })" class="fixed inset-0 md:hidden pointer-events-none" style="z-index:2147483646;">
      <!-- Toggle button -->
      <button @click="open = !open" class="absolute left-3 top-3 p-2 bg-[#0b1120] text-white rounded-lg shadow-md focus:outline-none pointer-events-auto">
        <template x-if="!open">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </template>
        <template x-if="open">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </template>
      </button>

      <!-- Overlay -->
      <div x-show="open" @click="open=false" class="fixed inset-0 bg-black/60 pointer-events-auto" style="z-index:2147483646;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"></div>

      <!-- Sidebar -->
      <div x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 h-screen w-64 bg-[#0b1120]/100 text-white shadow-2xl flex flex-col pt-5 pb-5 pl-5 pr-10 space-y-4 md:border-r md:border-[#6aa8fa]/30 backdrop-blur-none md:backdrop-blur-md pointer-events-auto isolate"
        style="background-color: #0b1120 !important; backdrop-filter: none !important; -webkit-backdrop-filter: none !important; z-index:2147483647;">
        <h2 class="text-2xl font-bold mb-4 border-b border-gray-600 pb-2 mt-5">Menu</h2>

        <!-- Close button -->
        <button @click="open=false" aria-label="Close menu" class="absolute top-3 right-3 p-2 rounded-md bg-white/10 hover:bg-white/20 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <a href="#" @click.prevent="open=false; window.dispatchEvent(new CustomEvent('openSetting'))" class="flex items-center space-x-2 hover:text-blue-400">
          <span>⚙️</span>
          <span>Setting</span>
        </a>
        <a href="#" @click.prevent="open=false; window.dispatchEvent(new CustomEvent('openLeaderboard'))" class="flex items-center space-x-2 hover:text-blue-400">
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
        <span class="text-white/90 font-medium text-sm md:text-base">{{ session('pengguna_username') ?? 'Nama' }}</span>
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

  <!-- Main Section - OPTIMIZED FOR MOBILE -->
  <main class="flex-1 relative z-10 overflow-y-auto py-2">
    <div class="flex flex-col md:flex-row gap-4 md:gap-6 w-full max-w-6xl mx-auto">

      <!-- Create Tournament Section -->
      <div class="animate-slideInLeft delay-300 flex-1">
        <div class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 md:px-6 py-4 text-white font-medium shadow-md backdrop-blur-sm h-full flex flex-col">
          <h2
            class="font-semibold text-[#cfe4ff] mb-4 md:mb-6 text-lg md:text-xl drop-shadow-sm tracking-wide text-left">
            Create New Tournament
          </h2>

          <h2 class="text-left mb-2 text-sm md:text-base">Tournament Name</h2>
          <input type="text" class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium 
                  shadow-md hover:bg-white/20 backdrop-blur-sm focus:bg-white/20 focus:border-blue-400 
                  focus:outline-none w-full text-left placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] 
                  transition duration-300 mb-3 text-sm md:text-base" placeholder="Example: WAR123">

          <h2 class="mb-2 text-sm md:text-base">Description</h2>
          <textarea type="text-area" class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium 
                  shadow-md hover:bg-white/20 backdrop-blur-sm focus:bg-white/20 focus:border-blue-400 
                  focus:outline-none w-full text-left placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] 
                  transition duration-300 mb-3 flex-1 min-h-[100px] md:min-h-[120px] text-sm md:text-base"
            placeholder="Description Game....."></textarea>

          <div class="flex flex-col md:flex-row gap-3 md:gap-4 mb-4">
            <div class="flex-1">
              <label class="block mb-1 text-left text-sm md:text-base">Start Date</label>
              <input type="datetime-local" class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium 
                      shadow-md hover:bg-white/20 backdrop-blur-sm focus:bg-white/20 focus:border-blue-400 
                      focus:outline-none w-full placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] 
                      transition duration-300 text-sm md:text-base">
            </div>

            <div class="flex-1">
              <label class="block mb-1 text-left text-sm md:text-base">End Date</label>
              <input type="datetime-local" class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium 
                      shadow-md hover:bg-white/20 backdrop-blur-sm focus:bg-white/20 focus:border-blue-400 
                      focus:outline-none w-full placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] 
                      transition duration-300 text-sm md:text-base">
            </div>
          </div>

          <button class="relative bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white px-6 py-2 
                     rounded-xl font-semibold border border-[#1b3e75]
                     shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)] 
                     overflow-hidden group w-full mt-auto text-sm md:text-base">
            <span class="relative z-10" id="createButton">Create Tournament</span>
          </button>
        </div>
      </div>

      <!-- My Tournaments Section -->
      <div class="animate-slideInRight delay-400 flex-1">
        <div class="border border-[#6aa8fa]/50 bg-gradient-to-b from-white/10 to-[#1b2e4a]/30 
                  rounded-2xl h-full p-4 md:p-6 backdrop-blur-md shadow-[0_0_15px_rgba(70,150,255,0.3)] flex flex-col">
          <h2 class="font-semibold text-[#cfe4ff] mb-4 text-lg md:text-xl drop-shadow-sm tracking-wide">
            🏆 My Tournaments
          </h2>

          <!-- Tournament List Container -->
          <div x-data="tournamentPagination()" class="flex-1 flex flex-col">
            <!-- Tournament List -->
            <div
              class="flex-1 space-y-3 text-blue-100 text-xs md:text-sm overflow-y-auto pr-1 md:pr-2 max-h-[300px] md:max-h-[400px] mb-4">
              <template x-for="tournament in displayedTournaments" :key="tournament.id">
                <div class="bg-white/5 border border-[#6aa8fa]/30 rounded-lg p-3 flex justify-between items-center 
                          hover:bg-white/10 transition group">
                  <div class="flex-1 min-w-0">
                    <p class="font-semibold text-white text-sm md:text-base truncate" x-text="tournament.title"></p>
                    <p class="text-xs text-blue-200 mt-1">Code: <span class="font-mono bg-black/20 px-1 rounded"
                        x-text="tournament.code"></span></p>
                  </div>
                  <div class="flex items-center gap-2 ml-2">
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full whitespace-nowrap" :class="tournament.status === 'Active' ? 'text-green-300 bg-green-500/20 border border-green-400/50' : 
                                tournament.status === 'Ended' ? 'text-red-300 bg-red-500/20 border border-red-400/50' :
                                'text-yellow-300 bg-yellow-500/20 border border-yellow-400/50'"
                      x-text="tournament.status"></span>
                    <button @click="window.__openEditTournament && window.__openEditTournament(tournament)"
                      class="text-xs text-yellow-300 opacity-0 group-hover:opacity-100 transition hidden md:block">Edit</button>
                  </div>
                </div>
              </template>
            </div>

            <!-- Page info -->
            <div class="text-xs text-blue-200 text-center mb-2">
              Showing <span x-text="startIndex + 1"></span> to <span
                x-text="Math.min(endIndex, totalTournaments)"></span>
              of <span x-text="totalTournaments"></span> tournaments
            </div>

            <!-- Pagination buttons -->
            <div class="flex items-center justify-center space-x-1 md:space-x-2">
              <!-- Previous button -->
              <button @click="previousPage()" :disabled="currentPage === 1" class="p-1.5 rounded-md transition" :class="currentPage === 1 
                              ? 'bg-white/5 text-white/30 cursor-not-allowed' 
                              : 'bg-white/10 text-white hover:bg-white/20'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
              </button>

              <!-- Page numbers -->
              <template x-for="page in pages" :key="page">
                <button @click="goToPage(page)"
                  class="px-2 py-1 text-xs rounded-md transition min-w-[1.5rem] md:min-w-[2rem]" :class="page === currentPage 
                                ? 'bg-[#6aa8fa] text-white shadow-[0_0_10px_rgba(70,150,255,0.5)]' 
                                : 'bg-white/10 text-white hover:bg-white/20'" x-text="page"></button>
              </template>

              <!-- Next button -->
              <button @click="nextPage()" :disabled="currentPage === totalPages" class="p-1.5 rounded-md transition"
                :class="currentPage === totalPages 
                              ? 'bg-white/5 text-white/30 cursor-not-allowed' 
                              : 'bg-white/10 text-white hover:bg-white/20'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    </div>
  </main>

  <!-- Modal - OPTIMIZED FOR MOBILE -->
  <div id="modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[2147483648] p-4">
    <div
      class="relative bg-gradient-to-b from-[#0f1b2e]/90 to-[#1b2e4a]/90 
              border border-[#6aa8fa]/50 rounded-2xl shadow-[0_0_25px_rgba(70,150,255,0.4)] 
              backdrop-blur-xl p-4 md:p-8 w-full max-w-md md:max-w-2xl lg:w-[1000px] animate-fadeInUp text-white max-h-[90vh] overflow-y-auto">

      <!-- Tombol close -->
      <button id="closeModal"
        class="absolute top-3 right-3 md:top-4 md:right-4 text-white/80 hover:text-white text-xl md:text-2xl font-bold transition">
        &times;
      </button>

      <!-- Judul Modal -->
      <h2
        class="font-blackops text-xl md:text-2xl mb-4 bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(70,150,255,0.6)]">
        Create Tournament
      </h2>

      <!-- Input -->
      <label class="block mb-2 text-sm text-blue-100 font-medium text-left">Tournament Name</label>
      <input type="text" class="w-full bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 mb-4 
                  text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm 
                  focus:bg-white/20 focus:border-blue-400 focus:outline-none 
                  placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] transition text-sm md:text-base"
        placeholder="Example: WAR123">

      <label class="block mb-2 text-sm text-blue-100 font-medium text-left">Description</label>
      <textarea rows="3" class="w-full bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 mb-4 
                     text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm 
                     focus:bg-white/20 focus:border-blue-400 focus:outline-none 
                     placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] transition text-sm md:text-base"
        placeholder="Description Game..."></textarea>

      <!-- Tambahan field baru di modal -->
      <label class="block mb-2 text-sm text-blue-100 font-medium text-left">Kode Room</label>
      <input id="roomCode" type="text" readonly class="w-full bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 mb-4 
                  text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm 
                  focus:bg-white/20 focus:border-blue-400 focus:outline-none 
                  placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] transition text-sm md:text-base"
        placeholder="WAR-XXXX">

      <label class="block mb-2 text-sm text-blue-100 font-medium text-left">Soal Turnamen</label>
      <textarea id="tournamentQuestion" rows="3" class="w-full bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 mb-4 
                     text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm 
                     focus:bg-white/20 focus:border-blue-400 focus:outline-none 
                     placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] transition text-sm md:text-base"
        placeholder="Tulis soal turnamen di sini..."></textarea>

      <label class="block mb-2 text-sm text-blue-100 font-medium text-left">Jawaban</label>
      <input id="tournamentAnswer" type="text" class="w-full bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 mb-4 
                  text-white font-medium shadow-md hover:bg-white/20 backdrop-blur-sm 
                  focus:bg-white/20 focus:border-blue-400 focus:outline-none 
                  placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] transition text-sm md:text-base"
        placeholder="Masukkan jawaban benar...">

      <div class="flex flex-col md:flex-row gap-3 md:gap-4 mb-6">
        <div class="flex-1">
          <label class="block mb-1 text-left text-sm md:text-base">Tanggal Mulai</label>
          <input id="modalStart" type="datetime-local" class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium 
                  shadow-md hover:bg-white/20 backdrop-blur-sm focus:bg-white/20 focus:border-blue-400 
                  focus:outline-none w-full placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] 
                  transition duration-300 text-sm md:text-base">
        </div>
        <div class="flex-1">
          <label class="block mb-1 text-left text-sm md:text-base">Tanggal Berakhir</label>
          <input id="modalEnd" type="datetime-local" class="bg-white/10 border border-[#6aa8fa]/40 rounded-xl px-4 py-2 text-white font-medium 
                  shadow-md hover:bg-white/20 backdrop-blur-sm focus:bg-white/20 focus:border-blue-400 
                  focus:outline-none w-full placeholder-gray-300 hover:shadow-[0_0_25px_rgba(70,150,255,0.4)] 
                  transition duration-300 text-sm md:text-base">
        </div>
      </div>

      <!-- Tombol aksi -->
      <div class="flex flex-col md:flex-row justify-end gap-3 mt-3">
        <!-- Cancel -->
        <button id="closeModal2" class="px-4 md:px-5 py-2 rounded-xl font-semibold border border-red-400/50 text-red-300 
                  bg-red-500/10 backdrop-blur-sm shadow-[0_0_10px_rgba(255,0,0,0.2)]
                  hover:bg-red-500/20 hover:shadow-[0_0_20px_rgba(255,0,0,0.4)]
                  hover:scale-105 active:scale-95 transition-all duration-300 text-sm md:text-base order-2 md:order-1">
          ✖ Cancel
        </button>

        <!-- Draft -->
        <button class="px-4 md:px-5 py-2 rounded-xl font-semibold border border-yellow-400/50 text-yellow-300 
              bg-yellow-500/10 backdrop-blur-sm shadow-[0_0_10px_rgba(255,255,0,0.2)]
              hover:bg-yellow-500/20 hover:shadow-[0_0_20px_rgba(255,255,0,0.4)]
              hover:scale-105 active:scale-95 transition-all duration-300 text-sm md:text-base order-3 md:order-2">
          📝 Draft
        </button>

        <!-- Save -->
        <button
          class="px-4 md:px-6 py-2 rounded-xl font-semibold border border-blue-400/50 text-white 
              bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] 
              shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)]
              hover:shadow-[0_0_20px_rgba(70,150,255,0.7)]
              hover:scale-105 active:scale-95 transition-all duration-300 relative overflow-hidden group text-sm md:text-base order-1 md:order-3">
          💾 <span class="relative z-10">Save</span>
          <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                      translate-x-[-100%] group-hover:translate-x-[100%] 
                      transition-transform duration-700"></span>
        </button>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <div
    class="flex flex-col-reverse md:flex-row justify-between items-center md:items-end animate-slideInUp delay-500 z-10 relative mt-4 md:mt-0"
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
                   transition-all duration-300 ease-in-out overflow-hidden group w-full max-w-xs md:w-auto text-sm md:text-base mb-4 md:mb-0">
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

  <script>
    // Alpine.js pagination component
    function tournamentPagination() {
      return {
        // Sample tournament data
        tournaments: [
          { id: 1, title: 'Fast Tournament Competition', code: 'FTC2025', status: 'Active' },
          { id: 2, title: 'War Academy Championship', code: 'WAC2025', status: 'Active' },
          { id: 3, title: 'Battle Royale Showdown', code: 'BRS2025', status: 'Ended' },
          { id: 4, title: 'Elite Warriors Cup', code: 'EWC2025', status: 'Active' },
          { id: 5, title: 'Strategy Masters League', code: 'SML2025', status: 'Upcoming' },
          { id: 6, title: 'Clash of Champions', code: 'COC2025', status: 'Active' },
          { id: 7, title: 'Tactical Warfare', code: 'TW2025', status: 'Ended' },
          { id: 8, title: 'Pro Gamer Arena', code: 'PGA2025', status: 'Active' },
          { id: 9, title: 'Ultimate Battle', code: 'UB2025', status: 'Upcoming' },
          { id: 10, title: 'Warrior Challenge', code: 'WC2025', status: 'Active' }
        ],
        currentPage: 1,
        itemsPerPage: 4,
        get totalTournaments() {
          return this.tournaments.length;
        },
        get totalPages() {
          return Math.ceil(this.totalTournaments / this.itemsPerPage);
        },
        get displayedTournaments() {
          const start = (this.currentPage - 1) * this.itemsPerPage;
          const end = start + this.itemsPerPage;
          return this.tournaments.slice(start, end);
        },
        get pages() {
          const pages = [];
          const maxVisiblePages = 5;
          let startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
          let endPage = Math.min(this.totalPages, startPage + maxVisiblePages - 1);

          // Adjust start page if we're near the end
          if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
          }

          for (let i = startPage; i <= endPage; i++) {
            pages.push(i);
          }

          return pages;
        },
        get startIndex() {
          return (this.currentPage - 1) * this.itemsPerPage;
        },
        get endIndex() {
          return this.startIndex + this.itemsPerPage;
        },
        nextPage() {
          if (this.currentPage < this.totalPages) {
            this.currentPage++;
          }
        },
        previousPage() {
          if (this.currentPage > 1) {
            this.currentPage--;
          }
        },
        goToPage(page) {
          this.currentPage = page;
        },
        updatePagination() {
          // Reset to first page when items per page changes
          this.currentPage = 1;
        }
      }
    }

    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');

    function resizeCanvas() {
      // Size canvas to its container to avoid 100vw/100vh overflow scrollbars
      const w = canvas.clientWidth;
      const h = canvas.clientHeight;
      if (w && h) {
        canvas.width = w;
        canvas.height = h;
      }
    }
    resizeCanvas();

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
      resizeCanvas();
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

    // === MODAL HANDLING ===
    const modal = document.getElementById('modal');
    const openModal = document.getElementById('createButton');
    const closeModal = document.getElementById('closeModal');
    const closeModal2 = document.getElementById('closeModal2');

    // Elemen input form utama
    const nameInput = document.querySelector('input[placeholder="Example: WAR123"]');
    const descInput = document.querySelector('textarea[placeholder="Description Game....."]');
    const startInput = document.querySelectorAll('input[type="datetime-local"]')[0];
    const endInput = document.querySelectorAll('input[type="datetime-local"]')[1];

    // Elemen input dalam modal
    const modalName = modal.querySelector('input[placeholder="Example: WAR123"]');
    const modalDesc = modal.querySelector('textarea[placeholder="Description Game..."]');

    function generateRoomCode() {
      const random = Math.floor(1000 + Math.random() * 9000);
      return `WAR-${random}`;
    }

    openModal.addEventListener('click', () => {
      if (
        nameInput.value.trim() === '' ||
        descInput.value.trim() === '' ||
        startInput.value.trim() === '' ||
        endInput.value.trim() === ''
      ) {
        alert('Harap lengkapi semua field di form utama terlebih dahulu!');
        return;
      }

      // isi otomatis ke modal
      modalName.value = nameInput.value;
      modalDesc.value = descInput.value;
      document.getElementById('modalStart').value = startInput.value;
      document.getElementById('modalEnd').value = endInput.value;
      document.getElementById('roomCode').value = generateRoomCode();

      modal.classList.remove('hidden');
    });

    // Fill modal for editing an existing tournament
    function fillModalForEdit(t) {
      const titleEl = modal.querySelector('h2');
      if (titleEl) {
        titleEl.textContent = 'Edit Tournament';
      }
      if (modalName) modalName.value = t?.title || '';
      if (modalDesc) modalDesc.value = t?.description || '';
      const room = document.getElementById('roomCode');
      if (room) room.value = t?.code || '';
      const ms = document.getElementById('modalStart');
      const me = document.getElementById('modalEnd');
      if (ms) ms.value = t?.start || '';
      if (me) me.value = t?.end || '';
    }

    // Global function used by the Edit buttons
    window.__openEditTournament = function (t) {
      fillModalForEdit(t || {});
      modal.classList.remove('hidden');
    };

    [closeModal, closeModal2].forEach(btn => {
      if (btn) {
        btn.addEventListener('click', () => {
          modal.classList.add('hidden');
        });
      }
    });

    window.addEventListener('click', e => {
      if (e.target === modal) modal.classList.add('hidden');
    });
  </script>

</body>

</html>