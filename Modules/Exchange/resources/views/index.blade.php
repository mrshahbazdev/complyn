<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Exchange — Marktplatz</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <form method="POST" action="{{ route('exchange.store') }}" class="space-y-3">
                @csrf
                <div class="flex gap-3">
                    <input name="title" placeholder="Titel (z. B. ISO 9001 Beratung gesucht)" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1">
                    <select name="type" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200"><option value="need">{{ __("Suche") }}</option><option value="offer">{{ __("Angebot") }}</option></select>
                </div>
                <textarea name="description" rows="2" placeholder="Beschreibung…" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full"></textarea>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Eintragen</button>
            </form>
        </div>
        @foreach ($listings as $l)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5" x-data="{open:false}">
            <div class="flex justify-between items-center">
                <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $l->title }}</span>
                    <span class="text-xs ml-2 {{ $l->type==='offer' ? 'text-green-600' : 'text-blue-600' }}">{{ $l->type==='offer' ? 'Angebot' : 'Suche' }}</span>
                    <span class="text-xs text-gray-500 ml-1">· {{ $l->status }}</span></div>
                <div class="flex gap-2">
                    @if ($l->status==='open')
                    <button @click="open=!open" class="text-indigo-500 text-xs">Anfragen</button>
                    <form method="POST" action="{{ route('exchange.close', $l) }}">@csrf @method('PUT')<button class="text-red-500 text-xs">Schließen</button></form>
                    @endif
                </div>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $l->description }}</div>
            <div x-show="open" class="mt-3">
                <form method="POST" action="{{ route('exchange.inquire', $l) }}" class="flex gap-3">
                    @csrf
                    <input name="message" required placeholder="Deine Nachricht…" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1 text-sm">
                    <button class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">Senden</button>
                </form>
                @foreach ($l->inquiries as $i)<div class="text-xs text-gray-500 mt-1">— {{ $i->message }}</div>@endforeach
            </div>
        </div>
        @endforeach
        {{ $listings->links() }}
    </div></div>
</x-app-layout>
