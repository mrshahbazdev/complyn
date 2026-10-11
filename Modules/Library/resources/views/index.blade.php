<x-app-layout>
    <x-slot name="header">Bibliothek</x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <form method="GET" class="flex gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="{{ __('Artikel suchen…') }}" class="field-input">
            <button class="btn btn-brand">{{ __('Suchen') }}</button>
        </form>
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">{{ __("Artikel") }}</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @foreach ($articles as $a)
                    <li class="py-2"><a href="{{ route('library.show', $a) }}" class="flink">{{ $a->title }}</a></li>
                @endforeach
            </ul>
            {{ $articles->links() }}
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">{{ __("Vorlagen") }}</h3>
            <ul class="text-sm space-y-1">
                @foreach ($templates as $t)<li >• <a href="{{ route('library.template', $t) }}" class="text-amber-600 hover:underline">{{ $t->name }}</a> <span class="text-xs text-gray-500">({{ $t->type }})</span></li>@endforeach
            </ul>
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">{{ __("Neuer Artikel") }}</h3>
            <form method="POST" action="{{ route('library.articles.store') }}" class="space-y-3">
                @csrf
                <input name="title" placeholder="{{ __('Titel') }}" required class="field-input">
                <select name="category_id" class="field-input">
                    <option value="">{{ __("— Kategorie —") }}</option>
                    @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name_de }}</option>@endforeach
                </select>
                <textarea name="body" required rows="4" placeholder="{{ __('Inhalt…') }}" class="field-input"></textarea>
                <button class="btn btn-brand">{{ __('Speichern') }}</button>
            </form>
        </div>
</div>
</x-app-layout>
