<section>
    <header>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">
            Update Password
        </h2>

        <p class="mt-1 flex items-center gap-2 text-sm font-bold text-slate-400">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1 mb-2">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 transition-all placeholder:text-slate-300 shadow-inner" autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1 mb-2">New Password</label>
            <input id="update_password_password" name="password" type="password" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 transition-all placeholder:text-slate-300 shadow-inner" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1 mb-2">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 transition-all placeholder:text-slate-300 shadow-inner" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs font-bold text-rose-500" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100/50">
            <button type="submit" class="bg-slate-900 text-white px-8 py-3.5 rounded-[1.2rem] font-black text-sm hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 active:scale-95 leading-none">
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p  x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-black text-emerald-500 flex items-center gap-2 bg-emerald-50 px-4 py-2 rounded-xl"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    Password Updated
                </p>
            @endif
        </div>
    </form>
</section>
