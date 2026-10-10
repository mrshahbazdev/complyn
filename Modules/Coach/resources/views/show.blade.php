<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Coach — {{ $session->topic ?? 'Sitzung #' . $session->id }}</h2></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 space-y-3">
            @foreach ($session->messages as $m)
                <div class="{{ $m->role === 'assistant' ? 'bg-indigo-50 dark:bg-indigo-950 p-3 rounded' : 'p-3 bg-gray-50 dark:bg-gray-700 rounded' }}">
                    <div class="text-xs text-gray-500 mb-1">{{ $m->role === 'assistant' ? 'Coach' : 'Du' }}</div>
                    <div class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $m->content }}</div>
                </div>
            @endforeach
        </div>
        <form method="POST" action="{{ route('coach.ask', $session) }}" class="flex gap-3">
            @csrf
            <textarea name="message" required rows="2" placeholder="{{ __('Frage an den Coach…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1"></textarea>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded self-end">Senden</button>
        </form>
    </div></div>
</x-app-layout>
