<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic violet"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></span>
            <div><h1>{{ __('Unternehmensanalyse & Branchenvergleich') }}</h1><p class="ph-sub">{{ $covered }}/{{ $total }} {{ __('typische Pflichten abgedeckt') }}</p></div>
        </div>
        <form method="POST" action="{{ route('coach.industry') }}" class="filter-bar">
            @csrf
            <select name="industry_id" class="f-select">
                @foreach ($industries as $i)<option value="{{ $i->id }}" @selected($industry?->id === $i->id)>{{ $i->name_de }}</option>@endforeach
            </select>
            <button class="btn btn-brand btn-sm">{{ __('Setzen') }}</button>
        </form>
    </div>

    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-head"><h3>{{ __('Branche') }}: {{ $industry?->name_de ?? __('Nicht gesetzt') }}</h3><span class="pill">{{ $covered }}/{{ $total }}</span></div>
        <div class="panel-body" style="padding:0">
            <div class="dl-list">
            @forelse ($rows as $r)
                <div class="dl-card {{ $r['covered'] ? 'p-slate' : 'p-amber' }}" style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-left:3px solid {{ $r['covered'] ? '#10b981' : '#f59e0b' }}">
                    <span class="badge {{ $r['covered'] ? 'green' : 'red' }}" style="border-radius:50%;width:26px;height:26px;justify-content:center;padding:0">{{ $r['covered'] ? '✓' : '!' }}</span>
                    <div style="flex:1">
                        <p style="font-weight:700;color:var(--slate-900)">{{ $r['duty'] }}</p>
                        <span class="muted">{{ __('Intervall') }}: {{ $r['interval'] }}</span>
                    </div>
                    @unless ($r['covered'])
                        <a href="{{ route('core.obligations') }}" class="btn btn-outline btn-sm">{{ __('Pflicht anlegen →') }}</a>
                    @endunless
                </div>
            @empty
                <div class="empty"><p>{{ __('Keine Daten.') }}</p></div>
            @endforelse
            </div>
        </div>
    </div>
    <a href="{{ route('coach.index') }}" class="flink">← {{ __('Zum KI-Coach') }}</a>
</div>
</x-app-layout>
