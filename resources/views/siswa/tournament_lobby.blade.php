<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lobi Turnamen | WarAcademy</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('/images/tournament.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    .font-blackops { font-family: '"Black Ops One"', sans-serif; }
    .participant-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(106, 168, 250, 0.3);
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }
    .participant-card:hover {
      transform: translateY(-5px);
      background: rgba(255, 255, 255, 0.1);
    }
    /* Animasi untuk item baru */
    .scale-enter-active { transition: all 0.3s ease-out; }
    .scale-enter-from { opacity: 0; transform: scale(0.9); }
    .scale-enter-to { opacity: 1; transform: scale(1); }
  </style>
</head>

<body
  class="relative font-poppins min-h-screen flex flex-col justify-between p-4 md:p-6 text-white overflow-hidden select-none"
  x-data="lobbyApp()">
  
  <div class="absolute inset-0 bg-gradient-to-b from-[#0f1b2e]/80 via-[#304863]/80 to-[#3b5875]/80 z-0"></div>

  <header class="relative w-full text-center z-10 mb-6">
    <h1 class="font-blackops text-2xl md:text-4xl font-extrabold bg-gradient-to-b 
               from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent 
               drop-shadow-[0_0_15px_rgba(70,150,255,0.6)] mb-2">
      {{ $turnamen->nama_turnamen }}
    </h1>
    <p class="text-lg text-cyan-300">Kode Room: 
      <strong class="font-bold text-2xl tracking-widest text-white">{{ $turnamen->kode_room }}</strong>
    </p>
  </header>

  <main class="flex-1 relative flex flex-col justify-start items-center z-10 overflow-y-auto">
    
    <div class="w-full max-w-md text-center mb-8">
      <div class="bg-white/10 border border-[#6aa8fa]/50 rounded-xl p-6 shadow-xl backdrop-blur-md">
        <h2 class="text-2xl font-bold text-white mb-3">Menunggu Guru Memulai...</h2>
        <p class="text-gray-300">Tetap di halaman ini. Permainan akan dimulai secara otomatis.</p>
        <svg class="animate-spin h-8 w-8 text-cyan-400 mx-auto mt-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>
    </div>

    <div class="text-center mb-6">
      <p class="text-gray-300 mb-4">{{ $initialParticipants->count() }} / {{ $turnamen->max_peserta }} Peserta Telah Bergabung</p>
      
      <!-- Grid Avatar (dinamis) -->
      <div class="grid grid-cols-4 gap-4 justify-center max-w-2xl mx-auto" id="participantsContainer">
        @forelse($initialParticipants as $participant)
          <div class="flex flex-col items-center">
            <div class="w-20 h-20 rounded-full border-2 border-cyan-400 flex items-center justify-center overflow-hidden bg-gray-800">
              @if($participant->avatar_url)
                <img src="{{ $participant->avatar_url }}" alt="{{ $participant->username }}" class="w-full h-full object-cover">
              @else
                <span class="text-gray-500 text-sm">No Avatar</span>
              @endif
            </div>
            <p class="text-sm text-gray-300 mt-2 truncate">{{ $participant->username }}</p>
          </div>
        @empty
          <p class="col-span-4 text-gray-400">Belum ada peserta yang bergabung.</p>
        @endforelse
      </div>
    </div>

  </main>

  <footer class="relative z-10 text-center text-gray-400 text-sm mt-6">
    © {{ date('Y') }} WarAcademy.
  </footer>

  <!-- Script untuk polling peserta terbaru (ganti isi #participantsContainer) -->
  <script>
    let pollInterval = setInterval(async () => {
      try {
        const res = await fetch('{{ route("tournament.lobby.status", ["kode" => $turnamen->kode_room]) }}');
        const data = await res.json();

        if (data.status === 'Berlangsung') {
          window.location.href = data.redirect_url;
          return;
        }

        if (data.status === 'Selesai') {
          window.location.href = data.redirect_url;
          return;
        }

        // Update participants jika status masih Menunggu
        if (data.participants && data.participants.length > 0) {
          const container = document.getElementById('participantsContainer');
          container.innerHTML = data.participants.map(p => `
            <div class="flex flex-col items-center">
              <div class="w-20 h-20 rounded-full border-2 border-cyan-400 flex items-center justify-center overflow-hidden bg-gray-800">
                ${p.avatar_url ? `<img src="${p.avatar_url}" alt="${p.username}" class="w-full h-full object-cover">` : '<span class="text-gray-500 text-sm">No Avatar</span>'}
              </div>
              <p class="text-sm text-gray-300 mt-2 truncate">${p.username}</p>
            </div>
          `).join('');

          // Update counter
          document.querySelector('p').textContent = `${data.participants.length} / {{ $turnamen->max_peserta }} Peserta Telah Bergabung`;
        }
      } catch (e) {
        console.error('Polling error:', e);
      }
    }, 2000); // polling setiap 2 detik

    // Cleanup saat page unload
    window.addEventListener('beforeunload', () => clearInterval(pollInterval));
  </script>
</body>
</html>