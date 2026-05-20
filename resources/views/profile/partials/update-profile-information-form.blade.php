<section>
    <header>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">
            Informasi Profil
        </h2>

        <p class="mt-1 flex items-center gap-2 text-sm font-bold text-slate-400">
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1 mb-2">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300 shadow-inner" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error class="mt-2 text-xs font-bold text-rose-500" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1 mb-2">Alamat Email</label>
            <input id="email" name="email" type="email" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300 shadow-inner" value="{{ old('email', $user->email) }}" required autocomplete="username" placeholder="Alamat email aktif Anda" />
            <x-input-error class="mt-2 text-xs font-bold text-rose-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-3 font-bold text-slate-600 bg-amber-50 p-4 rounded-xl border border-amber-100">
                        Your email address is unverified.
                        <button form="send-verification" class="text-amber-600 hover:text-amber-700 underline underline-offset-2 transition-colors focus:outline-none">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 font-bold text-sm text-emerald-600 bg-emerald-50 p-4 rounded-xl border border-emerald-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100/50">
            <button type="submit" class="bg-slate-900 text-white px-8 py-3.5 rounded-[1.2rem] font-black text-sm hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 active:scale-95 leading-none">
                Simpan Perubahan
            </button>

            </button>
        </div>
    </form>
</section>
