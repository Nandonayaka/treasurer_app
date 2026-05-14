@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/50 border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm transition-all duration-200 placeholder:text-slate-300']) }}>
