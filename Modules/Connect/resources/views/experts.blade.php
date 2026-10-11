<x-app-layout>
    <x-slot name="header">{{ __("Experten finden") }}</x-slot>
    <div class="py-8"><div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="GET" class="flex flex-wrap gap-2">
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
                <button class="bg-slate-900 text-white px-3 py-1.5 rounded text-sm">{{ __('Suchen') }}</button>
                <a href="{{ route('connect.index') }}" class="text-amber-600 text-sm self-center">{{ __('Anfragen') }}</a>
            </form>
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('connect.experts.store') }}" class="flex flex-wrap gap-2">
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
                <button class="bg-slate-900 text-white px-3 py-1.5 rounded text-sm">+ {{ __('Expertenprofil') }}</button>
            </form>
        </div>
        <div class="grid gap-3">
            @forelse ($experts as $e)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-4 flex justify-between items-center">
                    <div>
                        <div class="t-strong">{{ $e->name }} <span class="text-amber-600 text-xs font-semibold">{{ $e->specialty }}</span></div>
                        <div class="text-xs text-gray-500">{{ $e->industry?->name_de }} · {{ $e->location }} · {{ $e->experience_years }} {{ __('Jahre') }} @if($e->hourly_rate)· {{ $e->hourly_rate }} €/h @endif</div>
                    </div>
                    <div class="text-right">
                        @if($e->rating)<div class="text-amber-500 text-sm font-bold">★ {{ $e->rating }}</div>@endif
                        <div class="text-xs {{ $e->availability === 'available' ? 'text-green-600' : 'text-gray-400' }}">{{ __($e->availability) }}</div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-6 text-sm text-gray-500">{{ __("Keine Experten gefunden.") }}</div>
            @endforelse
            {{ $experts->links() }}
        </div>
</div>
</x-app-layout>
