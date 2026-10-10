<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Compliance-Coach</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <form method="POST" action="{{ route('coach.sessions.store') }}" class="flex gap-3">
                @csrf
                <input name="topic" placeholder="{{ __('Neues Coaching-Thema…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Starten</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @foreach ($sessions as $s)
                    <li class="py-2 flex justify-between">
                        <a href="{{ route('coach.show', $s) }}" class="text-indigo-600">{{ $s->topic ?? 'Sitzung #' . $s->id }}</a>
                        <span class="text-gray-500 text-xs">{{ $s->messages->count() }} Nachrichten · {{ $s->created_at->format('d.m.Y') }}</span>
                    </li>
                @endforeach
            </ul>
            {{ $sessions->links() }}
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">{{ __("Checklisten") }}</h3>
            <form method="POST" action="{{ route('coach.checklists.store') }}" class="flex gap-3 mb-3">
                @csrf
                <input name="title" placeholder="{{ __('Neue Checkliste…') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Anlegen</button>
            </form>
            <ul class="text-sm text-gray-800 dark:text-gray-200 space-y-1">
                @foreach ($checklists as $c)<li>• {{ $c->title }}</li>@endforeach
            </ul>
        </div>
    </div></div>
</x-app-layout>
