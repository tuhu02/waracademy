<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | WarAcademy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        poppins: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom styles for the starry background and animations */
        body {
            background-color: #0F172A;
            background-image: 
                radial-gradient(white, rgba(255,255,255,.2) 2px, transparent 40px),
                radial-gradient(white, rgba(255,255,255,.15) 1px, transparent 30px),
                radial-gradient(white, rgba(255,255,255,.1) 2px, transparent 40px),
                radial-gradient(rgba(255,255,255,.4), rgba(255,255,255,.1) 2px, transparent 30px);
            background-size: 550px 550px, 350px 350px, 250px 250px, 150px 150px; 
            background-position: 0 0, 40px 60px, 130px 270px, 70px 100px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }

    </style>
</head>
<body class="font-poppins text-white min-h-screen flex items-center justify-center p-4">

    <div class="bg-[#1E293B]/60 backdrop-blur-sm border border-slate-700 rounded-2xl w-full max-w-md p-8 shadow-2xl animate-fadeIn">
        
        <!-- Login Form -->
        <div class="w-full">
            <h2 class="text-3xl font-bold text-center text-white mb-2">Selamat Datang Kembali!</h2>
            <p class="text-slate-400 text-center mb-8">Masuk untuk melanjutkan petualanganmu.</p>
            
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="space-y-4">
                    <div class="opacity-0 animate-fadeIn delay-200" style="animation-fill-mode: forwards;">
                        <label class="block text-sm font-medium mb-2 text-slate-300">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required placeholder="Masukkan username"
                               class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                    </div>
                    <div class="opacity-0 animate-fadeIn delay-300" style="animation-fill-mode: forwards;">
                        <label class="block text-sm font-medium mb-2 text-slate-300">Password</label>
                        <input type="password" name="password" required placeholder="Masukkan password"
                               class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full mt-8 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all transform hover:scale-105 duration-300 opacity-0 animate-fadeIn delay-400" style="animation-fill-mode: forwards;">
                    Masuk
                </button>

                @if($errors->any())
                    <p class="text-red-500 text-sm text-center mt-4">{{ $errors->first() }}</p>
                @endif

                <div class="flex items-center my-6 opacity-0 animate-fadeIn delay-500" style="animation-fill-mode: forwards;">
                    <div class="flex-grow border-t border-slate-700"></div>
                    <span class="px-4 text-slate-500 text-sm">ATAU</span>
                    <div class="flex-grow border-t border-slate-700"></div>
                </div>

                <div class="text-center opacity-0 animate-fadeIn delay-600" style="animation-fill-mode: forwards;">
                    <a href="{{ route('google.redirect') }}" 
                       class="inline-flex items-center justify-center bg-slate-800 border border-slate-700 w-full px-4 py-2.5 rounded-lg text-sm text-slate-300 hover:bg-slate-700 transition transform hover:scale-105 duration-300">
                        <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5 mr-3">
                        Login dengan Google
                    </a>
                </div>
            </form>

             <p class="text-center text-sm text-slate-400 mt-6">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-semibold text-blue-500 hover:underline">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>

</body>
</html>
