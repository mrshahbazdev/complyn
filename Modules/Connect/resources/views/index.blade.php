<x-app-layout>
    <x-slot name="header">{{ __('Connect — Anfragen') }}</x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('connect.store') }}" class="space-y-3">
                @csrf
                <input name="title" placeholder="{{ __('Neue Anfrage — Titel') }}" required class="field-input">
                <textarea name="description" rows="2" placeholder="{{ __('Beschreibung…') }}" class="field-input"></textarea>
                <button class="btn btn-brand">{{ __('Absenden') }}</button>
            </form>
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @foreach ($requests as $r)
                    <li class="py-2 flex justify-between">
                        <a href="{{ route('connect.show', $r) }}" class="flink">{{ $r->title }}</a>
                        <span class="text-xs {{ $r->status === 'open' ? 'text-green-600' : 'text-gray-500' }}">{{ $r->status }} · {{ $r->messages_count }} Msgs</span>
                    </li>
                @endforeach
            </ul>
            {{ $requests->links() }}
        </div>
</div>
</x-app-layout>
