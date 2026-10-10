<x-admin::layout>
    <x-slot:title>{{ __('Tarife') }}</x-slot:title>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
        <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">{{ __("Neuer Tarif") }}</h3>
        <form method="POST" action="{{ route('admin.plans.store') }}" class="flex flex-wrap gap-3 items-end">
            @csrf
            <input name="name" placeholder="{{ __('Name') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <input name="slug" placeholder="{{ __('slug') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <input name="price_cents" type="number" placeholder="{{ __('Preis (Cent)') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Anlegen</button>
        </form>
    </div>

    @foreach ($plans as $plan)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5" x-data="{ open: false }">
            <div class="flex justify-between items-center">
                <div>
                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $plan->name }}</span>
                    <span class="text-sm text-gray-500 ml-2">{{ number_format($plan->price_cents / 100, 2, ',') }} € · {{ $plan->companies_count }} Unternehmen · {{ $plan->is_active ? 'aktiv' : 'inaktiv' }}</span>
                </div>
                <button @click="open = !open" class="text-indigo-500 text-sm">Module ({{ $plan->modules->count() }})</button>
            </div>
            <div x-show="open" x-cloak class="mt-3 flex flex-wrap gap-2">
                @foreach ($modules as $m)
                    @php $on = $plan->modules->contains($m->id); @endphp
                    <form method="POST" action="{{ route('admin.plans.modules.toggle', [$plan, $m]) }}" class="inline">
                        @csrf @method('PUT')
                        <input type="hidden" name="enabled" value="{{ $on ? 0 : 1 }}">
                        <button class="px-2 py-1 rounded text-xs border {{ $on ? 'bg-green-100 text-green-800 border-green-300' : 'bg-gray-100 text-gray-500 border-gray-300' }}" title="{{ $m->block_key }}">
                            {{ $m->key }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    @endforeach
</x-admin::layout>
