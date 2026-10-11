<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic violet"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></span>
            <div><h1>{{ $doc->title }}</h1><p class="ph-sub">{{ $doc->category?->name_de }}</p></div>
        </div>
        <div class="filter-bar">
            <span class="badge {{ $doc->released_at ? 'green' : 'gray' }}"><span class="cdot"></span>{{ $doc->released_at ? __('freigegeben') : $doc->status }}</span>
            <form method="POST" action="{{ route('docs.release', $doc) }}">@csrf @method('PUT')
                <button class="btn btn-outline btn-sm">{{ $doc->released_at ? __("Freigabe zurückziehen") : __("Freigeben") }}</button>
            </form>
        </div>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif

    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-head"><h3>{{ __('Details') }}</h3></div>
        <div class="panel-body">
        <form method="POST" action="{{ route('docs.update', $doc) }}">
            @csrf @method('PUT')
            <div class="field"><label>{{ __('Titel') }}</label><input name="title" value="{{ $doc->title }}" required></div>
            <div class="field"><label>{{ __('Beschreibung') }}</label><textarea name="description" rows="2">{{ $doc->description }}</textarea></div>
            <div class="filter-bar">
                <select name="category_id" class="f-select">
                    <option value="">{{ __("— Kategorie —") }}</option>
                    @foreach (\App\Models\Category::orderBy('name_de')->get() as $c)<option value="{{ $c->id }}" @selected($doc->category_id === $c->id)>{{ $c->name_de }}</option>@endforeach
                </select>
                <select name="status" class="f-select">
                    @foreach (['draft','published','archived'] as $s)<option value="{{ $s }}" @selected($doc->status === $s)>{{ $s }}</option>@endforeach
                </select>
                <div class="field"><input name="tags" value="{{ $doc->tags->pluck('name')->join(', ') }}" placeholder="{{ __('Tags') }}"></div>
                <button class="btn btn-brand btn-sm">{{ __('Speichern') }}</button>
            </div>
        </form>
        <form method="POST" action="{{ route('docs.destroy', $doc) }}" onsubmit="return confirm('{{ __('Löschen?') }}')" style="margin-top:12px">
            @csrf @method('DELETE')<button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Dokument löschen") }}</button>
        </form>
        </div>
    </div>

    <div class="card table-card fade-up" style="animation-delay:.1s">
        <div class="table-head">
            <div class="ph-left"><h3>{{ __("Versionen") }}</h3></div>
            <form method="POST" action="{{ route('docs.versions.upload', $doc) }}" enctype="multipart/form-data" class="filter-bar">
                @csrf
                <input type="file" name="file" required class="f-select" style="padding:7px 10px">
                <button class="btn btn-brand btn-sm">{{ __('Neue Version') }}</button>
            </form>
        </div>
        <div class="table-scroll">
        <table class="docs">
            <tbody>
            @forelse ($doc->versions->sortByDesc('version') as $v)
                <tr>
                    <td><p style="font-weight:700;color:var(--slate-900)">v{{ $v->version }} — {{ $v->original_name }}</p></td>
                    <td class="muted">{{ number_format($v->size / 1024, 1) }} KB</td>
                    <td><span class="duedate">{{ $v->created_at->format('d.m.Y H:i') }}</span></td>
                    <td><a href="{{ route('docs.versions.download', [$doc, $v->version]) }}" class="btn btn-outline btn-sm">{{ __('Download') }}</a></td>
                </tr>
            @empty
                <tr><td colspan="4"><div class="empty"><p>{{ __('Keine Versionen.') }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
</x-app-layout>
