<x-admin::layout>
    <x-slot:title>{{ __("Unternehmen") }}</x-slot:title>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
        <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">{{ __("Neues Unternehmen") }}</h3>
        <form method="POST" action="{{ route('admin.companies.store') }}" class="flex flex-wrap gap-3 items-end">
            @csrf
            <input name="name" placeholder="Name" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <input name="slug" placeholder="slug" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <select name="plan_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                @foreach ($plans as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
            </select>
            <select name="industry_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                <option value="">{{ __("— Branche —") }}</option>
                @foreach ($industries as $i)<option value="{{ $i->id }}">{{ $i->name_de }}</option>@endforeach
            </select>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Anlegen</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5" x-data="{ open: null }">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700">
                <th class="py-2">{{ __("Name") }}</th><th>{{ __("Tarif") }}</th><th>{{ __("Branche") }}</th><th>{{ __("Benutzer") }}</th><th>{{ __("Module") }}</th><th></th>
            </tr></thead>
            <tbody>
            @foreach ($companies as $c)
                <tr class="border-b dark:border-gray-700">
                    <td class="py-2 text-gray-800 dark:text-gray-200">{{ $c->name }}</td>
                    <td class="text-gray-600 dark:text-gray-300">{{ $c->plan?->name }}</td>
                    <td class="text-gray-600 dark:text-gray-300">{{ $c->industry?->name_de }}</td>
                    <td class="text-gray-600 dark:text-gray-300">{{ $c->users_count }}</td>
                    <td>
                        <button @click="open = open === {{ $c->id }} ? null : {{ $c->id }}" class="text-indigo-500 text-xs">Module ({{ $c->enabledModules()->count() }})</button>
                    </td>
                    <td class="text-right">
                        <form method="POST" action="{{ route('admin.companies.destroy', $c) }}" onsubmit="return confirm('Löschen?')" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-xs">{{ __("Löschen") }}</button>
                        </form>
                    </td>
                </tr>
                <tr x-show="open === {{ $c->id }}" x-cloak>
                    <td colspan="6" class="py-3 bg-gray-50 dark:bg-gray-900">
                        <div class="flex flex-wrap gap-2">
                            @php $overrides = $c->moduleOverrides->keyBy('id'); @endphp
                            @foreach ($modules as $m)
                                @php
                                    $inPlan = $c->plan?->modules->contains($m->id);
                                    $ov = $overrides->get($m->id);
                                    $on = $inPlan && ($ov === null || $ov->pivot->enabled);
                                @endphp
                                <form method="POST" action="{{ route('admin.companies.modules.toggle', [$c, $m]) }}" class="inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="enabled" value="{{ $on ? 0 : 1 }}">
                                    <button class="px-2 py-1 rounded text-xs border {{ $on ? 'bg-green-100 text-green-800 border-green-300' : 'bg-gray-100 text-gray-500 border-gray-300' }} {{ ! $inPlan ? 'opacity-50' : '' }}"
                                        title="{{ $m->block_key }} / {{ $inPlan ? 'im Tarif' : 'nicht im Tarif' }}">
                                        {{ $m->key }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $companies->links() }}
    </div>
</x-admin::layout>
