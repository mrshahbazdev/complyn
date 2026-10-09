<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Nachweismanagement") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <form method="POST" action="{{ route('core.evidences.store') }}" enctype="multipart/form-data" class="flex flex-wrap gap-2">
                @csrf
                <input name="title" required placeholder="Nachweis-Titel…" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm flex-1 min-w-48">
                <select name="core_obligation_id" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <option value="">{{ __("— Pflicht —") }}</option>
                    @foreach ($obligations as $o)<option value="{{ $o->id }}">{{ $o->title }}</option>@endforeach
                </select>
                <input name="note" placeholder="{{ __('Notiz') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                <input name="file" type="file" class="text-sm text-gray-500">
                <button class="bg-slate-900 text-white px-4 py-2 rounded text-sm">+ {{ __("Nachweis") }}</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700"><th class="py-2">{{ __("Nachweis") }}</th><th>{{ __("Pflicht") }}</th><th>{{ __("Datei") }}</th><th>{{ __("Datum") }}</th><th></th></tr></thead>
                <tbody>
                @foreach ($evidences as $e)
                    <tr class="border-b dark:border-gray-700">
                        <td class="py-2"><div class="text-gray-900 dark:text-gray-100">{{ $e->title }}</div><div class="text-xs text-gray-500">{{ $e->note }}</div></td>
                        <td class="text-gray-600">{{ $e->obligation->title }}</td>
                        <td>@if ($e->file)<a class="text-amber-600 text-xs" href="{{ route('files.download', $e->file) }}">{{ $e->file->original_name }}</a>@else<span class="text-xs text-gray-400">—</span>@endif</td>
                        <td class="text-gray-600">{{ $e->created_at->format('d.m.Y') }}</td>
                        <td><form method="POST" action="{{ route('core.evidences.destroy', $e) }}" onsubmit="return confirm('{{ __('Löschen?') }}')">@csrf @method('DELETE')<button class="text-xs text-red-600">{{ __("Löschen") }}</button></form></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $evidences->links() }}
        </div>
    </div></div>
</x-app-layout>
