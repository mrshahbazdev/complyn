<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic sky"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></span>
            <div><h1>{{ __("Aufgabenverwaltung") }}</h1><p class="ph-sub">{{ __("Offene und erledigte Aufgaben") }}</p></div>
        </div>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif

    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-head"><h3>{{ __("Neue Aufgabe") }}</h3></div>
        <div class="panel-body">
        <form method="POST" action="{{ route('core.tasks.store') }}" class="filter-bar">
            @csrf
            <div class="field" style="flex:2;min-width:200px"><input class="field-input" name="title" required placeholder="{{ __('Aufgabe…') }}"></div>
            <div class="field"><input class="field-input" name="due_at" type="date"></div>
            <select name="assigned_to" class="f-select">
                <option value="">{{ __("— Zugewiesen an —") }}</option>
                @foreach ($members as $m)<option value="{{ $m->id }}">{{ $m->name }}</option>@endforeach
            </select>
            <button class="btn btn-brand">{{ __('+ Aufgabe') }}</button>
        </form>
        </div>
    </div>

    <div class="card table-card fade-up" style="animation-delay:.1s">
        <div class="table-head">
            <div class="ph-left"><span class="p-ic sky"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg></span><h3>{{ __("Alle Aufgaben") }}</h3></div>
            <span class="pill">{{ $tasks->total() }} {{ __('Einträge') }}</span>
        </div>
        <div class="table-scroll">
        <table class="docs">
            <thead><tr><th>{{ __("Aufgabe") }}</th><th>{{ __("Fällig") }}</th><th>{{ __("Zugewiesen an") }}</th><th>{{ __("Status") }}</th><th></th></tr></thead>
            <tbody>
            @forelse ($tasks as $t)
                <tr>
                    <td><p style="font-weight:700;{{ $t->status === 'done' ? 'color:var(--slate-400);text-decoration:line-through' : 'color:var(--slate-900)' }}">{{ $t->title }}</p></td>
                    <td>@if ($t->due_at)<span class="duedate">{{ \Illuminate\Support\Carbon::parse($t->due_at)->format('d.m.Y') }}</span>@endif</td>
                    <td>@if ($t->assignee)<div class="doc-cell"><span class="ava sm bg-violet">{{ strtoupper(mb_substr($t->assignee->name,0,2)) }}</span><span style="font-size:13px;font-weight:600">{{ $t->assignee->name }}</span></div>@endif</td>
                    <td class="text-right">
                        <div class="filter-bar" style="justify-content:flex-end">
                        <form method="POST" action="{{ route('core.tasks.toggle', $t) }}">@csrf @method('PUT')
                            <button class="badge {{ $t->status === 'done' ? 'green' : 'blue' }}" style="border:0;cursor:pointer"><span class="cdot"></span>{{ $t->status === 'done' ? __('erledigt') : __('offen') }}</button>
                        </form>
                        <form method="POST" action="{{ route('core.tasks.destroy', $t) }}" onsubmit="return confirm('{{ __('Löschen?') }}')">@csrf @method('DELETE')
                            <button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Löschen") }}</button>
                        </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4"><div class="empty"><p>{{ __("Keine Aufgaben vorhanden.") }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="panel-body">{{ $tasks->links() }}</div>
    </div>
</div>
</x-app-layout>
