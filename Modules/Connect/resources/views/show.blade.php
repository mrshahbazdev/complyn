<x-app-layout>
    <x-slot name="header">{{ $request->title }}</x-slot>
    <div><div>
        <div class="card fade-up" style="padding:20px 24px">
            <div>{{ $request->user->name }} · Status: {{ $request->status }}</div>
            <div>{{ $request->description }}</div>
            @if ($request->status === 'open')
            <form method="POST" action="{{ route('connect.close', $request) }}">@csrf @method('PUT')<button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Schließen") }}</button></form>
            @endif
        </div>
        <div>
            @foreach ($request->messages as $m)
                <div><span class="muted">{{ $m->user->name }}:</span> <span >{{ $m->body }}</span></div>
            @endforeach
            <form method="POST" action="{{ route('connect.messages.store', $request) }}" class="gap-3">
                @csrf
                <input name="body" required placeholder="{{ __('Nachricht…') }}" class="field-input">
                <button class="btn btn-brand">{{ __('Senden') }}</button>
            </form>
        </div>
</div>
</x-app-layout>
