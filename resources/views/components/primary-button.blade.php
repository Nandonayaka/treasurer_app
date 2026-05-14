<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:from-emerald-700 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-lg shadow-emerald-200 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
