<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic violet"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg></span>
            <div><h1>{{ $session->topic ?? 'Sitzung #' . $session->id }}</h1><p class="ph-sub">Coach</p></div>
        </div>
    </div>
    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-body">
            @foreach ($session->messages as $m)
                <div class="card" style="margin-bottom:10px;padding:12px 16px;{{ $m->role === 'assistant' ? 'background:#f5f3ff;border-color:#ddd6fe' : 'background:var(--slate-50)' }}">
                    <span class="muted" style="font-size:11px;text-transform:uppercase;letter-spacing:.08em">{{ $m->role === 'assistant' ? 'Coach' : __('Du') }}</span>
                    <div style="font-size:14px;color:var(--slate-800);white-space:pre-line">{{ $m->content }}</div>
                </div>
            @endforeach
        </div>
        <div class="panel-body" style="border-top:1px solid var(--slate-100)">
        <form method="POST" action="{{ route('coach.ask', $session) }}" class="filter-bar">
            @csrf
            <div class="field" style="flex:1"><textarea name="message" required rows="2" placeholder="{{ __('Frage an den Coach…') }}"></textarea></div>
            <button class="btn btn-brand">{{ __('Senden') }}</button>
        </form>
        </div>
    </div>
</div>
</x-app-layout>
