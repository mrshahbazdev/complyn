<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic violet"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></span>
            <div><h1>{{ __('Neues Dokument') }}</h1><p class="ph-sub">{{ __('Dokument anlegen') }}</p></div>
        </div>
    </div>
    <div class="card panel fade-up" style="animation-delay:.05s;max-width:720px">
        <div class="panel-body">
        <form method="POST" action="{{ route('docs.store') }}" enctype="multipart/form-data" class="form-grid">
            @csrf
            <div class="field" style="grid-column:1/-1"><label>{{ __("Titel") }}</label><input class="field-input" name="title" required></div>
            <div class="field" style="grid-column:1/-1"><label>{{ __("Beschreibung") }}</label><textarea class="field-input" name="description" rows="3"></textarea></div>
            <div class="field"><label>{{ __("Kategorie") }}</label>
                <select class="field-input" name="category_id"><option value="">—</option>
                    @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name_de }}</option>@endforeach
                </select></div>
            <div class="field"><label>{{ __("Ablaufdatum") }}</label><input class="field-input" type="date" name="expires_at"></div>
            <div class="field"><label>{{ __("Tags (Komma-getrennt)") }}</label><input class="field-input" name="tags"></div>
            <div class="field"><label>{{ __("Datei") }}</label><input type="file" name="file" class="f-select" style="padding:7px 10px"></div>
            <div style="grid-column:1/-1"><button class="btn btn-brand">{{ __('Anlegen') }}</button></div>
        </form>
        </div>
    </div>
</div>
</x-app-layout>
