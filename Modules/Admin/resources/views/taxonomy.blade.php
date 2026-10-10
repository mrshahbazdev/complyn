<x-admin::layout>
    <x-slot:title>Taxonomie</x-slot:title>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach ([['industries', 'Branchen', $industries, 'name_de'], ['categories', 'Kategorien', $categories, 'name_de'], ['tags', 'Tags', $tags, 'name']] as [$type, $label, $items, $field])
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">{{ $label }}</h3>
                <form method="POST" action="{{ route('admin.taxonomy.store', $type) }}" class="flex gap-2 mb-3">
                    @csrf
                    @if ($type === 'tags')
                        <input name="name" placeholder="{{ __('Name') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm w-full">
                    @else
                        <input name="name_de" placeholder="{{ __('DE') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm w-full">
                        <input name="name_en" placeholder="{{ __('EN') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm w-full">
                    @endif
                    <button class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">+</button>
                </form>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    @foreach ($items as $item)
                        <li class="py-1.5 flex justify-between">
                            <span class="text-gray-800 dark:text-gray-200">{{ $item->$field }}</span>
                            <form method="POST" action="{{ route('admin.taxonomy.destroy', [$type, $item->id]) }}">
                                @csrf @method('DELETE')
                                <button class="text-red-500 text-xs">{{ __("×") }}</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</x-admin::layout>
