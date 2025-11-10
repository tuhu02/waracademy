<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WAR ACADEMY</title>

  <!-- FONT GOOGLE -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Black+Ops+One&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { 
            poppins: ['Poppins', 'sans-serif'],
            blackops: ['"Black Ops One"', 'sans-serif']
          },
          keyframes: {
            fadeInDown: {
              '0%': { opacity: '0', transform: 'translateY(-20px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            fadeInUp: {
              '0%': { opacity: '0', transform: 'translateY(30px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' },
            },
            pulseLight: {
              '0%, 100%': { opacity: '0.7', transform: 'scale(1)' },
              '50%': { opacity: '1', transform: 'scale(1.3)' },
            }
          },
          animation: {
            fadeInDown: 'fadeInDown 1s ease-out',
            fadeInUp: 'fadeInUp 1.3s ease-out',
            fadeIn: 'fadeIn 1.8s ease-out',
            pulseLight: 'pulseLight 3s ease-in-out infinite',
          },
        },
      },
    }
  </script>
</head>

<body class="flex flex-col items-center justify-center h-screen text-white text-center bg-gradient-to-b from-[#0f1b2e] via-[#304863] to-[#3b5875] font-poppins overflow-hidden relative select-none">

  <!-- TEKS SELAMAT DATANG -->
  <div class="text-xl md:text-2xl mb-3 font-normal tracking-wide animate-fadeInDown z-10">
    Selamat Datang di
  </div>

  <!-- JUDUL WAR ACADEMY (Black Ops One) -->
  <div class="text-5xl md:text-7xl font-black font-blackops tracking-widest mb-10 animate-fadeInUp 
              bg-gradient-to-b from-[#dce6f2] via-[#a3d3fa] to-[#6aa8fa] bg-clip-text text-transparent 
              drop-shadow-[0_0_15px_rgba(50,120,200,0.8)] z-10 uppercase">
    WAR ACADEMY
  </div>

  <!-- TOMBOL MULAI PERMAINAN -->
  <form action="{{ route('login') }}" method="get" class="animate-fadeIn z-10">
    <button
        type="submit"
        class="relative px-10 py-3 text-lg md:text-xl font-semibold text-white rounded-lg border-2 border-[#1b3e75]
                bg-gradient-to-b from-[#2f5fa8] to-[#0c2957]
                shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)]
                hover:scale-105 hover:shadow-[0_0_25px_rgba(70,150,255,0.8)]
                hover:from-[#3d6fc0] hover:to-[#14386d]
                transition-all duration-300 ease-in-out overflow-hidden group font-poppins">

        <span class="relative z-10">Mulai Permainan</span>

        <!-- Cahaya melewati tombol -->
        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent
                    translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
    </button>
  </form>

  <!-- CAHAYA SUDUT KANAN BAWAH -->
  <div class="absolute right-12 bottom-10 w-4 h-4 rounded-full bg-white/80 blur-[2px] shadow-[0_0_25px_rgba(255,255,255,0.6)] animate-pulseLight"></div>

  <!-- CANVAS UNTUK PARTIKEL -->
  <canvas id="particles" class="absolute inset-0 z-0"></canvas>

  <!-- LOGO TRANSPARAN -->
  <img src="/images/war.png" alt="Logo" 
       class="absolute opacity-20 scale-150 animate-fadeIn" 
       style="top: 50%; left: 50%; transform: translate(-50%, -50%); width: auto; height: 500px;">

  <!-- SCRIPT PARTIKEL -->
  <script>
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    canvas.width = innerWidth;
    canvas.height = innerHeight;

    const particles = Array.from({length: 60}, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      size: Math.random() * 2,
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

    window.addEventListener('resize', () => {
      canvas.width = innerWidth;
      canvas.height = innerHeight;
    });
  </script>
</body>
</html>
