<x-app-layout>
    <x-slot name="header">{{ __("Fachgruppen & Themennnetzwerke") }}</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('exchange.groups.store') }}" class="gap-2">
                @csrf
                <input name="name" required placeholder="{{ __('Gruppenname…') }}" class="field-input">
                <input name="topic" placeholder="{{ __('Thema') }}" class="field-input">
                <button class="btn btn-dark">+ {{ __('Gruppe') }}</button>
                <a href="{{ route('exchange.index') }}" class="flink">{{ __('Marktplatz') }}</a>
            </form>
        </div>
        <div class="gap-3">
            @forelse ($groups as $g)
                <a href="{{ route('exchange.groups.show', $g) }}">
                    <div class="t-strong">{{ $g->name }}</div>
                    <div>{{ $g->topic }} · {{ $g->topics_count }} {{ __('Diskussionen') }}</div>
                </a>
            @empty
                <div>{{ __("Noch keine Gruppen.") }}</div>
            @endforelse
        </div>
</div>
</x-app-layout>
