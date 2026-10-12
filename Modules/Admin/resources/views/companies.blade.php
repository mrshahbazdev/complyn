<x-admin::layout>
    <x-slot:title>{{ __("Unternehmen") }}</x-slot:title>

    <div class="card fade-up" style="padding:20px 24px">
        <h3 class="panel-h">{{ __("Neues Unternehmen") }}</h3>
        <form method="POST" action="{{ route('admin.companies.store') }}" class="gap-3">
            @csrf
            <input name="name" placeholder="{{ __('Name') }}" required class="field-input">
            <input name="slug" placeholder="{{ __('slug') }}" required class="field-input">
            <select name="plan_id" class="field-input">
                @foreach ($plans as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
            </select>
            <select name="industry_id" class="field-input">
                <option value="">{{ __("— Branche —") }}</option>
                @foreach ($industries as $i)<option value="{{ $i->id }}">{{ $i->name_de }}</option>@endforeach
            </select>
            <button class="btn btn-brand">Anlegen</button>
        </form>
    </div>

    <div class="card fade-up" style="padding:20px 24px" x-data="{ open: null }">
        <table class="docs">
            <thead><tr>
                <th>{{ __("Name") }}</th><th>{{ __("Tarif") }}</th><th>{{ __("Branche") }}</th><th>{{ __("Benutzer") }}</th><th>{{ __("Module") }}</th><th></th>
            </tr></thead>
            <tbody>
            @foreach ($companies as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td class="muted">{{ $c->plan?->name }}</td>
                    <td class="muted">{{ $c->industry?->name_de }}</td>
                    <td class="muted">{{ $c->users_count }}</td>
                    <td>
                        <button @click="open = open === {{ $c->id }} ? null : {{ $c->id }}" class="flink">Module ({{ $c->enabledModules()->count() }})</button>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.companies.destroy', $c) }}" onsubmit="return confirm('Löschen?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Löschen") }}</button>
                        </form>
                    </td>
                </tr>
                <tr x-show="open === {{ $c->id }}" x-cloak>
                    <td colspan="6">
                        <div class="gap-2">
                            @php $overrides = $c->moduleOverrides->keyBy('id'); @endphp
                            @foreach ($modules as $m)
                                @php
                                    $inPlan = $c->plan?->modules->contains($m->id);
                                    $ov = $overrides->get($m->id);
                                    $on = $inPlan && ($ov === null || $ov->pivot->enabled);
                                @endphp
                                <form method="POST" action="{{ route('admin.companies.modules.toggle', [$c, $m]) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="enabled" value="{{ $on ? 0 : 1 }}">
                                    <button class="{{ $on ? 'badge green' : 'badge gray' }} {{ ! $inPlan ? 'opacity-50' : '' }}"
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
