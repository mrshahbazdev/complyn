<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic slate"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
            <div><h1>{{ __('Unternehmens-Einstellungen') }}</h1><p class="ph-sub">{{ __('Stammdaten Ihres Unternehmens') }}</p></div>
        </div>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif
    @if ($company)
    <div class="card panel fade-up" style="animation-delay:.05s;max-width:640px">
        <div class="panel-head"><h3>{{ $company->name }}</h3><span class="pill">{{ $company->plan?->name }}</span></div>
        <div class="panel-body">
        <form method="POST" action="{{ route('settings.company') }}">
            @csrf @method('PUT')
            <div class="field"><label>{{ __("Name") }}</label><input class="field-input" name="name" value="{{ $company->name }}" required></div>
            <div class="field"><label>{{ __("Branche") }}</label>
                <select class="field-input" name="industry_id">
                    <option value="">—</option>
                    @foreach ($industries as $i)<option value="{{ $i->id }}" @selected($company->industry_id === $i->id)>{{ $i->name_de }}</option>@endforeach
                </select></div>
            <p class="muted" style="font-size:13px">Slug: {{ $company->slug }}</p>
            <button class="btn btn-brand">{{ __('Speichern') }}</button>
        </form>
        </div>
    </div>
    @else
    <div class="card alert-band fade-up" style="background:#fffbeb;border-color:#fde68a;color:#92400e">{{ __("Kein Unternehmen zugeordnet.") }}</div>
    @endif
</div>
</x-app-layout>
