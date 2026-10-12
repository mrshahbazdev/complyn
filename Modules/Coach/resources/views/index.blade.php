<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic violet"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg></span>
            <div><h1>Compliance-Coach</h1><p class="ph-sub">{{ __('KI-Coach für Ihre Compliance') }}</p></div>
        </div>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif

    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-body">
        <form method="POST" action="{{ route('coach.sessions.store') }}" class="filter-bar">
            @csrf
            <div class="field" style="flex:1"><input class="field-input" name="topic" placeholder="{{ __('Neues Coaching-Thema…') }}"></div>
            <button class="btn btn-brand">{{ __('Starten') }}</button>
        </form>
        </div>
    </div>

    <div class="card table-card fade-up" style="animation-delay:.1s">
        <div class="table-head"><div class="ph-left"><h3>{{ __('Sitzungen') }}</h3></div><span class="pill">{{ $sessions->total() }}</span></div>
        <div class="table-scroll">
        <table class="docs"><tbody>
            @forelse ($sessions as $s)
                <tr>
                    <td><a href="{{ route('coach.show', $s) }}" class="flink" style="font-weight:700">{{ $s->topic ?? 'Sitzung #' . $s->id }}</a></td>
                    <td class="muted">{{ $s->messages->count() }} {{ __('Nachrichten') }}</td>
                    <td><span class="duedate">{{ $s->created_at->format('d.m.Y') }}</span></td>
                </tr>
            @empty
                <tr><td colspan="3"><div class="empty"><p>{{ __('Keine Sitzungen.') }}</p></div></td></tr>
            @endforelse
        </tbody></table>
        </div>
        <div class="panel-body">{{ $sessions->links() }}</div>
    </div>

    <div class="card panel fade-up" style="animation-delay:.15s">
        <div class="panel-head"><h3>{{ __("Checklisten") }}</h3></div>
        <div class="panel-body">
        <form method="POST" action="{{ route('coach.checklists.store') }}" class="filter-bar" style="margin-bottom:12px">
            @csrf
            <div class="field" style="flex:1"><input class="field-input" name="title" placeholder="{{ __('Neue Checkliste…') }}" required></div>
            <button class="btn btn-brand">{{ __('Anlegen') }}</button>
        </form>
        <ul class="q-list">
            @foreach ($checklists as $c)<li class="check-list"><span class="ck"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>{{ $c->title }}</li>@endforeach
        </ul>
        </div>
    </div>
</div>
</x-app-layout>
