<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kisi-Kisi Level {{ $id }} | WarAcademy</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>

    /* Scrollbar gaya neon biru */

  ::-webkit-scrollbar {
    width: 6px;
  }
  ::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
  }
  ::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #60a5fa, #2563eb);
    border-radius: 10px;
    box-shadow: 0 0 6px rgba(96,165,250,0.7);
  }
  ::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #93c5fd, #3b82f6);
  }

</style>
<body class="font-poppins relative 
             bg-gradient-to-b from-[#0f1b2e] via-[#304863] to-[#243b55] 
             min-h-screen flex flex-col items-center justify-center p-6 
             text-white overflow-hidden select-none">

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
  <!-- CANVAS PARTIKEL -->
  <canvas id="particles" class="absolute inset-0 z-0"></canvas>

  <div class="bg-white/10 backdrop-blur-md p-8 rounded-2xl shadow-lg w-[90%] md:w-[600px] ">
    <h1 class="text-4xl font-bold text-center mb-4">Level {{ $id }}</h1>
    <p class="text-lg text-gray-300 text-center mb-6">
      Berikut kisi-kisi pertanyaan yang akan kamu hadapi di level ini:
    </p>

  <div class="text-gray-200 space-y-4 mb-8 
            bg-white/5 border border-white/10 
            rounded-xl p-4 overflow-y-auto"
     style="max-height: 450px;">  <!-- batas tinggi agar bisa scroll -->

      @php
        $topikData = json_decode($kisi->topik ?? '[]', true);
      @endphp

      <h2 class="text-xl font-semibold text-white mb-2">Topik Utama:</h2>

      @if (!empty($topikData))
        <ol class="list-decimal list-inside space-y-3">
          @foreach ($topikData as $topik)
            <li>
              <span class="font-bold text-blue-300">{{ $topik['nama'] ?? '-' }}</span>
              @if (!empty($topik['submateri']))
                <ul class="list-disc list-inside ml-6 mt-1 text-gray-300">
                  @foreach ($topik['submateri'] as $sub)
                    <li>{{ $sub }}</li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ol>
      @else
        <p class="text-gray-400">Belum ada kisi-kisi untuk level ini.</p>
      @endif
    <p>Jumlah soal: <span class="text-white font-semibold">{{ $kisi->jumlah_soal ?? '-' }}</span></p>
    <p>Waktu pengerjaan: <span class="text-white font-semibold">{{ $kisi->waktu_menit ?? '-' }} menit</span></p>
    <p>Jenis soal: <span class="text-white font-semibold">{{ $kisi->jenis_soal ?? '-' }}</span></p>
  </div>



    <div class="flex justify-center gap-4">
      <a href="{{ url('/level') }}" 
         class="bg-white/10 border border-[#6aa8fa]/60 text-white px-6 py-2 rounded-xl font-semibold 
                hover:bg-white/20 transition-all">
        ⬅ Kembali
      </a>

      <a href="{{ route('level.start', $id) }}" 
         class="bg-[#3b82f6] px-6 py-2 rounded-xl font-semibold 
                hover:bg-[#2563eb] shadow-lg transition-all">
        Mulai Soal 🚀
      </a>
    </div>
  </div>
</body>

<script>
  // efek partikel
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
</script>
</html>