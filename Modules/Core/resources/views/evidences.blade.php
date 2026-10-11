<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic green"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
            <div><h1>{{ __("Nachweismanagement") }}</h1><p class="ph-sub">{{ __("Nachweise zu Pflichten hinterlegen") }}</p></div>
        </div>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif

    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-head"><h3>{{ __("Neuer Nachweis") }}</h3></div>
        <div class="panel-body">
        <form method="POST" action="{{ route('core.evidences.store') }}" enctype="multipart/form-data" class="filter-bar">
            @csrf
            <div class="field" style="flex:2;min-width:200px"><input name="title" required placeholder="{{ __('Nachweis-Titel…') }}"></div>
            <select name="core_obligation_id" required class="f-select">
                <option value="">{{ __("— Pflicht —") }}</option>
                @foreach ($obligations as $o)<option value="{{ $o->id }}">{{ $o->title }}</option>@endforeach
            </select>
            <div class="field"><input name="note" placeholder="{{ __('Notiz') }}"></div>
            <input name="file" type="file" class="f-select" style="padding:7px 10px">
            <button class="btn btn-brand">{{ __('+ Nachweis') }}</button>
        </form>
        </div>
    </div>

    <div class="card table-card fade-up" style="animation-delay:.1s">
        <div class="table-head">
            <div class="ph-left"><span class="p-ic green"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg></span><h3>{{ __("Alle Nachweise") }}</h3></div>
            <span class="pill">{{ $evidences->total() }} {{ __('Einträge') }}</span>
        </div>
        <div class="table-scroll">
        <table class="docs">
            <thead><tr><th>{{ __("Nachweis") }}</th><th>{{ __("Pflicht") }}</th><th>{{ __("Datei") }}</th><th>{{ __("Datum") }}</th><th></th></tr></thead>
            <tbody>
            @forelse ($evidences as $e)
                <tr>
                    <td><div><p style="font-weight:700;color:var(--slate-900)">{{ $e->title }}</p><span class="muted">{{ $e->note }}</span></div></td>
                    <td class="muted">{{ $e->obligation->title }}</td>
                    <td>@if ($e->file)<a class="flink" href="{{ route('files.download', $e->file) }}">{{ $e->file->original_name }}</a>@else<span class="muted">—</span>@endif</td>
                    <td><span class="duedate">{{ $e->created_at->format('d.m.Y') }}</span></td>
                    <td><form method="POST" action="{{ route('core.evidences.destroy', $e) }}" onsubmit="return confirm('{{ __('Löschen?') }}')">@csrf @method('DELETE')<button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Löschen") }}</button></form></td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="empty"><p>{{ __("Keine Nachweise vorhanden.") }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="panel-body">{{ $evidences->links() }}</div>
    </div>
</div>
</x-app-layout>
