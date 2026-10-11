<x-app-layout>
    <x-slot name="header">Community</x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('community.posts.store') }}" class="space-y-3">
                @csrf
                <input name="title" placeholder="{{ __('Neuer Beitrag — Titel') }}" required class="field-input">
                <textarea name="body" required rows="3" placeholder="{{ __('Text…') }}" class="field-input"></textarea>
                <button class="btn btn-brand">{{ __("Veröffentlichen") }}</button>
            </form>
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @foreach ($posts as $p)
                    <li class="py-2 flex justify-between">
                        <a href="{{ route('community.show', $p) }}" class="flink">{{ $p->title }}</a>
                        <span class="muted">{{ $p->user->name }} · {{ $p->comments_count }} Kommentare</span>
                    </li>
                @endforeach
            </ul>
            {{ $posts->links() }}
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">{{ __("Gruppen") }}</h3>
            <form method="POST" action="{{ route('community.groups.store') }}" class="flex gap-3 mb-3">
                @csrf
                <input name="name" placeholder="{{ __('Gruppenname') }}" required class="field-input">
                <button class="btn btn-brand">Anlegen</button>
            </form>
            <ul class="text-sm text-gray-800 dark:text-gray-200 space-y-1">
                @foreach ($groups as $g)<li>• {{ $g->name }}</li>@endforeach
            </ul>
        </div>
</div>
</x-app-layout>
