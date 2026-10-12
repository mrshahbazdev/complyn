<x-app-layout>
    <x-slot name="header">{{ __('Dashboard') }}</x-slot>

    <div class="stack">
        <div class="page-head fade-up">
            <div>
                <div class="date">{{ now()->locale($locale ?? 'de')->translatedFormat('l, d. F Y') }}</div>
                <h1>{{ __('Guten Tag') }}, {{ auth()->user()->name }}</h1>
                <div class="sub">{{ $company?->name ?? __('Kein Unternehmen zugeordnet') }}</div>
            </div>
        </div>

        @if ($company)
        <div class="kpi-grid fade-up" style="animation-delay:.05s">
            <a href="{{ route('docs.index') }}" class="card kpi" style="--acc: var(--brand-500); text-decoration:none;">
                <div class="kpi-top"><span class="kpi-label">{{ __('Dokumente') }}</span></div>
                <div class="kpi-val">{{ $docsCount }}</div>
                <div class="kpi-foot"><span class="kpi-sub">{{ __('Gesamt im Archiv') }}</span></div>
            </a>
            <a href="{{ route('files.index') }}" class="card kpi" style="--acc: var(--slate-500); text-decoration:none;">
                <div class="kpi-top"><span class="kpi-label">{{ __('Dateien') }}</span></div>
                <div class="kpi-val">{{ $filesCount }}</div>
                <div class="kpi-foot"><span class="kpi-sub">{{ __('Hochgeladene Dateien') }}</span></div>
            </a>
            <a href="{{ route('core.tasks') }}" class="card kpi" style="--acc: #2563eb; text-decoration:none;">
                <div class="kpi-top"><span class="kpi-label">{{ __('Offene Aufgaben') }}</span></div>
                <div class="kpi-val">{{ $openTasks->count() }}</div>
                <div class="kpi-foot"><span class="kpi-sub">{{ __('Zu erledigen') }}</span></div>
            </a>
            <a href="{{ route('core.obligations') }}" class="card kpi" style="--acc: {{ $overdueObligations ? '#dc2626' : '#16a34a' }}; text-decoration:none;">
                <div class="kpi-top"><span class="kpi-label">{{ __('Überfällig') }}</span></div>
                <div class="kpi-val">{{ $overdueObligations }}</div>
                <div class="kpi-foot"><span class="kpi-sub">{{ $overdueObligations ? __('Sofort handeln!') : __('Alles im grünen Bereich') }}</span></div>
            </a>
        </div>

        <div class="row2 fade-up" style="animation-delay:.1s">
            <div class="card panel">
                <div class="panel-head">
                    <h3>{{ __('Nächste Fristen') }} <span class="muted">(≤30 {{ __('Tage') }})</span></h3>
                    <a href="{{ route('core.deadlines') }}" class="link">{{ __('Alle →') }}</a>
                </div>
                <div class="panel-body">
                    @forelse ($upcomingDeadlines as $d)
                        @php
                            $over = $d->due_at && $d->due_at->isPast();
                            $cls = $over ? 'p-red' : ($d->due_at && $d->due_at->lte(now()->addDays(7)) ? 'p-amber' : '');
                        @endphp
                        <div class="dl-card {{ $cls }}">
                            <div class="dl-date"><b>{{ optional($d->due_at)->format('d') }}</b><span>{{ optional($d->due_at)->translatedFormat('M') }}</span></div>
                            <div class="dl-info">
                                <div class="dl-title">{{ $d->title }}</div>
                                @if($over)<div class="dl-sub" style="color:#dc2626;">{{ __('Überfällig') }}</div>@endif
                            </div>
                        </div>
                    @empty
                        <p class="muted">{{ __('Keine Fristen in den nächsten 30 Tagen.') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="card panel">
                <div class="panel-head">
                    <h3>{{ __('Offene Aufgaben') }}</h3>
                    <a href="{{ route('core.tasks') }}" class="link">{{ __('Alle →') }}</a>
                </div>
                <div class="panel-body">
                    @forelse ($openTasks as $t)
                        <div class="dl-card">
                            <div class="dl-info">
                                <div class="dl-title">{{ $t->title }}</div>
                                <div class="dl-sub">{{ optional($t->due_at)->format('d.m.Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="muted">{{ __('Keine offenen Aufgaben.') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="card panel">
                <div class="panel-head"><h3>{{ __('Benachrichtigungen') }}</h3>
                    <a href="{{ route('notifications.index') }}" class="link">{{ __('Alle →') }}</a>
                </div>
                <div class="panel-body">
                    @forelse ($notifications as $n)
                        <div class="dl-card">
                            <div class="dl-info"><div class="dl-title">{{ $n->data['title'] ?? class_basename($n->type) }}</div>
                            <div class="dl-sub">{{ $n->created_at->diffForHumans() }}</div></div>
                        </div>
                    @empty
                        <p class="muted">{{ __('Keine neuen Benachrichtigungen.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card panel fade-up" style="animation-delay:.15s">
            <div class="panel-head"><h3>{{ __('Aktive Module') }}</h3></div>
            <div class="panel-body">
                @foreach ($modules as $m)<span class="badge" style="margin:2px;">{{ $m->key }}</span>@endforeach
            </div>
        </div>
        @else
        <div class="card panel"><div class="panel-body">
            <p>{{ __('Kein Unternehmen zugeordnet — bitte den Admin um Zuordnung bitten.') }}</p>
        </div></div>
        @endif
    </div>
</x-app-layout>
