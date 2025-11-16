<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Top 100 Leaderboard | WarAcademy</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Scrollbar */
    .leaderboard-scroll::-webkit-scrollbar { width: 6px; }
    .leaderboard-scroll::-webkit-scrollbar-thumb {
        background: rgba(0, 140, 255, 0.5);
        border-radius: 10px;
    }

    /* Animasi row */
    @keyframes fadeInSlide {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .row-animate { 
        animation: fadeInSlide 0.5s ease forwards;
        opacity: 0;
    }

    /* Hover efek */
    .hover-glow:hover {
        background: rgba(255, 255, 255, 0.02); 
        box-shadow: 0 0 10px rgba(0,150,255,0.15); 
    }
   
    .grid > .row-animate {
        border-bottom: 1px solid rgba(255,255,255,0.05); 
        background: rgba(255,255,255,0.02); 
    }

    
    stop[stop-color="white"] {
        stop-color: rgba(255,255,255,0.3); 
    }

    /* Medal default */
    .medal-default { 
        width: 35px; 
        height: 35px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: bold; 
        color: #ccc; 
    }

    .medal-svg { display: block; }

    /* Background gradient bergerak */
    @keyframes bgGradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .bg-animated {
        background: linear-gradient(270deg, #0f1b2e, #304863, #3b5875, #0f1b2e);
        background-size: 800% 800%;
        animation: bgGradient 20s ease infinite;
    }

    /* Particle bergerak */
    @keyframes particleMove {
        0% { transform: translateY(0) translateX(0); opacity: 0.3; }
        50% { transform: translateY(20px) translateX(10px); opacity: 0.8; }
        100% { transform: translateY(0) translateX(0); opacity: 0.3; }
    }
    .particle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.7);
        animation: particleMove 6s infinite ease-in-out;
    }
</style>
</head>

<body class="relative bg-animated text-white min-h-screen p-6 overflow-hidden">

<!-- Background particle/bintang -->
<div class="absolute inset-0 overflow-hidden z-0">
    @for ($i = 0; $i < 100; $i++)
        <div class="particle w-1 h-1" style="
            top: {{ rand(0,100) }}%;
            left: {{ rand(0,100) }}%;
            width: {{ rand(1,3) }}px;
            height: {{ rand(1,3) }}px;
            animation-delay: {{ rand(0,10) }}s;
            "></div>
    @endfor
</div>

<h1 class="relative z-10 text-center text-3xl font-bold mb-6 mt-2 drop-shadow-lg">🏆 Leaderboard</h1>

