<x-admin::layout>
    <x-slot:title>Taxonomie</x-slot:title>

    <div>
        @foreach ([['industries', 'Branchen', $industries, 'name_de'], ['categories', 'Kategorien', $categories, 'name_de'], ['tags', 'Tags', $tags, 'name']] as [$type, $label, $items, $field])
            <div class="card fade-up" style="padding:20px 24px">
                <h3 class="panel-h">{{ $label }}</h3>
                <form method="POST" action="{{ route('admin.taxonomy.store', $type) }}" class="gap-2">
                    @csrf
                    @if ($type === 'tags')
                        <input name="name" placeholder="{{ __('Name') }}" required class="field-input">
                    @else
                        <input name="name_de" placeholder="{{ __('DE') }}" required class="field-input">
                        <input name="name_en" placeholder="{{ __('EN') }}" required class="field-input">
                    @endif
                    <button class="btn btn-brand btn-sm">+</button>
                </form>
                <ul>
                    @foreach ($items as $item)
                        <li>
                            <span >{{ $item->$field }}</span>
                            <form method="POST" action="{{ route('admin.taxonomy.destroy', [$type, $item->id]) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("×") }}</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</x-admin::layout>
