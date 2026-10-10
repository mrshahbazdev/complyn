<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $doc->title }}</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <form method="POST" action="{{ route('docs.release', $doc) }}" class="inline">@csrf @method('PUT')<button class="text-amber-600 text-sm font-semibold underline">{{ $doc->released_at ? __("Freigabe zurückziehen") : __("Freigeben") }}</button></form>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <form method="POST" action="{{ route('docs.update', $doc) }}" class="space-y-3">
                @csrf @method('PUT')
                <input name="title" value="{{ $doc->title }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full">
                <textarea name="description" rows="2" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full">{{ $doc->description }}</textarea>
                <div class="flex gap-3">
                    <select name="category_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">{{ __("— Kategorie —") }}</option>
                        @foreach (\App\Models\Category::orderBy('name_de')->get() as $c)<option value="{{ $c->id }}" @selected($doc->category_id === $c->id)>{{ $c->name_de }}</option>@endforeach
                    </select>
                    <select name="status" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                        @foreach (['draft','published','archived'] as $s)<option value="{{ $s }}" @selected($doc->status === $s)>{{ $s }}</option>@endforeach
                    </select>
                    <input name="tags" value="{{ $doc->tags->pluck('name')->join(', ') }}" placeholder="{{ __('Tags') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">{{ __('Speichern') }}</button>
                </div>
            </form>
            <form method="POST" action="{{ route('docs.destroy', $doc) }}" onsubmit="return confirm('Löschen?')" class="mt-3">
                @csrf @method('DELETE')<button class="text-red-500 text-sm">{{ __("Dokument löschen") }}</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">{{ __("Versionen") }}</h3>
            <form method="POST" action="{{ route('docs.versions.upload', $doc) }}" enctype="multipart/form-data" class="flex gap-3 mb-3">
                @csrf
                <input type="file" name="file" required class="text-sm text-gray-700 dark:text-gray-300">
                <button class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">{{ __('Neue Version') }}</button>
            </form>
            <table class="w-full text-sm">
                @foreach ($doc->versions->sortByDesc('version') as $v)
                    <tr class="border-b dark:border-gray-700 last:border-0">
                        <td class="py-2 text-gray-800 dark:text-gray-200">v{{ $v->version }} — {{ $v->original_name }}</td>
                        <td class="text-gray-600">{{ number_format($v->size / 1024, 1) }} KB</td>
                        <td class="text-gray-600">{{ $v->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-right"><a href="{{ route('docs.versions.download', [$doc, $v->version]) }}" class="text-indigo-500 text-xs">Download</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div></div>
</x-app-layout>
