<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Turnamen - Main</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-slate-900 text-white font-poppins p-6">
  <div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-4">{{ $turnamen->nama_turnamen }}</h1>
    <h2 class="text-xl font-bold">Sisa Waktu: <span id="timer"></span></h2>
    <p class="mb-4">Kode Room: <strong>{{ $turnamen->kode_room }}</strong></p>
    <p class="mb-6">Durasi: {{ $turnamen->durasi_pengerjaan }} menit | Peserta maksimal: {{ $turnamen->max_peserta }}</p>

    <section class="bg-white/5 p-4 rounded-lg mb-6">
      <h2 class="text-xl font-semibold mb-2">Soal (preview)</h2>
      @if(count($questions) === 0)
        <p class="text-gray-300">Belum ada soal tersedia.</p>
      @else
        <ol class="list-decimal ml-6 space-y-4 text-gray-100">
          @foreach($questions as $q)
            <li>
              <div class="font-medium">{{ $q['text'] }}</div>
              <ul class="list-disc ml-6 text-sm text-gray-200">
                @foreach($q['choices'] as $c)
                  <li>{{ $c->teks_jawaban }}</li>
                @endforeach
              </ul>
            </li>
          @endforeach
        </ol>
      @endif
    </section>

    <button onclick="finishQuiz()" class="mt-6 px-5 py-2 bg-[#6aa8fa]/80 rounded-lg text-white font-semibold hover:bg-[#6aa8fa] transition">Selesai</button>

    <div class="text-sm text-gray-400">Halaman ini adalah halaman awal permainan. Implementasi pengambilan soal, timer, dan submit jawaban dapat ditambahkan di sini.</div>
  </div>



  <script>
      const serverTime   = new Date("{{ now()->toDateTimeString() }}").getTime();
      const startTime    = new Date("{{ $turnamen->start_time }}").getTime();
      const endTime      = new Date("{{ $turnamen->end_time }}").getTime();

      const drift = Date.now() - serverTime;  
      // => selisih HP dengan server

      function updateTimer() {
          const now = Date.now() - drift;
          const remaining = Math.max(0, Math.floor((endTime - now) / 1000));

          if (remaining <= 0) {
              document.body.innerHTML = "<h1>Waktu Habis</h1>";
              return;
          }

          document.getElementById("timer").innerText = format(remaining);
      }

      function format(s) {
          let m = Math.floor(s / 60);
          let d = s % 60;
          return `${m}:${d.toString().padStart(2,'0')}`;
      }

      setInterval(updateTimer, 1000);


      function finishQuiz() {
          fetch("{{ route('tournament.finish', ['idPeserta' => session('id_peserta')]) }}", {
              method: "POST",
              headers: {
                  "X-CSRF-TOKEN": "{{ csrf_token() }}",
                  "Accept": "application/json",
              }
          })
          .then(res => res.json())
          .then(data => {
              console.log("Score:", data);
              // tampilkan UI score breakdown
          });
      }

  </script>

</body>
</html>