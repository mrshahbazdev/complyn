<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic amber"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></span>
            <div><h1>{{ __("Handlungsempfehlungen") }}</h1><p class="ph-sub">{{ __('Vom Coach generierte Maßnahmen') }}</p></div>
        </div>
    </div>
    @forelse ($recs as $r)
        <div class="card fade-up dl-card" style="border-left:4px solid {{ $r['severity'] === 'critical' ? '#ef4444' : ($r['severity'] === 'warning' ? '#f59e0b' : ($r['severity'] === 'success' ? '#10b981' : '#94a3b8')) }};padding:16px 20px">
            <div>
                <p style="font-weight:700;color:var(--slate-900)">{{ $r['title'] }}</p>
                <p class="muted" style="margin-top:4px">{{ $r['body'] }}</p>
            </div>
        </div>
    @empty
        <div class="card empty"><p>{{ __('Keine Empfehlungen.') }}</p></div>
    @endforelse
    <a href="{{ route('coach.index') }}" class="flink">← {{ __('Zum KI-Coach') }}</a>
</div>
</x-app-layout>
