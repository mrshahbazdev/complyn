<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __('Neues Dokument') }}</h2></x-slot>
    <div class="py-8"><div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <form method="POST" action="{{ route('docs.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div><label class="text-sm text-gray-600 dark:text-gray-300">{{ __("Titel") }}</label>
                    <input name="title" required class="mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full"></div>
                <div><label class="text-sm text-gray-600 dark:text-gray-300">{{ __("Beschreibung") }}</label>
                    <textarea name="description" rows="3" class="mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full"></textarea></div>
                <div><label class="text-sm text-gray-600 dark:text-gray-300">{{ __("Kategorie") }}</label>
                    <select name="category_id" class="mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full">
                        <option value="">—</option>
                        @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name_de }}</option>@endforeach
                    </select></div>
                <div><label class="text-sm text-gray-600 dark:text-gray-300">{{ __("Tags (Komma-getrennt)") }}</label>
                    <input name="tags" class="mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full"></div>
                <div><label class="text-sm text-gray-600 dark:text-gray-300">{{ __("Ablaufdatum") }}</label>
                    <input type="date" name="expires_at" class="mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full"></div>
                <div><label class="text-sm text-gray-600 dark:text-gray-300">{{ __("Datei") }}</label>
                    <input type="file" name="file" class="mt-1 text-sm text-gray-700 dark:text-gray-300"></div>
                <button class="bg-slate-900 text-white px-4 py-2 rounded">{{ __('Anlegen') }}</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
