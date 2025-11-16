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

<body class="font-poppins relative bg-gradient-to-b from-[#0f1b2e] via-[#304863] to-[#3b5875] min-h-screen text-white overflow-hidden select-none">

  {{-- Sidebar --}}
  @include('siswa.sidebar')

  <!-- Background musik -->
  <audio id="bgMusic" loop>
    <source src="/audio/sound.mp3" type="audio/mpeg">
  </audio>

  <!-- Canvas efek partikel -->
  <canvas id="particles" class="absolute inset-0 z-0"></canvas>

  <!-- Logo latar -->
  <img 
    src="/images/war.png" 
    alt="Logo" 
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
    "
  >

  <!-- Judul halaman -->
  <div class="relative w-full text-center mt-6 z-10">
    <h1 class="font-blackops text-3xl md:text-4xl font-extrabold bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(70,150,255,0.6)]">
      Profil Saya
    </h1>
  </div>

  <!-- Konten profil -->
  <div class="relative z-10 max-w-5xl mx-auto mt-10 bg-white/10 border border-[#6aa8fa]/60 rounded-xl p-6 backdrop-blur-md shadow-lg">
    <div class="flex flex-col md:flex-row gap-8 items-start">

      <!-- Panel kiri: profil -->
      <div class="flex flex-col items-center flex-1 text-center">
        <img 
          src="{{ asset('avatars/' . ($user->avatar_url ?? 'cat.png')) }}" 
          alt="Avatar" 
          class="w-32 h-32 rounded-full border-4 border-[#6aa8fa]/70 shadow mb-4"
        >
        <h2 class="text-2xl font-semibold">{{ $user->username }}</h2>
        <p class="text-sm text-blue-200 mb-2">{{ $user->email }}</p>
        <p class="text-sm italic text-blue-100">
          {{ $user->deskripsi_profil ?? 'Belum ada deskripsi profil.' }}
        </p>

        <div class="grid grid-cols-3 gap-4 text-center mt-6">
          <div>
            <p class="text-lg font-bold text-blue-300">{{ number_format($totalExp) }}</p>
            <p class="text-xs text-blue-200">Total EXP</p>
          </div>
          <div>
            <p class="text-lg font-bold text-blue-300">{{ $totalBintang }}/{{ $maxBintangPossible }}</p>
            <p class="text-xs text-blue-200">Bintang</p>
          </div>
          <div>
            <p class="text-lg font-bold text-blue-300">{{ $jumlahTurnamen }}</p>
            <p class="text-xs text-blue-200">Turnamen</p>
          </div>
        </div>

        <button 
          onclick="document.getElementById('editProfilModal').classList.remove('hidden')"
          class="mt-6 px-5 py-2 bg-[#6aa8fa]/80 rounded-lg text-white font-semibold hover:bg-[#6aa8fa] transition"
        >
          Edit Profil
        </button>
      </div>

      <!-- Panel kanan: tabel riwayat -->
      <div class="flex-1 w-full overflow-y-auto max-h-[80vh] pr-2" x-data="{ view: 'level' }">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-blue-100 border-b border-blue-300/40 pb-1">
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
            class="bg-white/20 text-blue-300 border border-blue-300/50 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/50"
          >
            <option value="level">Riwayat Level</option>
            <option value="turnamen">Riwayat Turnamen</option>
          </select>
        </div>

        <!-- Riwayat Level -->
        <div x-show="view === 'level'" x-transition>
          <div class="overflow-x-auto mb-6">
            <table class="w-full text-sm text-left text-blue-100">
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
        </div>

        <!-- Riwayat Turnamen -->
        <div x-show="view === 'turnamen'" x-transition>
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-blue-100">
              <thead class="text-blue-300">
                <tr>
                  <th class="p-2">Nama Turnamen</th>
                  <th class="p-2">Kode Room</th>
                  <th class="p-2">Peringkat</th>
                </tr>
              </thead>
              <tbody>
                @foreach($riwayatTurnamen as $p)
                  <tr class="border-t border-blue-300/30">
                    <td class="p-2">{{ optional($p->turnamen)->nama_turnamen ?? '-' }}</td>
                    <td class="p-2">{{ optional($p->turnamen)->kode_room ?? '-' }}</td>
                    <td class="p-2">{{ $p->peringkat ?? '-' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  @include('partials.edit-profil-modal')

</body>
</html>
