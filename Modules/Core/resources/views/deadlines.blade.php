<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic red"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
            <div><h1>{{ __("Fristenverwaltung") }}</h1><p class="ph-sub">{{ __("Alle Fristen im Blick") }}</p></div>
        </div>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif

    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-head"><h3>{{ __("Neue Frist") }}</h3></div>
        <div class="panel-body">
        <form method="POST" action="{{ route('core.deadlines.store') }}" class="filter-bar">
            @csrf
            <div class="field" style="flex:2;min-width:200px"><input class="field-input" name="title" required placeholder="{{ __('Frist…') }}"></div>
            <div class="field"><input class="field-input" name="due_at" type="date" required></div>
            <select name="core_obligation_id" class="f-select">
                <option value="">{{ __("— Pflicht —") }}</option>
                @foreach ($obligations as $o)<option value="{{ $o->id }}">{{ $o->title }}</option>@endforeach
            </select>
            <select name="responsible_id" class="f-select">
                <option value="">{{ __("— Verantwortlich —") }}</option>
                @foreach ($members as $m)<option value="{{ $m->id }}">{{ $m->name }}</option>@endforeach
            </select>
            <button class="btn btn-brand">{{ __('+ Frist') }}</button>
        </form>
        </div>
    </div>

    <div class="card table-card fade-up" style="animation-delay:.1s">
        <div class="table-head">
            <div class="ph-left"><span class="p-ic red"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></span><h3>{{ __("Alle Fristen") }}</h3></div>
            <span class="pill">{{ $deadlines->total() }} {{ __('Einträge') }}</span>
        </div>
        <div class="table-scroll">
        <table class="docs">
            <thead><tr><th>{{ __("Frist") }}</th><th>{{ __("Datum") }}</th><th>{{ __("Pflicht") }}</th><th>{{ __("Verantwortlich") }}</th><th>{{ __("Status") }}</th><th></th></tr></thead>
            <tbody>
            @forelse ($deadlines as $d)
                @php $past = $d->status === 'open' && \Illuminate\Support\Carbon::parse($d->due_at)->isPast(); @endphp
                <tr>
                    <td><p style="font-weight:700;color:var(--slate-900)">{{ $d->title }}</p></td>
                    <td><span class="{{ $past ? 'overdue' : 'duedate' }}">{{ \Illuminate\Support\Carbon::parse($d->due_at)->format('d.m.Y') }}<small>{{ $past ? __('überfällig') : '' }}</small></span></td>
                    <td class="muted">{{ $d->obligation?->title }}</td>
                    <td>@if ($d->responsible)<div class="doc-cell"><span class="ava sm bg-sky">{{ strtoupper(mb_substr($d->responsible->name,0,2)) }}</span><span style="font-size:13px;font-weight:600">{{ $d->responsible->name }}</span></div>@endif</td>
                    <td>
                        <form method="POST" action="{{ route('core.deadlines.toggle', $d) }}">@csrf @method('PUT')
                            <button class="badge {{ $d->status === 'done' ? 'green' : ($past ? 'red' : 'blue') }}" style="border:0;cursor:pointer"><span class="cdot"></span>{{ $d->status === 'done' ? __('erledigt') : ($past ? __('überfällig') : __('offen')) }}</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('core.deadlines.destroy', $d) }}" onsubmit="return confirm('{{ __('Löschen?') }}')">@csrf @method('DELETE')
                            <button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Löschen") }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="empty"><p>{{ __("Keine Fristen vorhanden.") }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="panel-body">{{ $deadlines->links() }}</div>
    </div>
</div>
</x-app-layout>
