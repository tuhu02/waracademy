<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kisi-Kisi Level {{ $id }} | WarAcademy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script type="module">
  import { initMusic, fadeInMusic } from '/js/music.js';
  const music = initMusic('/audio/classical.mp3');
  fadeInMusic(1500); // efek masuk halus
</script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@400;600&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom, #0f1b2e, #304863 50%, #3b5875);
      color: white;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, #6aa8fa, #1e3a8a);
      border-radius: 10px;
    }

    /* Canvas Partikel */
    #particles {
      position: absolute;
      inset: 0;
      z-index: 0;
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
      width: 90%;
      max-width: 700px;
      max-height: 430px;
      overflow-y: auto;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      backdrop-filter: blur(10px);
      border-radius: 18px;
      box-shadow: 0 0 25px rgba(80,130,255,0.3);
      padding: 28px 30px;
      position: relative;
      z-index: 2;
      animation: slideDown 0.8s ease forwards;
    }

    .kisi-container::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: max-content;
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
      margin-bottom: 18px;
      padding: 16px 20px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 14px;
      transition: all 0.4s ease;
      overflow: hidden;
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
    }

    .section ul li::before {
      content: "";
      position: absolute;
      left: 0;
      top: 9px;
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
      padding: 10px 24px;
      border-radius: 10px;
      color: white;
      transition: 0.3s ease;
      background: linear-gradient(to bottom, #2f5fa8, #0c2957);
      font-family: 'Orbitron', sans-serif;
      text-transform: uppercase;
      letter-spacing: 1px;
      box-shadow: 0 0 10px rgba(70,120,255,0.3);
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
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(1.3);
      opacity: 0.06;
      pointer-events: none;
      height: 300px;
      z-index: 0;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(6px); }
    }

    .float { animation: float 4s ease-in-out infinite; }

  </style>
</head>

<body class="flex flex-col items-center justify-center min-h-screen relative p-6 select-none">

  <!-- Logo Latar -->
  <img src="{{ asset('images/war.png') }}" alt="Logo" class="logo-bg">
  <canvas id="particles"></canvas>

  <!-- Judul -->
  <div class="relative z-10 text-center mb-6">
    <h1 class="text-4xl font-bold text-glow mb-2">LEVEL {{ $id }}</h1>
    <p class="text-gray-300 text-lg">Kisi-kisi pertanyaan yang akan kamu hadapi:</p>
  </div>

  <!-- KISI-KISI -->
<div class="kisi-container space-y-5 overflow-y-auto max-h-[500px] p-4">
    @if($kisi->isNotEmpty())
        @foreach ($kisi as $item)
            @php
                $topikData = json_decode($item->topik ?? '[]', true);
            @endphp

            @if(!empty($topikData))
                @foreach ($topikData as $topik)
                    <div class="section bg-white/5 p-4 rounded-lg shadow-lg mb-3">
                        <h3 class="section-title text-lg font-semibold mb-2">{{ $topik['nama'] ?? 'Topik Tidak Diketahui' }}</h3>
                        @if(!empty($topik['submateri']))
                            <ul class="list-disc list-inside">
                                @foreach($topik['submateri'] as $sub)
                                    <li>{{ $sub }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            @else
            @endif
        @endforeach
    @else
        <p class="text-center text-gray-400">Belum ada kisi-kisi untuk semua level.</p>
    @endif
</div>



  <!-- Tombol Navigasi -->
  <div class="flex justify-center gap-6 mt-8 z-10">
    <a href="{{ url('/level') }}" class="btn-game">⬅ Kembali</a>
    <a href="{{ route('level.start', $id) }}" class="btn-game">Mulai Soal 🚀</a>
  </div>

  <script>
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    canvas.width = innerWidth;
    canvas.height = innerHeight;

    const particles = Array.from({ length: 90 }, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      size: Math.random() * 2.2,
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
        if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
        if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
      });
      requestAnimationFrame(drawParticles);
    }
    drawParticles();
  </script>
</body>
</html>
