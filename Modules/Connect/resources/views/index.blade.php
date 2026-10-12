<x-app-layout>
    <x-slot name="header">{{ __('Connect — Anfragen') }}</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('connect.store') }}">
                @csrf
                <input name="title" placeholder="{{ __('Neue Anfrage — Titel') }}" required class="field-input">
                <textarea name="description" rows="2" placeholder="{{ __('Beschreibung…') }}" class="field-input"></textarea>
                <button class="btn btn-brand">{{ __('Absenden') }}</button>
            </form>
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <ul>
                @foreach ($requests as $r)
                    <li>
                        <a href="{{ route('connect.show', $r) }}" class="flink">{{ $r->title }}</a>
                        <span class="{{ $r->status === 'open' ? 'text-green-600' : 'text-gray-500' }}">{{ $r->status }} · {{ $r->messages_count }} Msgs</span>
                    </li>
                @endforeach
            </ul>
            {{ $requests->links() }}
        </div>
</div>
</x-app-layout>
