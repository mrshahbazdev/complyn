<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic sky"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></span>
            <div><h1>{{ __("Suche") }}</h1><p class="ph-sub">{{ __('Dokumente durchsuchen') }}</p></div>
        </div>
    </div>
    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-body">
        <form method="GET" class="filter-bar">
            <div class="mini-search" style="flex:1"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg><input name="q" value="{{ $q }}" placeholder="{{ __('Dokumente durchsuchen…') }}" style="width:100%"></div>
            <button class="btn btn-brand">{{ __('Suchen') }}</button>
        </form>
        </div>
    </div>
    <div class="card table-card fade-up" style="animation-delay:.1s">
        <div class="table-scroll">
        <table class="docs">
            <tbody>
            @forelse ($results as $d)
                <tr>
                    <td><a href="{{ route('docs.show', $d) }}" class="flink" style="font-weight:700">{{ $d->title }}</a></td>
                    <td><span class="badge blue"><span class="cdot"></span>{{ $d->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="2"><div class="empty"><p>{{ $q ? __('Keine Treffer.') : __('Suchbegriff eingeben.') }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
</x-app-layout>
