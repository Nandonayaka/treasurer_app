<x-app-layout>
    <div class="py-10 md:py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">My Profile</h1>
                <p class="text-slate-500 font-medium mt-2">Manage your account settings and preferences.</p>
            </div>

            <div class="space-y-8">
                <!-- Profile Information -->
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-100/50 p-6 md:p-10 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="relative z-10">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-100/50 p-6 md:p-10 relative overflow-hidden">
                    <div class="absolute -left-10 -top-10 w-40 h-40 bg-blue-50 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="relative z-10">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white rounded-[2rem] border border-rose-100 shadow-xl shadow-rose-100/50 p-6 md:p-10 relative overflow-hidden">
                    <div class="absolute right-0 bottom-0 w-40 h-40 bg-rose-50 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="relative z-10">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
