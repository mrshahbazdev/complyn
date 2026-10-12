<x-app-layout>
    <x-slot name="header">Community</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('community.posts.store') }}">
                @csrf
                <input name="title" placeholder="{{ __('Neuer Beitrag — Titel') }}" required class="field-input">
                <textarea name="body" required rows="3" placeholder="{{ __('Text…') }}" class="field-input"></textarea>
                <button class="btn btn-brand">{{ __("Veröffentlichen") }}</button>
            </form>
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <ul>
                @foreach ($posts as $p)
                    <li>
                        <a href="{{ route('community.show', $p) }}" class="flink">{{ $p->title }}</a>
                        <span class="muted">{{ $p->user->name }} · {{ $p->comments_count }} Kommentare</span>
                    </li>
                @endforeach
            </ul>
            {{ $posts->links() }}
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">{{ __("Gruppen") }}</h3>
            <form method="POST" action="{{ route('community.groups.store') }}" class="gap-3">
                @csrf
                <input name="name" placeholder="{{ __('Gruppenname') }}" required class="field-input">
                <button class="btn btn-brand">Anlegen</button>
            </form>
            <ul>
                @foreach ($groups as $g)<li>• {{ $g->name }}</li>@endforeach
            </ul>
        </div>
</div>
</x-app-layout>
