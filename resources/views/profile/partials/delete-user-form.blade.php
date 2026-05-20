<section class="space-y-8">
    <header>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">
            Hapus Akun
        </h2>

        <p class="mt-1 flex items-center gap-2 text-sm font-bold text-slate-400">
            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Hapus akun Anda dan semua data terkait secara permanen.
        </p>
    </header>

    <div class="bg-rose-50 border border-rose-100 rounded-2xl p-6">
        <p class="text-xs font-bold text-rose-600 leading-relaxed">
            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun, silakan unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
        
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="mt-6 bg-rose-600 text-white px-8 py-3.5 rounded-[1.2rem] font-black text-sm hover:bg-rose-700 transition-all shadow-xl shadow-rose-200 active:scale-95 leading-none"
        >Hapus Akun</button>
    </div>

    <!-- Reusing existing x-modal since it works fine, just restyling the inner form -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 text-rose-600 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <h2 class="text-2xl font-black tracking-tight">
                    Apakah Anda Yakin?
                </h2>
            </div>

            <p class="mt-2 text-sm font-bold text-slate-500 leading-relaxed">
                Setelah akun Anda dihapus, semua data akan hilang selamanya. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.
            </p>

            <div class="mt-8">
                <label for="password" class="sr-only">Password</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-500 transition-all placeholder:text-slate-300 shadow-inner"
                    placeholder="Masukkan kata sandi untuk konfirmasi"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs font-bold text-rose-500" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3.5 rounded-[1.2rem] font-black text-sm text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-all">
                    Batal
                </button>

                <button type="submit" class="bg-rose-600 text-white px-8 py-3.5 rounded-[1.2rem] font-black text-sm hover:bg-rose-700 transition-all shadow-xl shadow-rose-200 active:scale-95 leading-none">
                    Hapus Akun Sekarang
                </button>
            </div>
        </form>
    </x-modal>
</section>
