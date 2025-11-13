<!-- Modal Edit Profil -->
<div id="editProfilModal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center z-50"
     x-data="{ selectedAvatar: '{{ $user->avatar_url ?? 'cat.png' }}' }">

  <div class="bg-[#1b2a41] border border-blue-400/40 rounded-2xl p-6 w-[90%] max-w-md shadow-xl text-white relative">
    <h2 class="text-2xl font-semibold mb-4 text-center text-blue-200">Edit Profil</h2>

    <!-- Tombol tutup -->
    <button onclick="document.getElementById('editProfilModal').classList.add('hidden')"
            class="absolute top-3 right-3 text-blue-300 hover:text-blue-100 text-xl">
      ✕
    </button>
    
    <form action="{{ route('profil.update', session('pengguna_id')) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      @method('PUT')

      <!-- Username -->
      <div>
        <label class="block text-sm text-blue-200 mb-1">Nama Pengguna</label>
        <input type="text" name="username" value="{{ $user->username }}"
               class="w-full bg-[#243b55] text-white border border-blue-300/40 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
      </div>

      <!-- Deskripsi -->
      <div>
        <label class="block text-sm text-blue-200 mb-1">Deskripsi Profil</label>
        <textarea name="deskripsi_profil" rows="3"
                  class="w-full bg-[#243b55] text-white border border-blue-300/40 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 outline-none resize-none">{{ $user->deskripsi_profil }}</textarea>
      </div>

      <!-- Pilihan Avatar -->
      <div>
        <label class="block text-sm text-blue-200 mb-2 text-center">Pilih Avatar</label>
        <div class="flex justify-center gap-4 flex-wrap">
          @foreach(['cat.png', 'dog.png', 'fox.png', 'lion.png', 'owl.png', 'panda.png'] as $avatar)
            <div 
              class="relative cursor-pointer transition-all duration-200"
              :class="selectedAvatar === '{{ $avatar }}' ? 'scale-110' : 'scale-100'"
              @click="selectedAvatar = '{{ $avatar }}'; $refs.avatarInput.value = '{{ $avatar }}'">

              <img src="{{ asset('avatars/' . $avatar) }}" 
                   alt="{{ pathinfo($avatar, PATHINFO_FILENAME) }}"
                   class="w-16 h-16 rounded-full border-4 transition-all duration-200"
                   :class="selectedAvatar === '{{ $avatar }}' ? 'border-blue-400 shadow-[0_0_10px_rgba(80,150,255,0.8)]' : 'border-transparent opacity-80 hover:opacity-100'">
            </div>
          @endforeach
        </div>
        <input type="hidden" name="avatar_url" x-ref="avatarInput" value="{{ $user->avatar_url }}">
      </div>

      <!-- Tombol Simpan -->
      <div class="text-center mt-4">
        <button type="submit"
                class="px-6 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg font-semibold transition text-white">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
