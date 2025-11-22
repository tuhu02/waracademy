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
    .max-tabel {
    max-height: 70vh;
    }
    @media (min-width: 768px) {
        .medal-default { width: 35px; height: 35px; font-size: 1.1rem; }
        .max-tabel { max-height: 80vh; }
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

<div class="relative z-10 w-full max-w-4xl mx-auto flex flex-col h-[calc(100vh-6rem)] px-4 pb-32 md:pb-8 overflow-hidden">
    {{-- Podium Top 3 --}}
    <div class="flex justify-center items-end gap-6 mt-10 mb-6 md:mb-8">
        {{-- Rank 2 --}}
        @if(isset($users[1]))
        <div class="flex flex-col items-center">
            <div class="relative w-16 md:w-20 h-24 md:h-28">
                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <img src="{{ asset('images/medal/silver.svg') }}" class="w-8 h-8 md:w-10 md:h-10 animate-bounce">
                </div>
                <div class="bg-gray-700/90 w-full h-full rounded-t-lg flex items-center justify-center shadow-lg">
                    <img src="{{ asset('avatars/' . ($users[1]->avatar_url ?? 'cat.png')) }}" class="w-12 h-12 md:w-16 md:h-16 rounded-full border border-white/30 object-cover">
                </div>
            </div>
            <span class="mt-1 font-semibold text-sm md:text-base text-white text-center truncate">{{ $users[1]->username }}</span>
            <span class="text-xs text-yellow-300">{{ number_format($users[1]->total_exp) }} EXP</span>
        </div>
        @endif

        {{-- Rank 1 --}}
        @if(isset($users[0]))
        <div class="flex flex-col items-center">
            <div class="relative w-20 md:w-24 h-32 md:h-40">
                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <img src="{{ asset('images/medal/gold.svg') }}" class="w-10 h-10 md:w-12 md:h-12 animate-bounce">
                </div>
                <div class="bg-yellow-300/90 w-full h-full rounded-t-lg flex items-center justify-center shadow-2xl">
                    <img src="{{ asset('avatars/' . ($users[0]->avatar_url ?? 'cat.png')) }}" class="w-14 h-14 md:w-20 md:h-20 rounded-full border border-white/30 object-cover">
                </div>
            </div>
            <span class="mt-1 font-bold text-base md:text-lg text-white text-center truncate">{{ $users[0]->username }}</span>
            <span class="text-sm text-yellow-300">{{ number_format($users[0]->total_exp) }} EXP</span>
        </div>
        @endif

        {{-- Rank 3 --}}
        @if(isset($users[2]))
        <div class="flex flex-col items-center">
            <div class="relative w-16 md:w-20 h-20 md:h-24">
                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <img src="{{ asset('images/medal/bronze.svg') }}" class="w-8 h-8 md:w-10 md:h-10 animate-bounce">
                </div>
                <div class="bg-amber-700/70 w-full h-full rounded-t-lg flex items-center justify-center shadow-lg">
                    <img src="{{ asset('avatars/' . ($users[2]->avatar_url ?? 'cat.png')) }}" class="w-12 h-12 md:w-16 md:h-16 rounded-full border border-white/30 object-cover">
                </div>
            </div>
            <span class="mt-1 font-semibold text-sm md:text-base text-white text-center truncate">{{ $users[2]->username }}</span>
            <span class="text-xs text-yellow-300">{{ number_format($users[2]->total_exp) }} EXP</span>
        </div>
        @endif
    </div>

    {{-- Table Leaderboard rank 4 ke bawah --}}
    <div class="bg-black/20 backdrop-blur-xl rounded-xl shadow-2xl border border-white/10 flex-1 flex flex-col overflow-hidden min-h-0">
        <!-- Header Tabel -->
        <div class="grid-leaderboard px-4 py-3 border-b border-white/10 bg-white/5 font-bold text-xs md:text-base text-blue-200 uppercase tracking-wide">
            <div class="text-center">#</div>
            <div class="text-left pl-2">Player</div>
            <div class="text-center">EXP</div>
            <div class="text-center">Star</div>
        </div>

        <!-- Scrollable Body -->
        <div class="overflow-y-auto flex-1 min-h-0 leaderboard-scroll p-2">
            @foreach ($users as $index => $u)
            @if($index >= 3)
            @php
                $rank = $index + 1;
                $isMe = isset($myUser) && $myUser->id == $u->id;
                $rowClasses = $isMe 
                    ? 'bg-blue-600/40 border border-blue-400/50 shadow-lg scale-[1.02]'
                    : 'hover-glow border-b border-white/10';
            @endphp

            <div class="grid-leaderboard px-3 py-3 mb-1 rounded-xl transition-all row-animate {{ $rowClasses }}" style="animation-delay: {{ min($index*0.05,1) }}s">
                <div class="flex items-center justify-center">
                    <span class="font-mono font-bold text-gray-400 text-sm md:text-lg">{{ $rank }}</span>
                </div>
                <div class="flex items-center gap-3 overflow-hidden">
                    <img src="{{ asset('avatars/' . ($u->avatar_url ?? 'cat.png')) }}" class="w-8 h-8 md:w-10 md:h-10 rounded-full border border-white/30 shadow-sm object-cover shrink-0 bg-black/40">
                    <div class="flex flex-col truncate">
                        <span class="font-semibold text-sm md:text-base text-white truncate {{ $isMe ? 'text-yellow-200' : '' }}">{{ $u->username }}</span>
                    </div>
                </div>
                <div class="text-center font-bold text-xs md:text-sm text-yellow-300 truncate">{{ number_format($u->total_exp) }}</div>
                <div class="text-center font-bold text-xs md:text-sm text-orange-300 truncate">{{ number_format($u->total_bintang) }}</div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>



<div class="fixed bottom-24 right-4 md:hidden z-30">
    <a href="{{ route('home') }}">
        <button class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center shadow-lg active:scale-90 transition">
             <span class="text-xl">🏠</span>
        </button>
    </a>
</div>

</body>
</html>