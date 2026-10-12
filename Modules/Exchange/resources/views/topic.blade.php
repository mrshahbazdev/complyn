<x-app-layout>
    <x-slot name="header">{{ $topic->title }}</x-slot>
    <div><div>
        <div class="card fade-up" style="padding:20px 24px">
            <div>{{ $topic->group->name }} · {{ $topic->user->name }} · {{ $topic->created_at->format('d.m.Y H:i') }}</div>
            <div>{{ $topic->body }}</div>
        </div>
        <div>
            <h3 class="panel-h">{{ __("Kommentare") }}</h3>
            @foreach ($topic->comments as $c)
                <div>
                    <span class="muted">{{ $c->user->name }}:</span>
                    <span >{{ $c->body }}</span>
                </div>
            @endforeach
            <form method="POST" action="{{ route('exchange.topics.comments.store', $topic) }}" class="gap-3">
                @csrf
                <input name="body" required placeholder="{{ __('Kommentar…') }}" class="field-input">
                <button class="btn btn-dark">{{ __('Senden') }}</button>
            </form>
        </div>
</div>
</x-app-layout>
