<x-app-layout>
    <x-slot name="header">Exchange — Marktplatz</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('exchange.store') }}">
                @csrf
                <div class="gap-3">
                    <input name="title" placeholder="{{ __('Titel (z. B. ISO 9001 Beratung gesucht)') }}" required class="field-input">
                    <select name="type" class="field-input"><option value="need">{{ __("Suche") }}</option><option value="offer">{{ __("Angebot") }}</option></select>
                </div>
                <textarea name="description" rows="2" placeholder="{{ __('Beschreibung…') }}" class="field-input"></textarea>
                <button class="btn btn-brand">{{ __('Eintragen') }}</button>
            </form>
        </div>
        @foreach ($listings as $l)
        <div class="card fade-up" style="padding:20px 24px" x-data="{open:false}">
            <div class="items-center">
                <div><span>{{ $l->title }}</span>
                    <span class="{{ $l->type==='offer' ? 'text-green-600' : 'text-blue-600' }}">{{ $l->type==='offer' ? 'Angebot' : 'Suche' }}</span>
                    <span>· {{ $l->status }}</span></div>
                <div class="gap-2">
                    @if ($l->status==='open')
                    <button @click="open=!open" class="flink">{{ __('Anfragen') }}</button>
                    <form method="POST" action="{{ route('exchange.close', $l) }}">@csrf @method('PUT')<button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Schließen") }}</button></form>
                    @endif
                </div>
            </div>
            <div class="muted">{{ $l->description }}</div>
            <div x-show="open">
                <form method="POST" action="{{ route('exchange.inquire', $l) }}" class="gap-3">
                    @csrf
                    <input name="message" required placeholder="{{ __('Deine Nachricht…') }}" class="field-input">
                    <button class="btn btn-brand btn-sm">Senden</button>
                </form>
                @foreach ($l->inquiries as $i)<div>— {{ $i->message }}</div>@endforeach
            </div>
        </div>
        @endforeach
        {{ $listings->links() }}
</div>
</x-app-layout>
