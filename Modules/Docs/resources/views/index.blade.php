<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Dokumente") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="flex justify-between items-center">
            <form method="GET" class="flex gap-2">
                <input name="q" value="{{ request('q') }}" placeholder="{{ __('Titel suchen…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                <select name="category" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <option value="">{{ __("— Kategorie —") }}</option>
                    @foreach ($categories as $c)<option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name_de }}</option>@endforeach
                </select>
                <button class="bg-gray-600 text-white px-3 py-1 rounded text-sm">Filtern</button>
            </form>
            <a href="{{ route('docs.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ Neues Dokument</a>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700"><th class="py-2">{{ __("Titel") }}</th><th>{{ __("Kategorie") }}</th><th>{{ __("Tags") }}</th><th>{{ __("Status") }}</th><th>{{ __("Version") }}</th><th>{{ __("Datum") }}</th></tr></thead>
                <tbody>
                @foreach ($docs as $d)
                    <tr class="border-b dark:border-gray-700">
                        <td class="py-2"><a href="{{ route('docs.show', $d) }}" class="text-indigo-600">{{ $d->title }}</a></td>
                        <td class="text-gray-600">{{ $d->category?->name_de }}</td>
                        <td>@foreach ($d->tags as $t)<span class="px-1.5 py-0.5 rounded text-xs bg-gray-100 dark:bg-gray-700">{{ $t->name }}</span>@endforeach</td>
                        <td class="text-gray-600">{{ $d->status }}</td>
                        <td class="text-gray-600">v{{ $d->latestVersion?->version ?? 0 }}</td>
                        <td class="text-gray-600">{{ $d->created_at->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $docs->links() }}
        </div>
    </div></div>
</x-app-layout>
