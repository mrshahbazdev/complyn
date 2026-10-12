<x-app-layout>
    <x-slot name="header">{{ $post->title }}</x-slot>
    <div><div>
        <div class="card fade-up" style="padding:20px 24px">
            <div class="items-center gap-2">
                {{ $post->user->name }}
                @if ($post->user->is_expert)<span class="badge amber">{{ $post->user->expert_label ?: __('Experte') }}</span>@endif
                · {{ $post->created_at->format('d.m.Y H:i') }}
                @if ($post->status === 'answered')<span class="badge green">{{ __('beantwortet') }}</span>@endif
            </div>
            <div>{{ $post->body }}</div>
        </div>
        <div>
            <h3 class="panel-h">{{ __("Antworten") }}</h3>
            @foreach ($post->comments->sortByDesc(fn($c) => $c->votes_count) as $c)
                <div class="{{ $post->accepted_comment_id === $c->id ? 'bg-green-50 dark:bg-green-900/20 -mx-2 px-2 rounded' : '' }}">
                    <div class="items-center gap-2">
                        <span class="muted">{{ $c->user->name }}</span>
                        @if ($c->user->is_expert)<span class="badge amber">{{ $c->user->expert_label ?: __('Experte') }}</span>@endif
                        @if ($post->accepted_comment_id === $c->id)<span class="badge green">✓ {{ __('akzeptiert') }}</span>@endif
                    </div>
                    <span >{{ $c->body }}</span>
                    <div class="items-center gap-3">
                        <form method="POST" action="{{ route('community.comments.vote', $c) }}">@csrf
                            <button>▲ {{ $c->votes_count }} {{ __('Bewertung') }}</button>
                        </form>
                        <form method="POST" action="{{ route('community.posts.accept', [$post, $c]) }}">@csrf
                            <button>{{ $post->accepted_comment_id === $c->id ? __('Akzeptieren aufheben') : __('Als Antwort akzeptieren') }}</button>
                        </form>
                    </div>
                </div>
            @endforeach
            <form method="POST" action="{{ route('community.comments.store', $post) }}" class="gap-3">
                @csrf
                <input name="body" required placeholder="{{ __('Antwort schreiben…') }}" class="field-input">
                <button class="btn btn-dark">{{ __('Senden') }}</button>
            </form>
        </div>
</div>
</x-app-layout>
