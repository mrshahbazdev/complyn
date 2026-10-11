<x-app-layout>
    <x-slot name="header">{{ $topic->title }}</x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="card fade-up" style="padding:20px 24px">
            <div class="text-xs text-gray-500 mb-2">{{ $topic->group->name }} · {{ $topic->user->name }} · {{ $topic->created_at->format('d.m.Y H:i') }}</div>
            <div class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $topic->body }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5 space-y-3">
            <h3 class="panel-h">{{ __("Kommentare") }}</h3>
            @foreach ($topic->comments as $c)
                <div class="text-sm border-b dark:border-gray-700 pb-2">
                    <span class="muted">{{ $c->user->name }}:</span>
                    <span >{{ $c->body }}</span>
                </div>
            @endforeach
            <form method="POST" action="{{ route('exchange.topics.comments.store', $topic) }}" class="flex gap-3">
                @csrf
                <input name="body" required placeholder="{{ __('Kommentar…') }}" class="field-input">
                <button class="btn btn-dark">{{ __('Senden') }}</button>
            </form>
        </div>
</div>
</x-app-layout>
