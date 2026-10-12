<x-admin::layout>
    <x-slot:title>{{ __('Tarife') }}</x-slot:title>

    <div class="card fade-up" style="padding:20px 24px">
        <h3 class="panel-h">{{ __("Neuer Tarif") }}</h3>
        <form method="POST" action="{{ route('admin.plans.store') }}" class="gap-3">
            @csrf
            <input name="name" placeholder="{{ __('Name') }}" required class="field-input">
            <input name="slug" placeholder="{{ __('slug') }}" required class="field-input">
            <input name="price_cents" type="number" placeholder="{{ __('Preis (Cent)') }}" required class="field-input">
            <button class="btn btn-brand">Anlegen</button>
        </form>
    </div>

    @foreach ($plans as $plan)
        <div class="card fade-up" style="padding:20px 24px" x-data="{ open: false }">
            <div class="items-center">
                <div>
                    <span class="panel-h">{{ $plan->name }}</span>
                    <span>{{ number_format($plan->price_cents / 100, 2, ',') }} € · {{ $plan->companies_count }} Unternehmen · {{ $plan->is_active ? 'aktiv' : 'inaktiv' }}</span>
                </div>
                <button @click="open = !open" class="flink">Module ({{ $plan->modules->count() }})</button>
            </div>
            <div x-show="open" x-cloak class="gap-2">
                @foreach ($modules as $m)
                    @php $on = $plan->modules->contains($m->id); @endphp
                    <form method="POST" action="{{ route('admin.plans.modules.toggle', [$plan, $m]) }}">
                        @csrf @method('PUT')
                        <input type="hidden" name="enabled" value="{{ $on ? 0 : 1 }}">
                        <button class="{{ $on ? 'badge green' : 'badge gray' }}" title="{{ $m->block_key }}">
                            {{ $m->key }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    @endforeach
</x-admin::layout>
