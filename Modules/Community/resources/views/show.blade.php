<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $post->title }}</h2></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <div class="text-xs text-gray-500 mb-2 flex items-center gap-2">
                {{ $post->user->name }}
                @if ($post->user->is_expert)<span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 font-semibold">{{ $post->user->expert_label ?: __('Experte') }}</span>@endif
                · {{ $post->created_at->format('d.m.Y H:i') }}
                @if ($post->status === 'answered')<span class="px-1.5 py-0.5 rounded bg-green-100 text-green-800">{{ __('beantwortet') }}</span>@endif
            </div>
            <div class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $post->body }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5 space-y-3">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ __("Antworten") }}</h3>
            @foreach ($post->comments->sortByDesc(fn($c) => $c->votes_count) as $c)
                <div class="text-sm border-b dark:border-gray-700 pb-2 {{ $post->accepted_comment_id === $c->id ? 'bg-green-50 dark:bg-green-900/20 -mx-2 px-2 rounded' : '' }}">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 text-xs">{{ $c->user->name }}</span>
                        @if ($c->user->is_expert)<span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 text-xs font-semibold">{{ $c->user->expert_label ?: __('Experte') }}</span>@endif
                        @if ($post->accepted_comment_id === $c->id)<span class="px-1.5 py-0.5 rounded bg-green-100 text-green-800 text-xs font-semibold">✓ {{ __('akzeptiert') }}</span>@endif
                    </div>
                    <span class="text-gray-800 dark:text-gray-200">{{ $c->body }}</span>
                    <div class="flex items-center gap-3 mt-1">
                        <form method="POST" action="{{ route('community.comments.vote', $c) }}" class="inline">@csrf
                            <button class="text-xs text-slate-500 hover:text-amber-600">▲ {{ $c->votes_count }} {{ __('Bewertung') }}</button>
                        </form>
                        <form method="POST" action="{{ route('community.posts.accept', [$post, $c]) }}" class="inline">@csrf
                            <button class="text-xs text-slate-500 hover:text-green-600">{{ $post->accepted_comment_id === $c->id ? __('Akzeptieren aufheben') : __('Als Antwort akzeptieren') }}</button>
                        </form>
                    </div>
                </div>
            @endforeach
            <form method="POST" action="{{ route('community.comments.store', $post) }}" class="flex gap-3">
                @csrf
                <input name="body" required placeholder="{{ __('Antwort schreiben…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1">
                <button class="bg-slate-900 text-white px-4 py-2 rounded">{{ __('Senden') }}</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
