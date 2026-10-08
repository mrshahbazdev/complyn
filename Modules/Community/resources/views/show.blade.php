<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $post->title }}</h2></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="text-xs text-gray-500 mb-2">{{ $post->user->name }} · {{ $post->created_at->format('d.m.Y H:i') }}</div>
            <div class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $post->body }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 space-y-3">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100">Kommentare</h3>
            @foreach ($post->comments as $c)
                <div class="text-sm border-b dark:border-gray-700 pb-2">
                    <span class="text-gray-500 text-xs">{{ $c->user->name }}:</span>
                    <span class="text-gray-800 dark:text-gray-200">{{ $c->body }}</span>
                </div>
            @endforeach
            <form method="POST" action="{{ route('community.comments.store', $post) }}" class="flex gap-3">
                @csrf
                <input name="body" required placeholder="Kommentar…" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Senden</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
