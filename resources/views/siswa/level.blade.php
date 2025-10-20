<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peta Level | WarAcademy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            blackops: ['"Black Ops One"', 'sans-serif'],
            poppins: ['Poppins', 'sans-serif']
          }
        }
      }
    }
  </script>

  <style>
    body {
      overflow: hidden;
    }

    .neon-path {
      stroke: #60a5fa;
      stroke-width: 6;
      fill: none;
      stroke-dasharray: 14 10;
      stroke-linecap: round;
      filter: drop-shadow(0 0 8px rgba(96,165,250,0.7));
      animation: dashMove 5s linear infinite;
    }

    @keyframes dashMove {
      from { stroke-dashoffset: 300; }
      to { stroke-dashoffset: 0; }
    }

    .level-dot {
      r: 24;
      fill: url(#gradBlue);
      stroke: #a3d3fa;
      stroke-width: 3;
      filter: drop-shadow(0 0 10px rgba(96,165,250,0.8));
      cursor: pointer;
      transition: transform 0.25s ease;
      transform-box: fill-box;
      transform-origin: center;
    }

    .level-dot:hover {
      transform: scale(1.25);
      filter: drop-shadow(0 0 18px rgba(147,197,253,1));
    }

    .level-text {
      font-family: 'Poppins', sans-serif;
      fill: white;
      font-size: 16px;
      font-weight: bold;
      pointer-events: none;
    }

    .light-dot {
      r: 8;
      fill: #e0f2fe;
      filter: drop-shadow(0 0 10px rgba(147,197,253,0.9));
      opacity: 0.8;
    }

    .trophy-icon {
      font-size: 64px;
      text-anchor: middle;
      dominant-baseline: middle;
      filter: drop-shadow(0 0 12px rgba(250,204,21,1))
              drop-shadow(0 0 20px rgba(250,204,21,0.8))
              drop-shadow(0 0 35px rgba(250,204,21,0.5));
      cursor: pointer;
      transition: transform 0.3s ease;
      transform-box: fill-box;
      transform-origin: center;
    }

    .trophy-icon:hover {
      transform: scale(1.25);
      filter: drop-shadow(0 0 25px rgba(250,204,21,1))
              drop-shadow(0 0 35px rgba(250,204,21,0.9));
    }

    .back-btn {
      position: absolute;
      bottom: 20px;
      left: 20px;
      z-index: 40;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(106,168,250,0.55);
      color: white;
      padding: 6px 10px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.9rem;
      backdrop-filter: blur(6px);
    }

    .back-btn:hover { background: rgba(255,255,255,0.16); }
  </style>
</head>

<body class="bg-gradient-to-b from-[#0f1b2e] via-[#243b55] to-[#3b5875] min-h-screen text-white">
  <canvas id="particles" class="absolute inset-0 z-0"></canvas>
  <img src="/images/war.png" alt="Logo"
       style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) scale(1.5);
              height:300px;opacity:0.05;pointer-events:none;z-index:0;mix-blend-mode:lighten;">

  <h1 class="text-center text-5xl font-blackops mt-10 mb-6
             bg-gradient-to-b from-[#e5f2ff] via-[#a3d3fa] to-[#6aa8fa]
             bg-clip-text text-transparent 
             drop-shadow-[0_0_15px_rgba(70,150,255,0.6)]">
    Peta Level
  </h1>

  <svg id="levelMap" class="w-full h-[90vh] relative z-10"
       xmlns="http://www.w3.org/2000/svg"
       viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid meet">
    <defs>
      <linearGradient id="gradBlue" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%" stop-color="#3b82f6"/>
        <stop offset="100%" stop-color="#1e40af"/>
      </linearGradient>
    </defs>

    <path id="fullPath"
          d="M 100,750
             C 300,650 300,550 100,450
             S -100,250 100,150
             S 300,50 500,150
             S 700,250 500,350
             S 300,450 500,550
             S 700,650 900,550
             S 1100,450 900,350
             S 700,250 900,150
             S 1100,50 1200,150
             S 1300,250 1400,150"
          stroke="transparent" fill="none"/>

    <!-- Garis neon yang dimulai dari level 1 dan berhenti sebelum trofi -->
    <path id="visiblePath" class="neon-path" fill="none"/>

    <circle class="light-dot">
      <animateMotion dur="4s" repeatCount="indefinite" rotate="auto">
        <mpath href="#visiblePath"/>
      </animateMotion>
    </circle>

    <g id="levels"></g>
  </svg>

  <a class="back-btn" href="{{ route('home') }}">⬅ Kembali</a>

  <script>
  const fullPath = document.getElementById('fullPath');
  const visiblePath = document.getElementById('visiblePath');
  const pathLength = fullPath.getTotalLength();
  const numLevels = 20;
  const levelsGroup = document.getElementById('levels');

  // contoh hasil skor -> jumlah bintang
  const levelStars = {
    1: 3, // level 1: 2 bintang aktif
    2: 2,
    3: 0,
  };

  // potong path untuk garis neon
  const level1T = 1 / (numLevels + 1);
  const startFrom = pathLength * level1T;
  const endBeforeTrophy = pathLength * 0.975;
  const steps = 300;
  let d = `M ${fullPath.getPointAtLength(startFrom).x},${fullPath.getPointAtLength(startFrom).y}`;
  for (let i = 1; i <= steps; i++) {
    const l = startFrom + (endBeforeTrophy - startFrom) * (i / steps);
    const p = fullPath.getPointAtLength(l);
    d += ` L ${p.x},${p.y}`;
  }
  visiblePath.setAttribute('d', d);

  // generate setiap level
  for (let i = 0; i < numLevels; i++) {
    const levelNum = i + 1;
    const t = levelNum / (numLevels + 1);
    const pos = fullPath.getPointAtLength(pathLength * t);

    const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');

    // lingkaran level
    const c = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    c.setAttribute('class', 'level-dot');
    c.setAttribute('cx', pos.x);
    c.setAttribute('cy', pos.y);
    c.setAttribute('r', 22);
    c.addEventListener('click', () => window.location.href = `/level/${levelNum}`);

    // teks nomor level
    const txt = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    txt.setAttribute('x', pos.x);
    txt.setAttribute('y', pos.y + 6);
    txt.setAttribute('text-anchor', 'middle');
    txt.setAttribute('class', 'level-text');
    txt.textContent = levelNum;

    // buat elemen foreignObject untuk menaruh HTML bintang Font Awesome
    const fObj = document.createElementNS('http://www.w3.org/2000/svg', 'foreignObject');
    fObj.setAttribute('x', pos.x - 40);
    fObj.setAttribute('y', pos.y - 60); // posisi di atas lingkaran
    fObj.setAttribute('width', 80);
    fObj.setAttribute('height', 30);
    fObj.setAttribute('pointer-events', 'none');

    // buat HTML container bintang
    const starsDiv = document.createElement('div');
    starsDiv.style.display = 'flex';
    starsDiv.style.justifyContent = 'center';
    starsDiv.style.gap = '6px';
    starsDiv.style.fontSize = '16px';

    // jumlah bintang aktif
    const activeStars = levelStars[levelNum] || 0;

    for (let s = 0; s < 3; s++) {
      const star = document.createElement('i');
      star.classList.add('fa-star');
      star.classList.add('fa-solid');
      star.style.color = s < activeStars ? '#facc15' : '#9ca3af';
      star.style.filter = s < activeStars ? 'drop-shadow(0 0 5px rgba(250,204,21,0.8))' : 'none';
      starsDiv.appendChild(star);
    }

    fObj.appendChild(starsDiv);
    g.appendChild(fObj);
    g.appendChild(c);
    g.appendChild(txt);
    levelsGroup.appendChild(g);
  }

  // trofi akhir
  const trophyPos = fullPath.getPointAtLength(pathLength * 0.99);
  const trophy = document.createElementNS('http://www.w3.org/2000/svg', 'text');
  trophy.setAttribute('x', trophyPos.x);
  trophy.setAttribute('y', trophyPos.y + 10);
  trophy.setAttribute('class', 'trophy-icon');
  trophy.textContent = '🏆';
  trophy.addEventListener('click', () => window.location.href = "{{ route('tournament') }}");
  levelsGroup.appendChild(trophy);
</script>


  <script>
    // efek partikel
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext && canvas.getContext('2d');
    if (ctx) {
      function resize() { canvas.width = innerWidth; canvas.height = innerHeight; }
      resize();
      window.addEventListener('resize', resize);

      const particles = Array.from({length: 60}, () => ({
        x: Math.random()*canvas.width,
        y: Math.random()*canvas.height,
        size: Math.random()*2,
        speedX: (Math.random()-0.5)*0.4,
        speedY: (Math.random()-0.5)*0.4
      }));

      function draw() {
        ctx.clearRect(0,0,canvas.width,canvas.height);
        ctx.fillStyle = 'rgba(255,255,255,0.6)';
        particles.forEach(p => {
          ctx.beginPath();
          ctx.arc(p.x, p.y, p.size, 0, Math.PI*2);
          ctx.fill();
          p.x += p.speedX; p.y += p.speedY;
          if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
          if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
        });
        requestAnimationFrame(draw);
      }
      draw();
    }
  </script>
</body>
</html>
