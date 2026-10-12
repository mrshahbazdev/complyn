<x-app-layout>
    <x-slot name="header">{{ __("Experten finden") }}</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="GET" class="gap-2">
                <input name="specialty" value="{{ request('specialty') }}" placeholder="{{ __('Fachgebiet…') }}" class="field-input">
                <select name="industry_id" class="field-input">
                    <option value="">{{ __("— Branche —") }}</option>
                    @foreach ($industries as $i)<option value="{{ $i->id }}" @selected(request('industry_id') == $i->id)>{{ $i->name_de }}</option>@endforeach
                </select>
                <input name="location" value="{{ request('location') }}" placeholder="{{ __('Ort') }}" class="field-input">
                <input name="min_exp" value="{{ request('min_exp') }}" type="number" min="0" placeholder="{{ __('Erfahrung (Jahre)') }}" class="field-input">
                <select name="availability" class="field-input">
                    <option value="">{{ __("— Verfügbarkeit —") }}</option>
                    <option value="available" @selected(request('availability')==='available')>{{ __('verfügbar') }}</option>
                    <option value="busy" @selected(request('availability')==='busy')>{{ __('eingeschränkt') }}</option>
                    <option value="unavailable" @selected(request('availability')==='unavailable')>{{ __('nicht verfügbar') }}</option>
                </select>
                <button>{{ __('Suchen') }}</button>
                <a href="{{ route('connect.index') }}" class="flink">{{ __('Anfragen') }}</a>
            </form>
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('connect.experts.store') }}" class="gap-2">
                @csrf
                <input name="name" required placeholder="{{ __('Name') }}" class="field-input">
                <input name="specialty" required placeholder="{{ __('Fachgebiet') }}" class="field-input">
                <select name="industry_id" class="field-input">
                    <option value="">{{ __("— Branche —") }}</option>
                    @foreach ($industries as $i)<option value="{{ $i->id }}">{{ $i->name_de }}</option>@endforeach
                </select>
                <input name="location" placeholder="{{ __('Ort') }}" class="field-input">
                <input name="experience_years" type="number" min="0" placeholder="{{ __('Jahre Erfahrung') }}" class="field-input">
                <input name="hourly_rate" type="number" step="0.01" min="0" placeholder="{{ __('€/h') }}" class="field-input">
                <button>+ {{ __('Expertenprofil') }}</button>
            </form>
        </div>
        <div class="gap-3">
            @forelse ($experts as $e)
                <div class="items-center">
                    <div>
                        <div class="t-strong">{{ $e->name }} <span class="flink">{{ $e->specialty }}</span></div>
                        <div>{{ $e->industry?->name_de }} · {{ $e->location }} · {{ $e->experience_years }} {{ __('Jahre') }} @if($e->hourly_rate)· {{ $e->hourly_rate }} €/h @endif</div>
                    </div>
                    <div>
                        @if($e->rating)<div>★ {{ $e->rating }}</div>@endif
                        <div class="{{ $e->availability === 'available' ? 'text-green-600' : 'text-gray-400' }}">{{ __($e->availability) }}</div>
                    </div>
                </div>
            @empty
                <div>{{ __("Keine Experten gefunden.") }}</div>
            @endforelse
            {{ $experts->links() }}
        </div>
</div>
</x-app-layout>
