<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Fachgruppen & Themennnetzwerke") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <form method="POST" action="{{ route('exchange.groups.store') }}" class="flex flex-wrap gap-2">
                @csrf
                <input name="name" required placeholder="{{ __('Gruppenname…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm flex-1 min-w-48">
                <input name="topic" placeholder="{{ __('Thema') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                <button class="bg-slate-900 text-white px-4 py-2 rounded text-sm">+ {{ __('Gruppe') }}</button>
                <a href="{{ route('exchange.index') }}" class="text-amber-600 text-sm self-center">{{ __('Marktplatz') }}</a>
            </form>
        </div>
        <div class="grid sm:grid-cols-2 gap-3">
            @forelse ($groups as $g)
                <a href="{{ route('exchange.groups.show', $g) }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-4 block">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $g->name }}</div>
                    <div class="text-xs text-gray-500">{{ $g->topic }} · {{ $g->topics_count }} {{ __('Diskussionen') }}</div>
                </a>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-6 text-sm text-gray-500">{{ __("Noch keine Gruppen.") }}</div>
            @endforelse
        </div>
    </div></div>
</x-app-layout>
