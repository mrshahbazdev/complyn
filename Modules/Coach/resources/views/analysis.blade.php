<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __('Unternehmensanalyse & Branchenvergleich') }}</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <div class="font-semibold text-gray-900 dark:text-gray-100">{{ __('Branche') }}: {{ $industry?->name_de ?? __('Nicht gesetzt') }}</div>
                    <div class="text-sm text-gray-600 mt-1">{{ $covered }}/{{ $total }} {{ __('typische Pflichten abgedeckt') }}</div>
                </div>
                <form method="POST" action="{{ route('coach.industry') }}" class="flex items-center gap-2">
                    @csrf
                    <select name="industry_id" class="rounded border-slate-300 text-sm">
                        @foreach ($industries as $i)<option value="{{ $i->id }}" @selected($industry?->id === $i->id)>{{ $i->name_de }}</option>@endforeach
                    </select>
                    <button class="bg-slate-900 text-white rounded-lg px-3 py-1.5 text-sm">{{ __('Setzen') }}</button>
                </form>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm divide-y">
            @foreach ($rows as $r)
                <div class="p-4 flex items-start gap-3">
                    <span class="mt-0.5 h-5 w-5 rounded-full text-xs flex items-center justify-center {{ $r['covered'] ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $r['covered'] ? '✓' : '!' }}</span>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $r['duty'] }}</div>
                        <div class="text-xs text-gray-500">{{ __('Intervall') }}: {{ $r['interval'] }}</div>
                    </div>
                    @unless ($r['covered'])
                        <a href="{{ route('core.obligations') }}" class="text-amber-600 text-xs whitespace-nowrap">{{ __('Pflicht anlegen →') }}</a>
                    @endunless
                </div>
            @endforeach
        </div>
        <a href="{{ route('coach.index') }}" class="text-amber-600 text-sm">← {{ __('Zum KI-Coach') }}</a>
    </div></div>
</x-app-layout>
