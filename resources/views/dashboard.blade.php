<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <div>
            <div>
                <p>{{ __('Willkommen zurück') }}</p>
                <h3>{{ auth()->user()->name }}</h3>
                <p>{{ auth()->user()->companies->first()?->name ?? '' }}</p>
            </div>

            <div>
                <a href="{{ route('docs.index') }}" class="group">
                    <div class="items-center">D</div>
                    <h4>{{ __('Docs') }}</h4>
                    <p>{{ __('Compliance-Dokumente verwalten') }}</p>
                </a>
                <a href="{{ route('files.index') }}" class="group">
                    <div class="items-center">F</div>
                    <h4>{{ __('Files') }}</h4>
                    <p>{{ __('Dateien hochladen und teilen') }}</p>
                </a>
                <a href="{{ route('library.index') }}" class="group">
                    <div class="items-center">L</div>
                    <h4>{{ __('Library') }}</h4>
                    <p>{{ __('Wissen, Vorlagen und Artikel') }}</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
