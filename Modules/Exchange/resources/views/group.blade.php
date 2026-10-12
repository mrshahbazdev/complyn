<x-app-layout>
    <x-slot name="header">{{ $group->name }}</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('exchange.topics.store', $group) }}">
                @csrf
                <input name="title" required placeholder="{{ __('Diskussionstitel…') }}" class="field-input">
                <textarea name="body" required placeholder="{{ __('Beitrag…') }}" rows="3" class="field-input"></textarea>
                <button class="btn btn-dark">+ {{ __('Diskussion starten') }}</button>
            </form>
        </div>
        <div>
            @forelse ($topics as $t)
                <a href="{{ route('exchange.topics.show', $t) }}">
                    <div class="t-strong">{{ $t->title }}</div>
                    <div>{{ $t->user->name }} · {{ $t->created_at->format('d.m.Y') }} · {{ $t->comments_count }} {{ __('Kommentare') }}</div>
                </a>
            @empty
                <div>{{ __("Noch keine Diskussionen.") }}</div>
            @endforelse
        </div>
        {{ $topics->links() }}
</div>
</x-app-layout>
