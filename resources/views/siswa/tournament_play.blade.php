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

    <div class="text-sm text-gray-400">Halaman ini adalah halaman awal permainan. Implementasi pengambilan soal, timer, dan submit jawaban dapat ditambahkan di sini.</div>
  </div>
</body>
</html>