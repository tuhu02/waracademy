<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Top 100 Leaderboard | WarAcademy</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Scrollbar Custom */
    .leaderboard-scroll::-webkit-scrollbar { width: 4px; }
    .leaderboard-scroll::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
    .leaderboard-scroll::-webkit-scrollbar-thumb {
        background: rgba(0, 140, 255, 0.5);
        border-radius: 10px;
    }

    /* Animasi Fade In Up */
    @keyframes fadeInSlide {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .row-animate { 
        animation: fadeInSlide 0.5s ease forwards;
        opacity: 0;
    }

    /* Hover Effect Row */
    .hover-glow:hover {
        background: rgba(255, 255, 255, 0.08); 
        box-shadow: inset 0 0 15px rgba(0,150,255,0.1); 
    }

    /* Medal Default Styling */
    .medal-default { 
        width: 28px; height: 28px; 
        display: flex; align-items: center; justify-content: center; 
        font-weight: bold; color: #ccc; font-size: 0.9rem;
    }
    @media (min-width: 768px) {
        .medal-default { width: 35px; height: 35px; font-size: 1.1rem; }
    }

    /* Animated Background */
    @keyframes bgGradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .bg-animated {
        background: linear-gradient(270deg, #0f1b2e, #304863, #3b5875, #0f1b2e);
        background-size: 400% 400%;
        animation: bgGradient 20s ease infinite;
    }

    /* Particles */
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

    /* Grid Template Columns Responsive */
    .grid-leaderboard {
        display: grid;
        grid-template-columns: 45px 1fr 60px 60px; /* Mobile Layout */
        gap: 0.5rem;
        align-items: center;
    }
    @media (min-width: 768px) {
        .grid-leaderboard {
            grid-template-columns: 80px 1fr 100px 100px; /* Desktop Layout */
            gap: 1rem;
        }
    }
</style>
</head>

<body class="relative bg-animated text-white min-h-screen overflow-hidden flex flex-col">

<div class="absolute inset-0 overflow-hidden z-0 pointer-events-none">
    @for ($i = 0; $i < 50; $i++)
        <div class="particle w-1 h-1" style="
            top: {{ rand(0,100) }}%;
            left: {{ rand(0,100) }}%;
            width: {{ rand(1,3) }}px;
            height: {{ rand(1,3) }}px;
            animation-delay: {{ rand(0,10) }}s;
            "></div>
    @endfor
</div>

<div class="absolute top-4 left-4 z-50 hidden md:block">
    <a href="{{ route('home') }}">
        <button class="relative bg-white/10 hover:bg-white/20 text-white px-5 py-2 rounded-xl font-semibold border border-white/20 shadow-lg transition-all">
             ← Kembali
        </button>
    </a>
</div>

<div class="relative z-10 pt-6 pb-2 px-4 text-center">
    <h1 class="text-2xl md:text-4xl font-bold drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)] uppercase tracking-wider text-transparent bg-clip-text bg-gradient-to-b from-white to-blue-300">
        🏆 Leaderboard
    </h1>
    <p class="text-xs md:text-sm text-blue-200 mt-1">Top 100 Pemain Terbaik</p>
</div>

<div class="relative z-10 w-full max-w-4xl mx-auto flex-1 flex flex-col px-4 pb-24 md:pb-8 overflow-hidden">
    
    <div class="bg-black/20 backdrop-blur-xl rounded-xl shadow-2xl border border-white/10 flex flex-col h-full max-h-[70vh] md:max-h-[80vh]">

        <div class="grid-leaderboard px-4 py-3 border-b border-white/10 bg-white/5 font-bold text-xs md:text-base text-blue-200 uppercase tracking-wide">
            <div class="text-center">#</div>
            <div class="text-left pl-2">Player</div>
            <div class="text-center">XP</div>
            <div class="text-center">Star</div>
        </div>

        <div class="overflow-y-auto leaderboard-scroll flex-1 p-2">
            @foreach ($users as $index => $u)
                @php
                    $rank = $index + 1;
                    $delay = min($index * 0.05, 1.0); // Cap animation delay
                    $isMe = isset($myUser) && $myUser->id == $u->id;
                    
                    // Medal logic (simplified for performance)
                    $medalHtml = '';
                    if($rank == 1) $medalHtml = '<img src="'.asset("images/medal/gold.svg").'" class="w-6 h-6 md:w-8 md:h-8 drop-shadow-md">';
                    elseif($rank == 2) $medalHtml = '<img src="'.asset("images/medal/silver.svg").'" class="w-6 h-6 md:w-8 md:h-8 drop-shadow-md">';
                    elseif($rank == 3) $medalHtml = '<img src="'.asset("images/medal/bronze.svg").'" class="w-6 h-6 md:w-8 md:h-8 drop-shadow-md">';
                    else $medalHtml = '<span class="font-mono font-bold text-gray-400 text-sm md:text-lg">'.$rank.'</span>';
                @endphp

                <div class="grid-leaderboard px-3 py-3 mb-1 rounded-lg transition-all row-animate {{ $isMe ? 'bg-blue-600/30 border border-blue-400/50' : 'hover-glow border-b border-white/5' }}"
                     style="animation-delay: {{ $delay }}s">

                    <div class="flex items-center justify-center">
                        {!! $medalHtml !!}
                    </div>

                    <div class="flex items-center gap-3 overflow-hidden">
                        <img src="{{ asset('avatars/'.$u->avatar_url) }}" class="w-8 h-8 md:w-10 md:h-10 rounded-full border border-white/30 shadow-sm object-cover shrink-0 bg-black/40">
                        <div class="flex flex-col truncate">
                            <span class="font-semibold text-sm md:text-base text-white truncate {{ $isMe ? 'text-yellow-200' : '' }}">
                                {{ $u->username }}
                            </span>
                             </div>
                    </div>

                    <div class="text-center font-bold text-xs md:text-sm text-yellow-300 truncate">
                        {{ number_format($u->total_exp) }}
                    </div>

                    <div class="text-center font-bold text-xs md:text-sm text-orange-300 truncate">
                         {{ number_format($u->total_bintang) }}
                    </div>

                </div>
            @endforeach

            @if(count($users) == 0)
                <div class="text-center py-10 text-gray-400 text-sm">
                    Belum ada data leaderboard.
                </div>
            @endif
        </div>
    </div>
</div>

@if(isset($myUser))
<div class="fixed bottom-0 left-0 w-full z-40 px-4 pb-4 pt-2 bg-gradient-to-t from-[#0f1b2e] to-transparent md:relative md:bg-none md:p-0 md:mt-4 md:max-w-4xl md:mx-auto">
    <div class="bg-[#1e40af]/90 backdrop-blur-md rounded-xl shadow-[0_-4px_20px_rgba(0,0,0,0.5)] border-t border-blue-400/40 p-3 md:p-4 flex items-center justify-between transform transition hover:scale-[1.01]">
        
        <div class="flex items-center gap-3 md:gap-4 overflow-hidden flex-1">
             <div class="bg-black/30 w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center font-bold text-white border border-white/10 shrink-0">
                #{{ $myUserRank ?? '-' }}
            </div>
            
            <img src="{{ asset('avatars/'.$myUser->avatar_url) }}" class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-yellow-400 shadow-md object-cover shrink-0 bg-black/40">
            
            <div class="flex flex-col overflow-hidden">
                <span class="text-xs text-blue-200 font-medium uppercase tracking-wider">My Rank</span>
                <span class="font-bold text-sm md:text-lg text-white truncate">{{ $myUser->username }}</span>
            </div>
        </div>

        <div class="flex gap-4 md:gap-8 shrink-0">
            <div class="text-center">
                <div class="text-[10px] md:text-xs text-blue-200 uppercase">XP</div>
                <div class="font-bold text-sm md:text-lg text-yellow-300">{{ number_format($myUser->total_exp) }}</div>
            </div>
            <div class="text-center">
                <div class="text-[10px] md:text-xs text-blue-200 uppercase">Star</div>
                <div class="font-bold text-sm md:text-lg text-orange-300">{{ number_format($myUser->total_bintang) }}</div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="fixed bottom-24 right-4 md:hidden z-30">
    <a href="{{ route('home') }}">
        <button class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center shadow-lg active:scale-90 transition">
             <span class="text-xl">🏠</span>
        </button>
    </a>
</div>

</body>
</html>