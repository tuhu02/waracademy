<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil | WarAcademy</title>

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

<body class="font-poppins relative bg-gradient-to-b from-[#0f1b2e] via-[#304863] to-[#3b5875] min-h-[100vh] text-white select-none pb-10 md:pb-15 overflow-auto">

  {{-- Sidebar --}}
  @include('siswa.sidebar')

  <!-- Background musik -->
  <audio id="bgMusic" loop>
    <source src="/audio/sound.mp3" type="audio/mpeg">
  </audio>

  <!-- Canvas efek partikel -->
  <canvas id="particles" class="fixed inset-0 z-0 pointer-events-none"></canvas>

  <!-- Logo latar -->
  <img 
  src="/images/war.png" 
  alt="Logo" 
  class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-5 pointer-events-none z-0 mix-blend-lighten max-h-[70vh] md:max-h-[300px]"
>

  <!-- Judul halaman -->
  <div class="relative w-full text-center mt-6 z-10">
    <h1 class="font-blackops text-3xl md:text-4xl font-extrabold bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(70,150,255,0.6)]">
      Profil Saya
    </h1>
  </div>

<!-- Konten profil -->
<div class="relative z-10 max-w-5xl mx-auto mt-6 md:mt-10 mb-6 md:mb-6 bg-white/10 border border-[#6aa8fa]/60 rounded-xl p-4 md:p-6 backdrop-blur-md shadow-lg min-h-[calc(100vh-4rem)] md:min-h-[calc(100vh-6rem)]">
  <div class="flex flex-col md:flex-row gap-4 md:gap-8 items-start w-full">

    <!-- Panel kiri: profil -->
    <div class="flex flex-col items-center flex-1 w-full mb-4 md:mb-0 text-center">
      <img 
        src="{{ asset('avatars/' . ($user->avatar_url ?? 'cat.png')) }}" 
        alt="Avatar" 
        class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-[#6aa8fa]/70 shadow mb-3 md:mb-4"
      >
      <h2 class="text-lg md:text-2xl font-semibold truncate">{{ $user->username }}</h2>
      <p class="text-xs md:text-sm text-blue-200 mb-1 truncate">{{ $user->email }}</p>
      <p class="text-xs md:text-sm italic text-blue-100 truncate">
        {{ $user->deskripsi_profil ?? 'Belum ada deskripsi profil.' }}
      </p>

      <div class="grid grid-cols-3 gap-1 md:gap-4 text-center mt-4 md:mt-6 text-[10px] md:text-xs">
        <div class="truncate">
          <p class="text-sm md:text-lg font-bold text-blue-300">{{ number_format($totalExp) }}</p>
          <p>Total EXP</p>
        </div>
        <div class="truncate">
          <p class="text-sm md:text-lg font-bold text-blue-300">{{ $totalBintang }}/{{ $maxBintangPossible }}</p>
          <p>Bintang</p>
        </div>
        <div class="truncate">
          <p class="text-sm md:text-lg font-bold text-blue-300">{{ $jumlahTurnamen }}</p>
          <p>Turnamen</p>
        </div>
      </div>

      <button 
        onclick="document.getElementById('editProfilModal').classList.remove('hidden')"
        class="mt-3 md:mt-6 px-4 md:px-5 py-2 bg-[#6aa8fa]/80 rounded-lg text-white font-semibold hover:bg-[#6aa8fa] transition text-xs md:text-sm"
      >
        Edit Profil
      </button>
    </div>

    <!-- Panel kanan: tabel riwayat -->
    <div class="flex-1 w-full overflow-x-auto max-h-[60vh] md:max-h-[80vh]" x-data="{ view: 'level' }">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-3 md:mb-4 gap-2 md:gap-0">
        <h3 class="text-sm md:text-lg font-semibold text-blue-100 border-b border-blue-300/40 pb-1">
          <template x-if="view === 'level'">
            <span>Riwayat Level</span>
          </template>
          <template x-if="view === 'turnamen'">
            <span>Riwayat Turnamen</span>
          </template>
        </h3>

        <!-- Dropdown -->
        <select 
          x-model="view" 
          class="bg-white/20 text-blue-300 border border-blue-300/50 rounded-md px-2 py-1 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/50"
        >
          <option value="level">Riwayat Level</option>
          <option value="turnamen">Riwayat Turnamen</option>
        </select>
      </div>

      <!-- Riwayat Level -->
      <div x-show="view === 'level'" x-transition class="overflow-x-auto mb-4 md:mb-6">
        <table class="w-full text-xs md:text-sm text-left text-blue-100 min-w-[400px] md:min-w-full">
          <thead class="text-blue-300">
            <tr>
              <th class="p-2">Level</th>
              <th class="p-2">EXP</th>
              <th class="p-2">Bintang</th>
            </tr>
          </thead>
          <tbody>
            @foreach($riwayatLevel as $row)
              <tr class="border-t border-blue-300/30">
                <td class="p-2">{{ optional($row->level)->nomor_level ?? $row->id_level }}</td>
                <td class="p-2">{{ $row->exp }}</td>
                <td class="p-2">{{ $row->bintang }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Riwayat Turnamen -->
      <div x-show="view === 'turnamen'" x-transition class="overflow-x-auto">
        <table class="w-full text-xs md:text-sm text-left text-blue-100 min-w-[500px] md:min-w-full">
          <thead class="text-blue-300">
            <tr>
              <th class="p-2">Nama Turnamen</th>
              <th class="p-2">Kode Room</th>
              <th class="p-2">Peringkat</th>
              <th class="p-2">Bonus Exp</th>
            </tr>
          </thead>
          <tbody>
            @foreach($riwayatTurnamen as $p)
              <tr class="border-t border-blue-300/30">
                <td class="p-2 truncate">{{ optional($p->turnamen)->nama_turnamen ?? '-' }}</td>
                <td class="p-2 truncate">{{ optional($p->turnamen)->kode_room ?? '-' }}</td>
                <td class="p-2">
                  @if(isset($p->peringkat) && $p->peringkat !== null)
                    {{ $p->peringkat }} / {{ $p->total_participants ?? '-' }}
                  @else
                    -
                  @endif
                </td>
                <td class="p-2 text-yellow-300 font-semibold">
                  {{ number_format($p->bonus_exp_didapat ?? 0) }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>


  @include('partials.edit-profil-modal')

  <script>
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
