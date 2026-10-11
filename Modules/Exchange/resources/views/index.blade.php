<x-app-layout>
    <x-slot name="header">Exchange — Marktplatz</x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('exchange.store') }}" class="space-y-3">
                @csrf
                <div class="flex gap-3">
                    <input name="title" placeholder="{{ __('Titel (z. B. ISO 9001 Beratung gesucht)') }}" required class="field-input">
                    <select name="type" class="field-input"><option value="need">{{ __("Suche") }}</option><option value="offer">{{ __("Angebot") }}</option></select>
                </div>
                <textarea name="description" rows="2" placeholder="{{ __('Beschreibung…') }}" class="field-input"></textarea>
                <button class="btn btn-brand">{{ __('Eintragen') }}</button>
            </form>
        </div>
        @foreach ($listings as $l)
        <div class="card fade-up" style="padding:20px 24px" x-data="{open:false}">
            <div class="flex justify-between items-center">
                <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $l->title }}</span>
                    <span class="text-xs ml-2 {{ $l->type==='offer' ? 'text-green-600' : 'text-blue-600' }}">{{ $l->type==='offer' ? 'Angebot' : 'Suche' }}</span>
                    <span class="text-xs text-gray-500 ml-1">· {{ $l->status }}</span></div>
                <div class="flex gap-2">
                    @if ($l->status==='open')
                    <button @click="open=!open" class="flink">{{ __('Anfragen') }}</button>
                    <form method="POST" action="{{ route('exchange.close', $l) }}">@csrf @method('PUT')<button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Schließen") }}</button></form>
                    @endif
                </div>
            </div>
            <div class="muted">{{ $l->description }}</div>
            <div x-show="open" class="mt-3">
                <form method="POST" action="{{ route('exchange.inquire', $l) }}" class="flex gap-3">
                    @csrf
                    <input name="message" required placeholder="{{ __('Deine Nachricht…') }}" class="field-input">
                    <button class="btn btn-brand btn-sm">Senden</button>
                </form>
                @foreach ($l->inquiries as $i)<div class="text-xs text-gray-500 mt-1">— {{ $i->message }}</div>@endforeach
            </div>
        </div>
        @endforeach
        {{ $listings->links() }}
</div>
</x-app-layout>
