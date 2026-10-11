<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic amber"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></span>
            <div><h1>{{ __("Pflichtenkalender") }}</h1><p class="ph-sub">{{ __("Alle Pflichten im Überblick") }}</p></div>
        </div>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif

    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-head"><h3>{{ __("Neue Pflicht") }}</h3></div>
        <div class="panel-body">
        <form method="POST" action="{{ route('core.obligations.store') }}" class="filter-bar">
            @csrf
            <div class="field" style="flex:2;min-width:200px"><input name="title" required placeholder="{{ __('Titel der Pflicht…') }}"></div>
            <div class="field"><input name="next_due_at" type="date"></div>
            <select name="interval_months" class="f-select">
                <option value="12">{{ __("jährlich") }}</option><option value="6">{{ __("halbjährlich") }}</option>
                <option value="3">{{ __("vierteljährlich") }}</option><option value="24">{{ __("alle 2 Jahre") }}</option>
            </select>
            <div class="field" style="flex:1.5;min-width:160px"><input name="description" placeholder="{{ __('Beschreibung') }}"></div>
            <button class="btn btn-brand">{{ __('+ Pflicht') }}</button>
        </form>
        </div>
    </div>

    <div class="card table-card fade-up" style="animation-delay:.1s">
        <div class="table-head">
            <div class="ph-left"><span class="p-ic amber"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></span><h3>{{ __("Alle Pflichten") }}</h3></div>
            <span class="pill">{{ $obligations->total() }} {{ __('Einträge') }}</span>
        </div>
        <div class="table-scroll">
        <table class="docs">
            <thead><tr><th>{{ __("Pflicht") }}</th><th>{{ __("Intervall") }}</th><th>{{ __("Nächste Frist") }}</th><th>{{ __("Verantwortlich") }}</th><th>{{ __("Nachweise") }}</th><th>{{ __("Status") }}</th><th></th></tr></thead>
            <tbody>
            @forelse ($obligations as $o)
                @php $past = $o->next_due_at && \Illuminate\Support\Carbon::parse($o->next_due_at)->isPast() && $o->status !== 'done'; @endphp
                <tr>
                    <td><div><p style="font-weight:700;color:var(--slate-900)">{{ $o->title }}</p><span class="muted">{{ $o->description }}</span></div></td>
                    <td><span class="htag">{{ __("alle") }} {{ $o->interval_months }} {{ __("Monate") }}</span></td>
                    <td>@if ($o->next_due_at)<span class="{{ $past ? 'overdue' : 'duedate' }}">{{ \Illuminate\Support\Carbon::parse($o->next_due_at)->format('d.m.Y') }}<small>{{ $past ? __('überfällig') : \Illuminate\Support\Carbon::parse($o->next_due_at)->diffForHumans() }}</small></span>@endif</td>
                    <td>
                        @foreach ($o->responsibilities as $r)<div class="doc-cell"><span class="ava sm bg-emerald">{{ strtoupper(mb_substr($r->user->name,0,2)) }}</span><span style="font-size:13px;font-weight:600">{{ $r->user->name }}</span></div>@endforeach
                        <form method="POST" action="{{ route('core.obligations.assign', $o) }}" class="filter-bar" style="margin-top:4px">@csrf
                            <select name="user_id" class="f-select">@foreach ($members as $m)<option value="{{ $m->id }}">{{ $m->name }}</option>@endforeach</select>
                            <button class="btn btn-outline btn-sm">{{ __("zuweisen") }}</button>
                        </form>
                    </td>
                    <td><span class="badge {{ $o->evidences_count ? 'green' : 'gray' }}">{{ $o->evidences_count }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('core.obligations.status', $o) }}">@csrf @method('PUT')
                            <button name="status" value="{{ $o->status === 'done' ? 'active' : 'done' }}" class="badge {{ $o->status === 'done' ? 'green' : 'blue' }}" style="border:0;cursor:pointer"><span class="cdot"></span>{{ $o->status === 'done' ? __('erledigt') : __('offen') }}</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('core.obligations.destroy', $o) }}" onsubmit="return confirm('{{ __('Löschen?') }}')">@csrf @method('DELETE')
                            <button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Löschen") }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><div class="empty"><p>{{ __("Keine Pflichten vorhanden.") }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="panel-body">{{ $obligations->links() }}</div>
    </div>
</div>
</x-app-layout>
