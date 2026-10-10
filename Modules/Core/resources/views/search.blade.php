<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Suche") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <form method="GET" class="flex gap-2">
            <input name="q" value="{{ $q }}" placeholder="{{ __('Dokumente durchsuchen…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">{{ __('Suchen') }}</button>
        </form>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @forelse ($results as $d)
                    <li class="py-2">
                        <a href="{{ route('docs.show', $d) }}" class="text-indigo-600 font-medium">{{ $d->title }}</a>
                        <span class="text-gray-500 text-xs ml-2">{{ $d->status }}</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">{{ $q ? 'Keine Treffer.' : 'Suchbegriff eingeben.' }}</li>
                @endforelse
            </ul>
        </div>
    </div></div>
</x-app-layout>
