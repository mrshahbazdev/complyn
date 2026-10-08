<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Dashboard — {{ $company?->name }}</h2></x-slot>
    <div class="py-8"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if ($company)
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <a href="{{ route('docs.index') }}" class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow block">
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $docsCount }}</div>
                <div class="text-sm text-gray-500">Dokumente</div>
            </a>
            <a href="{{ route('files.index') }}" class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow block">
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $filesCount }}</div>
                <div class="text-sm text-gray-500">Dateien</div>
            </a>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow">
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $modules->count() }}</div>
                <div class="text-sm text-gray-500">Aktive Module</div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">Aktive Module</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($modules as $m)<span class="px-2 py-1 rounded text-xs bg-indigo-100 text-indigo-800">{{ $m->key }}</span>@endforeach
            </div>
        </div>
        @else
        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-300 rounded p-5 text-sm">
            Kein Unternehmen zugeordnet — bitte den Admin um Zuordnung bitten.
        </div>
        @endif
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">Ungelesene Benachrichtigungen</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @forelse ($notifications as $n)
                    <li class="py-2 text-gray-800 dark:text-gray-200">{{ $n->data['title'] ?? class_basename($n->type) }}</li>
                @empty
                    <li class="py-2 text-gray-500">Keine neuen Benachrichtigungen.</li>
                @endforelse
            </ul>
        </div>
    </div></div>
</x-app-layout>
