<x-app-layout>
    <x-slot name="header">Academy — Schulungen</x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-4">
            @forelse ($courses as $c)
            <a href="{{ route('academy.show', $c) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 block">
                <h3 class="panel-h">{{ $c->title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $c->description }}</p>
                <div class="text-xs text-gray-500 mt-2">{{ $c->lessons_count }} Lektionen</div>
            </a>
            @empty
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 text-sm text-gray-500 col-span-2">{{ __('Noch keine Kurse angelegt — Admin kann sie im Admin-Bereich verwalten.') }}</div>
            @endforelse
        </div>
</div>
</x-app-layout>
