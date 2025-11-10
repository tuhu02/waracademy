<div x-data="{ open: false }" class="z-20">
  <!-- Hamburger Button -->
  <button 
    @click="open = !open"
    class="fixed top-6 left-6 z-30 p-3 bg-white/10 border border-[#6aa8fa]/40 rounded-lg text-white hover:bg-white/20 backdrop-blur-sm transition-all duration-300"
  >
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="h-6 w-6" 
         fill="none" 
         viewBox="0 0 24 24" 
         stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>

  <!-- Overlay (klik buat nutup sidebar) -->
  <div 
    x-show="open" 
    @click="open = false"
    x-transition.opacity
    class="fixed inset-0 bg-black/40 backdrop-blur-sm z-20"
  ></div>

  <!-- Sidebar -->
  <aside 
    x-show="open" 
    x-transition:enter="transition ease-out duration-300" 
    x-transition:enter-start="opacity-0 -translate-x-full" 
    x-transition:enter-end="opacity-100 translate-x-0" 
    x-transition:leave="transition ease-in duration-200" 
    x-transition:leave-start="opacity-100 translate-x-0" 
    x-transition:leave-end="opacity-0 -translate-x-full"
    class="fixed top-0 left-0 w-64 h-full bg-gradient-to-b from-[#152235] to-[#2c4463] border-r border-[#6aa8fa]/40 shadow-xl backdrop-blur-lg text-white p-6 z-30 flex flex-col space-y-6"
  >
    <!-- Header Sidebar -->
    <div class="flex items-center space-x-3 border-b border-white/10 pb-3">
      <img src="/images/war.png" class="w-10 h-10 opacity-80" alt="Logo">
      <h2 class="font-blackops text-xl bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent">WarAcademy</h2>
    </div>

    <!-- Menu -->
    <nav class="flex flex-col space-y-3 font-semibold text-blue-100">
      <a href="{{ route('home') }}" class="px-4 py-2 rounded-md hover:bg-white/10 transition">🏠 Home</a>
      <a href="{{ route('level') }}" class="px-4 py-2 rounded-md hover:bg-white/10 transition">🚀 Level</a>
      <a href="{{ route('tournament') }}" class="px-4 py-2 rounded-md hover:bg-white/10 transition">🏆 Tournament</a>
      {{-- <a href="{{ route('achievement') }}" class="px-4 py-2 rounded-md hover:bg-white/10 transition">🎯 Achievement</a> --}}
      @if(session('pengguna_id'))
        <a href="{{ route('profil.show', session('pengguna_id')) }}" class="px-4 py-2 rounded-md hover:bg-white/10 transition">
            👤 Profile
        </a>
      @else
          <a href="{{ route('login') }}" class="px-4 py-2 rounded-md hover:bg-white/10 transition">
              🔐 Profile
          </a>
      @endif

    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
      @csrf
      <button type="submit" class="w-full bg-red-600/80 hover:bg-red-700 transition px-4 py-2 rounded-lg font-semibold">
        Logout
      </button>
    </form>
  </aside>
</div>
