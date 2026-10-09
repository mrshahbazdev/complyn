<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $group->name }}</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <form method="POST" action="{{ route('exchange.topics.store', $group) }}" class="space-y-2">
                @csrf
                <input name="title" required placeholder="{{ __('Diskussionstitel…') }}" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                <textarea name="body" required placeholder="{{ __('Beitrag…') }}" rows="3" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm"></textarea>
                <button class="bg-slate-900 text-white px-4 py-2 rounded text-sm">+ {{ __('Diskussion starten') }}</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm divide-y dark:divide-gray-700">
            @forelse ($topics as $t)
                <a href="{{ route('exchange.topics.show', $t) }}" class="block p-4">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $t->title }}</div>
                    <div class="text-xs text-gray-500">{{ $t->user->name }} · {{ $t->created_at->format('d.m.Y') }} · {{ $t->comments_count }} {{ __('Kommentare') }}</div>
                </a>
            @empty
                <div class="p-4 text-sm text-gray-500">{{ __("Noch keine Diskussionen.") }}</div>
            @endforelse
        </div>
        {{ $topics->links() }}
    </div></div>
</x-app-layout>
