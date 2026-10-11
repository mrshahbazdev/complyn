<x-app-layout>
    <x-slot name="header">{{ __("Fachgruppen & Themennnetzwerke") }}</x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('exchange.groups.store') }}" class="flex flex-wrap gap-2">
                @csrf
                <input name="name" required placeholder="{{ __('Gruppenname…') }}" class="field-input">
                <input name="topic" placeholder="{{ __('Thema') }}" class="field-input">
                <button class="btn btn-dark">+ {{ __('Gruppe') }}</button>
                <a href="{{ route('exchange.index') }}" class="text-amber-600 text-sm self-center">{{ __('Marktplatz') }}</a>
            </form>
        </div>
        <div class="grid sm:grid-cols-2 gap-3">
            @forelse ($groups as $g)
                <a href="{{ route('exchange.groups.show', $g) }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-4 block">
                    <div class="t-strong">{{ $g->name }}</div>
                    <div class="text-xs text-gray-500">{{ $g->topic }} · {{ $g->topics_count }} {{ __('Diskussionen') }}</div>
                </a>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-6 text-sm text-gray-500">{{ __("Noch keine Gruppen.") }}</div>
            @endforelse
        </div>
</div>
</x-app-layout>
