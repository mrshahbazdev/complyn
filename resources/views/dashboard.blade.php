<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-slate-900 rounded-2xl p-8 text-white">
                <p class="text-amber-400 text-sm font-semibold uppercase tracking-wide">{{ __('Willkommen zurück') }}</p>
                <h3 class="text-2xl font-bold mt-1">{{ auth()->user()->name }}</h3>
                <p class="text-slate-400 mt-1">{{ auth()->user()->companies->first()?->name ?? '' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('docs.index') }}" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:border-amber-400 transition group">
                    <div class="h-10 w-10 rounded-xl bg-amber-500/15 text-amber-500 flex items-center justify-center font-bold">D</div>
                    <h4 class="mt-4 font-semibold text-slate-900">{{ __('Docs') }}</h4>
                    <p class="text-sm text-slate-500 mt-1">{{ __('Compliance-Dokumente verwalten') }}</p>
                </a>
                <a href="{{ route('files.index') }}" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:border-amber-400 transition group">
                    <div class="h-10 w-10 rounded-xl bg-amber-500/15 text-amber-500 flex items-center justify-center font-bold">F</div>
                    <h4 class="mt-4 font-semibold text-slate-900">{{ __('Files') }}</h4>
                    <p class="text-sm text-slate-500 mt-1">{{ __('Dateien hochladen und teilen') }}</p>
                </a>
                <a href="{{ route('library.index') }}" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:border-amber-400 transition group">
                    <div class="h-10 w-10 rounded-xl bg-amber-500/15 text-amber-500 flex items-center justify-center font-bold">L</div>
                    <h4 class="mt-4 font-semibold text-slate-900">{{ __('Library') }}</h4>
                    <p class="text-sm text-slate-500 mt-1">{{ __('Wissen, Vorlagen und Artikel') }}</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
