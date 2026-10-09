@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 bg-white focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm']) }}>
