<div id="editProfilModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded p-6 w-full max-w-lg">
        <h2 class="text-lg font-semibold mb-4">Edit Profil</h2>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-3">
                <label class="block text-sm mb-1">Deskripsi Profil</label>
                <textarea name="deskripsi_profil" class="w-full border rounded p-2" rows="3">{{ old('deskripsi_profil', $user->deskripsi_profil) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm mb-2">Pilih Avatar</label>
                <div class="grid grid-cols-6 gap-2">
                    @foreach($availableAvatars as $avatar)
                        <label class="cursor-pointer text-center">
                            <input type="radio" name="avatar" value="{{ $avatar }}" class="hidden" {{ (old('avatar', basename($user->avatar_url ?? '')) == $avatar) ? 'checked' : '' }}>
                            <img src="{{ asset('avatars/'.$avatar) }}" alt="{{ $avatar }}" class="w-16 h-16 rounded-full border p-1">
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="document.getElementById('editProfilModal').classList.add('hidden')" class="px-4 py-2 rounded border">Batal</button>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Simpan</button>
            </div>
        </form>
    </div>
</div>
