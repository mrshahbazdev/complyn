<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic violet"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></span>
            <div><h1>{{ __("Dokumente") }}</h1><p class="ph-sub">{{ __('Alle Dokumente verwalten') }}</p></div>
        </div>
        <a href="{{ route('docs.create') }}" class="btn btn-brand">{{ __('+ Neues Dokument') }}</a>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif

    <div class="card table-card fade-up" style="animation-delay:.05s">
        <div class="table-head">
            <div class="filter-bar">
                <form method="GET" class="filter-bar">
                    <div class="mini-search"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg><input name="q" value="{{ request('q') }}" placeholder="{{ __('Titel suchen…') }}"></div>
                    <select name="category" class="f-select">
                        <option value="">{{ __("— Kategorie —") }}</option>
                        @foreach ($categories as $c)<option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name_de }}</option>@endforeach
                    </select>
                    <button class="btn btn-outline btn-sm">{{ __('Filtern') }}</button>
                </form>
            </div>
            <span class="pill">{{ $docs->total() }} {{ __('Einträge') }}</span>
        </div>
        <div class="table-scroll">
        <table class="docs">
            <thead><tr><th>{{ __("Titel") }}</th><th>{{ __("Kategorie") }}</th><th>{{ __("Tags") }}</th><th>{{ __("Status") }}</th><th>{{ __("Version") }}</th><th>{{ __("Datum") }}</th></tr></thead>
            <tbody>
            @forelse ($docs as $d)
                <tr>
                    <td><a href="{{ route('docs.show', $d) }}" class="flink" style="font-weight:700">{{ $d->title }}</a></td>
                    <td class="muted">{{ $d->category?->name_de }}</td>
                    <td>@foreach ($d->tags as $t)<span class="htag">{{ $t->name }}</span>@endforeach</td>
                    <td><span class="badge {{ $d->status === 'published' ? 'green' : ($d->status === 'archived' ? 'gray' : 'blue') }}"><span class="cdot"></span>{{ $d->status }}</span></td>
                    <td class="muted">v{{ $d->latestVersion?->version ?? 0 }}</td>
                    <td><span class="duedate">{{ $d->created_at->format('d.m.Y') }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="empty"><p>{{ __('Keine Dokumente.') }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="panel-body">{{ $docs->links() }}</div>
    </div>
</div>
</x-app-layout>
