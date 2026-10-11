<x-app-layout>
    <x-slot name="header">{{ $request->title }}</x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="card fade-up" style="padding:20px 24px">
            <div class="text-xs text-gray-500 mb-2">{{ $request->user->name }} · Status: {{ $request->status }}</div>
            <div class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $request->description }}</div>
            @if ($request->status === 'open')
            <form method="POST" action="{{ route('connect.close', $request) }}" class="mt-3">@csrf @method('PUT')<button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Schließen") }}</button></form>
            @endif
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 space-y-3">
            @foreach ($request->messages as $m)
                <div class="text-sm border-b dark:border-gray-700 pb-2"><span class="muted">{{ $m->user->name }}:</span> <span >{{ $m->body }}</span></div>
            @endforeach
            <form method="POST" action="{{ route('connect.messages.store', $request) }}" class="flex gap-3">
                @csrf
                <input name="body" required placeholder="{{ __('Nachricht…') }}" class="field-input">
                <button class="btn btn-brand">{{ __('Senden') }}</button>
            </form>
        </div>
</div>
</x-app-layout>
