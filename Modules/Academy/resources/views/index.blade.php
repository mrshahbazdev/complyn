<x-app-layout>
    <x-slot name="header">Academy — Schulungen</x-slot>
    <div><div>
        <div>
            @forelse ($courses as $c)
            <a href="{{ route('academy.show', $c) }}">
                <h3 class="panel-h">{{ $c->title }}</h3>
                <p>{{ $c->description }}</p>
                <div>{{ $c->lessons_count }} Lektionen</div>
            </a>
            @empty
            <div>{{ __('Noch keine Kurse angelegt — Admin kann sie im Admin-Bereich verwalten.') }}</div>
            @endforelse
        </div>
</div>
</x-app-layout>
