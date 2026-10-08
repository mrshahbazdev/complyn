<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Creator — Dokumente erstellen</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <form method="POST" action="{{ route('creator.drafts.store') }}" class="flex gap-3">
                @csrf
                <input name="title" placeholder="Titel des Dokuments…" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1">
                <select name="type" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                    <option value="document">Dokument</option><option value="checklist">Checkliste</option><option value="policy">Richtlinie</option>
                </select>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Anlegen</button>
            </form>
        </div>
        @foreach ($drafts as $d)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5" x-data="{open:false}">
            <div class="flex justify-between items-center">
                <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $d->title }}</span>
                    <span class="text-xs text-gray-500 ml-2">{{ $d->type }} · {{ $d->status }}</span></div>
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('creator.drafts.generate', $d) }}">@csrf<button class="text-indigo-500 text-xs">AI generieren</button></form>
                    <button @click="open=!open" class="text-gray-500 text-xs">Bearbeiten</button>
                </div>
            </div>
            <div x-show="open" class="mt-3">
                <form method="POST" action="{{ route('creator.drafts.update', $d) }}">
                    @csrf @method('PUT')
                    <textarea name="content" rows="8" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full text-sm">{{ $d->content }}</textarea>
                    <div class="flex gap-3 mt-2">
                        <select name="status" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                            <option value="draft" @selected($d->status==='draft')>Entwurf</option>
                            <option value="final" @selected($d->status==='final')>Final</option>
                        </select>
                        <button class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">Speichern</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
        {{ $drafts->links() }}
    </div></div>
</x-app-layout>
