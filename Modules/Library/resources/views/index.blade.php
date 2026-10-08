<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Bibliothek</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <form method="GET" class="flex gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Artikel suchen…" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Suchen</button>
        </form>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">Artikel</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @foreach ($articles as $a)
                    <li class="py-2"><a href="{{ route('library.show', $a) }}" class="text-indigo-600">{{ $a->title }}</a></li>
                @endforeach
            </ul>
            {{ $articles->links() }}
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">Vorlagen</h3>
            <ul class="text-sm space-y-1">
                @foreach ($templates as $t)<li class="text-gray-800 dark:text-gray-200">• {{ $t->name }} <span class="text-xs text-gray-500">({{ $t->type }})</span></li>@endforeach
            </ul>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">Neuer Artikel</h3>
            <form method="POST" action="{{ route('library.articles.store') }}" class="space-y-3">
                @csrf
                <input name="title" placeholder="Titel" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full">
                <select name="category_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full">
                    <option value="">— Kategorie —</option>
                    @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name_de }}</option>@endforeach
                </select>
                <textarea name="body" required rows="4" placeholder="Inhalt…" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full"></textarea>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Speichern</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
