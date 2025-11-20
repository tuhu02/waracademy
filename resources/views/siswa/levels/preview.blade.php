<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kisi-Kisi Level {{ $id }} | WarAcademy</title>
  <script src="https://cdn.tailwindcss.com"></script>
<script type="module">
  import { initMusic, fadeInMusic } from '/js/music.js';

  // 1. Ambil setting dari localStorage
  const savedVol = parseFloat(localStorage.getItem("volume"));
  const savedMute = localStorage.getItem("muted");

  // 2. Terapkan nilai default
  const volume = !isNaN(savedVol) ? savedVol : 0.5;
  const muted = savedMute === "true"; 

  // 3. Inisialisasi musik
  const music = initMusic('/audio/classical.mp3');

  // 4. Terapkan setting
  if (music) {
      music.volume = volume;
      music.muted = muted;

      // 5. Mainkan
      if (!music.muted && music.volume > 0) {
          fadeInMusic(1500); 
      }
  } else {
      console.error("Gagal menginisialisasi musik dari music.js");
  }
</script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@400;600&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom, #0f1b2e, #304863 50%, #3b5875);
      color: white;
      /* overflow-x: hidden; -> Dihapus biar aman di mobile, dihandle tailwind */
      min-height: 100vh;
    }

    /* Scrollbar Custom */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, #6aa8fa, #1e3a8a);
      border-radius: 10px;
    }

    /* Canvas Partikel */
    #particles {
      position: fixed; /* Ubah ke fixed agar background tetap saat scroll */
      inset: 0;
      z-index: 0;
      pointer-events: none;
    }

    /* Glow text */
    .text-glow {
      text-shadow: 0 0 10px rgba(170,210,255,0.9),
                   0 0 25px rgba(90,150,255,0.6);
      font-family: 'Orbitron', sans-serif;
      letter-spacing: 1px;
      color: #dce6f2;
    }

    /* Animasi slide */
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .kisi-container {
      /* Hapus max-width/height fixed, ganti dengan utility tailwind di HTML */
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      backdrop-filter: blur(10px);
      border-radius: 18px;
      box-shadow: 0 0 25px rgba(80,130,255,0.3);
      position: relative;
      z-index: 2;
      animation: slideDown 0.8s ease forwards;
    }

    /* Efek background bergerak di container */
    .kisi-container::before {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 30% 30%, rgba(100,150,255,0.18), transparent 70%),
                  radial-gradient(circle at 70% 70%, rgba(147,197,253,0.12), transparent 70%);
      background-size: 200% 200%;
      animation: moveBg 10s ease-in-out infinite alternate;
      z-index: 0;
      border-radius: inherit;
      pointer-events: none;
    }

    @keyframes moveBg {
      0% { background-position: 0% 0%; }
      100% { background-position: 100% 100%; }
    }

    .section {
      position: relative;
      z-index: 2;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 14px;
      transition: all 0.4s ease;
      overflow: hidden;
      height: 100%; /* Agar tinggi kartu seragam */
    }

    .section:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 0 25px rgba(90,150,255,0.4);
      background: rgba(255,255,255,0.1);
    }

    .section-title {
      border-left: 3px solid #6aa8fa;
      padding-left: 10px;
      font-weight: 600;
      color: #a3d3fa;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 8px;
      font-size: 0.9rem; /* Ukuran font sedikit disesuaikan */
    }

    .section ul {
      list-style: none;
      color: #dce6f2;
      margin-left: 0;
      padding-left: 0;
    }

    .section ul li {
      position: relative;
      padding-left: 18px;
      font-size: 0.85rem;
      line-height: 1.4;
      margin-bottom: 4px;
    }

    .section ul li::before {
      content: "";
      position: absolute;
      left: 0;
      top: 8px; /* Adjusted alignment */
      width: 6px;
      height: 6px;
      background: linear-gradient(135deg, #6aa8fa, #1e3a8a);
      border-radius: 50%;
      box-shadow: 0 0 6px rgba(100,150,255,0.7);
    }

    .btn-game {
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(100,150,255,0.4);
      padding: 10px 20px; /* Padding responsif */
      border-radius: 10px;
      color: white;
      transition: 0.3s ease;
      background: linear-gradient(to bottom, #2f5fa8, #0c2957);
      font-family: 'Orbitron', sans-serif;
      text-transform: uppercase;
      letter-spacing: 1px;
      box-shadow: 0 0 10px rgba(70,120,255,0.3);
      white-space: nowrap;
      font-size: 0.9rem;
    }
    
    /* Media Query untuk tombol di layar besar */
    @media (min-width: 768px) {
      .btn-game { padding: 10px 24px; font-size: 1rem; }
    }

    .btn-game::after {
      content: "";
      position: absolute;
      top: 0; left: -100%;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
      transition: all 0.6s ease;
    }

    .btn-game:hover::after { left: 100%; }

    .btn-game:hover {
      background: linear-gradient(to bottom, #3d6fc0, #14386d);
      box-shadow: 0 0 25px rgba(100,150,255,0.5);
      transform: translateY(-2px);
    }

    .logo-bg {
      position: fixed; /* Ubah ke fixed */
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.06;
      pointer-events: none;
      z-index: 0;
      width: 80vw; /* Responsive width */
      max-width: 500px;
    }

  </style>
</head>

<body class="flex flex-col items-center justify-center min-h-screen p-4 md:p-6 overflow-x-hidden">

  <img src="{{ asset('images/war.png') }}" alt="Logo" class="logo-bg">
  <canvas id="particles"></canvas>

  <div class="relative z-10 flex flex-col items-center w-full max-w-[1400px] mx-auto h-full">

    <div class="text-center mb-6 mt-4 md:mt-0">
      <h1 class="text-3xl md:text-5xl font-bold text-glow mb-2">LEVEL {{ $id }}</h1>
    </div>

    <div class="flex flex-row justify-center gap-4 mb-6 z-10 w-full max-w-md">
      <a href="{{ url('/level') }}" class="btn-game flex-1 text-center">⬅ Kembali</a>
      <a href="{{ route('level.start', $id) }}" class="btn-game flex-1 text-center">Mulai Soal 🚀</a>
    </div>

    @php
        $firstKisi = $kisiList->first();
    @endphp
    
    <div class="summary mb-6 bg-white/10 p-4 rounded-lg text-center shadow-lg w-full max-w-lg border border-white/10 backdrop-blur-sm">
        <div class="flex justify-around items-center">
          <p class="text-gray-300 text-sm md:text-lg flex flex-col md:flex-row items-center gap-1">
             <span>🧩</span> <strong>{{ $firstKisi->jumlah_soal ?? '-' }} Soal</strong>
          </p>
          <div class="h-8 w-[1px] bg-gray-500/50"></div>
          <p class="text-gray-300 text-sm md:text-lg flex flex-col md:flex-row items-center gap-1">
             <span>⏱️</span> <strong>{{ $firstKisi->waktu_menit ?? '-' }} Menit</strong>
          </p>
        </div>
    </div>

    <p class="text-gray-300 text-base md:text-lg mb-4 text-center px-2">
      Kisi-kisi pertanyaan yang akan kamu hadapi:
    </p>

    <div class="kisi-container w-full p-4 md:p-6">
        
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 overflow-y-auto max-h-[65vh] pr-2 custom-scrollbar">
          @if($kisiList->isNotEmpty())
              @foreach ($kisiList as $item)
                  @php
                      $topikData = json_decode($item->topik ?? '[]', true);
                  @endphp

                  @if(!empty($topikData))
                      @foreach ($topikData as $topik)
                          <div class="section h-full flex flex-col">
                            <h3 class="section-title">
                                  {{ $topik['nama'] ?? 'Topik Tidak Diketahui' }}
                              </h3>

                              @if(!empty($topik['submateri']))
                                  <ul class="list-disc list-inside flex-grow">
                                      @foreach($topik['submateri'] as $sub)
                                          <li>{{ $sub }}</li>
                                      @endforeach
                                  </ul>
                              @endif
                          </div>
                      @endforeach
                  @endif
              @endforeach
          @else
              <div class="col-span-full flex items-center justify-center h-32">
                 <p class="text-center text-gray-400">
                   Belum ada kisi-kisi untuk level ini.
                 </p>
              </div>
          @endif
      </div>
      
    </div>

  </div> 
  
  <script>
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    
    // Fungsi resize agar canvas mengikuti ukuran layar saat rotasi/resize
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas(); // Panggil saat awal

    // Sesuaikan jumlah partikel berdasarkan ukuran layar
    const isMobile = window.innerWidth < 768;
    const particleCount = isMobile ? 40 : 90;

    const particles = Array.from({ length: particleCount }, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      size: Math.random() * (isMobile ? 1.5 : 2.2),
      speedX: (Math.random() - 0.5) * 0.5,
      speedY: (Math.random() - 0.5) * 0.5,
    }));

    function drawParticles() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
      particles.forEach(p => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fill();
        p.x += p.speedX;
        p.y += p.speedY;
        
        // Wrap around screen
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