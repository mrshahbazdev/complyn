<x-app-layout>
    <x-slot name="header">{{ __('Dashboard') }}</x-slot>

    <div class="stack">
        <div class="page-head fade-up">
            <div class="ph-left">
                <div class="p-ic amber">C</div>
                <div>
                    <h1>{{ __('Willkommen zurück') }}, {{ auth()->user()->name }}</h1>
                    <div class="ph-sub">{{ auth()->user()->companies->first()?->name ?? '' }}</div>
                </div>
            </div>
        </div>

        <div class="kpi-grid fade-up">
            <a href="{{ route('docs.index') }}" class="card kpi" style="--acc: var(--brand-500); text-decoration:none;">
                <div class="kpi-top"><span class="kpi-label">{{ __('Docs') }}</span></div>
                <div class="kpi-val">D</div>
                <div class="kpi-foot"><span class="kpi-sub">{{ __('Compliance-Dokumente verwalten') }}</span></div>
            </a>
            <a href="{{ route('files.index') }}" class="card kpi" style="--acc: var(--slate-500); text-decoration:none;">
                <div class="kpi-top"><span class="kpi-label">{{ __('Files') }}</span></div>
                <div class="kpi-val">F</div>
                <div class="kpi-foot"><span class="kpi-sub">{{ __('Dateien hochladen und teilen') }}</span></div>
            </a>
            <a href="{{ route('library.index') }}" class="card kpi" style="--acc: #2563eb; text-decoration:none;">
                <div class="kpi-top"><span class="kpi-label">{{ __('Library') }}</span></div>
                <div class="kpi-val">L</div>
                <div class="kpi-foot"><span class="kpi-sub">{{ __('Wissen, Vorlagen und Artikel') }}</span></div>
            </a>
        </div>
    </div>
</x-app-layout>