<div class="relative z-10 max-w-5xl mx-auto mt-4 bg-white/10 backdrop-blur-md rounded-xl shadow-xl border border-white/20">

    <!-- HEADER STICKY -->
    <div class="grid grid-cols-[2fr_1fr_1fr] items-center px-4 py-3 border-b border-white/20 sticky top-0 z-10 bg-white/5">
        <div class="text-left text-lg">Ranking</div>
        <div class="text-center text-lg">Exp</div>
        <div class="text-center text-lg">Star</div>
    </div>

    <!-- SCROLLABLE LEADERBOARD -->
    <div class="max-h-[500px] overflow-y-auto leaderboard-scroll">

        @foreach ($users as $index => $u)
            @php
                $rank = $index + 1;
                $delay = $index * 0.08;

                // Medal SVG shimmer effect
                $medal = match($rank) {
                    1 => '
                    <svg class="medal-svg w-12 h-12" viewBox="0 0 100 100">
                        <defs>
                            <linearGradient id="shimmer-gold" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="white" stop-opacity="0"/>
                                <stop offset="50%" stop-color="white" stop-opacity="0.6"/>
                                <stop offset="100%" stop-color="white" stop-opacity="0"/>
                            </linearGradient>
                            <mask id="mask-gold">
                                <image href="'.asset("images/medal/gold.svg").'" width="100" height="100"/>
                            </mask>
                        </defs>
                        <image href="'.asset("images/medal/gold.svg").'" width="100" height="100"/>
                        <rect width="100" height="100" fill="url(#shimmer-gold)" mask="url(#mask-gold)">
                            <animate attributeName="x" from="-100" to="100" dur="2s" repeatCount="indefinite"/>
                        </rect>
                    </svg>',
                    2 => '
                    <svg class="medal-svg w-10 h-10" viewBox="0 0 80 80">
                        <defs>
                            <linearGradient id="shimmer-silver" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="white" stop-opacity="0"/>
                                <stop offset="50%" stop-color="white" stop-opacity="0.5"/>
                                <stop offset="100%" stop-color="white" stop-opacity="0"/>
                            </linearGradient>
                            <mask id="mask-silver">
                                <image href="'.asset("images/medal/silver.svg").'" width="80" height="80"/>
                            </mask>
                        </defs>
                        <image href="'.asset("images/medal/silver.svg").'" width="80" height="80"/>
                        <rect width="80" height="80" fill="url(#shimmer-silver)" mask="url(#mask-silver)">
                            <animate attributeName="x" from="-80" to="80" dur="2s" repeatCount="indefinite"/>
                        </rect>
                    </svg>',
                    3 => '
                    <svg class="medal-svg w-8 h-8" viewBox="0 0 70 70">
                        <defs>
                            <linearGradient id="shimmer-bronze" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="white" stop-opacity="0"/>
                                <stop offset="50%" stop-color="white" stop-opacity="0.5"/>
                                <stop offset="100%" stop-color="white" stop-opacity="0"/>
                            </linearGradient>
                            <mask id="mask-bronze">
                                <image href="'.asset("images/medal/bronze.svg").'" width="70" height="70"/>
                            </mask>
                        </defs>
                        <image href="'.asset("images/medal/bronze.svg").'" width="70" height="70"/>
                        <rect width="70" height="70" fill="url(#shimmer-bronze)" mask="url(#mask-bronze)">
                            <animate attributeName="x" from="-70" to="70" dur="2s" repeatCount="indefinite"/>
                        </rect>
                    </svg>',
                    default => "<div class='medal-default'>{$rank}</div>",
                };
            @endphp

            <div class="grid grid-cols-[2fr_1fr_1fr] items-center px-4 py-4 border-b border-white/10 hover-glow row-animate"
                 style="animation-delay: {{ $delay }}s">

                <div class="flex items-center gap-3">
                    <!-- Wrapper medal fixed height agar semua sejajar -->
                    <div class="flex items-center justify-center h-12 w-12">
                        {!! $medal !!}
                    </div>

                    <img src="{{ asset('avatars/'.$u->avatar_url) }}" class="w-12 h-12 rounded-lg border border-blue-300 shadow-md">
                    <p class="font-semibold text-blue-100 text-lg truncate">{{ $u->username }}</p>
                </div>

                <div class="text-yellow-300 font-semibold text-center text-lg">✨ {{ number_format($u->total_exp) }}</div>

                <div class="text-orange-300 font-semibold text-center text-lg">⭐ {{ number_format($u->total_bintang) }}</div>

            </div>
        @endforeach

    </div>
    
     <!-- USER RANK BAWAH -->
    @if(isset($myUser))
    <div class="max-w-5xl mx-auto bg-white/20 backdrop-blur-md rounded-xl shadow-xl border border-white/30 p-4">
        <div class="grid grid-cols-[2fr_1fr_1fr] items-center gap-3">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center h-12 w-12">
                    @php
                        $myRank = $myUserRank ?? 0;
                        if ($myRank == 1) {
                            $medal = '<img src="'.asset("images/medal/gold.svg").'" class="w-12 h-12" />';
                        } elseif ($myRank == 2) {
                            $medal = '<img src="'.asset("images/medal/silver.svg").'" class="w-10 h-10" />';
                        } elseif ($myRank == 3) {
                            $medal = '<img src="'.asset("images/medal/bronze.svg").'" class="w-8 h-8" />';
                        } else {
                            $medal = "<div class='medal-default'>{$myRank}</div>";
                        }
                    @endphp
                    {!! $medal !!}
                </div>
                <img src="{{ asset('avatars/'.$myUser->avatar_url) }}" class="w-12 h-12 rounded-lg border border-blue-300 shadow-md">
                <p class="font-semibold text-blue-100 text-lg truncate">{{ $myUser->username }}</p>
            </div>
            <div class="text-yellow-300 font-semibold text-center text-lg">✨ {{ number_format($myUser->total_exp) }}</div>
            <div class="text-orange-300 font-semibold text-center text-lg">⭐ {{ number_format($myUser->total_bintang) }}</div>
        </div>
    </div>
    @endif
</div>

<!-- Tombol Kembali floating kanan bawah -->
<div class="fixed bottom-6 right-6 z-50">
    <a href="{{ route('home') }}">
        <button class="relative bg-gradient-to-b from-[#2f5fa8] to-[#0c2957] text-white px-6 py-2 rounded-xl font-semibold 
                       border border-[#1b3e75]
                       shadow-[0_4px_10px_rgba(0,0,30,0.5),inset_0_1px_1px_rgba(255,255,255,0.2)]
                       hover:scale-105 hover:shadow-[0_0_20px_rgba(70,150,255,0.7)]
                       transition-all duration-300 ease-in-out overflow-hidden group">
            <span class="relative z-10">← Kembali</span>
            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                          translate-x-[-100%] group-hover:translate-x-[100%] 
                          transition-transform duration-700"></span>
        </button>
    </a>
</div>

</body>
</html>
